<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * StatusPagamento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class StatusPagamento extends EntityAbstract{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var gatewayPagamento
     *
     * @ManyToOne(targetEntity="GatewayPagamento")
     * @JoinColumn(name="gatewayPagamento_id", referencedColumnName="id", nullable=false)
     */
    private $gatewayPagamento;

    /**
     * @var string
     *
     * @ORM\Column(name="gatewayStatus", type="string", length=3)
     */
    private $gatewayStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="valorGatewayStatus", type="string", length=255)
     */
    private $valorGatewayStatus;
    /**
     * @var string
     *
     * @ORM\Column(name="descricaoGatewayStatus", type="string", length=255)
     */
    private $descricaoGatewayStatus;

    /**
     * @var statusDoacao
     *
     * @ManyToOne(targetEntity="StatusDoacao")
     * @JoinColumn(name="statusDoacao_id", referencedColumnName="id", nullable=false)
     */
    private $statusDoacao;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }

    /**
     *
     * @param GatewayPagamento $gatewayPagamento
     * @return StatusPagamento 
     */
    public function setGatewayPagamento(GatewayPagamento $gatewayPagamento){
        $this->gatewayPagamento = $gatewayPagamento;
    
        return $this;
    }

    /**
     * Get gatewayPagamento
     *
     * @return GatewayPagamento 
     */
    public function getGatewayPagamento(){
        return $this->gatewayPagamento;
    }

    /**
     * Set gatewayStatus
     *
     * @param string $gatewayStatus
     * @return StatusPagamento
     */
    public function setGatewayStatus($gatewayStatus){
        $this->gatewayStatus = $gatewayStatus;
    
        return $this;
    }

    /**
     * Get gatewayStatus
     *
     * @return string 
     */
    public function getGatewayStatus(){
        return $this->gatewayStatus;
    }

    /**
     * Set descricaoGatewayStatus
     *
     * @param string $descricaoGatewayStatus
     * @return StatusPagamento
     */
    public function setDescricaoGatewayStatus($descricaoGatewayStatus){
        $this->descricaoGatewayStatus = $descricaoGatewayStatus;
    
        return $this;
    }

    /**
     * Get descricaoGatewayStatus
     *
     * @return string 
     */
    public function getDescricaoGatewayStatus(){
        return $this->descricaoGatewayStatus;
    }

    /**
     * Set statusDoacao
     *
     * @param StatusDoacao $statusDoacao
     * @return StatusPagamento
     */
    public function setStatusDoacao(StatusDoacao $statusDoacao){
        $this->statusDoacao = $statusDoacao;
    
        return $this;
    }

    /**
     * Get statusDoacao
     *
     * @return StatusDoacao 
     */
    public function getStatusDoacao(){
        return $this->statusDoacao;
    }
    
    /**
     * @return string 
     */
    public function getValorGatewayStatus() {
        return $this->valorGatewayStatus;
    }

    /**
     * @param string $valorGatewayStatus
     * @return StatusPagamento 
     */
    public function setValorGatewayStatus($valorGatewayStatus) {
        $this->valorGatewayStatus = $valorGatewayStatus;
        
        return $this;
    }


}
