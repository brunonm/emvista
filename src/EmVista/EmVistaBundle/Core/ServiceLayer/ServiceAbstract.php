<?php

namespace EmVista\EmVistaBundle\Core\ServiceLayer;

use EmVista\EmVistaBundle\Core\Mailer\MailerInterface;

abstract class ServiceAbstract
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Respect\Validation\Validator
     */
    protected $validator;

    /**
     * @var \EmVista\EmVistaBundle\Core\Mailer\MailerInterface
     */
    protected $mailer;

    /**
     * @var Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    /**
     * @param \Doctrine\ORM\EntityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Respect\Validation\Validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return \Respect\Validation\Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param \EmVista\EmVistaBundle\Core\Mailer\MailerInterface
     */
    public function setMailer(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @return \EmVista\EmVistaBundle\Core\Mailer\MailerInterface
     */
    public function getMailer()
    {
        return $this->mailer;
    }
}
