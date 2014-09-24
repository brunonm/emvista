<?php

namespace EmVista\EmVistaBundle\Entity;

/**
 * EmVista\EmVistaBundle\Entity\TipoDestaque
 *
 */
class TipoDestaque
{
    const HOME_PRIMARIO   = 1;
    const HOME_SECUNDARIO = 2;

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
