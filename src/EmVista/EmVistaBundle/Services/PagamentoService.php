<?php

namespace EmVista\EmVistaBundle\Services;

use EmVista\EmVistaBundle\Entity\Email;
use EmVista\EmVistaBundle\Entity\Doacao;
use EmVista\EmVistaBundle\Entity\LogPagamento;
use EmVista\EmVistaBundle\Entity\StatusDoacao;
use EmVista\EmVistaBundle\Entity\StatusFinanceiro;
use EmVista\EmVistaBundle\Entity\GatewayPagamento;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira;
use EmVista\EmVistaBundle\Entity\UsuarioDetalhesPagamento;
use EmVista\EmVistaBundle\Entity\TipoMovimentacaoFinanceira;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceAbstract;
use EmVista\EmVistaBundle\Services\Exceptions\InvalidTokenException;
use EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException;
use EmVista\EmVistaBundle\Services\Exceptions\RepasseNaoPermitidoException;
use EmVista\EmVistaBundle\Services\Exceptions\QuantidadeMaximaDeRecompensaAtingidaException;

class PagamentoService extends ServiceAbstract
{
    /**
     * @var \Tear\MoipBundle\Services\Moip
     */
    private $paymentGateway;

    /**
     * @param  ServiceData $sd
     * @throws Exception
     */
    public function atualizarValorArrecadado(ServiceData $sd)
    {
        $em      = $this->getEntityManager();
        $projeto = $em->find('EmVistaBundle:Projeto', $sd->get('projetoId'));


        try {
            $valorArrecadado = (float) $em->getRepository('EmVistaBundle:Projeto')->calcularValorArrecadado($projeto->getId());
            $projeto->setValorArrecadado($valorArrecadado);
            $em->persist($projeto);
            $em->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param ServiceData $sd
     */
    public function atualizaQuantidadeApoiadores(ServiceData $sd)
    {
    }

    /**
     * @param  ServiceData $sd
     * @throws Exception
     */
    public function cancel(ServiceData $sd)
    {
        $em            = $this->getEntityManager();
        $movFinanceira = $em->find('EmVistaBundle:MovimentacaoFinanceira', $sd->get('movFinanceiraId'));

        try {
            $em->beginTransaction();

            $status = $em->find('EmVistaBundle:StatusDoacao', StatusDoacao::CANCELADO);

            $doacao = $movFinanceira->getDoacao();
            $doacao->setStatus($status);

            $em->persist($doacao);
            $em->flush();
            $em->commit();

        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param ServiceData $sd
     */
    public function informarPagamento(ServiceData $sd)
    {
        $em = $this->getEntityManager();

        $status = $em->find('EmVistaBundle:StatusFinanceiro', StatusFinanceiro::STATUS_PAGO);

        $projeto = $em->find('EmVistaBundle:Projeto', $sd->get('projetoId'));

        if ($projeto->getStatusFinanceiro() != null) {
            throw new RepasseNaoPermitidoException();
        }

        $projeto->setStatusFinanceiro($status);
        $em->persist($projeto);
        $em->flush();
    }

    /**
     * @param \Tear\MoipBundle\Services\Moip $gateway
     */
    public function setPaymentGateway($gateway)
    {
        $this->paymentGateway = $gateway;
    }

    /**
     * @param  ServiceData                                   $sd
     * @return string
     * @throws Exception
     * @throws ServiceValidationException
     * @throws QuantidadeMaximaDeRecompensaAtingidaException
     */
    public function checkout(ServiceData $sd)
    {
        $em = $this->getEntityManager();
        $em->beginTransaction();

        try {
            $v = $this->getValidator();
            $v::arr()->key('valor',$v::float()->min(0))
                     ->key('recompensaId',$v::int()->min(0))
                     ->key('ip',$v::ip())
                     ->check($sd->get());

            $valor      = $sd->get('valor');
            $usuario    = $sd->getUser();
            $recompensa = $em->find('EmVistaBundle:Recompensa', $sd->get('recompensaId'));
            $status     = $em->find('EmVistaBundle:StatusDoacao', StatusDoacao::AGUARDANDO);
            $gateway    = $em->find('EmVistaBundle:GatewayPagamento',  GatewayPagamento::MOIP);

            if ($valor < $recompensa->getValorMinimo()) {
                throw new ServiceValidationException('Valor inválido para a recompensa escolhida.');
            }

            if ($recompensa->getQuantidadeMaximaApoiadores() > 0) {
                if ($recompensa->getQuantidadeMaximaApoiadores() <= $recompensa->getQuantidadeApoiadores()) {
                    throw new QuantidadeMaximaDeRecompensaAtingidaException('Quantidade maxima de apoiadores para essa recompensa alcançada.');
                }
            }

            $doacao = new Doacao();
            $doacao->setRecompensa($recompensa)
                   ->setStatus($status)
                   ->setUsuario($usuario)
                   ->setValor($valor);

            $em->persist($doacao);

            $tipoMovFinanceira = $em->find('EmVistaBundle:TipoMovimentacaoFinanceira', TipoMovimentacaoFinanceira::PAGAMENTO);
            $movFinanceira = new MovimentacaoFinanceira();
            $movFinanceira->setDoacao($doacao)
                          ->setToken('')
                          ->setValor($valor)
                          ->setGatewayPagamento($gateway)
                          ->setTipoMovimentacaoFinanceira($tipoMovFinanceira);

            $em->persist($movFinanceira);
            $em->flush();

            $descricao = 'Apoio para o projeto "' . $recompensa->getProjeto()->getNome() . '" ';

            $this->paymentGateway->setValue($valor)
                                 ->setReason(utf8_decode($descricao))
                                 ->setUniqueID($movFinanceira->getId())
                                 ->setReturnURL('http://culturacrowd.capital/pagamento/retorno-pagamento/' . $movFinanceira->getId())
                                 ->send();

            $response = $this->paymentGateway->getAnswer(false);
            $movFinanceira->setToken($response->getToken());
            $em->persist($movFinanceira);

            $conteudoEnvio = $this->paymentGateway->getXML();
            $conteudoRetorno = $this->paymentGateway->getAnswer(true);

            $log = new LogPagamento();
            $log->setConteudoEnvio($conteudoEnvio)
                ->setConteudoRetorno($conteudoRetorno)
                ->setHost($sd->get('ip'))
                ->setMovimentacaoFinanceira($movFinanceira);

            $em->persist($movFinanceira);
            $em->persist($log);
            $em->flush();

            $this->sendEmailCheckout($doacao);

            $em->commit();

            return $response->payment_url;

        } catch (\InvalidArgumentException $e) {
            $em->rollback();
            throw new ServiceValidationException();
        } catch (\Exception $e) {
            $em->rollback();
            throw $e;
        }
    }

    /**
     * @param  ServiceData                $sd
     * @return MovimentacaoFinanceira
     * @throws ServiceValidationException
     * @throws InvalidArgumentException
     * @throws InvalidTokenException
     */
    public function review(ServiceData $sd)
    {
        $em = $this->getEntityManager();

        try {
            $this->validaReview($sd->get());

            $movFinanceiraId = $sd->get('movFinanceiraId');
            $movFinanceira   = $em->getRepository('EmVistaBundle:MovimentacaoFinanceira')->find($movFinanceiraId);


            if (empty($movFinanceira)) {
                throw new InvalidTokenException('Token inválido');
            }

            $token = $movFinanceira->getToken();

            $this->paymentGateway->getDetails($token);
            $xml = $this->paymentGateway->getDetailsAnswer(true);


            // log
            $encoder = new JsonEncoder();
            $log     = new LogPagamento();
            $log->setConteudoEnvio($encoder->encode($sd->get('post'), 'json'))
                ->setConteudoRetorno($xml)
                ->setHost($sd->get('ip'));

            $em->persist($log);


            $response = $this->paymentGateway->getDetailsAnswer();
            //pego as informações do gateway e informo no sistema
            $usuario = $movFinanceira->getDoacao()->getUsuario();
            $gateway = $movFinanceira->getGatewayPagamento();

            $usuarioDetalhesPag = $em->getRepository('EmVistaBundle:UsuarioDetalhesPagamento')
                                     ->findOneBy(array('usuario' => $usuario->getId(),
                                                       'gatewayPagamento' => $gateway->getId()));

            if (empty($usuarioDetalhesPag)) {
                $usuarioDetalhesPag = new UsuarioDetalhesPagamento();
                $usuarioDetalhesPag->setGateway($gateway);
            }

            if ($response->pagador) {
                $usuarioDetalhesPag->setUsuario($usuario)
                                   ->setGatewayId($response->pagador->Email)
                                   ->setGatewayEmail($response->pagador->Email)
                                   ->setPrimeiroNome($response->pagador->Nome)
                                   ->setPais($response->enderecoCobranca->Pais);
            }
            //verifico se o status atual é diferente do ultimo status dele
            if ($response->pagamento) {
                $arrayPagamento = $response->pagamento;
                $pagamento = current($arrayPagamento);
                $doacao = $movFinanceira->getDoacao();
                $statusDoacao = $doacao->getStatus();
                $statusPagamentoGateway = $pagamento->Status['Tipo'];


                $statusGateway = $em->getRepository('EmVistaBundle:StatusPagamento')
                                    ->findOneBy(array('gatewayPagamento' => $gateway->getId(),
                                                      'gatewayStatus' => $statusPagamentoGateway));

                if ($statusDoacao->getId() != $statusGateway->getStatusDoacao()->getId()) {

                    $doacao->setStatus($statusGateway->getStatusDoacao());
                    $em->persist($doacao);

                    if ($statusGateway->getStatusDoacao()->getId() == StatusDoacao::APROVADO ) {
                        $recompensa = $doacao->getRecompensa();
                        $qtApoiadores = $recompensa->getQuantidadeApoiadores() + 1;
                        $recompensa->setQuantidadeApoiadores($qtApoiadores);
                        $em->persist($recompensa);
                    }
                }

                $movFinanceira->setTaxa($pagamento->TaxaMoIP);
                $movFinanceira->setValorLiquido($pagamento->ValorLiquido);
                $movFinanceira->setStatus($pagamento->Status);
                $movFinanceira->setTransacaoId(str_replace('.','',$pagamento->CodigoMoIP));
                $em->persist($movFinanceira);
            }

            $em->persist($usuarioDetalhesPag);
            $em->flush();



            if($doacao->getStatus()->getId() == StatusDoacao::APROVADO) {

                $this->atualizarValorArrecadado(ServiceData::build(array(
                    'projetoId' => $doacao->getRecompensa()->getProjeto()->getId())));

                //$this->sendEmailConfirmacaoPagamento($doacao);
            }

            return $movFinanceira;

        } catch (\InvalidArgumentException $e) {
            throw new ServiceValidationException($e);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param type $data
     */
    public function validaReview($data)
    {
        $r = $this->getValidator();
        $r::arr()->key('movFinanceiraId',$r::int()->min(0))
                 ->key('ip',$r::ip())
                 ->check($data);

    }

    /**
     * @param Doacao $doacao
     */
    private function sendEmailCheckout($doacao)
    {
        $emailRepository = $this->getEntityManager()->getRepository('EmVistaBundle:Email');
        $mailer = $this->getMailer();

        $recompensa = $doacao->getRecompensa();
        $apoiador   = $doacao->getUsuario();
        $projeto    = $recompensa->getProjeto();

        $template = $emailRepository->find(Email::APOIADOR_RECEMOS_SUA_CONTRIBUICAO);

        $text = str_replace(array('{PROJETO}', '{VALOR}', '{RECOMPENSA}'),
                            array($projeto->getNome(), $doacao->getValorFormatado(), $recompensa->getTitulo()),
                            $template->getTexto());

        $mailer->newMessage()
               ->to($apoiador->getEmail())
               ->subject($template->getTitulo())
               ->message($text)
               ->isHtml(true)
               ->send();
    }

    /**
     * @param Doacao $doacao
     */
    private function sendEmailConfirmacaoPagamento($doacao)
    {
        $emailRepository = $this->getEntityManager()->getRepository('EmVistaBundle:Email');
        $mailer = $this->getMailer();

        $recompensa = $doacao->getRecompensa();
        $apoiador   = $doacao->getUsuario();
        $projeto    = $recompensa->getProjeto();

        $template = $emailRepository->find(Email::APOIADOR_CONFIRMACAO_DE_PAGAMENTO);

        $text = str_replace(array('{PROJETO}', '{VALOR}', '{RECOMPENSA}'),
                            array($projeto->getNome(), $doacao->getValorFormatado(), $recompensa->getTitulo()),
                            $template->getTexto());

        $mailer->newMessage()
               ->to($apoiador->getEmail())
               ->subject($template->getTitulo())
               ->message($text)
               ->isHtml(true)
               ->send();

        $template = $emailRepository->find(Email::AUTOR_CONTRIBUICAO_RECEBIDA);

        $text = str_replace(array('{NOME}', '{EMAIL}', '{VALOR}', '{PROJETO}', '{RECOMPENSA}'),
                            array($apoiador->getNome(), $apoiador->getEmail(), $doacao->getValorFormatado(), $projeto->getNome(), $recompensa->getTitulo()),
                            $template->getTexto());

        $mailer->newMessage()
               ->to($projeto->getUsuario()->getEmail())
               ->subject($template->getTitulo())
               ->message($text)
               ->isHtml(true)
               ->send();
    }

    public function cancelaDoacoesAbertasExpiradas()
    {
        $em = $this->getEntityManager();
        $doacoesRepository = $this->getEntityManager()->getRepository('EmVistaBundle:Doacao');
        $doacoes = $doacoesRepository->getDoacoesExpirados();

        foreach ($doacoes as $doacao) {
            $doacao->setStatus($em->getRepository('EmVistaBundle:StatusDoacao')->find(StatusDoacao::CANCELADO));
            foreach ($doacao->getMovimentacoesFinanceiras() as $mf) {
                $mf->setStatus('Cancelado');
                $em->persist($mf);
            }
            $em->persist($doacao);
        }
        $em->flush();
    }

}
