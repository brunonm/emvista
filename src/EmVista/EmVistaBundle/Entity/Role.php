<?php

namespace EmVista\EmVistaBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * EmVista\EmVistaBundle\Entity\Role
 *
 */
class Role implements RoleInterface
{
    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var string $ome
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

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->getNome();
    }
}
