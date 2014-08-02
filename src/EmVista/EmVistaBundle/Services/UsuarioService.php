<?php

namespace EmVista\EmVistaBundle\Services;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImagineInterface;
use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Email;
use EmVista\EmVistaBundle\Entity\Pessoa;
use EmVista\EmVistaBundle\Entity\Imagem;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Endereco;
use EmVista\EmVistaBundle\Entity\TokenSenha;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\TokenInvalidoException;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioJaExisteException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioNaoExisteException;
use EmVista\EmVistaBundle\Services\Exceptions\EmailDeOutroUsuarioException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioJaPossuiAcessoAdministrativoException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioNaoPossuiAcessoAdministrativoException;

class UsuarioService extends ServiceAbstract{
    
    /**
     * @var ImagineInterface
     */
    private $imagine;

    /**
     *
     * @var String 
     */
    private $profileDir;
    
    /**
     * @var String 
     */
    private $profileTempDir;
    
    /**
     *
     * @var String
     */
    private $profileWebPath;
    
    /**
     *
     * @var int
     */
    private $profileHeight;
    
    /**
     *
     * @var int 
     */
    private $profileWidth;
    
    /**
     *
     * @var String
     */
    private $profileWebTempPath;
    
    /**
     * @var Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    private $encoderFactory;
    
    
    /**
     * @param ImagineInterface $imagine
     * @return SubmissaoService
     */
    public function setImagine(ImagineInterface $imagine){
        $this->imagine = $imagine;
        return $this;
    }

    /**
     * @param Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    public function setEncoderFactory($encoderFactory){
        $this->encoderFactory = $encoderFactory;
        return $this;
    }
    
    public function setProfileDir($profileDir) {
        $this->profileDir = $profileDir;
        return $this;
    }

    public function setProfileTempDir($profileTempDir) {
        $this->profileTempDir = $profileTempDir;
        return $this;
    }

    public function setProfileWebPath($profileWebPath) {
        $this->profileWebPath = $profileWebPath;
        return $this;
    }

    public function setProfileWebTempPath($profileWebTempPath) {
        $this->profileWebTempPath = $profileWebTempPath;
        return $this;
    }
    
    public function setProfileHeight($profileHeight) {
        $this->profileHeight = $profileHeight;
        return $this;
    }

    public function setProfileWidth($profileWidth) {
        $this->profileWidth = $profileWidth;
        return $this;
    }

    
    
    /**
     *
     * @param integer $id
     * @return Usuario
     */
    public function getUsuario($id){
        return $this->getEntityManager()->getRepository('EmVistaBundle:Usuario')->find($id);
    }

    /**
     * Altera os dados pessoais de um usuário
     * @param ServiceData $sd
     * @throws ServiceValidationException
     */
    public function alterarDados(ServiceData $sd){
        try{
            $em = $this->getEntityManager();

            $this->validarAlteracaoDadosPessoais($sd->get());

            $usuario = $em->find('EmVistaBundle:Usuario', $sd->get('id'));
            $usuario->setEmail($sd->get('email'));
            $usuario->setNome($sd->get('nome'));

            $senha = $sd->get('senha');
            if(!empty($senha)){
                $password = $this->codificarSenha(ServiceData::build()->setUser($usuario)->set('senha', $senha));

                $usuario->setSenha($password);
            }
            $endereco = $usuario->getEndereco();
            if($endereco == NULL){
                $endereco = new Endereco();
                $endereco->setUsuario($usuario);
            }
            $enderecoData = $sd->get('endereco');
            $endereco->setCep($enderecoData['cep']);
            $endereco->setCidade($enderecoData['cidade']);
            $endereco->setEndereco($enderecoData['endereco']);
            $endereco->setBairro($enderecoData['bairro']);
            $endereco->setUf($enderecoData['uf']);
            
            $usuario->setEndereco($endereco);
            
            $this->validarEmailUnico($sd->get('email'), $usuario);

            $em->beginTransaction();
            $em->persist($endereco);
            $em->persist($usuario);
            $em->flush();
            $em->commit();
            return $usuario;

        }catch(\InvalidArgumentException $e){
            throw new ServiceValidationException($e->getMessage());
        }catch(Exception $e){
            $this->getEntityManager()->rollback();
            throw $e;
        }
    }

    /**
     * valida os dados de alteração
     * @param string[] $data
     */
    private function validarAlteracaoDadosPessoais($data){
        $validator = $this->getValidator();
        $isValid = $validator::arr()->key('id', $validator::positive()->int())
                                    ->key('nome', $validator::string()->length(2, 100))
                                    ->key('email', $validator::email())
                                    ->key('confirmaEmail',$validator::equals($data['email']))
                                    ->key('endereco',$validator::arr()
                                            ->key('cep',$validator::int()->length(8,8,true),false)
                                            ->key('uf',$validator::alpha()->length(2,2,true),false)
                                            ->key('cidade',$validator::string(),false)
                                            ->key('bairro',$validator::string(),false)
                                            ->key('endereco',$validator::string(),false)
                                        );

        if(!empty($data['senha'])){
            $isValid->key('senha', $validator::alnum()->length(6,50)->noWhitespace())
                    ->key('confirmaSenha',$validator::equals($data['senha']));
        }

        $isValid->check($data);
    }

    /**
     * verifica se o email vai ser único no banco
     * @param type $email
     * @param Usuario $usuario
     * @throws EmailDeOutroUsuarioException
     */
    private function validarEmailUnico($email, Usuario $usuario){
        $em = $this->getEntityManager();
        $usuariosEmail = $em->getRepository('EmVistaBundle:Usuario')->findBy(array('email' => $email));
        foreach($usuariosEmail as $item){
            if($item->getId() == $usuario->getId()){
                continue;
            }
            throw new EmailDeOutroUsuarioException();
        }
    }

    /**
     * Inativa a conta de um usuário
     * @param ServiceData $sd
     */
    public function inativarConta(ServiceData $sd){
        $em = $this->getEntityManager();
        $usuario = $sd->getUser();
        $usuario->setStatus(false);
        $em->persist($usuario);
        $em->flush();
    }

    /**
     * Lista os administradores do sistema
     * @return Usuario[]
     */
    public function listarAdministradores(){
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Usuario')
                    ->listarAdministradores();
    }

    /**
     * Lista os usuários ativos do sistema
     * @return Usuario[]
     */
    public function listarUsuariosAtivos(){
        return $this->getEntityManager()
                    ->getRepository('EmVistaBundle:Usuario')
                    ->findBy(array('status' => true), array('nome' => 'ASC'));
    }

    /**
     * Concede acesso administrativo a um usuário especifico
     * @param ServiceData $sd
     */
    public function concederAcessoAdministrativo(ServiceData $sd){
        $em = $this->getEntityManager();

        $usuario = $em->find('EmVistaBundle:Usuario', $sd->get('usuarioId'));

        if($usuario->isAdmin()){
            throw new UsuarioJaPossuiAcessoAdministrativoException();
        }

        $roleAdmin = $em->find('EmVistaBundle:Role', Role::ROLE_ADMIN);
        $usuario->addUserRole($roleAdmin);
        $em->persist($usuario);
        $em->flush();
    }

    /**
     * Remove acesso administrativo de um usuário especifico
     * @param ServiceData $sd
     */
    public function removerAcessoAdministrativo(ServiceData $sd){
        $em = $this->getEntityManager();

        $usuario = $em->find('EmVistaBundle:Usuario', $sd->get('usuarioId'));

        if(!$usuario->isAdmin()){
            throw new UsuarioNaoPossuiAcessoAdministrativoException();
        }

        $roleAdmin = $em->find('EmVistaBundle:Role', Role::ROLE_ADMIN);
        $usuario->getUserRoles()->removeElement($roleAdmin);
        $em->persist($usuario);
        $em->flush();
    }

    /**
     * @param ServiceData $data
     * @param string $data['nome']
     * @param string $data['email']
     * @param string $data['senha']
     * @return Usuario
     */
    public function registrar(ServiceData $data){
        try{
            $data = $data->get();
            $validator = $this->getValidator();
            $em = $this->getEntityManager();

            $validator::arr()->key('nome', $validator::string()->length(2, 100))
                             ->key('email', $validator::email())
                             ->key('senha', $validator::alnum()->length(6,50)->noWhitespace())
                             ->key('confirmaEmail',$validator::equals($data['email']))
                             ->key('confirmaSenha',$validator::equals($data['senha']))
                             ->check($data);

            $usuario = $em->getRepository('EmVistaBundle:Usuario')->findOneBy(array('email' => $data['email']));

            if(!empty($usuario)){
                throw new UsuarioJaExisteException();
            }

            $usuario = new Usuario();
            $usuario->setEmail($data['email']);
            $usuario->setNome($data['nome']);
            $usuario->addUserRole($em->find('EmVistaBundle:Role', Role::ROLE_USER));

            $password = $this->codificarSenha(ServiceData::build()->set('senha', $data['senha'])->setUser($usuario));

            $usuario->setSenha($password);

            $em->beginTransaction();
            $em->persist($usuario);
            $em->flush();
            $em->commit();

            return $usuario;

        }catch(\InvalidArgumentException $e){
            throw new ServiceValidationException($e->getMessage());
        }catch(Exception $e){
            $em->rollback();
            throw $e;
        }
    }

    /**
     * Codifica a senha
     * @param ServiceData $sd
     * @param string  $sd['senha']
     * @param Usuario $sd['user']
     * @return string
     */
    public function codificarSenha(ServiceData $sd){
        $usuario = $sd->getUser();
        $encoder = $this->encoderFactory->getEncoder($usuario);
        return $encoder->encodePassword($sd->get('senha'), $usuario->getSalt());
    }

    /**
     * @param ServiceData $sd
     * @param ServiceData $sd['user']
     */
    public function getPessoa(ServiceData $sd){
        $em = $this->getEntityManager();
        return $em->getRepository('EmVistaBundle:Pessoa')->findOneBy(array('usuario' => $sd->getUser()->getId()));
    }


    /**
     * @param ServiceData $sd
     * @throws ServiceValidationException
     * @throws InvalidArgumentException
     * @throws UsuarioNaoExisteException
     */
    public function esqueciMinhaSenha(ServiceData $sd){
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try{
            $v = $this->getValidator();
            $v::arr()->key('email', $v::email())
                     ->key('link', $v::string())
                     ->check($sd->get());

            $repository = $em->getRepository('EmVistaBundle:Usuario');

            $usuario = $repository->findOneBy(array('email'  => $sd->get('email'),
                                                    'status' => true));

            # verifica se foi encontrado usuario com o email informado
            if(empty($usuario)){
                throw new UsuarioNaoExisteException('Email não encontrado.');
            }

            # se existir tokens abertos pra este usuário, inativa
            $tokens = $em->getRepository('EmVistaBundle:TokenSenha')->findBy(array('usuario' => $usuario->getId()));
            foreach($tokens as $token){
                $token->setAtivo(false);
                $em->persist($token);
            }

            $token = new TokenSenha();
            $token->setUsuario($usuario);
            $em->persist($token);
            $em->flush();

            $hash = md5($token->getId() . 'emvista');
            $token->setToken($hash);
            $em->persist($token);

            $link = str_replace('TOKEN', $token->getToken(), $sd->get('link'));
            $this->sendEmailEsqueciMinhaSenha($token, $link);

            $em->flush();
            $em->commit();

        }catch(\InvalidArgumentException $e){
            throw new ServiceValidationException($e->getMessage());
        }catch(Exception $e){
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param TokenSenha $token
     * @param string $link
     */
    public function sendEmailEsqueciMinhaSenha(TokenSenha $token, $link){
        $emailTemplate = $this->getEntityManager()->find('EmVistaBundle:Email', Email::USUARIO_ALTERACAO_SENHA);
        $text = str_replace('{LINK}', $link, $emailTemplate->getTexto());

        $mailer = $this->getMailer();
        $mailer->newMessage()
               ->isHtml(true)
               ->to($token->getUsuario()->getEmail())
               ->subject($emailTemplate->getTitulo())
               ->message($text)
               ->send();
    }

    /**
     * @param ServiceData $sd
     * @return TokenSenha
     * @throws ServiceValidationException
     * @throws TokenInvalidoException
     */
    public function validarTokenSenha(ServiceData $sd){
        $em = $this->getEntityManager();

        try{
            $v = $this->getValidator();
            $v::arr()->key('token', $v::string())
                     ->check($sd->get());

            $repository = $em->getRepository('EmVistaBundle:TokenSenha');

            $token = $repository->findOneBy(array('token' => $sd->get('token')));

            $now = new \DateTime('now');

            if(!empty($token) && $now > $token->getDataExpiracao()){
                $token->setAtivo(false);
                $em->persist($token);
                $em->flush();
            }

            if(empty($token) || !$token->getAtivo()){
                throw new TokenInvalidoException('Token inválido.');
            }

            return $token;

        }catch(\InvalidArgumentException $e){
            throw new ServiceValidationException($e->getMessage());
        }
    }

    /**
     * @param ServiceData $sd
     * @throws ServiceValidationException
     * @throws InvalidArgumentException
     * @throws TokenInvalidoException
     */
    public function alterarSenha(ServiceData $sd){
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try{
            $v = $this->getValidator();
            $v::arr()->key('usuarioId', $v::positive()->int())
                     ->key('token', $v::string())
                     ->key('senha', $v::alnum()->length(6,50)->noWhitespace())
                     ->key('confirmaSenha',$v::equals($sd->get('senha')))
                     ->check($sd->get());

            $token = $em->getRepository('EmVistaBundle:TokenSenha')->findOneBy(array('token' => $sd->get('token')));

            if(false === $token->getAtivo()){
                throw new TokenInvalidoException('Token inválido.');
            }

            $token->setAtivo(false);
            $em->persist($token);

            $usuario = $em->find('EmVistaBundle:Usuario', $sd->get('usuarioId'));
            $password = $this->codificarSenha(ServiceData::build()->setUser($usuario)->set('senha', $sd->get('senha')));
            $usuario->setSenha($password);
            $em->persist($usuario);


            $em->flush();
            $em->commit();

        }catch(\InvalidArgumentException $e){
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        }catch(Exception $e){
            $em->rollback();
            throw $e;
        }
    }
    
    public function salvarImagemProfile(ServiceData $sd){
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try{
            $v = $this->getValidator();
            $v::arr()->key('file', $v::instance('Symfony\Component\HttpFoundation\File\UploadedFile'))
                     ->key('user', $v::instance('EmVista\EmVistaBundle\Entity\Usuario'))
                     ->check($sd->get());
            
            $file = $sd->get('file');
            
            if(false === file_exists($this->profileDir)){
                if(false === mkdir($this->profileDir, 0777)){
                    throw new \Exception('Permissão negada.');
                }
            }
            
            if(false === file_exists($this->profileTempDir)){
                if(false === mkdir($this->profileTempDir,0777)){
                    throw new \Exception('Permissão negada.');
                }
            }

            $mimeType = exif_imagetype($file->getRealPath());
            if(false === $file->isValid() || false === in_array($mimeType, array(IMAGETYPE_JPEG, IMAGETYPE_PNG))){
                throw new ServiceValidationException('Imagem ou formato inválido.');
            }
            
            
            $size = getimagesize($file->getRealPath());
            $originalWidth = $size[0];
            $originalHeight = $size[1];
            $height = $originalHeight;
            $width = $originalWidth;
            
            
            $filePath = $this->profileTempDir . md5($sd->getUser()->getId() . 'EmVista') . '.png';
            $webPath = $this->profileWebTempPath . md5($sd->getUser()->getId() . 'EmVista') . '.png';
            
            $file->move( $this->profileTempDir,md5($sd->getUser()->getId() . 'EmVista') . '.png');
            
            $returnFile = new \stdClass();
            $returnFile->webPath = $webPath;
            $returnFile->filePath = $filePath;
            $returnFile->width = $width;
            $returnFile->height = $height;
            $returnFile->originalName = $file->getClientOriginalName();
            
            return $returnFile;
            
        }catch(\InvalidArgumentException $e){
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        }catch(\Exception $e){
            $em->rollback();
            throw $e;
        }
        
    }
    
    public function recortaImagemProfile(ServiceData $sd){
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try{
            $v = $this->getValidator();
            $v::arr()->key('user', $v::instance('EmVista\EmVistaBundle\Entity\Usuario'))
                     ->key('x', $v::numeric())
                     ->key('y', $v::numeric())
                     ->key('w', $v::numeric())
                     ->key('h', $v::numeric())
                     ->key('escH', $v::numeric())
                     ->key('escW', $v::numeric())
                     ->key('name', $v::string()->length(0,255))
                     ->check($sd->get());
            
            $escW = $sd->get('escW');
            $escH = $sd->get('escH');
            $w = round($sd->get('w')/$escW,0);
            $h = round($sd->geT('h')/$escH,0);
            
            $x = round($sd->get('x') * $h / $sd->get('h'),0);
            $y = round($sd->get('y') * $w / $sd->get('w'),0);
            
            
            $imagem = new Imagem();
            
            $imagem ->setAltura($this->profileHeight)
                    ->setLargura($this->profileWidth)
                    ->setOriginalFilename($sd->get('name'))
                    ->setSize(0)
                    ->setExtensao('png')
                    ->setUsuario($sd->getUser());;
            if($sd->getUser()->getImagemProfile()){
                $em->remove($sd->getUser()->getImagemProfile());
                if(file_exists($this->profileDir . $sd->getUser()->getImagemProfile()->getFilename())){
                    unlink($this->profileDir . $sd->getUser()->getImagemProfile()->getFilename());
                }
            }
            
            $usuario = $sd->getUser()->setImagemProfile($imagem);
            
            $em->persist($imagem);
            $em->persist($usuario);
            $em->flush();

            $filePath = $this->profileTempDir . md5($sd->getUser()->getId() . 'EmVista') . '.png';
            
            $newFilename = $this->profileDir . md5($imagem->getId()) . '.png';
            
            
            
            $imagine = $this->imagine->open($filePath)
                            ->crop(new Point($x, $y), new Box($w, $h))
                            ->save($newFilename);
            
            $filePath = $this->profileTempDir . md5($sd->getUser()->getId() . 'EmVista') . '.png';
            unlink($filePath);
            
            $imagine = $this->imagine->open($newFilename)
                            ->thumbnail(new Box($this->profileWidth,$this->profileHeight))
                            ->save($newFilename);
            
            $imagem->setWebPath($this->profileWebPath . $imagem->getFilename());
            $em->persist($imagem);
            
            $em->flush();
            $em->commit();

            return $usuario;
        }catch(\InvalidArgumentException $e){
            $em->rollback();
            throw new ServiceValidationException($e->getMessage());
        }catch(\Exception $e){
            $em->rollback();
            throw $e;
        }
        
        
    }
}