<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GatewayPagamento
 *
 */
class GatewayPagamento{
    
    const MOIP  = 1;
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $nome;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set string
     *
     * @param string $string
     * @return GatewayPagamento
     */
    public function setNome($nome){
        $this->nome = $nome;
    
        return $this;
    }

    /**
     * Get string
     *
     * @return string 
     */
    public function getNome(){
        return $this->nome;
    }
}
