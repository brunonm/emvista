<?php

namespace EmVista\EmVistaBundle\Controller;

use EmVista\EmVistaBundle\Entity\SiteVideo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\SubmissaoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Messages\UsuarioMessages;

class HomeController extends ControllerAbstract
{
    /**
     * @Route("/", name="home_index")
     */
    public function indexAction()
    {
        $projetos = $this->get('service.projeto')->getMore(ServiceData::build(array('lastProjectId' => 0, 'count' => 8)));

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
     * @return Response
     */
    public function contatoAction()
    {
        return $this->render('EmVistaBundle:Home:contato.html.php');
    }
    
    /**
     * @return Response
     */
    public function enviarEmailAction()
    {
        $sd = ServiceData::build($this->getRequest()->request->all());
        
        try {
            $this->get('service.usuario')->enviarEmailContato($sd);
            $this->setSuccessMessage(UsuarioMessages::SUCESSO_EMAIL_CONTATO);
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(UsuarioMessages::ERRO_VALIDACAO);
        }
        
        return $this->redirect($this->generateUrl('home_index'));
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
    /**
     * @Route("/crowdfunding-festival", name="home_crowdfunding-Festival")
     */
    public function crowdfundingFestivalAction()
    {
        $siteVideo = $this->get('doctrine')->getRepository('EmVistaBundle:SiteVideo')->find(SiteVideo::VIMEO);
        return $this->render('EmVistaBundle:Home:festival.html.php', array(
            'siteVideo' => $siteVideo,
            'videos' => array(
                array('unique' => 70583304),
                array('unique' => 68496010),
                array('unique' => 68492930),
                array('unique' => 67839064),
                array('unique' => 67835997),
                array('unique' => 67779634),
                array('unique' => 67275161),
                array('unique' => 67275160),
                array('unique' => 67275159),
                array('unique' => 66444100),
                array('unique' => 66444099),
                array('unique' => 66444097),
                array('unique' => 66444096),
                array('unique' => 66444095),
                array('unique' => 55512008),
                array('unique' => 55147771),
                array('unique' => 54894389),
                array('unique' => 54673534),
                array('unique' => 54571608),
                array('unique' => 54335782),
                array('unique' => 54064573),
                array('unique' => 52188952),
                array('unique' => 51800999),
                array('unique' => 50813014),
            )
        ));
    }
}
