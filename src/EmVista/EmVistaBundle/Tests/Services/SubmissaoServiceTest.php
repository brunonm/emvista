<?php

namespace EmVista\EmVistaBundle\Tests\Services;

use EmVista\EmVistaBundle\Util\Date;
use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Entity\SiteVideo;
use EmVista\EmVistaBundle\Entity\StatusSubmissao;
use EmVista\EmVistaBundle\Entity\TipoProjetoImagem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;

class SubmissaoServiceTest extends TestCase
{
    /**
     * @var \EmVista\EmVistaBundle\Services\SubmissaoService
     */
    private $service;

    const FAKE_DESCRIPTION =
       'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nisi orci, iaculis vel euismod eget,
        interdum id arcu. Aliquam tincidunt viverra feugiat. Pellentesque habitant morbi tristique senectus et netus
        et malesuada fames ac turpis egestas. Suspendisse urna orci, ornare quis semper non, imperdiet quis augue.
        Maecenas sem turpis, condimentum quis fringilla eu, facilisis eu mi. Cras dictum imperdiet fringilla.
        Pellentesque pretium tincidunt hendrerit. Cras ipsum nisi, ullamcorper sit amet mollis ut, semper quis turpis.
        Nullam accumsan purus non ante consequat eu blandit erat adipiscing. Aliquam dignissim dolor faucibus magna
        lobortis vitae pretium risus placerat. Donec ut sapien magna, vitae lacinia lorem. Phasellus consectetur erat
        id eros sagittis ut bibendum libero bibendum. Nam cursus varius urna, vel volutpat leo accumsan sed.';

    protected function setUp()
    {
        parent::setUp();

        $this->service = $this->get('service.submissao');

        $this->loadTestFixtures('Domain');
        $this->loadTestFixtures('SubmissaoServiceTest');
    }

    protected function tearDown()
    {
        parent::tearDown();

        $uploadDir = $this->container->getParameter('upload_dir');

        $projeto2Dir = $uploadDir . DIRECTORY_SEPARATOR . md5(2);

        foreach (glob($projeto2Dir . '/*') as $file) {
            unlink($file);
        }

        if (file_exists($projeto2Dir)) {
            rmdir($projeto2Dir);
        }

        copy($uploadDir . '/image_bak.jpg', $uploadDir . '/image.jpg');
        copy($uploadDir . '/image2_bak.jpg', $uploadDir . '/image2.jpg');

        # apaga o crop de teste
        $dir       = $uploadDir . '/' . md5(1);
        $filename  = $dir . '/' . md5(2) . '.jpg';

        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    /**
     * @test
     */
    public function deveSetarProjetoServiceComSucesso()
    {
        $projetoService = $this->get('service.projeto');
        $this->assertAttributeInstanceOf('EmVista\EmVistaBundle\Services\ProjetoService', 'projetoService', $this->service);
    }

    /**
     * @test
     */
    public function deveSetarQuantidadeDiasMinimoComSucesso()
    {
        $service = $this->service->setQuantidadeDiasMinimo(15);
        $this->assertAttributeEquals(15, 'quantidadeDiasMinimo', $service);
    }

    /**
     * @test
     */
    public function deveSetarQuantidadeDiasMaximoComSucesso()
    {
        $service = $this->service->setQuantidadeDiasMaximo(70);
        $this->assertAttributeEquals(70, 'quantidadeDiasMaximo', $service);
    }

    /**
     * @test
     */
    public function deveIniciarComSucesso()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $sd   = ServiceData::build()->setUser($user);

        $submissao = $this->service->iniciar($sd);
        $submissao = $this->getEntityManager()->getRepository('EmVistaBundle:Submissao')->find($submissao->getId());

        // asserts submissao
        $this->assertNotNull($submissao);
        $this->assertEquals(StatusSubmissao::STATUS_INICIAL, $submissao->getStatus()->getId());
        $this->assertEquals(date('Y-m-d'), $submissao->getDataCadastro()->format('Y-m-d'));
        $this->assertNull($submissao->getDataResposta());

        $projeto = $submissao->getProjeto();

        //asserts projeto
        $this->assertNotNull($projeto);
        $this->assertEquals($user->getId(), $projeto->getUsuario()->getId());
        $this->assertEquals(1, $this->get('service.projeto')->getTermoUsoVigente()->getId());
        $this->assertEquals(date('Y-m-d'), $projeto->getDataCadastro()->format('Y-m-d'));
        $this->assertEquals(0, $projeto->getValorArrecadado());
        $this->assertFalse($projeto->getPublicado());
        $this->assertFalse($projeto->getFinalizado());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeIniciarSubmissaoSemUsuario()
    {
        $sd = ServiceData::build()->set('termoUsoId', 'abc');
        $this->service->iniciar($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeIniciarSubmissaoComUsuarioInvalido()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 999);
        $sd   = ServiceData::build()->set('termoUsoId', 'abc')->setUser($user);
        $this->service->iniciar($sd);
    }

    /**
     * @test
     */
    public function deveRetornarSubmissaoComSucesso()
    {
        $sd = ServiceData::build()->set('submissaoId', 1);
        $submissao = $this->service->getSubmissao($sd);
        $this->assertNotNull($submissao);
        $this->assertEquals(1, $submissao->getId());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeTentarRetornarSubmissaoComIdInvalido()
    {
        $sd = ServiceData::build()->set('submissaoId', 'abc');
        $this->service->getSubmissao($sd);
    }

    /**
     * @test
     */
    public function deveCarregarDadosBasicosComSucesso()
    {
        $dadosBasicos = $this->service->dadosBasicos();
        $this->assertArrayHasKey('categorias', $dadosBasicos);
        $this->assertTrue(count($dadosBasicos['categorias']) > 10);
        $this->assertEquals($dadosBasicos['quantidadeDiasMinimo'], 10);
        $this->assertEquals($dadosBasicos['quantidadeDiasMaximo'], 60);
    }

    private function getDadosBasicos()
    {
        return ServiceData::build(array(
            'submissaoId'    => 1,
            'categoriaId'    => 10,
            'nome'           => 'Projeto Teste',
            'quantidadeDias' => 10,
            'valor'          => 4000
        ));
    }

    /**
     * @test
     */
    public function deveSalvarDadosBasicosComSucesso()
    {
        $sd = $this->getDadosBasicos();

        $this->service->salvarDadosBasicos($sd);

        $projeto = $this->get('service.projeto')->getProjeto(1);

        $this->assertEquals($sd->get('categoriaId'), $projeto->getCategoria()->getId());
        $this->assertEquals($sd->get('nome'), $projeto->getNome());
        $this->assertEquals($sd->get('quantidadeDias'), $projeto->getQuantidadeDias());
        $this->assertEquals($sd->get('valor'), $projeto->getValor());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeSubmissaoIdForInvalido()
    {
        $sd = $this->getDadosBasicos()->set('submissaoId', 'abc');
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeNomeForInvalido()
    {
        $sd = $this->getDadosBasicos()->set('nome', 1231235555);
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeNomeForInvalido2()
    {
        $sd = $this->getDadosBasicos()->set('nome', 'ab');
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeCategoriaIdForInvalido()
    {
        $sd = $this->getDadosBasicos()->set('categoriaId', 'abc');
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeQuantidadeDeDiasForInvalido()
    {
        $sd = $this->getDadosBasicos()->set('quantidadeDias', 150);
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeQuantidadeDeDiasForInvalido2()
    {
        $sd = $this->getDadosBasicos()->set('quantidadeDias', 0);
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeQuantidadeDeDiasForInvalido3()
    {
        $sd = $this->getDadosBasicos()->set('quantidadeDias', -1);
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeQuantidadeDeDiasForInvalido4()
    {
        $sd = $this->getDadosBasicos()->set('quantidadeDias', 'abc');
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeValorForInvalido()
    {
        $sd = $this->getDadosBasicos()->set('valor', 0);
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeValorForInvalido2()
    {
        $sd = $this->getDadosBasicos()->set('valor', -1);
        $this->service->salvarDadosBasicos($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeValorForInvalido3()
    {
        $sd = $this->getDadosBasicos()->set('valor', 'abc');
        $this->service->salvarDadosBasicos($sd);
    }

    private function getDescricao()
    {
        return ServiceData::build(array(
            'submissaoId'      => 1,
            'descricaoCurta' => substr(self::FAKE_DESCRIPTION, 0, 130),
            'descricao'      => self::FAKE_DESCRIPTION
        ));
    }

    /**
     * @test
     */
    public function deveSalvarDescricaoComSucesso()
    {
        $sd = $this->getDescricao();

        $this->service->salvarDescricao($sd);

        $submissao = $this->getEntityManager()->find('EmVistaBundle:Submissao', $sd->get('submissaoId'));

        $projeto = $submissao->getProjeto();

        $this->assertEquals($sd->get('descricaoCurta'), $projeto->getDescricaoCurta());
        $this->assertEquals($sd->get('descricao'), $projeto->getDescricao());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeSubmissaoIdForInvalidoAoSalvarDescricao()
    {
        $sd = $this->getDescricao()->set('submissaoId', 'abc');
        $this->service->salvarDescricao($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeDescricaoCurtaForMaiorQue130()
    {
        $sd = $this->getDescricao()->set('descricaoCurta', substr(self::FAKE_DESCRIPTION, 0, 131));
        $this->service->salvarDescricao($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeDescricaoCurtaForInvalida()
    {
        $sd = $this->getDescricao()->set('descricaoCurta', substr(self::FAKE_DESCRIPTION, 0, 131));
        $this->service->salvarDescricao($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeDescricaoForInvalida()
    {
        $sd = $this->getDescricao()->set('descricao', null);
        $this->service->salvarDescricao($sd);
    }

    private function getRecompensa()
    {
        return array(
            'valorMinimo' => 50,
            'titulo'      => 'Recompensa de teste 1',
            'descricao'   => 'Recompensa de teste 1 Recompensa de teste 1',
            'quantidadeMaximaApoiadores' => 5
        );
    }

    /**
     * @test
     */
    public function deveSalvarRecompensasComSucesso()
    {
        $recompensa2 = $this->getRecompensa();
        $recompensa2['valorMinimo'] = 100;
        $recompensa2['titulo']      = 'Recompensa de teste 2';
        $recompensa2['descricao']   = 'Recompensa de teste 2 Recompensa de teste 2';
        unset($recompensa2['quantidadeMaximaApoiadores']);

        $recompensa3 = $this->getRecompensa();
        $recompensa3['valorMinimo'] = 200;
        $recompensa3['titulo']      = 'Recompensa de teste 3';
        $recompensa3['descricao']   = 'Recompensa de teste 3 Recompensa de teste 3';
        $recompensa3['quantidadeMaximaApoiadores'] = null;

        $recompensas[] = $this->getRecompensa();
        $recompensas[] = $recompensa2;
        $recompensas[] = $recompensa3;

        $sd = ServiceData::build()->set('recompensas', $recompensas)
                                  ->set('submissaoId', 1);

        $this->service->salvarRecompensas($sd);

        $recompensas = $this->getEntityManager()->find('EmVistaBundle:Projeto', 1)->getRecompensas();

        $this->assertCount(3, $recompensas);
        $this->assertEquals('Recompensa de teste 2', $recompensas[1]->getTitulo());
        $this->assertEquals(0, $recompensas[1]->getQuantidadeApoiadores());
        $this->assertEquals(5, $recompensas[0]->getQuantidadeMaximaApoiadores());
        $this->assertNull($recompensas[1]->getQuantidadeMaximaApoiadores());
        $this->assertNull($recompensas[2]->getQuantidadeMaximaApoiadores());
    }

    /**
     * @test
     */
    public function deveInserirAtualizarEApagarRecompensasComSucesso()
    {
        $recompensas[] = $this->getRecompensa();
        $recompensas[] = $this->getRecompensa();

        $sd = ServiceData::build()->set('recompensas', $recompensas)
                                  ->set('submissaoId', 1);

        $this->service->salvarRecompensas($sd);

        $recompensas = array();

        $recompensa = $this->getRecompensa();
        $recompensa['recompensaId'] = 2;
        $recompensa['titulo'] = 'novo titulo';
        $recompensas[] = $recompensa;

        $recompensa = $this->getRecompensa();
        $recompensa['titulo'] = 'nova recompensa';
        $recompensas[] = $recompensa;
        $recompensas[] = $recompensa;

        $sd = ServiceData::build()->set('recompensas', $recompensas)
                                  ->set('submissaoId', 1);

        $this->service->salvarRecompensas($sd);

        $recompensas = $this->getEntityManager()->getRepository('EmVistaBundle:Recompensa')->findBy(array('projeto' => 1));

        $this->assertCount(3, $recompensas);
        $this->assertEquals(2, $recompensas[0]->getId());
        $this->assertEquals('novo titulo', $recompensas[0]->getTitulo());
        $this->assertEquals(3, $recompensas[1]->getId());
        $this->assertEquals('nova recompensa', $recompensas[1]->getTitulo());
        $this->assertEquals(4, $recompensas[2]->getId());
        $this->assertEquals('nova recompensa', $recompensas[2]->getTitulo());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeValorMinimoForNegativo()
    {
        $recompensa = $this->getRecompensa();
        $recompensa['valorMinimo'] = -1;

        $recompensas[] = $recompensa;

        $sd = ServiceData::build()->set('recompensas', $recompensas)->set('submissaoId', 1);

        $this->service->salvarRecompensas($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeDescricaoDaRecompensaForInvalida()
    {
        $recompensa = $this->getRecompensa();
        $recompensa['descricao'] = 'a';

        $recompensas[] = $recompensa;

        $sd = ServiceData::build()->set('recompensas', $recompensas)->set('submissaoId', 1);

        $this->service->salvarRecompensas($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeTituloDaRecompensaForInvalido()
    {
        $recompensa = $this->getRecompensa();
        $recompensa['titulo'] = 'a';

        $recompensas[] = $recompensa;

        $sd = ServiceData::build()->set('recompensas', $recompensas)->set('submissaoId', 1);

        $this->service->salvarRecompensas($sd);
    }

    /**
     * @test
     */
    public function deveSalvarVideoYoutubeComSucesso()
    {
        $url = 'http://www.youtube.com/watch?v=NgjgnTXxX7I&feature=g-all-lik';

        $sd = ServiceData::build()->set('url', $url)->set('submissaoId', 1)->set('siteVideoId', 1);

        $this->service->salvarVideo($sd);

        $projeto = $this->getEntityManager()->find('EmVistaBundle:Projeto', 1);;

        $this->assertEquals('NgjgnTXxX7I', $projeto->getVideo()->getIdentificador());
        $this->assertEquals(SiteVideo::YOUTUBE, $projeto->getVideo()->getSiteVideo()->getId());
    }

    /**
     * @test
     */
    public function deveSalvarVideoVimeoComSucesso()
    {
        $url = 'http://vimeo.com/50085266';
        $sd  = ServiceData::build()->set('url', $url)->set('submissaoId', 1)->set('siteVideoId', 2);

        $this->service->salvarVideo($sd);

        $projeto = $this->getEntityManager()->find('EmVistaBundle:Projeto', 1);;

        $this->assertEquals('50085266', $projeto->getVideo()->getIdentificador());
        $this->assertEquals(SiteVideo::VIMEO, $projeto->getVideo()->getSiteVideo()->getId());
    }

    /**
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\VideoInvalidoException
     * @test
     */
    public function deveLancarExceptionSeUrlForInvalida()
    {
        $url = 'http://vimeo.com';
        $sd  = ServiceData::build()->set('url', $url)->set('submissaoId', 1)->set('siteVideoId', 2);
        $this->service->salvarVideo($sd);
    }

    /**
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\VideoInvalidoException
     * @test
     */
    public function deveLancarExceptionSeUrlForInvalida2()
    {
        $url = 'http://uol.com';
        $sd  = ServiceData::build()->set('url', $url)->set('submissaoId', 1)->set('siteVideoId', 2);
        $this->service->salvarVideo($sd);
    }

    /**
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\VideoInvalidoException
     * @test
     */
    public function deveLancarExceptionSeUrlForInvalida3()
    {
        $url = 'http://youtube.com/asd';
        $sd  = ServiceData::build()->set('url', $url)->set('submissaoId', 1)->set('siteVideoId', 2);
        $this->service->salvarVideo($sd);
    }

    /**
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\VideoInvalidoException
     * @test
     */
    public function deveLancarExceptionSeUrlForInvalida4()
    {
        $url = 'http://www.youtube.com/watch?teste=CeXFw11Ycvs&feature=g-all-lik';
        $sd  = ServiceData::build()->set('url', $url)->set('submissaoId', 1)->set('siteVideoId', 1);
        $this->service->salvarVideo($sd);
    }

    /**
     * @test
     */
    public function deveSalvarImagemOriginalComSucesso()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);

        $uploadDir = $this->container->getParameter('upload_dir');

        $imagePath = $uploadDir . '/image.jpg';

        $imageSize = filesize($imagePath);

        $file = new UploadedFile($imagePath, 'image.jpg', 'image/jpeg', $imageSize, null, true);

        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', $file)
                                  ->setUser($user);

        $projetoImagem = $this->service->salvarImagemOriginal($sd);

        $projetoDir = $uploadDir . '/' . md5($projetoImagem->getProjeto()->getId());
        $newName    = $projetoDir . '/' . $projetoImagem->getImagem()->getFilename();

        $this->assertFileExists($newName);
        $this->assertEquals('jpeg', $projetoImagem->getImagem()->getExtensao());
        $this->assertEquals(TipoProjetoImagem::TIPO_ORIGINAL, $projetoImagem->getTipoProjetoImagem()->getId());
        $this->assertEquals(1, $projetoImagem->getImagem()->getUsuario()->getId());
        $this->assertEquals($imageSize, $projetoImagem->getImagem()->getSize());
        $this->assertEquals(470, $projetoImagem->getImagem()->getAltura());
        $this->assertEquals(470, $projetoImagem->getImagem()->getLargura());
        $this->assertEquals('image.jpg', $projetoImagem->getImagem()->getOriginalFilename());
    }

    private function getInvalidUploadedFile()
    {
        $uploadDir = $this->container->getParameter('upload_dir');
        $imagePath = $uploadDir . '/image_invalid.gif';

        return new UploadedFile($imagePath, 'image_invalid.gif', 'image/gif', filesize($imagePath), null, true);
    }

    private function getValidUploadedFile()
    {
        $uploadDir = $this->container->getParameter('upload_dir');
        $imagePath = $uploadDir . '/image.jpg';

        return new UploadedFile($imagePath, 'image.jpg', 'image/jpeg', filesize($imagePath), null, true);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeImagemDoUploadForInvalida()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);

        $file = $this->getInvalidUploadedFile();

        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', $file)
                                  ->setUser($user);

        $this->service->salvarImagemOriginal($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeSubmissaoIdDoUploadForInvalido()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);

        $file = $this->getInvalidUploadedFile();

        $sd = ServiceData::build()->set('submissaoId', 'abc')
                                  ->set('file', $file)
                                  ->setUser($user);

        $this->service->salvarImagemOriginal($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeUploadedFileDoUploadForInvalido()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);

        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', new \stdClass())
                                  ->setUser($user);

        $this->service->salvarImagemOriginal($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeUserDoUploadForInvalido()
    {
        $file = $this->getValidUploadedFile();

        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', $file)
                                  ->setUser(null);

        $this->service->salvarImagemOriginal($sd);
    }

    private function getCropParams()
    {
        $params['h']  = 62.09302325581393;
        $params['w']  = 267;
        $params['x']  = 84;
        $params['y']  = 244;
        $params['projetoImagemId'] = 1;
        $params['tipoProjetoImagemId'] = 1;

        return $params;
    }

    /**
     * @test
     */
    public function deveFazerCropDoDestaqueComSucesso()
    {
        $params = $this->getCropParams();

        $this->service->cropDestaque(ServiceData::build($params));

        $em = $this->getEntityManager();

        $arrProjetoImagem = $em->getRepository('EmVistaBundle:ProjetoImagem')->findAll();

        $this->assertCount(2, $arrProjetoImagem);

        $projetoImagem = $arrProjetoImagem[1];

        $this->assertEquals(2, $projetoImagem->getId());
        $this->assertEquals(1, $projetoImagem->getProjeto()->getId());
        $this->assertEquals(TipoProjetoImagem::TIPO_DESTAQUE, $projetoImagem->getTipoProjetoImagem()->getId());

        $imagem = $projetoImagem->getImagem();

        $this->assertEquals(2, $imagem->getId());
        $this->assertEquals(1, $imagem->getUsuario()->getId());
        $this->assertEquals('robo', $imagem->getOriginalFilename());
        $this->assertEquals('jpg', $imagem->getExtensao());
        //consertar
        $this->assertTrue($imagem->getSize() < 10000);
        $this->assertEquals($params['w'], $imagem->getLargura());
        $this->assertEquals($params['h'], $imagem->getAltura());
        $this->assertEquals(md5(2) . '.jpg', $imagem->getFilename());

        $uploadDir = $this->container->getParameter('upload_dir');
        $filename  = $uploadDir . '/' . md5(1) . '/' . $imagem->getFilename();

        $this->assertFileExists($filename);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeHDoCropForInvalido()
    {
        $params = $this->getCropParams();
        $params['h'] = null;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeWDoCropForInvalido()
    {
        $params = $this->getCropParams();
        $params['w'] = null;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeXDoCropForInvalido()
    {
        $params = $this->getCropParams();
        $params['x'] = null;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeYDoCropForInvalido()
    {
        $params = $this->getCropParams();
        $params['y'] = null;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeProjetoImagemIdDoCropForInvalido()
    {
        $params = $this->getCropParams();
        $params['projetoImagemId'] = null;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeTipoProjetoImagemIdDoCropForInvalido()
    {
        $params = $this->getCropParams();
        $params['tipoProjetoImagemId'] = null;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeAspectRatioForIncorreto()
    {
        $params = $this->getCropParams();
        $params['w'] = 50;
        $params['h'] = 400;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    /**
     * @test
     */
    public function deveApagarImagensAntigasAoFazerUploadNovamente()
    {
        $em   = $this->getEntityManager();
        $user = $em->find('EmVistaBundle:Usuario', 1);
        $projetoImagemRepository = $em->getRepository('EmVistaBundle:ProjetoImagem');
        $imagemRepository        = $em->getRepository('EmVistaBundle:Imagem');
        $uploadDir = $this->container->getParameter('upload_dir');

        $imagePath = $uploadDir . '/image.jpg';
        $imageSize = filesize($imagePath);
        $file = new UploadedFile($imagePath, 'image.jpg', 'image/jpeg', $imageSize, null, true);

        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', $file)
                                  ->setUser($user);

        # upload
        $projetoImagem = $this->service->salvarImagemOriginal($sd);
        $idNotExistsUpload = $projetoImagem->getImagem()->getId();

        # crop
        $cropParams = $this->getCropParams();
        $cropParams['projetoImagemId'] = $projetoImagem->getId();
        $projetoImagem = $this->service->cropDestaque(ServiceData::build($cropParams));
        $idNotExistsCrop = $projetoImagem->getImagem()->getId();

        # segundo upload
        $imagePath = $uploadDir . '/image2.jpg';
        $imageSize = filesize($imagePath);
        $file = new UploadedFile($imagePath, 'image2.jpg', 'image/jpeg', $imageSize, null, true);

        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', $file)
                                  ->setUser($user);

        $projetoImagem = $this->service->salvarImagemOriginal($sd);

        $projetoDir        = $uploadDir  . '/' . md5($projetoImagem->getProjeto()->getId());
        $notExistsUpload   = $projetoDir . '/' . md5($idNotExistsUpload) . '.jpeg';
        $notExistsCrop     = $projetoDir . '/' . md5($idNotExistsCrop) . '.jpeg';
        $exists            = $projetoDir . '/' . $projetoImagem->getImagem()->getFilename();

        $this->assertFileNotExists($notExistsUpload);
        $this->assertFileNotExists($notExistsCrop);
        $this->assertFileExists($exists);

        $this->assertCount(1, $projetoImagemRepository->findBy(array('projeto' => 2)));
        $this->assertCount(2, $imagemRepository->findAll());
    }

    /**
     * @test
     */
    public function deveSalvarMaisSobreVocePFComSucesso()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'f', 'nome' => 'Bruno Neves', 'documento' => '832.541.658-02');
        $sd     = ServiceData::build($params)->setUser($user);

        $this->service->salvarMaisSobreVoce($sd);

        $em = $this->getEntityManager();

        $pessoa = $em->getRepository('EmVistaBundle:Pessoa')->findOneBy(array('usuario' => $user->getId()));

        $this->assertInstanceOf('\EmVista\EmVistaBundle\Entity\Pessoa', $pessoa);
        $this->assertEquals('Bruno Neves', $pessoa->getNome());
        $this->assertEquals('83254165802', $pessoa->getDocumento());
        $this->assertEquals('f', $pessoa->getTipo());
    }
    /**
     * @test
     */
    public function deveSalvarMaisSobreVocePJComSucesso()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'j', 'nome' => 'Coca Cola', 'documento' => '10.417.267/0001-32');
        $sd     = ServiceData::build($params)->setUser($user);

        $this->service->salvarMaisSobreVoce($sd);

        $em = $this->getEntityManager();

        $pessoa = $em->getRepository('EmVistaBundle:Pessoa')->findOneBy(array('usuario' => $user->getId()));

        $this->assertInstanceOf('\EmVista\EmVistaBundle\Entity\Pessoa', $pessoa);
        $this->assertEquals('Coca Cola', $pessoa->getNome());
        $this->assertEquals('10417267000132', $pessoa->getDocumento());
        $this->assertEquals('j', $pessoa->getTipo());
    }

    /**
     * @test
     */
    public function naoDeveInserirNovaPessoaSeJaExistir()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'f', 'nome' => 'Bruno Neves', 'documento' => '832.541.658-02');
        $sd     = ServiceData::build($params)->setUser($user);

        $this->service->salvarMaisSobreVoce($sd);

        $this->service->salvarMaisSobreVoce($sd);

        $em = $this->getEntityManager();

        $this->assertCount(1, $em->getRepository('EmVistaBundle:Pessoa')->findAll());

        $pessoa = $em->getRepository('EmVistaBundle:Pessoa')->findOneBy(array('usuario' => $user->getId()));

        $this->assertInstanceOf('\EmVista\EmVistaBundle\Entity\Pessoa', $pessoa);
        $this->assertEquals('Bruno Neves', $pessoa->getNome());
        $this->assertEquals('83254165802', $pessoa->getDocumento());
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeCpfForInvalido()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'f', 'nome' => 'Bruno Neves', 'documento' => '123.123.123-12');
        $sd     = ServiceData::build($params)->setUser($user);
        $this->service->salvarMaisSobreVoce($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeCnpjForInvalido()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'j', 'nome' => 'Brasil Varonil', 'documento' => '11.444.222/0000-33');
        $sd     = ServiceData::build($params)->setUser($user);
        $this->service->salvarMaisSobreVoce($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeTipoPessoaForInvalido()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'X', 'nome' => 'Brasil Varonil', 'documento' => '10.417.267/0001-32');
        $sd     = ServiceData::build($params)->setUser($user);
        $this->service->salvarMaisSobreVoce($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeDocumentoForInvalido()
    {
        $user   = $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'f', 'nome' => 'Brasil Varonil', 'documento' => 'abc');
        $sd     = ServiceData::build($params)->setUser($user);
        $this->service->salvarMaisSobreVoce($sd);
    }

    /**
     * @test
     */
    public function deveConcluirSubmissaoComSucesso()
    {
        $this->executeSalvarDadosBasicos();
        $this->executeSalvarDescricao();
        $this->executeSalvarRecompensas();
        $this->executeSalvarVideo();
        $this->executeSalvarImagens();
        $this->executeMaisSobreVoce();

        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);

        $em = $this->getEntityManager();

        $submissoes = $em->getRepository('EmVistaBundle:Submissao')->findBy(array('projeto' => 2));
        $submissao  = current($submissoes);

        $this->assertCount(1, $submissoes);
        $this->assertEquals($submissao->getStatus()->getId(), StatusSubmissao::STATUS_AGUARDANDO_APROVACAO);
        $this->assertEquals(Date::formatdmY($submissao->getDataEnvio()), date('d/m/Y'));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeConcluirComSubmissaoIdInvalido()
    {
        $sd = ServiceData::build(array('submissaoId' => 'abc'));
        $this->service->concluir($sd);
    }

    //dadosbasicos, descricao, recompensas, video, imagens, maissobrevoce

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\DadosBasicosErrorException
     */
    public function deveLancarExceptionSeConcluirComDadosBasicosIncompleto()
    {
        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\DescricaoErrorException
     */
    public function deveLancarExceptionSeConcluirComDescricaoIncompleto()
    {
        $this->executeSalvarDadosBasicos();

        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\RecompensasErrorException
     */
    public function deveLancarExceptionSeConcluirComRecompensasIncompleto()
    {
        $this->executeSalvarDadosBasicos();
        $this->executeSalvarDescricao();

        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\VideoErrorException
     */
    public function deveLancarExceptionSeConcluirComVideoIncompleto()
    {
        $this->executeSalvarDadosBasicos();
        $this->executeSalvarDescricao();
        $this->executeSalvarRecompensas();

        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\ImagensErrorException
     */
    public function deveLancarExceptionSeConcluirComImagensIncompleto()
    {
        $this->executeSalvarDadosBasicos();
        $this->executeSalvarDescricao();
        $this->executeSalvarRecompensas();
        $this->executeSalvarVideo();

        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\MaisSobreVoceErrorException
     */
    public function deveLancarExceptionSeConcluirComMaisSobreVoceIncompleto()
    {
        $this->executeSalvarDadosBasicos();
        $this->executeSalvarDescricao();
        $this->executeSalvarRecompensas();
        $this->executeSalvarVideo();
        $this->executeSalvarImagens();

        $sd = ServiceData::build(array('submissaoId' => 2));
        $this->service->concluir($sd);
    }

    private function executeSalvarDadosBasicos()
    {
        $sd = $this->getDadosBasicos();
        $sd->set('submissaoId', 2);
        $this->service->salvarDadosBasicos($sd);
    }

    private function executeSalvarDescricao()
    {
        $sd = $this->getDescricao();
        $sd->set('submissaoId', 2);
        $this->service->salvarDescricao($sd);
    }

    private function executeSalvarRecompensas()
    {
        $recompensas[] = $this->getRecompensa();
        $recompensas[] = $this->getRecompensa();
        $sd = ServiceData::build()->set('recompensas', $recompensas)->set('submissaoId', 2);
        $this->service->salvarRecompensas($sd);
    }

    private function executeSalvarVideo()
    {
        $url = 'http://www.youtube.com/watch?v=NgjgnTXxX7I&feature=g-all-lik';
        $sd = ServiceData::build()->set('url', $url)->set('submissaoId', 2)->set('siteVideoId', 1);
        $this->service->salvarVideo($sd);
    }

    private function executeSalvarImagens()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $uploadDir = $this->container->getParameter('upload_dir');
        $imagePath = $uploadDir . '/image.jpg';
        $file = new UploadedFile($imagePath, 'image.jpg', 'image/jpeg', 500, null, true);
        $sd = ServiceData::build()->set('submissaoId', 2)
                                  ->set('file', $file)
                                  ->setUser($user);
        $projetoImagem = $this->service->salvarImagemOriginal($sd);

        $params = $this->getCropParams();
        $params['projetoImagemId'] = $projetoImagem->getId();
        $this->service->cropDestaque(ServiceData::build($params));

        $params['tipoProjetoImagemId'] = 2;
        $params['h']  = 200;
        $params['w']  = 360;
        $params['x']  = 0;
        $params['y']  = 0;
        $this->service->cropDestaque(ServiceData::build($params));

        $params['tipoProjetoImagemId'] = 3;
        $params['h']  = 300;
        $params['w']  = 220;
        $this->service->cropDestaque(ServiceData::build($params));
    }

    private function executeMaisSobreVoce()
    {
        $user = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $params = array('tipoPessoa' => 'f', 'nome' => 'Bruno Neves', 'documento' => '832.541.658-02');
        $sd     = ServiceData::build($params)->setUser($user);
        $this->service->salvarMaisSobreVoce($sd);
    }

    /**
     * @test
     */
    public function deveRetornarSitesVideoComSucesso()
    {
        $sitesVideo = $this->service->getSitesVideo();
        $this->assertCount(2, $sitesVideo);
        $this->assertEquals('Youtube', $sitesVideo[0]->getNome());
        $this->assertEquals('Vimeo', $sitesVideo[1]->getNome());
    }

    /**
     * @test
     */
    public function deveRetornarParametrosDoCropComSucesso()
    {
        $cropParams = $this->service->getCropParams();
        $this->assertCount(3, $cropParams);
        $this->assertTrue(is_array(current($cropParams)));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\PermissaoNegadaException
     */
    public function deveLancarExceptionSeNaoTiverPermissaoUsuarioDiferente()
    {
        $em = $this->getEntityManager();
        $usuario = $em->find('EmVistaBundle:Usuario', 2);
        $this->service->verifyPermission(ServiceData::build(array('submissaoId' => 1))->setUser($usuario));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Services\Exceptions\Submissao\PermissaoNegadaException
     */
    public function deveLancarExceptionSeNaoTiverPermissaoProjetoJaSubmetido()
    {
        $em = $this->getEntityManager();
        $usuario = $em->find('EmVistaBundle:Usuario', 2);
        $status = $em->find('EmVistaBundle:StatusSubmissao', 2);
        $submissao = $em->find('EmVistaBundle:Submissao', 1);
        $submissao->setStatus($status);
        $em->persist($submissao);
        $em->flush();
        $this->service->verifyPermission(ServiceData::build(array('submissaoId' => 1))->setUser($usuario));
    }

    /**
     * @test
     */
    public function deveListarSubmissoesAgAprovacaoComSucesso()
    {
        $submissoes = $this->service->listarSubmissoesAguardandoAprovacao();
        $this->assertCount(1, $submissoes);
    }

    /**
     * @test
     */
    public function deveAprovarSubmissaoComSucesso()
    {
        $sd = ServiceData::build(array(
            'submissaoId' => 3,
            'statusSubmissaoId' => StatusSubmissao::STATUS_APROVADO
        ));

        $this->service->avaliarSubmissao($sd);

        $submissao = $this->getEntityManager()->find('EmVistaBundle:Submissao', 3);
        $projeto = $submissao->getProjeto();

        $dataInicio = Date::buildDateInFuture(1);
        $dataInicio->setTime(0, 0, 0);

        $dataFim = Date::buildDateInFuture(31);
        $dataFim->setTime(23, 59, 59);

        $dataAprovacao = new Date('now');

        $this->assertEquals(StatusSubmissao::STATUS_APROVADO, $submissao->getStatus()->getId());
        $this->assertEquals($dataAprovacao->format('d/m/Y'), $projeto->getDataAprovacao()->format('d/m/Y'));
        $this->assertEquals($dataInicio->format('d/m/Y H:i:s'), $projeto->getDataInicio()->format('d/m/Y H:i:s'));
        $this->assertEquals($dataFim->format('d/m/Y H:i:s'), $projeto->getDataFim()->format('d/m/Y H:i:s'));
        $this->assertEquals(false, $projeto->getPublicado());
        $this->assertEquals(null, $projeto->getStatusArrecadacao());
        $this->assertEquals(null, $projeto->getStatusFinanceiro());
    }

    /**
     * @test
     */
    public function deveRejeitarSubmissaoComSucesso()
    {
        $statusSubmissao = StatusSubmissao::STATUS_REJEITADO;
        $observacaoResposta = 'Reprovado pelos motivos xyz';

        $sd = ServiceData::build(array(
            'submissaoId' => 3,
            'statusSubmissaoId' => $statusSubmissao,
            'observacaoResposta' => $observacaoResposta
        ));

        $this->service->avaliarSubmissao($sd);

        $submissao = $this->getEntityManager()->find('EmVistaBundle:Submissao', 3);
        $projeto = $submissao->getProjeto();

        $dataResposta = new Date('now');

        $this->assertEquals($statusSubmissao, $submissao->getStatus()->getId());
        $this->assertEquals($observacaoResposta, $submissao->getObservacaoResposta());
        $this->assertEquals($dataResposta->format('d/m/Y'), $submissao->getDataResposta()->format('d/m/Y'));
        $this->assertEquals(null, $projeto->getDataAprovacao());
        $this->assertEquals(null, $projeto->getDataInicio());
        $this->assertEquals(null, $projeto->getDataFim());
        $this->assertEquals(false, $projeto->getPublicado());
        $this->assertEquals(null, $projeto->getStatusArrecadacao());
        $this->assertEquals(null, $projeto->getStatusFinanceiro());
    }

    /**
     * @test
     */
    public function deveDispararEmailAoAprovarSubmissao()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeSubmissaoIdForInvalidoAoAprovar()
    {
        $sd = ServiceData::build(array(
            'submissaoId' => 'abc',
            'statusSubmissaoId' => StatusSubmissao::STATUS_APROVADO,
            'observacaoResposta' => 'TESTE OBSERVACAO'
        ));

        $this->service->avaliarSubmissao($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeStatusSubmissaoIdForInvalidoAoAprovar()
    {
        $sd = ServiceData::build(array(
            'submissaoId' => 3,
            'statusSubmissaoId' => 'OPAOPAOPA',
            'observacaoResposta' => 'TESTE OBSERVACAO'
        ));

        $this->service->avaliarSubmissao($sd);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeObservacaoRespostaForInvalidoAoAprovar()
    {
        $sd = ServiceData::build(array(
            'submissaoId' => 3,
            'statusSubmissaoId' => StatusSubmissao::STATUS_REJEITADO,
            'observacaoResposta' => null
        ));

        $this->service->avaliarSubmissao($sd);
    }

    /**
     * @test
     */
    public function deveListarSubmissoesDoUsuarioComSucesso()
    {
        $usuario = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $sd = ServiceData::build()->setUser($usuario);
        $submissoes = $this->service->listarSubmissoesPorUsuario($sd);
        $this->assertCount(3, $submissoes);
    }
}
