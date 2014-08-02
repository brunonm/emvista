<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * EmVista\EmVistaBundle\Entity\Recompensa
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EmVista\EmVistaBundle\Repository\RecompensaRepository")
 */
class Recompensa extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float $valorMinimo
     *
     * @ORM\Column(name="valor_minimo", type="decimal", scale=2, nullable=false)
     */
    private $valorMinimo;

    /**
     * @var text $descricao
     *
     * @ORM\Column(name="descricao", type="text")
     */
    private $descricao;

    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="data_cadastro", type="datetime")
     */
    private $dataCadastro;

    /**
     * @var integer $quantidadeApoiadores
     *
     * @ORM\Column(name="quantidade_apoiadores", type="integer")
     */
    private $quantidadeApoiadores = 0;

    /**
     * @var string $titulo
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string $quantidadeMaximaApoiadores = 0
     *
     * @ORM\Column(name="quantidade_maxima_apoiadores", type="integer", nullable=true)
     */
    private $quantidadeMaximaApoiadores;

    /**
     * @var Projeto
     *
     * @ManyToOne(targetEntity="Projeto", inversedBy="recompensas")
     * @JoinColumn(name="projeto_id", referencedColumnName="id", nullable=false)
     */
    private $projeto;

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
     * Set valorMinimo
     *
     * @param float $valorMinimo
     */
    public function setValorMinimo($valorMinimo){
        $this->valorMinimo = $valorMinimo;
        return $this;
    }

    /**
     * Get valorMinimo
     *
     * @return float
     */
    public function getValorMinimo(){
        return $this->valorMinimo;
    }

    /**
     * Set descricao
     *
     * @param text $descricao
     */
    public function setDescricao($descricao){
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return text
     */
    public function getDescricao(){
        return $this->descricao;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro(\DateTime $dataCadastro){
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
     * Set quantidadeApoiadores
     *
     * @param integer $quantidadeApoiadores
     */
    public function setQuantidadeApoiadores($quantidadeApoiadores){
        $this->quantidadeApoiadores = $quantidadeApoiadores;
        return $this;
    }

    /**
     * Get quantidadeApoiadores
     *
     * @return integer
     */
    public function getQuantidadeApoiadores(){
        return $this->quantidadeApoiadores;
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

    /**
     * Remove o projeto
     */
    public function removeProjeto(){
        $this->projeto = null;
    }

    /**
     *
     * @return int
     */
    public function getQuantidadeMaximaApoiadores() {
        return $this->quantidadeMaximaApoiadores;
    }

    /**
     *
     * @param int $quantidadeMaximaApoiadores
     */
    public function setQuantidadeMaximaApoiadores($quantidadeMaximaApoiadores) {
        $this->quantidadeMaximaApoiadores = $quantidadeMaximaApoiadores;
        return $this;
    }


}