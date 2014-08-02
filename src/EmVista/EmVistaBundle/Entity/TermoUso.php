<?php

namespace EmVista\EmVistaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\TermoUso
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TermoUso extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var text $termoUso
     *
     * @ORM\Column(name="termoUso", type="text")
     */
    private $termoUso;

    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="dataCadastro", type="datetime")
     */
    private $dataCadastro;

    /**
     * @var datetime $dataFim
     *
     * @ORM\Column(name="dataFim", type="datetime", nullable=true)
     */
    private $dataFim;

    /**
     * @var boolean $ativo
     *
     * @ORM\Column(name="ativo", type="boolean")
     */
    private $ativo;

    public function __construct(){
        parent::__construct();
        $this->setAtivo(true);
        $this->setDataCadastro(new \DateTime('now'));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set termoUso
     *
     * @param text $termoUso
     */
    public function setTermoUso($termoUso) {
        $this->termoUso = $termoUso;
        return $this;
    }

    /**
     * Get termoUso
     *
     * @return text
     */
    public function getTermoUso() {
        return $this->termoUso;
    }

    /**
     * @return text
     */
    public function getTermoUsoFormatado() {
        return nl2br($this->termoUso);
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return datetime
     */
    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    /**
     * Set dataFim
     *
     * @param datetime $dataFim
     */
    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
        return $this;
    }

    /**
     * Get dataFim
     *
     * @return datetime
     */
    public function getDataFim() {
        return $this->dataFim;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     */
    public function setAtivo($ativo) {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo() {
        return $this->ativo;
    }

}