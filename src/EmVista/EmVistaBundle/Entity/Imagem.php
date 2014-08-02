<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Imagem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Imagem extends EntityAbstract{

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
     * @ManyToOne(targetEntity="Usuario")
     * @JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @var string $originalFilename
     *
     * @ORM\Column(name="original_filename", type="string", length=255)
     */
    private $originalFilename;

    /**
     * @var string $extensao
     *
     * @ORM\Column(name="extensao", type="string", length=5)
     */
    private $extensao;

    /**
     * Tamanho em Kilobytes (KB)
     * @var integer $size
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * Largura em pixels
     * @var integer $largura
     *
     * @ORM\Column(name="largura", type="float")
     */
    private $largura;

    /**
     * Altura em pixels
     * @var integer $altura
     *
     * @ORM\Column(name="altura", type="float")
     */
    private $altura;

    /**
     * Altura em pixels
     * @var integer $altura
     *
     * @ORM\Column(name="webPath", type="string", length=255, nullable=true)
     */
    private $webPath;

    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="dataCadastro", type="datetime", nullable=false)
     */
    private $dataCadastro;

    function __construct(){
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
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
     * Set usuario
     *
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario){
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * Set original filename
     *
     * @param string $originalFilename
     */
    public function setOriginalFilename($originalFilename){
        $this->originalFilename = $originalFilename;
        return $this;
    }

    /**
     * Get original filename
     *
     * @return string
     */
    public function getOriginalFilename(){
        return $this->originalFilename;
    }

    /**
     * Set extensao
     *
     * @param string $extensao
     */
    public function setExtensao($extensao){
        $this->extensao = $extensao;
        return $this;
    }

    /**
     * Get extensao
     *
     * @return string
     */
    public function getExtensao(){
        return $this->extensao;
    }

    /**
     * Set size
     *
     * @param integer $size
     */
    public function setSize($size){
        $this->size = $size;
        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize(){
        return $this->size;
    }

    /**
     * Set largura
     *
     * @param integer $largura
     */
    public function setLargura($largura){
        $this->largura = $largura;
        return $this;
    }

    /**
     * Get largura
     *
     * @return integer
     */
    public function getLargura(){
        return $this->largura;
    }

    /**
     * Set altura
     *
     * @param integer $altura
     */
    public function setAltura($altura){
        $this->altura = $altura;
        return $this;
    }

    /**
     * Get altura
     *
     * @return integer
     */
    public function getAltura(){
        return $this->altura;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro($dataCadastro){
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
     * get filename
     *
     * @return string
     */
    public function getFilename(){
        return md5($this->id) . '.' . $this->extensao;
    }
    /**
     *
     * @return string 
     */
    public function getWebPath() {
        return $this->webPath;
    }
    /**
     *
     * @param string $webPath
     * @return \EmVista\EmVistaBundle\Entity\Imagem 
     */
    public function setWebPath($webPath) {
        $this->webPath = $webPath;
        return $this;
    }


}