<?php

namespace EmVista\EmVistaBundle\Entity;

/**
 * EmVista\EmVistaBundle\Entity\StatusDoacao
 *
 */
class StatusDoacao
{
    const APROVADO   = 1;
    const PENDENTE   = 2;
    const CANCELADO  = 3;
    const FALHADO    = 4;
    const ESTORNADO  = 5;
    const AGUARDANDO = 6;

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
     * @var string $descricao
     *
     */
    private $descricao;

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
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }
}
