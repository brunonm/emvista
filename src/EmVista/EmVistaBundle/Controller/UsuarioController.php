<?php

namespace EmVista\EmVistaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\UsuarioMessages;
use Symfony\Component\Security\Core\SecurityContext;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\TokenInvalidoException;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioJaExisteException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioNaoExisteException;
use EmVista\EmVistaBundle\Services\Exceptions\EmailDeOutroUsuarioException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\PermissaoNegadaException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioJaPossuiAcessoAdministrativoException;
use EmVista\EmVistaBundle\Services\Exceptions\UsuarioNaoPossuiAcessoAdministrativoException;

class UsuarioController extends ControllerAbstract{

    /**
     * @Route("/usuario/meus-projetos", name="usuario_meusProjetos")
     */
    public function meusProjetosAction(){
        $sd = ServiceData::build()->setUser($this->getUser());
        $submissoes = $this->get('service.submissao')->listarSubmissoesPorUsuario($sd);
        return $this->render('EmVistaBundle:Usuario:meusProjetos.html.php', array('submissoes' => $submissoes,
                                                                                  'active' => 'meusProjetos',
                                                                                  'usuario' => $this->getUser()
                ));
    }

    /**
     * @Route("/usuario/contribuicoes", name="usuario_contribuicoes")
     */
    public function contribuicoesAction(){
        $sd = ServiceData::build()->setUser($this->getUser());
        $doacoes = $this->get('service.projeto')->listarDoacoesPorUsuario($sd);
        return $this->render('EmVistaBundle:Usuario:contribuicoes.html.php', array('doacoes' => $doacoes,
                                                                                   'active' => 'contribuicoes',
                                                                                   'usuario' => $this->getUser()));
    }

    /**
     * @Route("/usuario/dados-pessoais", name="usuario_dadosPessoais")
     */
    public function dadosPessoaisAction(){
        return $this->render('EmVistaBundle:Usuario:dadosPessoais.html.php', array('usuario' => $this->getUser()
                            ,'active' => 'dadosPessoais'));
    }

    /**
     * @Route("/usuario/alterar-dados-pessoais", name="usuario_alterarDadosPessoais")
     */
    public function alterarDadosPessoaisAction(){
        $serviceData = ServiceData::build($this->getRequest()->get('usuario'));

        try{
            $this->get('service.usuario')->alterarDados($serviceData);
            $this->setSuccessMessage(UsuarioMessages::SUCESSO_DADOS_ALTERADOS);
        }catch(ServiceValidationException $e){
            $this->setWarningMessage(UsuarioMessages::ERRO_VALIDACAO);
        }catch(EmailDeOutroUsuarioException $e){
            $this->setErrorMessage(UsuarioMessages::ERRO_EMAIL_OUTRA_CONTA);
        }

        return $this->redirect($this->generateUrl('usuario_dadosPessoais'));
    }

    /**
     * @Route("/usuario/confirmacao-inativar-conta", name="usuario_confirmacaoInativarConta")
     */
    public function confirmacaoInativarContaAction(){
        return $this->render('EmVistaBundle:Usuario:confirmacaoInativarConta.html.php', array('usuario' => $this->getUser(),
                                                                                              'active' => 'dadosPessoais'));
    }

    /**
     * @Route("/usuario/inativar-conta", name="usuario_inativarConta")
     */
    public function inativarContaAction(){
        $serviceData = ServiceData::build()->setUser($this->getUser());
        $this->get('service.usuario')->inativarConta($serviceData);
        $this->setSuccessMessage(UsuarioMessages::SUCESSO_CONTA_INATIVADA);
        return $this->redirect($this->generateUrl('logout'));
    }

    /**
     * @Route("/usuario/login", name="usuario_login")
     */
    public function loginAction(){
        $request = $this->getRequest();
        $session = $request->getSession();

        try{

            if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
            }else{
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                $session->remove(SecurityContext::AUTHENTICATION_ERROR);
            }

            # se tiver erro nas credenciais, lanca exception
            if($error instanceof \Exception){
                throw $error;
            }

        }catch(BadCredentialsException $e){
            $this->setWarningMessage(UsuarioMessages::ERROR_LOGIN);
        }

        return $this->render('EmVistaBundle:Usuario:registro.html.php', array(
                   'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                   'focado'        => 'login'
               ));
    }

    /**
     * @Route("/usuario/registro", name="usuario_registro")
     */
    public function registroAction(){
        return $this->render('EmVistaBundle:Usuario:registro.html.php', array(
                   'last_username' => null,
                   'focado'        => 'registro'
               ));
    }

    /**
     * @Route("/usuario/registrar", name="usuario_registrar")
     * @Method("post")
     */
    public function registrarAction(){
        $sd = ServiceData::build($this->getRequest()->get('usuario'));
        try{
            $usuario = $this->get('service.usuario')->registrar($sd);

            # loga o usuário automaticamente
            $token = new UsernamePasswordToken($usuario, $sd->get('senha'), 'main', $usuario->getRoles());
            $this->get('security.context')->setToken($token);

            $response = $this->redirect($this->generateUrl('usuario_registroSucesso'));
        }catch(ServiceValidationException $e){
            $this->setNoticeMessage(UsuarioMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('usuario_registro'));
        }catch(UsuarioJaExisteException $e){
            $this->setWarningMessage(UsuarioMessages::ERRO_USUARIO_JA_EXISTE);
            $response = $this->redirect($this->generateUrl('usuario_registro'));
        }
        return $response;
    }

    /**
     * @Route("/usuario/registro-sucesso", name="usuario_registroSucesso")
     */
    public function registroSucessoAction(){
        return $this->render('EmVistaBundle:Usuario:registroSucesso.html.php');
    }

    /**
     * @Route("/usuario/esqueci-minha-senha", name="usuario_esqueciMinhaSenha")
     */
    public function esqueciMinhaSenhaAction(){
        return $this->render('EmVistaBundle:Usuario:esqueciMinhaSenha.html.php');
    }

    /**
     * @Route("/usuario/enviar-esqueci-minha-senha", name="usuario_enviarEsqueciMinhaSenha")
     */
    public function enviarEsqueciMinhaSenhaAction(){

        $link = $this->getRequest()->server->get('HTTP_HOST') .
                $this->generateUrl('usuario_validarTokenSenha', array('token' => 'TOKEN'));

        $sd = ServiceData::build($this->getRequest()->request->all());
        $sd->set('link', $link);

        try{
            $this->get('service.usuario')->esqueciMinhaSenha($sd);
            $this->setSuccessMessage(UsuarioMessages::SUCESSO_ENVIO_ESQUECI_MINHA_SENHA);
            $route = 'home_index';

        }catch(UsuarioNaoExisteException $e){
            $this->setErrorMessage($e->getMessage());
            $route = 'usuario_esqueciMinhaSenha';
        }

        return $this->redirect($this->generateUrl($route));
    }

    /**
     * @Route("/usuario/validar-token-senha/{token}", name="usuario_validarTokenSenha")
     */
    public function validarTokenSenhaAction($token){
        $sd = ServiceData::build()->set('token', $token);

        try{
            $token = $this->get('service.usuario')->validarTokenSenha($sd);
            $response = $this->forward('EmVistaBundle:Usuario:cadastroNovaSenha', array('token' => $token));

        }catch(TokenInvalidoException $e){
            $this->setErrorMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('home_index'));
        }

        return $response;
    }

    /**
     * @Route("/usuario/cadastro-nova-senha", name="usuario_cadastroNovaSenha")
     */
    public function cadastroNovaSenhaAction($token){
        return $this->render('EmVistaBundle:Usuario:cadastroNovaSenha.html.php', array('token' => $token));
    }

    /**
     * @Route("/usuario/alterar-senha", name="usuario_alterarSenha")
     * @Method("post")
     */
    public function alterarSenhaAction(){
        $sd = ServiceData::build($this->getRequest()->request->all());

        try{
            $this->get('service.usuario')->alterarSenha($sd);
            $this->setSuccessMessage(UsuarioMessages::SUCESSO_ALTERAÇÃO_SENHA);
            $response = $this->redirect($this->generateUrl('home_index'));

        }catch(ServiceValidationException $e){
            $this->setErrorMessage(UsuarioMessages::ERRO_ALTERAÇÃO_SENHA);
            $response = $this->redirect($this->generateUrl('usuario_validarTokenSenha', array('token' => $sd->get('token'))));

        }catch(TokenInvalidoException $e){
            $this->setErrorMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('home_index'));
        }

        return $response;
    }

    /**
     * @Route("/usuario/salvarImagemTemporariaProfile", name="usuario_salvarImagemTemporariaProfile")
     * @Method("post")
     */
    public function salvarImagemTemporariaProfileAction(){

        try{

            $request = $this->getRequest();
            $sd = ServiceData::build();
            $sd->set('file', $request->files->get('image'))
               ->setUser($this->getUser());

            $profileImagem = $this->get('service.usuario')->salvarImagemProfile($sd);

            $return = array('status' => true,
                'message' => 'ok',
                'url' => $profileImagem->webPath,
                'h' => $profileImagem->height,
                'w' => $profileImagem->width,
                'name' => $profileImagem->originalName);

        }  catch (Exception $e){
            $return = array(
                'message' => $e->getMessage(),
                'status'  => false
            );
        }
        return new Response(json_encode($return),200,array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/usuario/recortaImagemProfile", name="usuario_recortaImagemProfile")
     * @Method("post")
     */
    public function recortaImagemProfileAction(){

        try{
            $sd = ServiceData::build($this->getRequest()->request->all());
            $sd->setUser($this->getUser());
            $usuario = $this->get('service.usuario')->recortaImagemProfile($sd);
             $return =
            array('status' => true,
                'message' => 'ok',
                'url' => $usuario->getImagemProfile()->getWebPath(),
                'imagemId' => $usuario->getImagemProfile()->getId()
            );

        }  catch (Exception $e){
            $return = array(
                'message' => $e->getMessage(),
                'status'  => false
            );
        }
        return new Response(json_encode($return),200,array('Content-Type' => 'application/json'));

    }

    /**
     * @Route("/usuario/apoiadores-projeto/{projetoId}", name="usuario_apoiadoresProjeto")
     */
    public function apoiadoresProjetoAction($projetoId){
        try{

            $projeto = $this->get('service.projeto')->getProjeto($projetoId);

            if($projeto->getUsuario()->getId() != $this->getUser()->getId()){
                throw new PermissaoNegadaException();
            }

            $sd = ServiceData::build(array('projetoId' => $projetoId));
            $apoiadores = $this->get('service.projeto')->listApoiadoresProjeto($sd);
            return $this->render('EmVistaBundle:Usuario:apoiadoresProjeto.html.php',
                                array('apoiadores' => $apoiadores,
                                    'projeto'    => $this->get('service.projeto')->getProjeto($projetoId)));

        }catch(PermissaoNegadaException $e){
            return $this->redirect($this->generateUrl('home_index'));
        }
    }
}
