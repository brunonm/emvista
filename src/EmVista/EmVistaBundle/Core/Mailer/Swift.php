<?php

namespace EmVista\EmVistaBundle\Core\Mailer;
use EmVista\EmVistaBundle\Core\Exceptions\MailerException;

class Swift implements MailerInterface{

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    protected $defaultFrom;

    /**
     * @param \Swift_Mailer $mailer
     */
    public function __construct($mailer){
        $this->mailer = $mailer;
    }

    /**
     * @param Message $message
     * @return integer - número de emails enviados com sucesso
     */
    public function send(Message $message){
        try{
            $email = \Swift_Message::newInstance();

            $from = $message->getFrom();

            if(empty($from)){
                $from = $this->defaultFrom;
            }

            $email->setFrom($from);

            $email->setTo($message->getTo())
                  ->setCc($message->getCc())
                  ->setBcc($message->getBcc())
                  ->setSubject($message->getSubject())
                  ->setBody($message->getMessage(), $message->getIsHtml() ? 'text/html' : null);

            return $this->mailer->send($email);

        }catch(\Swift_TransportException $e){
            throw new MailerException($e->getMessage());
        }catch(\Exception $e){
            throw $e;
        }

    }

    /**
     * @return Message
     */
    public function newMessage(){
        return new Message($this);
    }

    /**
     * @param string $from
     */
    public function setDefaultFrom($from){
        $this->defaultFrom = $from;
    }
}