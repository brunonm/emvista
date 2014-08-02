<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\ProjetoImagem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProjetoImagem extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Projeto $projeto
     *
     * @ManyToOne(targetEntity="Projeto", inversedBy="imagens")
     * @JoinColumn(name="projeto_id", referencedColumnName="id", nullable=false)
     */
    private $projeto;

    /**
     * @var Imagem $imagem
     *
     * @ManyToOne(targetEntity="Imagem")
     * @JoinColumn(name="imagem_id", referencedColumnName="id", nullable=false)
     */
    private $imagem;

    /**
     * @var TipoProjetoImagem $tipoProjetoImagem
     *
     * @ManyToOne(targetEntity="TipoProjetoImagem")
     * @JoinColumn(name="tipo_projeto_imagem_id", referencedColumnName="id", nullable=false)
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