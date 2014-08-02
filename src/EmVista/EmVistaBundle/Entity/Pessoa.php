<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class Pessoa extends EntityAbstract{

    const TIPO_FISICA   = 'f';
    const TIPO_JURIDICA = 'j';

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Usuario $usuario
     *
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     *
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=50, nullable=false)
     */
    private $nome;

    /**
     * @var string $documento
     *
     * @ORM\Column(name="documento", type="string", length=14, nullable=false)
     */
    private $documento;

    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=1, nullable=false)
     */
    private $tipo;

    public function __construct(){
        parent::__construct();
        $this->setTipo('f');
    }

    /**
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     *
     * @return Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * @param Usuario $usuario
     * @return \EmVista\EmVistaBundle\Entity\Pessoa
     */
    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome){
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return string
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * @param string $documento
     * @return Pessoa
     */
    public function setDocumento($documento){
        $this->documento = $documento;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumento(){
        return $this->documento;
    }

    /**
     * @param string $tipo
     * @return Pessoa
     */
    public function setTipo($tipo){
        $this->tipo = strtolower($tipo);
        return $this;
    }

    /**
     * @return string
     */
    public function getTipo(){
        return $this->tipo;
    }
}