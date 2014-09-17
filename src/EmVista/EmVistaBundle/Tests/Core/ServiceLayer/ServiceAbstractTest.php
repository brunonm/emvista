<?php

namespace EmVista\EmVistaBundle\Tests\Core\ServiceLayer;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Tests\Core\Mailer\MockMailer;
use EmVista\EmVistaBundle\Core\Mailer\Swift;

class ServiceAbstractTest extends TestCase
{
    /**
     * @var \EmVista\EmVistaBundle\Core\ServiceLayer\ServiceAbstract
     */
    private $stubServiceAbstract = null;

    protected function setUp()
    {
        parent::setUp();

        $this->stubServiceAbstract = $this->getMockForAbstractClass(
                'EmVista\EmVistaBundle\Core\ServiceLayer\ServiceAbstract'
        );
    }

    /**
     * @test
     */
    public function deveSetarERetornarEntityManagerComSucesso()
    {
        $this->stubServiceAbstract->setEntityManager('entityManager');
        $this->assertEquals('entityManager', $this->stubServiceAbstract->getEntityManager());
    }

    /**
     * @test
     */
    public function deveSetarERetornarValidatorComSucesso()
    {
        $this->stubServiceAbstract->setValidator('validator');
        $this->assertEquals('validator', $this->stubServiceAbstract->getValidator());
    }

    /**
     * @test
     */
    public function deveSetarERetornarMailerComSucesso()
    {
        $this->stubServiceAbstract->setMailer(new Swift(new MockMailer()));
        $this->assertInstanceOf(
                'EmVista\EmVistaBundle\Core\Mailer\MailerInterface',
                $this->stubServiceAbstract->getMailer()
        );
    }
}
