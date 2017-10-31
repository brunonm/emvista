<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmVista\EmVistaBundle\Entity\UsuarioDetalhesPagamento
 *
 */
class UsuarioDetalhesPagamento
{
    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var Usuario
     */
    private $usuario;

    /**
     * @var GatewayPagamento
     */
    private $gatewayPagamento;

    /**
     * @var string $gatewayId
     *
     */
    private $gatewayId;

    /**
     * @var string $gatewayEmail
     *
     */
    private $gatewayEmail;

    /**
     * @var string $gatewayStatus
     *
     */
    private $gatewayStatus;

    /**
     * @var string $primeiroNome
     *
     */
    private $primeiroNome;

    /**
     * @var string $ultimoNome
     *
     */
    private $ultimoNome;

    /**
     * @var string $pais
     *
     */
    private $pais;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set usuario
     *
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set gatewayId
     *
     * @param string $gatewayId
     */
    public function setGatewayId($gatewayId)
    {
        $this->gatewayId = $gatewayId;

        return $this;
    }

    /**
     * Get gatewayId
     *
     * @return string
     */
    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    /**
     * Set gatewayEmail
     *
     * @param string $gatewayEmail
     */
    public function setGatewayEmail($gatewayEmail)
    {
        $this->gatewayEmail = $gatewayEmail;

        return $this;
    }

    /**
     * Get gatewayEmail
     *
     * @return string
     */
    public function getGatewayEmail()
    {
        return $this->gatewayEmail;
    }

    /**
     * Set gatewayStatus
     *
     * @param string $gatewayStatus
     */
    public function setGatewayStatus($gatewayStatus)
    {
        $this->gatewayStatus = $gatewayStatus;

        return $this;
    }

    /**
     * Get gatewayStatus
     *
     * @return string
     */
    public function getGatewayStatus()
    {
        return $this->gatewayStatus;
    }

    /**
     * Set primeiroNome
     *
     * @param string $primeiroNome
     */
    public function setPrimeiroNome($primeiroNome)
    {
        $this->primeiroNome = $primeiroNome;

        return $this;
    }

    /**
     * Get primeiroNome
     *
     * @return string
     */
    public function getPrimeiroNome()
    {
        return $this->primeiroNome;
    }

    /**
     * Set ultimoNome
     *
     * @param string $ultimoNome
     */
    public function setUltimoNome($ultimoNome)
    {
        $this->ultimoNome = $ultimoNome;

        return $this;
    }

    /**
     * Get ultimoNome
     *
     * @return string
     */
    public function getUltimoNome()
    {
        return $this->ultimoNome;
    }

    /**
     * Set pais
     *
     * @param string $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     *
     * @return GatewayPagamento
     */
    public function getGateway()
    {
        return $this->gatewayPagamento;
    }

    /**
     *
     * @param  GatewayPagamento         $gateway
     * @return UsuarioDetalhesPagamento
     */
    public function setGateway(GatewayPagamento $gateway)
    {
        $this->gatewayPagamento = $gateway;

        return $this;
    }

}
