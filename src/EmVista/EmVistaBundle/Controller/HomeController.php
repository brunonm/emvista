<?php

namespace EmVista\EmVistaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use EmVista\EmVistaBundle\Entity\TipoDestaque;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\SubmissaoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;

class HomeController extends ControllerAbstract{

    /**
     * @Route("/", name="home_index")
     */
    public function indexAction(){
//        $destaques = $this->get('service.projeto')->listarProjetosDestaqueHome();
//        $novos     = $this->get('service.projeto')->listarProjetosNovos();
//        $retaFinal = $this->get('service.projeto')->listarProjetosRetaFinal();
//
//        $secundario = isset($destaques[TipoDestaque::HOME_SECUNDARIO]) ? $destaques[TipoDestaque::HOME_SECUNDARIO] : array();
//        $primario   = isset($destaques[TipoDestaque::HOME_PRIMARIO])   ? $destaques[TipoDestaque::HOME_PRIMARIO]   : null;
        $destaques = array();
        $novos     = array();
        $retaFinal = array();
        $finalizados = array();

        $secundario = array(
            $this->get('service.projeto')->getProjeto(34),
            $this->get('service.projeto')->getProjeto(32),
        );
        $primario   = array(
            $this->get('service.projeto')->getProjeto(33),
            );

        $finalizados = array(
            $this->get('service.projeto')->getProjeto(30),
            $this->get('service.projeto')->getProjeto(19),
            $this->get('service.projeto')->getProjeto(1),
            $this->get('service.projeto')->getProjeto(2),
        );
        return $this->render(
            'EmVistaBundle:Home:index.html.php',
            array(
                'primario'   => $primario,
                'secundario' => $secundario,
                'novos'      => $novos,
                'retaFinal'  => $retaFinal,
                'finalizados' => $finalizados
            ));
    }

    /**
     * @Route("/home/footer", name="home_footer")
     */
    public function footerAction(){
        $categorias = $this->get('service.projeto')->listarCategorias();
        return $this->render('EmVistaBundle:Home:footer.html.php', array('categorias' => $categorias));
    }

    /**
     * @Route("/home/topbar", name="home_topbar")
     */
    public function topbarAction(){
        $user = $this->getUser();
        return $this->render('EmVistaBundle:Home:topbar.html.php', array('user' => $user));
    }

    /**
     * @Route("/ajuda", name="home_ajuda")
     */
    public function ajudaAction(){
        return $this->render('EmVistaBundle:Home:ajuda.html.php');
    }

    /**
     * @Route("/termos-uso", name="home_termosUso")
     */
    public function termosUsoAction(){
        $termosUso = $this->get('service.projeto')->getTermoUsoVigente();
        return $this->render('EmVistaBundle:Home:termosUso.html.php', array('termosUso' => $termosUso));
    }

    /**
     * @Route("/comece", name="home_comece")
     */
    public function comeceAction(){
        return $this->redirect($this->generateUrl('home_cadastre'), 301);
    }

    /**
     * @Route("/cadastre", name="home_cadastre")
     */
    public function cadastreAction(){
        return $this->render('EmVistaBundle:Home:comece.html.php', array('user' => $this->getUser()));
    }

    /**
     * @Route("/cadastre/submeterEmailProjeto", name="home_cadastre_submeterEmailProjeto")
     * @Method("post")
     */
    public function submeterEmailProjeto(){
        try{
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->enviarEmailSubmissao($sd);
            $message = SubmissaoMessages::PRE_CADASTRO_SUCESSO;
            $status = true;
        }catch(ServiceValidationException $e){
            $message = SubmissaoMessages::DADOS_INCOMPLETOS;
            $status = false;
        }

        $result['status']  = $status;
        $result['message'] = $message;

        return new Response(json_encode($result), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/crowdfunding", name="home_crowdfunding")
     */
    public function crowdfundingAction(){
        return $this->render('EmVistaBundle:Home:crowdfunding.html.php');
    }
}
