<?php

namespace EmVista\EmVistaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\SubmissaoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;

class HomeController extends ControllerAbstract
{
    /**
     * @Route("/", name="home_index")
     */
    public function indexAction()
    {
        $projetos = array(
            $this->get('service.projeto')->getProjeto(1),
            $this->get('service.projeto')->getProjeto(1),
            $this->get('service.projeto')->getProjeto(1),
            $this->get('service.projeto')->getProjeto(1),
            $this->get('service.projeto')->getProjeto(1),
            $this->get('service.projeto')->getProjeto(1),
        );
        return $this->render(
            'EmVistaBundle:Home:index.html.php',
            array(
                'projetos'   => $projetos,
            ));
    }

    /**
     * @Route("/home/footer", name="home_footer")
     */
    public function footerAction()
    {
        $categorias = $this->get('service.projeto')->listarCategorias();

        return $this->render('EmVistaBundle:Home:footer.html.php', array('categorias' => $categorias));
    }

    /**
     * @Route("/home/topbar", name="home_topbar")
     */
    public function topbarAction()
    {
        $user = $this->getUser();

        return $this->render('EmVistaBundle:Home:topbar.html.php', array('user' => $user));
    }

    /**
     * @Route("/ajuda", name="home_ajuda")
     */
    public function ajudaAction()
    {
        return $this->render('EmVistaBundle:Home:ajuda.html.php');
    }

    /**
     * @Route("/termos-uso", name="home_termosUso")
     */
    public function termosUsoAction()
    {
        $termosUso = $this->get('service.projeto')->getTermoUsoVigente();

        return $this->render('EmVistaBundle:Home:termosUso.html.php', array('termosUso' => $termosUso));
    }

    /**
     * @Route("/comece", name="home_comece")
     */
    public function comeceAction()
    {
        return $this->redirect($this->generateUrl('home_cadastre'), 301);
    }

    /**
     * @Route("/cadastre", name="home_cadastre")
     */
    public function cadastreAction()
    {
        return $this->render('EmVistaBundle:Home:comece.html.php', array('user' => $this->getUser()));
    }

    /**
     * @Route("/cadastre/submeterEmailProjeto", name="home_cadastre_submeterEmailProjeto")
     * @Method("post")
     */
    public function submeterEmailProjetoAction()
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->enviarEmailSubmissao($sd);
            $message = SubmissaoMessages::PRE_CADASTRO_SUCESSO;
            $status = true;
        } catch (ServiceValidationException $e) {
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
    public function crowdfundingAction()
    {
        return $this->render('EmVistaBundle:Home:crowdfunding.html.php');
    }
}
