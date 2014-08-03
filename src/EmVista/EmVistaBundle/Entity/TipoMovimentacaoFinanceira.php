<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmVista\EmVistaBundle\Entity\TipoMovimentacaoFinanceira
 *
 */
class TipoMovimentacaoFinanceira
{
    const PAGAMENTO = 1;
    const ESTORNO = 2;

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
}