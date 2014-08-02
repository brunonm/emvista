<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\TipoProjetoImagem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TipoProjetoImagem extends EntityAbstract{

    const TIPO_DESTAQUE            = 1;
    const TIPO_DESTAQUE_SECUNDARIO = 2;
    const TIPO_THUMB               = 3;
    const TIPO_ORIGINAL            = 4;

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
     * @var float $aspectRatio
     *
     * @ORM\Column(name="aspect_ratio", type="float", nullable=true)
     */
    private $aspectRatio;

    /**
     * @var integer $largura
     *
     * @ORM\Column(name="largura", type="integer", nullable=true)
     */
    private $largura;

    /**
     * @var integer $altura
     *
     * @ORM\Column(name="altura", type="integer", nullable=true)
     */
    private $altura;

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
     * @param float $aspectRatio
     */
    public function setAspectRatio($aspectRatio){
        $this->aspectRatio = $aspectRatio;
        return $this;
    }

    /**
     * @return float
     */
    public function getAspectRatio(){
        return $this->aspectRatio;
    }

    /**
     * @param int $largura
     */
    public function setLargura($largura){
        $this->largura = $largura;
        return $this;
    }

    /**
     * @return int
     */
    public function getLargura(){
        return $this->largura;
    }

    /**
     * @param int $altura
     */
    public function setAltura($altura){
        $this->altura = $altura;
        return $this;
    }

    /**
     * @return int
     */
    public function getAltura(){
        return $this->altura;
    }
}