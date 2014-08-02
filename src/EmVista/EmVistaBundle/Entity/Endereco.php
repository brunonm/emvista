<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;
/**
 * EmVista\EmVistaBundle\Entity\Endereco
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Endereco extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
    * @OneToOne(targetEntity="Usuario", inversedBy="endereco")
    * @JoinColumn(name="usuario_id", referencedColumnName="id")
    */
    private $usuario;

    
    /**
     * @var string $cep
     *
     * @ORM\Column(name="cep", type="string", length=8)
     */
    private $cep;
    
    /**
     * @var string $uf
     *
     * @ORM\Column(name="uf", type="string", length=2)
     */
    private $uf;
    
    /**
     * @var string $cidade
     *
     * @ORM\Column(name="cidade", type="string", length=60)
     */
    private $cidade;
    
    /**
     * @var string $bairro
     *
     * @ORM\Column(name="bairro", type="string", length=255)
     */
    private $bairro;
    
    /**
     * @var string $endereco
     *
     * @ORM\Column(name="endereco", type="string", length=255)
     */
    private $endereco;
    
    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="data_cadastro", type="datetime")
     */
    private $dataCadastro;
    

    public function __construct(){
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
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
     *
     * @param Usuario $usuario
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
        return $this;
    }
    /**
     *
     * @return string 
     */
    public function getCep() {
        return $this->cep;
    }
    /**
     *
     * @param string $cep
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setCep($cep) {
        $this->cep = $cep;
        return $this;
    }
    /**
     *
     * @return string 
     */
    public function getUf() {
        return $this->uf;
    }
    /**
     *
     * @param string $uf
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setUf($uf) {
        $this->uf = $uf;
        return $this;
    }
    /**
     *
     * @return string 
     */
    public function getCidade() {
        return $this->cidade;
    }
    /**
     *
     * @param string $cidade
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setCidade($cidade) {
        $this->cidade = $cidade;
        return $this;
    }
    
    /**
     *
     * @return string 
     */
    public function getEndereco() {
        return $this->endereco;
    }
    /**
     *
     * @param string $endereco
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setEndereco($endereco) {
        $this->endereco = $endereco;
        return $this;
    }
    /**
     *
     * @return \DateTime 
     */
    public function getDataCadastro() {
        return $this->dataCadastro;
    }
    /**
     *
     * @param \DateTime $dataCadastro
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setDataCadastro(\DateTime $dataCadastro) {
        $this->dataCadastro = $dataCadastro;
        return $this;
    }
    
    /**
     *
     * @return string 
     */
    public function getBairro() {
        return $this->bairro;
    }

    /**
     *
     * @param string $bairro
     * @return \EmVista\EmVistaBundle\Entity\Endereco 
     */
    public function setBairro($bairro) {
        $this->bairro = $bairro;
        return $this;
    }




    
    
}