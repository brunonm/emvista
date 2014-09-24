<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Submissao
 *
 */
class Submissao extends EntityAbstract
{
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
     * @var StatusSubmissao
     *
     */
    private $status;

    /**
     * @var text $observacaoResposta
     *
     */
    private $observacaoResposta;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    /**
     * @var datetime $dataEnvio
     *
     */
    private $dataEnvio;

    /**
     * @var datetime $dataResposta
     *
     */
    private $dataResposta;

    public function __construct()
    {
        parent::__construct();
        $this->setDataCadastro(new \DateTime('now'));
    }

    /**
     *
     * @return Projeto
     */
    public function getProjeto()
    {
        return $this->projeto;
    }

    /**
     *
     * @param Projeto $projeto
     */
    public function setProjeto(Projeto $projeto)
    {
        $this->projeto = $projeto;

        return $this;
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
     * Set status
     *
     * @param StatusSubmissao $status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set observacaoResposta
     *
     * @param text $observacaoResposta
     */
    public function setObservacaoResposta($observacaoResposta)
    {
        $this->observacaoResposta = $observacaoResposta;

        return $this;
    }

    /**
     * Get observacaoResposta
     *
     * @return text
     */
    public function getObservacaoResposta()
    {
        return $this->observacaoResposta;
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
     * Set dataResposta
     *
     * @param datetime $dataResposta
     */
    public function setDataResposta($dataResposta)
    {
        $this->dataResposta = $dataResposta;

        return $this;
    }

    /**
     * Get dataResposta
     *
     * @return datetime
     */
    public function getDataResposta()
    {
        return $this->dataResposta;
    }

    /**
     * Set dataEnvio
     *
     * @param datetime $dataEnvio
     */
    public function setDataEnvio($dataEnvio)
    {
        $this->dataEnvio = $dataEnvio;

        return $this;
    }

    /**
     * Get dataEnvio
     *
     * @return datetime
     */
    public function getDataEnvio()
    {
        return $this->dataEnvio;
    }
}
