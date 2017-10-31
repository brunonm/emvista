<?php

namespace EmVista\EmVistaBundle\Entity;

use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Categoria
 *
 */
class Categoria extends EntityAbstract
{
    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var string $nome
     *
     */
    private $nome;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    /**
     * @var integer $quantidadeProjetosPublicados
     *
     */
    private $quantidadeProjetosPublicados;

    /**
     *
     * @var string
     */
    private $slug;

    public function __construct()
    {
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
        $this->setQuantidadeProjetosPublicados(0);
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
     * Set nome
     *
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro(\DateTime $dataCadastro)
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
     * @param integer $qtd
     */
    public function setQuantidadeProjetosPublicados($qtd)
    {
        $this->quantidadeProjetosPublicados = $qtd;

        return $this;
    }

    /**
     * @return integer
     */
    public function getQuantidadeProjetosPublicados()
    {
        return $this->quantidadeProjetosPublicados;
    }
    /**
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
