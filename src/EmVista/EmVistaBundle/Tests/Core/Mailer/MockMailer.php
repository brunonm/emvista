<?php

namespace EmVista\EmVistaBundle\Tests\Core\Mailer;

class MockMailer{

    public function send($message){

        $from = $message->getFrom();
        $to = $message->getTo();

        if(empty($from) || empty($to)){
            throw new \Swift_TransportException('Erro');
        }

        return 1;
    }

}