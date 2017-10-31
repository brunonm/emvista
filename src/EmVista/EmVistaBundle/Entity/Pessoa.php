<?php

namespace EmVista\EmVistaBundle\Entity;

use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 */
class Pessoa extends EntityAbstract
{
    const TIPO_FISICA   = 'f';
    const TIPO_JURIDICA = 'j';

    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var Usuario $usuario
     *
     */
    private $usuario;

    /**
     *
     * @var string $nome
     *
     */
    private $nome;

    /**
     * @var string $documento
     *
     */
    private $documento;

    /**
     * @var string $tipo
     *
     */
    private $tipo;

    public function __construct()
    {
        parent::__construct();
        $this->setTipo('f');
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param  Usuario                              $usuario
     * @return \EmVista\EmVistaBundle\Entity\Pessoa
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param  string $documento
     * @return Pessoa
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * @param  string $tipo
     * @return Pessoa
     */
    public function setTipo($tipo)
    {
        $this->tipo = strtolower($tipo);

        return $this;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
