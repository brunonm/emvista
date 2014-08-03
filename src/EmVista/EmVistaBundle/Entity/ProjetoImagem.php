<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\ProjetoImagem
 *
 */
class ProjetoImagem extends EntityAbstract{

    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var Projeto $projeto
     *
     */
    private $projeto;

    /**
     * @var Imagem $imagem
     *
     */
    private $imagem;

    /**
     * @var TipoProjetoImagem $tipoProjetoImagem
     *
     */
    private $tipoProjetoImagem;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set projeto
     *
     * @param Projeto $projeto
     */
    public function setProjeto(Projeto $projeto){
        $this->projeto = $projeto;
        return $this;
    }

    /**
     * Get projeto
     *
     * @return Projeto
     */
    public function getProjeto(){
        return $this->projeto;
    }

    /**
     * Set imagem
     *
     * @param Imagem $imagem
     */
    public function setImagem(Imagem $imagem){
        $this->imagem = $imagem;
        return $this;
    }

    /**
     * Get imagem
     *
     * @return Imagem
     */
    public function getImagem(){
        return $this->imagem;
    }

    /**
     * Set tipoProjetoImagem
     *
     * @param TipoProjetoImagem $tipoProjetoImagem
     */
    public function setTipoProjetoImagem(TipoProjetoImagem $tipoProjetoImagem){
        $this->tipoProjetoImagem = $tipoProjetoImagem;
        return $this;
    }

    /**
     * Get tipoProjetoImagem
     *
     * @return TipoProjetoImagem
     */
    public function getTipoProjetoImagem(){
        return $this->tipoProjetoImagem;
    }

    /**
     * @return string
     */
    public function getWebPath(){
        return '/uploads/' . md5($this->getProjeto()->getId()) . '/' . $this->getImagem()->getFilename();
    }
}