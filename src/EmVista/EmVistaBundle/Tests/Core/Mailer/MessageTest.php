<?php

namespace EmVista\EmVistaBundle\Tests\Core\Mailer;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Core\Mailer\Message;

class MessageTest extends TestCase
{
    /**
     * @var Message
     */
    private $message;

    protected function setUp()
    {
        parent::setUp();

        $stub = $this->getMock('EmVista\EmVistaBundle\Core\Mailer\MailerInterface');

        $stub->expects($this->any())
             ->method('send')
             ->will($this->returnValue(1));

        $this->message = new Message($stub);
    }

    /**
     * @test
     */
    public function deveEnviarComSucesso()
    {
        $this->assertEquals(1, $this->message->send());
    }

    /**
     * @test
     */
    public function to()
    {
        $this->message->to('leonn@emvista.me');
        $this->assertEquals('leonn@emvista.me', $this->message->getTo());
    }

    /**
     * @test
     */
    public function from()
    {
        $this->message->from('leonn@emvista.me');
        $this->assertEquals('leonn@emvista.me', $this->message->getFrom());
    }

    /**
     * @test
     */
    public function subject()
    {
        $this->message->subject('assunto do emvista');
        $this->assertEquals('assunto do emvista', $this->message->getSubject());
    }

    /**
     * @test
     */
    public function message()
    {
        $this->message->message('mensagem radical do papai');
        $this->assertEquals('mensagem radical do papai', $this->message->getMessage());
    }

    /**
     * @test
     */
    public function cc()
    {
        $this->message->cc(array('bruno@emvista.me', 'raphael@emvista.me'));
        $cc = $this->message->getCc();
        $this->assertInternalType('array', $cc);
        $this->assertEquals('bruno@emvista.me', $cc[0]);
        $this->assertEquals('raphael@emvista.me', $cc[1]);
    }

    /**
     * @test
     */
    public function bcc()
    {
        $this->message->bcc(array('bruno@emvista.me', 'raphael@emvista.me'));
        $bcc = $this->message->getBcc();
        $this->assertInternalType('array', $bcc);
        $this->assertEquals('bruno@emvista.me', $bcc[0]);
        $this->assertEquals('raphael@emvista.me', $bcc[1]);
    }
}
