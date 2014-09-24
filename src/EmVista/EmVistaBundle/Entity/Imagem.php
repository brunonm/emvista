<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Imagem
 *
 */
class Imagem extends EntityAbstract
{
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
     * @var string $originalFilename
     *
     */
    private $originalFilename;

    /**
     * @var string $extensao
     *
     */
    private $extensao;

    /**
     * Tamanho em Kilobytes (KB)
     * @var integer $size
     *
     */
    private $size;

    /**
     * Largura em pixels
     * @var integer $largura
     *
     */
    private $largura;

    /**
     * Altura em pixels
     * @var integer $altura
     *
     */
    private $altura;

    /**
     * Altura em pixels
     * @var integer $altura
     *
     */
    private $webPath;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    public function __construct()
    {
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
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
     * Set usuario
     *
     * @param Usuario $usuario
     */
    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set original filename
     *
     * @param string $originalFilename
     */
    public function setOriginalFilename($originalFilename)
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    /**
     * Get original filename
     *
     * @return string
     */
    public function getOriginalFilename()
    {
        return $this->originalFilename;
    }

    /**
     * Set extensao
     *
     * @param string $extensao
     */
    public function setExtensao($extensao)
    {
        $this->extensao = $extensao;

        return $this;
    }

    /**
     * Get extensao
     *
     * @return string
     */
    public function getExtensao()
    {
        return $this->extensao;
    }

    /**
     * Set size
     *
     * @param integer $size
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set largura
     *
     * @param integer $largura
     */
    public function setLargura($largura)
    {
        $this->largura = $largura;

        return $this;
    }

    /**
     * Get largura
     *
     * @return integer
     */
    public function getLargura()
    {
        return $this->largura;
    }

    /**
     * Set altura
     *
     * @param integer $altura
     */
    public function setAltura($altura)
    {
        $this->altura = $altura;

        return $this;
    }

    /**
     * Get altura
     *
     * @return integer
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     */
    public function setDataCadastro($dataCadastro)
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
     * get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return md5($this->id) . '.' . $this->extensao;
    }
    /**
     *
     * @return string
     */
    public function getWebPath()
    {
        return $this->webPath;
    }
    /**
     *
     * @param  string                               $webPath
     * @return \EmVista\EmVistaBundle\Entity\Imagem
     */
    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;

        return $this;
    }

}
