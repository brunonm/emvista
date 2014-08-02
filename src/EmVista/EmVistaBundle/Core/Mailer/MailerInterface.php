<?php

namespace EmVista\EmVistaBundle\Core\Mailer;

interface MailerInterface{

    /**
     * @param Message $message
     * @return integer
     */
    public function send(Message $message);

    /**
     * @return Message
     */
    public function newMessage();
}