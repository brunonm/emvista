<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Doacao;
use Doctrine\Common\Collections\ArrayCollection;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * EmVista\EmVistaBundle\Entity\Usuario
 *
 */
class Usuario extends EntityAbstract implements UserInterface, AdvancedUserInterface, \Serializable{

    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var string $nome
     *
     */
    private $nome;

    /**
     * @var string $email
     *
     */
    private $email;

    /**
     * @var string $senha
     *
     */
    private $senha;

    /**
     * @var Projeto[]
     *
     */
    private $projetos;

    /**
     * @var string $salt
     *
     */
    private $salt;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    /**
     *  @var boolean $status
     *
     */
    private $status;

    /**
     * @var Imagem $imagemProfile
     *
     */
    private $imagemProfile;

    /**
     *
     * @var ArrayCollection $userRoles
     */
    private $userRoles;

    /**
     *
     *@OneToOne(targetEntity="Endereco", mappedBy="usuario")
     */
    private $endereco;

    /**
     * @var Doacao[]

     */
    private $doacoes;

    public function __construct(){
        parent::__construct();
        $this->setDataCadastro(new \DateTime("now"));
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->userRoles = new ArrayCollection();
        $this->doacoes = new ArrayCollection();
        $this->status = true;
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
     * Set nome
     *
     * @param string $nome
     * @return \EmVista\EmVistaBundle\Entity\Usuario
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
     * Set email
     *
     * @param string $email
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set senha
     *
     * @param string $senha
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setSenha($senha){
        $this->senha = $senha;
        return $this;
    }

    /**
     * Get senha
     *
     * @return string
     */
    public function getSenha(){
        return $this->senha;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setDataCadastro(\DateTime $dataCadastro){
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
     * @return Projeto[]
     */
    public function getProjetos(){
        return $this->projetos;
    }

    /**
     * @param Projeto $projeto
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function addProjeto(Projeto $projeto){
        $this->projetos[] = $projeto;
        return $this;
    }

    /**
     * @param Role $role
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function addUserRole(Role $role){
        $this->userRoles[] = $role;
        return $this;
    }

    /**
     * @return Role[]
     */
    public function getUserRoles(){
        return $this->userRoles;
    }

    /**
     * @return string[]
     */
    public function getRoles(){
        return $this->getUserRoles()->toArray();
    }

    /**
     * @return string
     */
    public function getPassword(){
        return $this->getSenha();
    }
    /**
     *
     * @param type $salt
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setSalt($salt){
        $this->salt = $salt;
        return $this;
    }
    /**
     * @return string
     */
    public function getSalt(){
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getUsername(){
        $this->getEmail();
    }

    public function eraseCredentials(){}

    /**
     * @return boolean
     */
    public function equals(UserInterface $usuario){
        return $usuario->getUsername() == $this->getUsername();
    }

    /**
     * @param boolean $status
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * @return boolean $status
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @param Imagem $imagemProfile
     * @return Imagem
     */
    public function setImagemProfile(Imagem $imagemProfile){
        $this->imagemProfile = $imagemProfile;
        return $this;
    }

    /**
     * @return Imagem
     */
    public function getImagemProfile(){
        return $this->imagemProfile;
    }

    /**
     * @return boolean
     */
    public function isAccountNonExpired(){
        return true;
    }

    /**
     * @return boolean
     */
    public function isAccountNonLocked(){
        return true;
    }

    /**
     * @return boolean
     */
    public function isCredentialsNonExpired(){
        return true;
    }

    /**
     * @return boolean
     */
    public function isEnabled(){
        return (bool) $this->getStatus();
    }

    /**
     * @return boolean
     */
    public function isAdmin(){
        foreach($this->getUserRoles() as $role){
            if($role->getId() == Role::ROLE_ADMIN){
                return true;
            }
        }
        return false;
    }

    /**
     * @return Doacao[]
     */
    public function getDoacoes(){
        return $this->doacoes;
    }

    /**
     * @param Doacao $doacao
     */
    public function addDoacao(Doacao $doacao){
        $this->doacoes[] = $doacao;
        return $this;
    }

    /**
     *
     * @return Endereco
     */
    public function getEndereco() {
        return $this->endereco;
    }

    /**
     *
     * @param Endereco $endereco
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setEndereco(Endereco $endereco) {
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * @return string
     */
    public function serialize(){
        $r = new \ReflectionClass($this);
        $array = array();
        foreach($r->getProperties() as $property){
            $methodName = 'get'.ucfirst($property->name);
            $value = $this->$methodName();
            if(is_string($value) || is_numeric($value)){
                $array[$property->name] = $value;
            }
        }
        return serialize($array);
    }

    /**
     * @param string $data
     */
    public function unserialize($data){
        foreach(unserialize($data) as $property => $value){
            if($property == 'id'){
                $this->$property = ($value);
            }else{
                $methodName = 'set'.ucfirst($property);
                $this->$methodName($value);
            }
        }
    }

    /**
     * @return string
     */
    public function getImageProfileWebPath(){
        if($this->getImagemProfile() == NULL){
            return '/bundles/emvista/images/usuario_padrao_emvista.jpg';
        }else{
            return $this->getImagemProfile()->getWebPath();
        }
    }
}