<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Util\Date;
use EmVista\EmVistaBundle\Entity\Usuario;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * TokenSenha
 *
 */
class TokenSenha extends EntityAbstract{

    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $token;

    /**
     * @var Usuario $usuario
     *
     */
    private $usuario;

    /**
     * @var \DateTime
     *
     */
    private $dataCadastro;

    /**
     * @var \DateTime
     *
     */
    private $dataExpiracao;

    /**
     * @var boolean
     *
     */
    private $ativo;

    public function __construct(){
        parent::__construct();
        $this->setAtivo(true)
             ->setDataCadastro(new Date("now"))
             ->setDataExpiracao(Date::buildDateInFuture(1));
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
     * Set token
     *
     * @param string $token
     * @return TokenSenha
     */
    public function setToken($token){
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken(){
        return $this->token;
    }

    /**
     * Set usuario
     *
     * @param integer $usuario
     * @return TokenSenha
     */
    public function setUsuario($usuario){
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return integer
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * Set dataCadastro
     *
     * @param \DateTime $dataCadastro
     * @return TokenSenha
     */
    public function setDataCadastro($dataCadastro){
        $this->dataCadastro = $dataCadastro;

        return $this;
    }

    /**
     * Get dataExpiracao
     *
     * @return \DateTime
     */
    public function getDataExpiracao(){
        return $this->dataExpiracao;
    }

    /**
     * Set dataExpiracao
     *
     * @param \DateTime $dataExpiracao
     * @return TokenSenha
     */
    public function setDataExpiracao($dataExpiracao){
        $this->dataExpiracao = $dataExpiracao;

        return $this;
    }

    /**
     * Get dataCadastro
     *
     * @return \DateTime
     */
    public function getDataCadastro(){
        return $this->dataCadastro;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return TokenSenha
     */
    public function setAtivo($ativo){
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo(){
        return $this->ativo;
    }

}
