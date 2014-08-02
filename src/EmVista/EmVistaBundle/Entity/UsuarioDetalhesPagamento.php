<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Entity\Usuario;

/**
 * EmVista\EmVistaBundle\Entity\UsuarioDetalhesPagamento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UsuarioDetalhesPagamento{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Usuario
     * @ManyToOne(targetEntity="Usuario")
     * @JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @var GatewayPagamento
     * @ManyToOne(targetEntity="GatewayPagamento")
     * @JoinColumn(name="gatewayPagamento_id", referencedColumnName="id", nullable=false)
     */
    private $gatewayPagamento;

    /**
     * @var string $gatewayId
     *
     * @ORM\Column(name="gatewayId", type="string", length=255)
     */
    private $gatewayId;

    /**
     * @var string $gatewayEmail
     *
     * @ORM\Column(name="gatewayEmail", type="string", length=255)
     */
    private $gatewayEmail;

    /**
     * @var string $gatewayStatus
     *
     * @ORM\Column(name="gatewayStatus", type="string", length=255, nullable=true)
     */
    private $gatewayStatus;

    /**
     * @var string $primeiroNome
     *
     * @ORM\Column(name="primeiroNome", type="string", length=255)
     */
    private $primeiroNome;

    /**
     * @var string $ultimoNome
     *
     * @ORM\Column(name="ultimoNome", type="string", length=255, nullable=true)
     */
    private $ultimoNome;

    /**
     * @var string $pais
     *
     * @ORM\Column(name="pais", type="string", length=255)
     */
    private $pais;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set usuario
     *
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario){
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * Set gatewayId
     *
     * @param string $gatewayId
     */
    public function setGatewayId($gatewayId){
        $this->gatewayId = $gatewayId;
        return $this;
    }

    /**
     * Get gatewayId
     *
     * @return string
     */
    public function getGatewayId(){
        return $this->gatewayId;
    }

    /**
     * Set gatewayEmail
     *
     * @param string $gatewayEmail
     */
    public function setGatewayEmail($gatewayEmail){
        $this->gatewayEmail = $gatewayEmail;
        return $this;
    }

    /**
     * Get gatewayEmail
     *
     * @return string
     */
    public function getGatewayEmail(){
        return $this->gatewayEmail;
    }

    /**
     * Set gatewayStatus
     *
     * @param string $gatewayStatus
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
     * Set primeiroNome
     *
     * @param string $primeiroNome
     */
    public function setPrimeiroNome($primeiroNome){
        $this->primeiroNome = $primeiroNome;
        return $this;
    }

    /**
     * Get primeiroNome
     *
     * @return string
     */
    public function getPrimeiroNome(){
        return $this->primeiroNome;
    }

    /**
     * Set ultimoNome
     *
     * @param string $ultimoNome
     */
    public function setUltimoNome($ultimoNome){
        $this->ultimoNome = $ultimoNome;
        return $this;
    }

    /**
     * Get ultimoNome
     *
     * @return string
     */
    public function getUltimoNome(){
        return $this->ultimoNome;
    }

    /**
     * Set pais
     *
     * @param string $pais
     */
    public function setPais($pais){
        $this->pais = $pais;
        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais(){
        return $this->pais;
    }
    
    /**
     *
     * @return  GatewayPagamento 
     */
    public function getGateway() {
        return $this->gatewayPagamento;
    }

    /**
     *
     * @param GatewayPagamento $gateway
     * @return UsuarioDetalhesPagamento 
     */
    public function setGateway(GatewayPagamento $gateway) {
        $this->gatewayPagamento = $gateway;
        return $this;
    }



}