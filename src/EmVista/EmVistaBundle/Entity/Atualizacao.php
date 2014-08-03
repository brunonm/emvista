<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Entity\Projeto;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Atualizacao
 *
 */
class Atualizacao extends EntityAbstract{

    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var Projeto
     *
     */
    private $projeto;

    /**
     * @var string $titulo
     *
     */
    private $titulo;

    /**
     * @var text $texto
     *
     */
    private $texto;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    public function __construct(){
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     */
    public function setTitulo($titulo){
        $this->titulo = $titulo;
        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param text $texto
     */
    public function setTexto($texto){
        $this->texto = $texto;
        return $this;
    }

    /**
     * Get texto
     *
     * @return text
     */
    public function getTexto(){
        return $this->texto;
    }

    /**
     * get dataCadastro
     *
     * @return datetime
     */
    public function getDataCadastro(){
        return $this->dataCadastro;
    }

    /**
     * set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro(\DateTime $dataCadastro){
        $this->dataCadastro = $dataCadastro;
        return $this;
    }

    /**
     * Set Projeto
     *
     * @return Projeto
     */
    public function getProjeto(){
        return $this->projeto;
    }

    /**
     * Set Projeto
     *
     * @param Projeto $projeto
     */
    public function setProjeto(Projeto $projeto){
        $this->projeto = $projeto;
        return $this;
    }
}