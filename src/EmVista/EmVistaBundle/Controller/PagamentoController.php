<?php

namespace EmVista\EmVistaBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use EmVista\EmVistaBundle\Messages\PagamentoMessages;
use EmVista\EmVistaBundle\Entity\StatusArrecadacao;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use EmVista\EmVistaBundle\Core\Controller\ControllerAbstract;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Services\Exceptions\QuantidadeMaximaDeRecompensaAtingidaException;

class PagamentoController extends ControllerAbstract{

    /**
     * @Route("/pagamento/checkout/{projetoId}", name="pagamento_checkout")
     */
    public function checkoutAction($projetoId){
        $projeto = $this->get('service.projeto')->getProjeto($projetoId);

        // so visualiza a tela se o projeto estiver arrecadando
        if(!$projeto->getStatusArrecadacao() || $projeto->getStatusArrecadacao()->getId() != StatusArrecadacao::STATUS_EM_ANDAMENTO){
            return $this->redirect($this->generateUrl('home_index'));
        }

        return $this->render('EmVistaBundle:Pagamento:checkout.html.php', array('projeto' => $projeto));
    }

    /**
     * @Route("/pagamento/continue-checkout", name="pagamento_continueCheckout")
     */
    public function continueCheckoutAction(){
        try{
            $serviceData = ServiceData::build($this->getRequest()->get('apoio'));
            $serviceData->setUser($this->getUser());
            $serviceData->set('ip',$this->container->get('request')->getClientIp());
            $url = $this->get('service.pagamento')->checkout($serviceData);
            return $this->redirect($url);
        }catch(QuantidadeMaximaDeRecompensaAtingidaException $e){
            $this->setWarningMessage(PagamentoMessages::QUANTIDADE_MAX_RECOMPENSAS_ATINGIDA);
            return $this->redirect($this->generateUrl('home_index'));
        }catch(ServiceValidationException $e){
            $this->setWarningMessage(PagamentoMessages::VALOR_INVALIDO_PARA_RECOMPENSA);
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/pagamento/review", name="pagamento_review")
     */
    public function reviewAction(){
        try{
            $serviceData = ServiceData::build();
            $serviceData->set('movFinanceiraId', $this->getRequest()->get('id_transacao'));
            $serviceData->set('post',$this->getRequest()->request->all());
            $serviceData->set('ip',$this->container->get('request')->getClientIp());
            $movFinanceira = $this->get('service.pagamento')->review($serviceData);
            return $this->render('EmVistaBundle:Pagamento:review.html.php', array('movFinanceira' => $movFinanceira));
        }catch(ServiceValidationException $e){
            return $this->redirect($this->generateUrl('home_index'));
        }
    }

    /**
     * @Route("/pagamento/retorno-pagamento/{movFinanceiraId}", name="pagamento_retornoPagamento")
     */
    public function retornoPagamentoAction($movFinanceiraId){
        $serviceData = ServiceData::build();
        $serviceData->set('movFinanceiraId', $movFinanceiraId);
        $serviceData->set('post',$this->getRequest()->request->all());
        $serviceData->set('ip',$this->container->get('request')->getClientIp());
        $movFinanceira = $this->get('service.pagamento')->review($serviceData);
        return $this->render('EmVistaBundle:Pagamento:retornoPagamento.html.php', array('movFinanceira' => $movFinanceira));
    }
    
}