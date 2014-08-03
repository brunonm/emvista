<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;
/**
 * FormaPagamento
 *
 */
class FormaPagamento extends EntityAbstract{
    /**
     * @var integer
     *
     */
    private $id;
    
    
    /**
     * @var string
     *
     */
    private $codigo;


    /**
     * @var string
     *
     */
    private $valor;

    /**
     * @var string
     *
     */
    private $descricao;

    
    /**
     * @var gatewayPagamento
     *
     */
    private $gatewayPagamento;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }
    
    
    /**
     * Set codigo
     *
     * @param string $codigo
     * @return FormaPagamento
     */
    public function setCodigo($codigo){
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo(){
        return $this->codigo;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return FormaPagamento
     */
    public function setValor($valor){
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor(){
        return $this->valor;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FormaPagamento
     */
    public function setDescricao($descricao){
        $this->descricao = $descricao;
    
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string 
     */
    public function getDescricao(){
        return $this->descricao;
    }

    /**
     * Set gatewayPagamento
     *
     * @param GatewayPagamento $gatewayPagamento
     * @return FormaPagamento
     */
    public function setGatewayPagamento(GatewayPagamento $gatewayPagamento){
        $this->gatewayPagamento = $gatewayPagamento;
    
        return $this;
    }

    /**
     * Get gatewayPagamento
     *
     * @return \stdClass 
     */
    public function getGatewayPagamento(){
        return $this->gatewayPagamento;
    }

}
