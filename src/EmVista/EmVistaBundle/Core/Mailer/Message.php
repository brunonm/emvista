<?php

namespace EmVista\EmVistaBundle\Core\Mailer;

class Message{

    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var boolean
     */
    private $isHtml;

    /**
     * @var string | string[]
     */
    private $to;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string | string[]
     */
    private $cc = array();

    /**
     * @var string | string[]
     */
    private $bcc = array();

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    /**
     * Envia a mensagem para o objeto mailer
     * @return Message
     */
    public function send(){
        return $this->mailer->send($this);
    }

    /**
     * @return string | string[]
     */
    public function getTo(){
        return $this->to;
    }

    /**
     * @param string | string[] $to
     * @return Message
     */
    public function to($to){
        $this->to = $to;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(){
        return $this->from;
    }

    /**
     * @param string | string[] $from
     * @return Message
     */
    public function from($from){
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(){
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return Message
     */
    public function subject($subject){
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function message($message){
        $this->message = $message;
        return $this;
    }

    /**
     * @return string | string[]
     */
    public function getCc(){
        return $this->cc;
    }

    /**
     * @param string | string[] $cc
     * @return Message
     */
    public function cc($cc){
        $this->cc = $cc;
        return $this;
    }

    /**
     * @return string | string[]
     */
    public function getBcc(){
        return $this->bcc;
    }

    /**
     * @param string | string[] $cco
     * @return Message
     */
    public function bcc($cco){
        $this->bcc = $cco;
        return $this;
    }

    /**
     * @param boolean
     */
    public function isHtml($isHtml){
        $this->isHtml = $isHtml;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsHtml(){
        return $this->isHtml;
    }
}