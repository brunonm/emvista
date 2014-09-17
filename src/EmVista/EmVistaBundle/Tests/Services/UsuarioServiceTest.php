<?php

namespace EmVista\EmVistaBundle\Tests\Services;

use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;

class UsuarioServiceTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->fixtures();
    }

    private function fixtures()
    {
        $role1 = new Role();
        $role1->setNome('ROLE_USER');
        $role2 = new Role();
        $role2->setNome('ROLE_ADMIN');
        $em = $this->getEntityManager();
        $em->persist($role1);
        $em->persist($role2);
        $em->flush();
    }

    private function getUsuarioValido()
    {
        return array('nome' => 'Usuario de Teste', 'email' => 'teste@emvista.me', 'senha' => '123abc',
                     'confirmaSenha' => '123abc', 'confirmaEmail' => 'teste@emvista.me');
    }

    private function getInvalidUploadedFile()
    {
        $uploadDir = $this->container->getParameter('upload_dir');
        $imagePath = $uploadDir . '/profile_invalid.gif';
        copy($uploadDir . '/image_invalid.gif', $uploadDir . '/profile_invalid.gif');

        return new UploadedFile($imagePath, 'profile_invalid.gif', 'image/gif', filesize($imagePath), null, true);
    }

    private function getValidUploadedFile()
    {
        $uploadDir = $this->container->getParameter('upload_dir');
        $imagePath = $uploadDir . '/profile.jpg';
        copy($uploadDir . '/image.jpg', $uploadDir . '/profile.jpg');

        return new UploadedFile($imagePath, 'profile.jpg', 'image/jpeg', filesize($imagePath), null, true);
    }

    /**
     * @test
     */
    public function deveRegistrarUsuarioComSucesso()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuarioId = $this->get('service.usuario')->registrar($sd)->getId();
        $usuario = $this->getEntityManager()->find('EmVistaBundle:Usuario', $usuarioId);

        $this->assertEquals($usuario->getNome(), $usuarioData['nome']);
        $this->assertEquals($usuario->getEmail(), $usuarioData['email']);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\UsuarioJaExisteException
     */
    public function deveLancarExceptionSeRegistrarUsuarioJaExistente()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeUsuarioTiverNomeMenorQue2()
    {
        $usuarioData = $this->getUsuarioValido();
        $usuarioData['nome'] = 'A';
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeUsuarioTiverEmailInvalido()
    {
        $usuarioData = $this->getUsuarioValido();
        $usuarioData['email'] = 'email@invalido';
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeUsuarioTiverSenhaMenorQue6()
    {
        $usuarioData = $this->getUsuarioValido();
        $usuarioData['senha'] = 'abcd';
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeUsuarioTiverSenhaComEspaco()
    {
        $usuarioData = $this->getUsuarioValido();
        $usuarioData['senha'] = '123456 bruno';
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeEmailDeConfirmacaoDiferenteDoEmail()
    {
        $usuarioData = $this->getUsuarioValido();
        $usuarioData['confirmaEmail'] = 'teste2@emvista.me';
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeSenhaDeConfirmacaoDiferenteDaSenha()
    {
        $usuarioData = $this->getUsuarioValido();
        $usuarioData['confirmaSenha'] = '321abc';
        $sd = ServiceData::build($usuarioData);
        $this->get('service.usuario')->registrar($sd);
    }

    /**
     * @test
     */
    public function deveCriarRoleParaOUsuarioNoRegistro()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);
        $usuario = $this->get('service.usuario')->registrar($sd);
        foreach ($usuario->getUserRoles() as $role) {
            $this->assertInstanceOf('EmVista\EmVistaBundle\Entity\Role', $role);
        }
    }

    /**
     * @test
     */
    public function deveFazerUploadDeImagemParaProfile()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $file = $this->getValidUploadedFile();

        $sd = ServiceData::build();
        $sd->set('file', $file)
           ->setUser($usuario);

        $profileImagem = $this->get('service.usuario')->salvarImagemProfile($sd);

        $this->assertFalse(is_file($file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename()));
        $this->assertEquals(470, $profileImagem->height);
        $this->assertEquals(470, $profileImagem->width);
        $this->assertEquals('profile.jpg', $profileImagem->originalName);
        $this->assertEquals($this->container->getParameter('profile_web_temp_path')
                                . md5($usuario->getId() . 'EmVista') . '.png', $profileImagem->webPath);

        $array['x'] = 0;
        $array['y'] = 0;
        $array['w'] = 150;
        $array['h'] = 150;
        $array['escH'] = 1;
        $array['escW'] = 1;
        $array['name'] = 'profile.jpg';
        $sd = ServiceData::build($array);
        $sd->setUser($usuario);
        $usuarioNew = $this->get('service.usuario')->recortaImagemProfile($sd);
        $imagemProfile = $usuarioNew->getImagemProfile();
        $this->assertEquals(1, $imagemProfile->getId());
        $this->assertEquals('profile.jpg',$imagemProfile->getOriginalFilename());
        $this->assertEquals($this->container->getParameter('profile_height'),$imagemProfile->getAltura());
        $this->assertEquals($this->container->getParameter('profile_width'),$imagemProfile->getLargura());
        $this->assertEquals($this->container->getParameter('profile_web_path')
                                . md5($imagemProfile->getId()) . '.png'
                , $usuarioNew->getImagemProfile()->getWebPath());

    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeImagemDoUploadForGif()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $file = $this->getInvalidUploadedFile();

        $sd = ServiceData::build();
        $sd->set('file', $file)
           ->setUser($usuario);

        $this->get('service.usuario')->salvarImagemProfile($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeImagemDoUploadForInvalida()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);

        $sd = ServiceData::build();
        $sd->set('file', null)
           ->setUser($usuario);

        $this->get('service.usuario')->salvarImagemProfile($sd);
    }

    /**
     * @test
     */
    public function deveAlterarDadosPessoaisComSucesso()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $sd->set('id', $usuario->getId());
        $sd->set('endereco', array('cep' => '72015535','cidade' => 'BRASILIA', 'bairro' => 'TAGUATINGA' , 'uf' => 'DF',
                'endereco' => 'CSB 03 LOTE 02'
            ));
        $sd->set('email', 'batman@emvista.me');
        $sd->set('confirmaEmail', 'batman@emvista.me');
        $sd->set('senha', 'emvista123');
        $sd->set('confirmaSenha', 'emvista123');
        $usuario = $this->get('service.usuario')->alterarDados($sd);

        $this->assertEquals($usuario->getNome(), $usuarioData['nome']);
        $this->assertEquals($usuario->getEmail(), 'batman@emvista.me');
        $this->assertEquals($usuario->getEndereco()->getCep(), '72015535');

    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionPoisEmailEConfirmacaoDeEmailDiferentes()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $sd->set('id', $usuario->getId());
        $sd->set('endereco', array('cep' => '72015535','cidade' => 'BRASILIA', 'bairro' => 'TAGUATINGA' , 'uf' => 'DF',
                'endereco' => 'CSB 03 LOTE 02'
            ));
        $sd->set('email', 'batman@emvista.me');

        $usuario = $this->get('service.usuario')->alterarDados($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionPoisSenhaEConfirmacaoDeSenhaDiferentes()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $sd->set('id', $usuario->getId());
        $sd->set('endereco', array('cep' => '72015535','cidade' => 'BRASILIA', 'bairro' => 'TAGUATINGA' , 'uf' => 'DF',
                'endereco' => 'CSB 03 LOTE 02'
            ));
        $sd->set('senha', 'emvista123');

        $usuario = $this->get('service.usuario')->alterarDados($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionPoisCepComLetras()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $sd->set('id', $usuario->getId());
        $sd->set('endereco', array('cep' => '72015535','cidade' => 'BRASILIA', 'bairro' => 'TAGUATINGA' , 'uf' => 'DF',
                'endereco' => 'CSB 03 LOTE 02'
            ));
        $sd->set('endereco', array('cep' => '7201a535'));

        $usuario = $this->get('service.usuario')->alterarDados($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionPoisCepComMenosDe8Caracteres()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $sd->set('id', $usuario->getId());
        $sd->set('endereco', array('cep' => '72015535','cidade' => 'BRASILIA', 'bairro' => 'TAGUATINGA' , 'uf' => 'DF',
                'endereco' => 'CSB 03 LOTE 02'
            ));
        $sd->set('endereco', array('cep' => '7201535'));
        $usuario = $this->get('service.usuario')->alterarDados($sd);

    }

    public function deveLancarExceptionPoisEnderecoComCaracteresEspeciais()
    {
        $usuarioData = $this->getUsuarioValido();
        $sd = ServiceData::build($usuarioData);

        $usuario = $this->get('service.usuario')->registrar($sd);
        $sd->set('id', $usuario->getId());
        $sd->set('endereco', array('cep' => '72015535','cidade' => 'BRASILIA', 'bairro' => 'TAGUATINGA' , 'uf' => 'DF',
                'endereco' => 'CSB 03 LOTE 02'
            ));
        $sd->set('endereco', array('endereco','CSB 03 LOTE @'));

    }
}
