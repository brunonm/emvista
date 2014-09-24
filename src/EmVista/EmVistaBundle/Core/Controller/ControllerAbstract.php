<?php

namespace EmVista\EmVistaBundle\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class ControllerAbstract extends Controller
{
    /**
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function getUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

    /**
     * @param  string                                                    $msg
     * @return \EmVista\EmVistaBundle\Core\Controller\ControllerAbstract
     */
    public function setNoticeMessage($msg)
    {
        $this->get('session')->getFlashBag()->add('notice', $msg);

        return $this;
    }

    /**
     * @param  string                                                    $msg
     * @return \EmVista\EmVistaBundle\Core\Controller\ControllerAbstract
     */
    public function setWarningMessage($msg)
    {
        $this->get('session')->getFlashBag()->add('warning', $msg);

        return $this;
    }

    /**
     * @param  string                                                    $msg
     * @return \EmVista\EmVistaBundle\Core\Controller\ControllerAbstract
     */
    public function setErrorMessage($msg)
    {
        $this->get('session')->getFlashBag()->add('error', $msg);

        return $this;
    }

    /**
     * @param  string                                                    $msg
     * @return \EmVista\EmVistaBundle\Core\Controller\ControllerAbstract
     */
    public function setSuccessMessage($msg)
    {
        $this->get('session')->getFlashBag()->add('success', $msg);

        return $this;
    }

}
