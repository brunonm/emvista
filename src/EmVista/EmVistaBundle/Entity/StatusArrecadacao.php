<?php

namespace EmVista\EmVistaBundle\Entity;

use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\StatusArrecadacao
 *
 */
class StatusArrecadacao extends EntityAbstract
{
    const STATUS_EM_ANDAMENTO      = 1;
    const STATUS_SUCESSO           = 2;
    const STATUS_INSUCESSO         = 3;
    const STATUS_AGUARDANDO_BOLETO = 4;
    const STATUS_CANCELADO         = 5;

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
     * Set descricao
     *
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

}
