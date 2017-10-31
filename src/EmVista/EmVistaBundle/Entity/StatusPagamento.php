<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * StatusPagamento
 *
 */
class StatusPagamento extends EntityAbstract
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var gatewayPagamento
     *
     */
    private $gatewayPagamento;

    /**
     * @var string
     *
     */
    private $gatewayStatus;

    /**
     * @var string
     *
     */
    private $valorGatewayStatus;
    /**
     * @var string
     *
     */
    private $descricaoGatewayStatus;

    /**
     * @var statusDoacao
     *
     */
    private $statusDoacao;

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
     *
     * @param  GatewayPagamento $gatewayPagamento
     * @return StatusPagamento
     */
    public function setGatewayPagamento(GatewayPagamento $gatewayPagamento)
    {
        $this->gatewayPagamento = $gatewayPagamento;

        return $this;
    }

    /**
     * Get gatewayPagamento
     *
     * @return GatewayPagamento
     */
    public function getGatewayPagamento()
    {
        return $this->gatewayPagamento;
    }

    /**
     * Set gatewayStatus
     *
     * @param  string          $gatewayStatus
     * @return StatusPagamento
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
     * Set descricaoGatewayStatus
     *
     * @param  string          $descricaoGatewayStatus
     * @return StatusPagamento
     */
    public function setDescricaoGatewayStatus($descricaoGatewayStatus)
    {
        $this->descricaoGatewayStatus = $descricaoGatewayStatus;

        return $this;
    }

    /**
     * Get descricaoGatewayStatus
     *
     * @return string
     */
    public function getDescricaoGatewayStatus()
    {
        return $this->descricaoGatewayStatus;
    }

    /**
     * Set statusDoacao
     *
     * @param  StatusDoacao    $statusDoacao
     * @return StatusPagamento
     */
    public function setStatusDoacao(StatusDoacao $statusDoacao)
    {
        $this->statusDoacao = $statusDoacao;

        return $this;
    }

    /**
     * Get statusDoacao
     *
     * @return StatusDoacao
     */
    public function getStatusDoacao()
    {
        return $this->statusDoacao;
    }

    /**
     * @return string
     */
    public function getValorGatewayStatus()
    {
        return $this->valorGatewayStatus;
    }

    /**
     * @param  string          $valorGatewayStatus
     * @return StatusPagamento
     */
    public function setValorGatewayStatus($valorGatewayStatus)
    {
        $this->valorGatewayStatus = $valorGatewayStatus;

        return $this;
    }

}
