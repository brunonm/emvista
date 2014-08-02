<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Submissao
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EmVista\EmVistaBundle\Repository\SubmissaoRepository")
 */
class Submissao extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Projeto
     *
     * @OneToOne(targetEntity="Projeto")
     * @JoinColumn(name="projeto_id", referencedColumnName="id", nullable=false)
     */
    private $projeto;

    /**
     * @var StatusSubmissao
     *
     * @ManyToOne(targetEntity="StatusSubmissao")
     * @JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    private $status;

    /**
     * @var text $observacaoResposta
     *
     * @ORM\Column(name="observacao_resposta", type="text", nullable=true)
     */
    private $observacaoResposta;

    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="data_cadastro", type="datetime")
     */
    private $dataCadastro;

    /**
     * @var datetime $dataEnvio
     *
     * @ORM\Column(name="data_envio", type="datetime", nullable=true)
     */
    private $dataEnvio;

    /**
     * @var datetime $dataResposta
     *
     * @ORM\Column(name="data_resposta", type="datetime", nullable=true)
     */
    private $dataResposta;

    function __construct(){
        parent::__construct();
        $this->setDataCadastro(new \DateTime('now'));
    }

    /**
     *
     * @return Projeto
     */
    public function getProjeto(){
        return $this->projeto;
    }

    /**
     *
     * @param Projeto $projeto
     */
    public function setProjeto(Projeto $projeto){
        $this->projeto = $projeto;
        return $this;
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
     * Set status
     *
     * @param StatusSubmissao $status
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * Set observacaoResposta
     *
     * @param text $observacaoResposta
     */
    public function setObservacaoResposta($observacaoResposta){
        $this->observacaoResposta = $observacaoResposta;
        return $this;
    }

    /**
     * Get observacaoResposta
     *
     * @return text
     */
    public function getObservacaoResposta(){
        return $this->observacaoResposta;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro($dataCadastro){
        $this->dataCadastro = $dataCadastro;
        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return datetime
     */
    public function getDataCadastro(){
        return $this->dataCadastro;
    }

    /**
     * Set dataResposta
     *
     * @param datetime $dataResposta
     */
    public function setDataResposta($dataResposta){
        $this->dataResposta = $dataResposta;
        return $this;
    }

    /**
     * Get dataResposta
     *
     * @return datetime
     */
    public function getDataResposta(){
        return $this->dataResposta;
    }

    /**
     * Set dataEnvio
     *
     * @param datetime $dataEnvio
     */
    public function setDataEnvio($dataEnvio){
        $this->dataEnvio = $dataEnvio;
        return $this;
    }

    /**
     * Get dataEnvio
     *
     * @return datetime
     */
    public function getDataEnvio(){
        return $this->dataEnvio;
    }
}