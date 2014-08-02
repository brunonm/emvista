<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GatewayPagamento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GatewayPagamento{
    
    const MOIP  = 1;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255)
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
