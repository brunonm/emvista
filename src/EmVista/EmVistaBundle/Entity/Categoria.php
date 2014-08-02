<?php

namespace EmVista\EmVistaBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Categoria
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EmVista\EmVistaBundle\Repository\CategoriaRepository")
 */
class Categoria extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="data_cadastro", type="datetime")
     */
    private $dataCadastro;

    /**
     * @var integer $quantidadeProjetosPublicados
     *
     * @ORM\Column(name="quantidade_projetos_publicados", type="integer", nullable=true)
     */
    private $quantidadeProjetosPublicados;

    /**
     *
     * @Gedmo\Slug(fields={"nome"}, updatable=true)
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     * @var type
     */
    private $slug;

    public function __construct(){
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
        $this->setQuantidadeProjetosPublicados(0);
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
     * Set nome
     *
     * @param string $nome
     */
    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome(){
        return $this->nome;
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
     * @param integer $qtd
     */
    public function setQuantidadeProjetosPublicados($qtd){
        $this->quantidadeProjetosPublicados = $qtd;
        return $this;
    }

    /**
     * @return integer
     */
    public function getQuantidadeProjetosPublicados(){
        return $this->quantidadeProjetosPublicados;
    }
    /**
     *
     * @return string
     */
    public function getSlug(){
        return $this->slug;
    }
}