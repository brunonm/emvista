<?php

namespace EmVista\EmVistaBundle\Controller;

use EmVista\EmVistaBundle\Entity\Imagem;
use EmVista\EmVistaBundle\Entity\ProjetoImagem;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\SubmissaoMessages;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\VideoInvalidoException;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\VideoErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\ImagensErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\DescricaoErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\PermissaoNegadaException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\RecompensasErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\DadosBasicosErrorException;
use EmVista\EmVistaBundle\Services\Exceptions\Submissao\MaisSobreVoceErrorException;

class SubmissaoController extends ControllerAbstract
{
    private function verifyPermission($submissaoId)
    {
        $sd = ServiceData::build()->setUser($this->getUser())
                                  ->set('submissaoId', $submissaoId);

        $this->get('service.submissao')->verifyPermission($sd);
    }

    /**
     * @Route("/submissao/termosUso", name="submissao_termosUso")
     */
    public function termosUsoAction()
    {
        $termosUso = $this->get('service.projeto')->getTermoUsoVigente();

        return $this->render('EmVistaBundle:Submissao:termosUso.html.php', array('termosUso' => $termosUso));
    }

    /**
     * @Route("/submissao/iniciar", name="submissao_iniciar")
     * @Method("post")
     */
    public function iniciarAction()
    {
        $sd = ServiceData::build()->setUser($this->getUser());
        $submissao = $this->get('service.submissao')->iniciar($sd);

        return $this->redirect($this->generateUrl('submissao_dados-basicos', array('submissaoId' => $submissao->getId())));
    }

    /**
     * @Route("/submissao/{submissaoId}/dadosBasicos", name="submissao_dados-basicos")
     */
    public function dadosBasicosAction($submissaoId)
    {
        try {
            $this->verifyPermission($submissaoId);

            $sd = ServiceData::build()->set('submissaoId', $submissaoId);
            $dados = $this->get('service.submissao')->dadosBasicos();
            $dados['submissao'] = $this->get('service.submissao')->getSubmissao($sd);
            $dados['step']      = 1;

            return $this->render('EmVistaBundle:Submissao:dadosBasicos.html.php', $dados);
        } catch (PermissaoNegadaException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/submissao/{submissaoId}/salvarDadosBasicos", name="submissao_salvar-dados-basicos")
     * @Method("post")
     */
    public function salvarDadosBasicosAction($submissaoId)
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->salvarDadosBasicos($sd);
            $response = $this->redirect($this->generateUrl('submissao_descricao', array('submissaoId' => $submissaoId)));
            $this->setSuccessMessage(SubmissaoMessages::DADOS_BASICOS_SALVO_SUCESSO);
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('submissao_dados-basicos', array('submissaoId' => $submissaoId)));
        }

        return $response;
    }

    /**
     * @Route("/submissao/{submissaoId}/descricao", name="submissao_descricao")
     */
    public function descricaoAction($submissaoId)
    {
        try {
            $this->verifyPermission($submissaoId);

            $sd = ServiceData::build()->set('submissaoId', $submissaoId);
            $params['submissao'] = $this->get('service.submissao')->getSubmissao($sd);
            $params['step']      = 2;

            return $this->render('EmVistaBundle:Submissao:descricao.html.php', $params);
        } catch (PermissaoNegadaException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/submissao/{submissaoId}/salvarDescricao", name="submissao_salvar-descricao")
     * @Method("post")
     */
    public function salvarDescricaoAction($submissaoId)
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->salvarDescricao($sd);
            $response = $this->redirect($this->generateUrl('submissao_recompensas', array('submissaoId' => $submissaoId)));
            $this->setSuccessMessage(SubmissaoMessages::DESCRICAO_SALVA_SUCESSO);
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('submissao_descricao', array('submissaoId' => $submissaoId)));
        }

        return $response;
    }

    /**
     * @Route("/submissao/{submissaoId}/recompensas", name="submissao_recompensas")
     */
    public function recompensasAction($submissaoId)
    {
        try {
            $this->verifyPermission($submissaoId);

            $sd = ServiceData::build()->set('submissaoId', $submissaoId);
            $params['submissao'] = $this->get('service.submissao')->getSubmissao($sd);
            $params['step']      = 3;

            return $this->render('EmVistaBundle:Submissao:recompensas.html.php', $params);
        } catch (PermissaoNegadaException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/submissao/{submissaoId}/salvarRecompensas", name="submissao_salvar-recompensas")
     * @Method("post")
     */
    public function salvarRecompensasAction($submissaoId)
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->salvarRecompensas($sd);
            $response = $this->redirect($this->generateUrl('submissao_video', array('submissaoId' => $submissaoId)));
            $this->setSuccessMessage(SubmissaoMessages::RECOMPENSAS_SALVA_SUCESSO);
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('submissao_recompensas', array('submissaoId' => $submissaoId)));
        }

        return $response;
    }

    /**
     * @Route("/submissao/{submissaoId}/video", name="submissao_video")
     */
    public function videoAction($submissaoId)
    {
        try {
            $this->verifyPermission($submissaoId);

            $sd = ServiceData::build()->set('submissaoId', $submissaoId);
            $service = $this->get('service.submissao');
            $params['submissao']  = $service->getSubmissao($sd);
            $params['sitesVideo'] = $service->getSitesVideo();
            $params['step']       = 4;

            return $this->render('EmVistaBundle:Submissao:video.html.php', $params);
        } catch (PermissaoNegadaException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/submissao/{submissaoId}/salvarVideo", name="submissao_salvar-video")
     * @Method("post")
     */
    public function salvarVideoAction($submissaoId)
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all());
            $this->get('service.submissao')->salvarVideo($sd);
            $response = $this->redirect($this->generateUrl('submissao_imagens', array('submissaoId' => $submissaoId)));
            $this->setSuccessMessage(SubmissaoMessages::VIDEO_SALVO_SUCESSO);
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('submissao_video', array('submissaoId' => $submissaoId)));
        } catch (VideoInvalidoException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_video', array('submissaoId' => $submissaoId)));
        }

        return $response;
    }

    /**
     * @Route("/submissao/{submissaoId}/imagens", name="submissao_imagens")
     */
    public function imagensAction($submissaoId)
    {
        try {
            $this->verifyPermission($submissaoId);

            $sd = ServiceData::build()->set('submissaoId', $submissaoId);
            $params['submissao'] = $this->get('service.submissao')->getSubmissao($sd);

            $sd = ServiceData::build(array('projetoId' => $params['submissao']->getProjeto()->getId()));
            $params['imagemOriginal'] = $this->get('service.projeto')->getImagemOriginal($sd);
            $params['imagemThumb'] = $this->get('service.projeto')->getImagemThumb($sd);
            
            $params['step'] = 5;

            return $this->render('EmVistaBundle:Submissao:imagens.html.php', $params);
        } catch (PermissaoNegadaException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    public function getCropParamsAction()
    {
        $result = $this->get('service.submissao')->getCropParams();

        return new Response(json_encode($result), 200, array('Content-Type' => 'application/json'));
    }

    public function salvarImagemOriginalAction ($submissaoId)
    {
        try {
            $request = $this->getRequest();

            $sd = ServiceData::build();
            $sd->set('submissaoId', $request->get('submissaoId'))
                ->set('file', $request->files->get('imagem'))
                ->setUser($this->getUser());
            /**
             * @var ProjetoImagem $projetoImagem
             */
            $projetoImagem = $this->get('service.submissao')->salvarImagemOriginal($sd);

            $return = array(
                'result' => array(
                    'webPath' => $projetoImagem->getWebPath(),
                    'projetoImagemId' => $projetoImagem->getId(),
                    'altura' => $projetoImagem->getImagem()->getAltura(),
                    'largura' => $projetoImagem->getImagem()->getLargura()
                ),
                'message' => SubmissaoMessages::IMAGEM_UPLOAD_SUCESSO,
                'status' => true
            );

        } catch (ServiceValidationException $e) {
            $return = array(
                'message' => $e->getMessage(),
                'status' => false
            );
        }

        return new Response(json_encode($return), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/submissao/{submissaoId}/salvarCrop", name="submissao_salvarCrop")
     * @Method("post")
     */
    public function salvarCropAction($submissaoId)
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all());
            /**
             * @var ProjetoImagem $pi
             */
            $pi = $this->get('service.submissao')->crop($sd);
            $return = array('status'  => true,
                'image' => $pi->getImagem()->getId(),
                'webPath' => $pi->getWebPath());
        } catch (ServiceValidationException $e) {
            $return = array(
                'message' => $e->getMessage(),
                'status'  => false
            );
        }

        return new Response(json_encode($return), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Route("/submissao/{submissaoId}/maisSobreVoce", name="submissao_mais-sobre-voce")
     */
    public function maisSobreVoceAction($submissaoId)
    {
        try {
            $this->verifyPermission($submissaoId);

            $sd = ServiceData::build()->set('submissaoId', $submissaoId);
            $user = $this->getUser();
            $service = $this->get('service.submissao');
            $params['submissao']  = $service->getSubmissao($sd);
            $params['user']       = $user;
            $params['pessoa']     = $this->get('service.usuario')->getPessoa(ServiceData::build()->setUser($user));
            $params['step']       = 6;

            return $this->render('EmVistaBundle:Submissao:maisSobreVoce.html.php', $params);
        } catch (PermissaoNegadaException $e) {
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/submissao/{submissaoId}/salvarMaisSobreVoce", name="submissao_salvar-mais-sobre-voce")
     * @Method("post")
     */
    public function salvarMaisSobreVoceAction($submissaoId)
    {
        try {
            $sd = ServiceData::build($this->getRequest()->request->all())->setUser($this->getUser());
            $this->get('service.submissao')->salvarMaisSobreVoce($sd);
            $response = $this->forward('EmVistaBundle:Submissao:concluir', array('submissaoId' => $submissaoId));
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('submissao_mais-sobre-voce', array('submissaoId' => $submissaoId)));
        }

        return $response;
    }

    /**
     * @Route("/submissao/{submissaoId}/concluir", name="submissao_concluir")
     */
    public function concluirAction($submissaoId)
    {
        $param = array('submissaoId' => $submissaoId);

        try {
            $sd = ServiceData::build(array('submissaoId' => $submissaoId));
            $this->get('service.submissao')->concluir($sd);
            $response = $this->redirect($this->generateUrl('submissao_sucesso', $param));
        } catch (ServiceValidationException $e) {
            $this->setWarningMessage(SubmissaoMessages::ERRO_VALIDACAO);
            $response = $this->redirect($this->generateUrl('submissao_mais-sobre-voce', $param));

        # SE DEU ERRO EM ALGUMA ETAPA, REDIRECIONA
        } catch (DadosBasicosErrorException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_dados-basicos', $param));
        } catch (DescricaoErrorException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_descricao', $param));
        } catch (RecompensasErrorException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_recompensas', $param));
        } catch (VideoErrorException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_video', $param));
        } catch (ImagensErrorException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_imagens', $param));
        } catch (MaisSobreVoceErrorException $e) {
            $this->setWarningMessage($e->getMessage());
            $response = $this->redirect($this->generateUrl('submissao_mais-sobre-voce', $param));
        }

        return $response;
    }

    /**
     * @Route("/submissao/{submissaoId}/sucesso", name="submissao_sucesso")
     */
    public function sucessoAction($submissaoId)
    {
        return $this->render('EmVistaBundle:Submissao:sucesso.html.php');
    }
}
