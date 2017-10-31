<?php

namespace EmVista\EmVistaBundle\Entity;

use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\TermoUso
 *
 */
class TermoUso extends EntityAbstract
{
    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var text $termoUso
     *
     */
    private $termoUso;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    /**
     * @var datetime $dataFim
     *
     */
    private $dataFim;

    /**
     * @var boolean $ativo
     *
     */
    private $ativo;

    public function __construct()
    {
        parent::__construct();
        $this->setAtivo(true);
        $this->setDataCadastro(new \DateTime('now'));
    }

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
     * Set termoUso
     *
     * @param text $termoUso
     */
    public function setTermoUso($termoUso)
    {
        $this->termoUso = $termoUso;

        return $this;
    }

    /**
     * Get termoUso
     *
     * @return text
     */
    public function getTermoUso()
    {
        return $this->termoUso;
    }

    /**
     * @return text
     */
    public function getTermoUsoFormatado()
    {
        return nl2br($this->termoUso);
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return datetime
     */
    public function getDataCadastro()
    {
        return $this->dataCadastro;
    }

    /**
     * Set dataFim
     *
     * @param datetime $dataFim
     */
    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;

        return $this;
    }

    /**
     * Get dataFim
     *
     * @return datetime
     */
    public function getDataFim()
    {
        return $this->dataFim;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

}
