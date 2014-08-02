<?php

namespace EmVista\EmVistaBundle\Tests\Core\Mailer;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Core\Mailer\Swift;
use EmVista\EmVistaBundle\Tests\Core\Mailer\MockMailer;

class SwiftTest extends TestCase{

    /**
     * @var Swift
     */
    private $swift;

    protected function setUp(){
        parent::setUp();
        $this->swift = new Swift(new MockMailer());
    }

    /**
     * @test
     */
    public function construct(){
        $this->assertAttributeInstanceOf('EmVista\EmVistaBundle\Tests\Core\Mailer\MockMailer', 'mailer', $this->swift);
    }

    /**
     * @test
     */
    public function deveEnviarComSucesso(){
        $message = $this->swift->newMessage();
        $message->from('emvista@emvista.me')
                ->to('brunonm@gmail.com')
                ->subject('assunto')
                ->message('mensagem');

        $this->assertEquals(1, $this->swift->send($message));
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\MailerException
     */
    public function deveLancarExceptionSeMensagemForInvalida(){
        $message = $this->swift->newMessage();
        $this->swift->send($message);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\MailerException
     */
    public function deveLancarExceptionSeNaoTiverFrom(){
        $message = $this->swift->newMessage()->to('bruno@emvista.me');
        $this->swift->send($message);
    }

    /**
     * @test
     * @expectedException EmVista\EmVistaBundle\Core\Exceptions\MailerException
     */
    public function deveLancarExceptionSeNaoTiverTo(){
        $message = $this->swift->newMessage()->from('bruno@emvista.me');
        $this->swift->send($message);
    }

    /**
     * @test
     */
    public function deveConstruirObjetoMessageComSucesso(){
        $message = $this->swift->newMessage();
        $this->assertInstanceOf('\EmVista\EmVistaBundle\Core\Mailer\Message', $message);
    }

    /**
     * @test
     */
    public function deveSetarDefaultFromComSucesso(){
        $this->swift->setDefaultFrom('teste@emvista.me');
        $this->assertAttributeEquals('teste@emvista.me', 'defaultFrom', $this->swift);
    }
}