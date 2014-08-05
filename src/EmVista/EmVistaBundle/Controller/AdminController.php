<?php

namespace EmVista\EmVistaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use EmVista\EmVistaBundle\Messages\ProjetoMessages;
use EmVista\EmVistaBundle\Messages\UsuarioMessages;
use EmVista\EmVistaBundle\Messages\TermoUsoMessages;
use EmVista\EmVistaBundle\Messages\PagamentoMessages;
use EmVista\EmVistaBundle\Messages\SubmissaoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\RepasseNaoPermitidoException;

class AdminController extends ControllerAbstract{

    /**
     * @Route("/admin", name="admin_index")
     */
    public function indexAction(){
        return $this->render('EmVistaBundle:Admin:index.html.php');
    }

    /**
     * @Route("admin/gerenciar-administradores", name="admin_gerenciarAdministradores")
     */
    public function gerenciarAdministradoresAction(){
        $administradores = $this->get('service.usuario')->listarAdministradores();
        return $this->render('EmVistaBundle:Admin:gerenciarAdministradores.html.php', array('administradores' => $administradores));
    }

    /**
     * @Route("admin/vincular-usuario-administrador", name="admin_vincularUsuarioAdministrador")
     */
    public function vincularUsuarioAdministradorAction(){
        $usuarios = $this->get('service.usuario')->listarUsuariosAtivos();
        return $this->render('EmVistaBundle:Admin:vincularUsuarioAdministrador.html.php', array('usuarios' => $usuarios));
    }

    /**
     * @Route("admin/adicionar-administrador/{usuarioId}", name="admin_adicionarAdministrador")
     */
    public function adicionarAdministradorAction($usuarioId){
        $sd = ServiceData::build()->set('usuarioId', $usuarioId);

        try{
            $this->get('service.usuario')->concederAcessoAdministrativo($sd);
            $this->setSuccessMessage(UsuarioMessages::SUCESSO_ACESSO_ADMINISTRADOR);
        }catch(UsuarioJaPossuiAcessoAdministrativoException $e){
            $this->setWarningMessage(UsuarioMessages::ERROR_JA_POSSUI_ACESSO_ADMINISTRADOR);
        }

        return $this->redirect($this->generateUrl('admin_gerenciarAdministradores'));
    }

    /**
     * @Route("admin/remover-administrador/{usuarioId}", name="admin_removerAdministrador")
     */
    public function removerAdministradorAction($usuarioId){
        $sd = ServiceData::build()->set('usuarioId', $usuarioId);

        try{
            $this->get('service.usuario')->removerAcessoAdministrativo($sd);
            $this->setSuccessMessage(UsuarioMessages::SUCESSO_REMOVIDO_ACESSO_ADMINISTRADOR);
        }catch(UsuarioNaoPossuiAcessoAdministrativoException $e){
            $this->setWarningMessage(UsuarioMessages::ERROR_NAO_POSSUI_ACESSO_ADMINISTRADOR);
        }

        return $this->redirect($this->generateUrl('admin_gerenciarAdministradores'));
    }

    /**
     * @Route("/admin/pagamentos", name="admin_pagamentos")
     */
    public function pagamentosAction(){
        $repasse = $this->get('service.projeto')->listarProjetosRepasse();
        return $this->render('EmVistaBundle:Admin:pagamentos.html.php', array('repasse' => $repasse));
    }

    /**
     * @Route("/admin/informar-pagamento/projetoId/{projetoId}", name="admin_informarPagamento")
     */
    public function informarPagamentoAction($projetoId){
        try{
            $sd = ServiceData::build(array('projetoId' => $projetoId));
            $this->get('service.pagamento')->informarPagamento($sd);
            $this->setSuccessMessage(PagamentoMessages::REPASSE_SUCESSO);
        }catch(RepasseNaoPermitidoException $e){
            $this->setErrorMessage(PagamentoMessages::REPASSE_ERRO);
        }
        return $this->redirect($this->generateUrl('admin_pagamentos'));
    }

    /**
     * @Route("admin/registro-termo-uso", name="admin_registroTermoUso")
     */
    public function registroTermoUsoAction(){
        $termoUso = $this->get('service.projeto')->getTermoUsoVigente();
        return $this->render('EmVistaBundle:Admin:registroTermoUso.html.php', array('termoUso' => $termoUso));
    }

    /**
     * @Route("admin/registrar-termo-uso", name="admin_registrarTermoUso")
     */
    public function registrarTermoUsoAction(){
        $serviceData = ServiceData::build($this->getRequest()->get('termoUso'));
        try{
            $termoUso = $this->get('service.projeto')->salvarTermoUso($serviceData);
            $this->setSuccessMessage(TermoUsoMessages::TERMO_USO_SUCESSO_ALTERADO);
            $response = $this->redirect($this->generateUrl('admin_registroTermoUso'));
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(TermoUsoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('admin_registroTermoUso'));
        }
        return $response;
    }

    /**
     * @Route("admin/categorias", name="admin_categorias")
     */
    public function categoriasAction(){
        $categorias = $this->get('service.projeto')->listarCategorias();
        return $this->render('EmVistaBundle:Admin:categorias.html.php', array('categorias' => $categorias));
    }

    /**
     * @Route("admin/salvarCategoria", name="admin_salvarCategoria")
     * @Method("post")
     */
    public function salvarCategoriaAction(){
        $serviceData = ServiceData::build($this->getRequest()->get('categoria'));

        try{
            $this->get('service.projeto')->salvarCategoria($serviceData);

            if($serviceData->offsetExists('id')){
                $message = ProjetoMessages::CATEGORIA_SUCESSO_EDICAO;
            }else{
                $message = ProjetoMessages::CATEGORIA_SUCESSO_CADASTRO;
            }

            $this->setSuccessMessage($message);
            $response = $this->redirect($this->generateUrl('admin_categorias'));
        }catch(ServiceValidationException $e){
            $this->setWarningMessage(ProjetoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('admin_categorias'));
        }

        return $response;
    }

    /**
     * @Route("admin/listaAprovacaoSubmissao", name="admin_listaAprovacaoSubmissao")
     */
    public function listaAprovacaoSubmissaoAction(){
        $submissoes = $this->get('service.submissao')->listarSubmissoesAguardandoAprovacao();
        return $this->render('EmVistaBundle:Admin:listaAprovacaoSubmissao.html.php', array('submissoes' => $submissoes));
    }

    /**
     * @Route("admin/aprovacaoSubmissao/{submissaoId}", name="admin_aprovacaoSubmissao")
     */
    public function aprovacaoSubmissaoAction($submissaoId){
        $submissao = $this->get('service.submissao')
                          ->getSubmissao(ServiceData::build(array('submissaoId' => $submissaoId)));

        $pessoa = $this->get('service.usuario')
                       ->getPessoa(ServiceData::build()->setUser($submissao->getProjeto()->getUsuario()));

        $params['submissao'] = $submissao;
        $params['pessoa']    = $pessoa;

        return $this->render('EmVistaBundle:Admin:aprovacaoSubmissao.html.php', $params);
    }

    /**
     * @Route("admin/salvarAprovacaoSubmissao", name="admin_salvarAprovacaoSubmissao")
     * @Method("post")
     */
    public function salvarAprovacaoSubmissaoAction(){
        try{
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->avaliarSubmissao($sd);
            $this->setSuccessMessage(SubmissaoMessages::AVALIACAO_SUBMISSAO_SUCESSO);
        }catch(ServiceValidationException $e){
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
        }
        return $this->redirect($this->generateUrl('admin_listaAprovacaoSubmissao'));;
    }

    /**
     * @Route("admin/publicacao-projetos", name="admin_publicacaoProjetos")
     */
    public function publicacaoProjetosAction(){
        return $this->render('EmVistaBundle:Admin:publicacaoProjetos.html.php');
    }

    /**
     * @Route("admin/publicarProjetos", name="admin_publicarProjetos")
     */
    public function publicarProjetosAction(){
        try{
            $this->get('service.submissao')->publicarProjetosAprovadosNaoPublicados();
            $this->setSuccessMessage(SubmissaoMessages::PUBLICACAO_PROJETOS_SUCESSO);
        }catch(\Exception $e){
            $this->setWarningMessage($e->getMessage());
        }
        return $this->redirect($this->generateUrl('admin_index'));;
    }

    /**
     * @Route("admin/estornos", name="admin_estornos")
     */
    public function estornosAction(){
        $projetos = $this->get('service.projeto')->listarProjetosFinalizadosSemSucessoNaoEstornados();
        return $this->render('EmVistaBundle:Admin:estornos.html.php', array('projetos' => $projetos));
    }

    /**
     * @Route("admin/estornos/projeto/{projetoId}", name="admin_estornosProjeto")
     */
    public function estornosProjetoAction($projetoId){
        $projetos = $this->get('service.projeto')->listarProjetosFinalizadosSemSucessoNaoEstornados();
        return $this->render('EmVistaBundle:Admin:estornos.html.php', array('projetos' => $projetos));
    }

}
