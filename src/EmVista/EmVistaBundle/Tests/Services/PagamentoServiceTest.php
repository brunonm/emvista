<?php

namespace EmVista\EmVistaBundle\Tests\Services;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Entity\Recompensa;

class PagamentoServiceTest extends TestCase
{
    private $service;

    protected function setUp()
    {
        parent::setUp();
        $this->fixtures();

        $mock = $this->getMockBuilder('\Tear\MoipBundle\Services\Moip')->getMock();
        $mockResponse = $this->getMockBuilder('\Tear\MoipBundle\Services\MoipResponse')
                             ->disableOriginalConstructor()->getMock();

        $mock->expects($this->any())
                    ->method('setReason')
                    ->will($this->returnSelf());

        $mock->expects($this->any())
                    ->method('setValue')
                    ->will($this->returnSelf());

        $mock->expects($this->any())
                    ->method('setUniqueID')
                    ->will($this->returnSelf());

        $mock->expects($this->any())
                    ->method('setReturnURL')
                    ->will($this->returnSelf());

        $mock->expects($this->any())
                    ->method('getAnswer')
                    ->with(false)
                    ->will($this->returnValue($mockResponse));

        $mock->expects($this->any())
                    ->method('getAnswer')
                    ->will($this->returnValue('xml resposta'));

        $mock->expects($this->any())
                    ->method('getXml')
                    ->will($this->returnValue('xml envio'));

        $mockResponse->expects($this->any())
                    ->method('getToken')
                    ->will($this->returnValue('EmVistaToken'));

        $mockResponse->expects($this->any())
                    ->method('getToken')
                    ->will($this->returnValue('EmVistaToken'));

        $mock->expects($this->any())
                    ->method('send')
                    ->will($this->returnValue($mockResponse));

        $mockResponse->payment_url = 'www.emvista.me';
        $this->service = $this->get('service.pagamento');
        $this->service->setPaymentGateway($mock);

    }

    private function fixtures()
    {
        $this->loadTestFixtures('Domain');
        $this->loadTestFixtures('PagamentoServiceTest');

    }

    /**
     * @test
     */
    public function deveRealizarCheckoutComSucesso()
    {
        $this->markTestIncomplete();

        $serviceData = ServiceData::build(
                array('recompensaId'=>1,'valor' => 10,'ip' => '127.0.1.1'));
        $usuario = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $serviceData->setUser($usuario);
        $url = $this->service->checkout($serviceData);
        $logs = $this->getEntityManager()->getRepository('EmVistaBundle:LogPagamento')->findAll();

        $log = $logs[0];
        $movimentacaoFinanceira = $log->getMovimentacaoFinanceira();
        $doacao = $movimentacaoFinanceira->getDoacao();
        $recompensa = $doacao->getRecompensa();

        $this->assertEquals($url,'www.emvista.me');
        $this->assertEquals(count($logs),1);
        $this->assertEquals($log->getHost(),'127.0.1.1');
        $this->assertEquals($movimentacaoFinanceira->getValor(),10);
        $this->assertEquals($doacao->getValor(),10);
        $this->assertEquals($doacao->getProjeto()->getValorArrecadado(),10);
        $this->assertEquals($recompensa->getValorMinimo(),10);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeOValorForInvalido()
    {
        $this->markTestIncomplete();

        $serviceData = ServiceData::build(
                array('recompensaId'=>1,'valor' => 'abc','ip' => '127.0.1.1'));
        $usuario = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $serviceData->setUser($usuario);
        $this->service->checkout($serviceData);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\ServiceValidationException
     */
    public function deveLancarExceptionSeOValorForMenorQueARecompensaEscolhida()
    {
        $this->markTestIncomplete();

        $serviceData = ServiceData::build(
                array('recompensaId'=>1,'valor' => 9.99,'ip' => '127.0.1.1'));
        $usuario = $this->getEntityManager()->find('EmVistaBundle:Usuario', 1);
        $serviceData->setUser($usuario);
        $this->service->checkout($serviceData);
    }

    /**
     * @test
     */
    public function deveLancarExceptionSeRecompensaJaTiverAtingidoNumeroMaximoDeDoadores()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function deveLancarExceptionSeRecompensaForInvalida()
    {
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function deveLancarExceptionSeUsuarioForInvalido()
    {
        $this->markTestIncomplete();
    }
}
