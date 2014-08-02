<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Util\Date;
use Gedmo\Mapping\Annotation as Gedmo;
use EmVista\EmVistaBundle\Entity\ProjetoImagem;
use Doctrine\Common\Collections\ArrayCollection;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Projeto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EmVista\EmVistaBundle\Repository\ProjetoRepository")
 */
class Projeto extends EntityAbstract{

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
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;


    /**
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"nome"}, updatable=true)
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;


    /**
     * @var text $descricao
     *
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $descricao;

    /**
     * @var string $descricaoCurta
     *
     * @ORM\Column(name="descricao_curta", type="string", length=130, nullable=true)
     */
    private $descricaoCurta;

    /**
     * @var Usuario $usuario
     *
     * @ManyToOne(targetEntity="Usuario", inversedBy="projetos")
     * @JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     */
    private $usuario;

    /**
     * @var Categoria $categoria
     *
     * @ManyToOne(targetEntity="Categoria")
     * @JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * @var TermoUso $termoUso
     *
     * @ManyToOne(targetEntity="TermoUso")
     * @JoinColumn(name="termo_uso_id", referencedColumnName="id", nullable=false)
     */
    private $termoUso;

    /**
     * @var Recompensa[]
     *
     * @OneToMany(targetEntity="Recompensa", mappedBy="projeto")
     * @OrderBy({"valorMinimo" = "ASC"})
     */
    private $recompensas;

    /**
     * @var decimal $valor
     *
     * @ORM\Column(name="valor", type="decimal", scale=2, nullable=true)
     */
    private $valor;

    /**
     * @var decimal $valorArrecadado
     *
     * @ORM\Column(name="valor_arrecadado", type="decimal", scale=2, nullable=false)
     */
    private $valorArrecadado;

    /**
     * @var Video $video
     *
     * @OneToOne(targetEntity="Video")
     * @JoinColumn(name="video_id", referencedColumnName="id")
     */
    private $video;

    /**
     * @var datetime $dataInicio
     *
     * @ORM\Column(name="data_inicio", type="datetime", nullable=true)
     */
    private $dataInicio;

    /**
     * @var datetime $dataFim
     *
     * @ORM\Column(name="data_fim", type="datetime", nullable=true)
     */
    private $dataFim;

    /**
     * @var datetime $dataAprovacao
     *
     * @ORM\Column(name="data_aprovacao", type="datetime", nullable=true)
     */
    private $dataAprovacao;

    /**
     * @var datetime $dataCadastro
     *
     * @ORM\Column(name="data_cadastro", type="datetime", nullable=false)
     */
    private $dataCadastro;

    /**
     * @var integer $quantidadeDias
     *
     * @ORM\Column(name="quantidade_dias", type="integer", nullable=true)
     */
    private $quantidadeDias;

    /**
     * @var StatusFinanceiro $statusFinanceiro
     *
     * @ManyToOne(targetEntity="StatusFinanceiro")
     * @JoinColumn(name="status_financeiro_id", referencedColumnName="id")
     */
    private $statusFinanceiro;

    /**
     * @var object $statusArrecadacao
     *
     * @ManyToOne(targetEntity="StatusArrecadacao")
     * @JoinColumn(name="status_arrecadacao_id", referencedColumnName="id")
     */
    private $statusArrecadacao;

    /**
     * @var boolean $publicado
     *
     * @ORM\Column(name="publicado", type="boolean", nullable=false)
     */
    private $publicado;

    /**
     * @var ProjetoImagem[]
     *
     * @OneToMany(targetEntity="ProjetoImagem", mappedBy="projeto")
     */
    private $imagens;

    public function __construct(){
        parent::__construct();
        $this->setValorArrecadado(0)
             ->setPublicado(false)
             ->setDataCadastro(new \DateTime("now"));

        $this->recompensas = new ArrayCollection();
        $this->imagens     = new ArrayCollection();
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
     * Set descricao
     *
     * @param text $descricao
     */
    public function setDescricao($descricao){
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return text
     */
    public function getDescricao(){
        return $this->descricao;
    }

    /**
     * Set descricaoCurta
     *
     * @param string $descricaoCurta
     */
    public function setDescricaoCurta($descricaoCurta){
        $this->descricaoCurta = $descricaoCurta;
        return $this;
    }

    /**
     * Get descricaoCurta
     *
     * @return string
     */
    public function getDescricaoCurta(){
        return $this->descricaoCurta;
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
     * Set categoria
     *
     * @param Categoria $categoria
     */
    public function setCategoria(Categoria $categoria){
        $this->categoria = $categoria;
        return $this;
    }

    /**
     * Get categoria
     *
     * @return Categoria
     */
    public function getCategoria(){
        return $this->categoria;
    }

    /**
     * Set termoUso
     *
     * @param TermoUso $termoUso
     */
    public function setTermoUso(TermoUso $termoUso){
        $this->termoUso = $termoUso;
        return $this;
    }

    /**
     * Get termoUso
     *
     * @return TermoUso
     */
    public function getTermoUso(){
        return $this->termoUso;
    }

    /**
     * Set valor
     *
     * @param decimal $valor
     */
    public function setValor($valor){
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return decimal
     */
    public function getValor(){
        return $this->valor;
    }

    /**
     * Set valorArrecadado
     *
     * @param decimal $valorArrecadado
     */
    public function setValorArrecadado($valorArrecadado){
        $this->valorArrecadado = $valorArrecadado;
        return $this;
    }

    /**
     * Get valorArrecadado
     *
     * @return decimal
     */
    public function getValorArrecadado(){
        return $this->valorArrecadado;
    }

    /**
     * Set video
     *
     * @param Video $video
     */
    public function setVideo($video){
        $this->video = $video;
        return $this;
    }

    /**
     * Get video
     *
     * @return Video
     */
    public function getVideo(){
        return $this->video;
    }

    /**
     * Set dataInicio
     *
     * @param datetime $dataInicio
     */
    public function setDataInicio($dataInicio){
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * Get dataInicio
     *
     * @return datetime
     */
    public function getDataInicio(){
        return $this->dataInicio;
    }

    /**
     * Set dataFim
     *
     * @param datetime $dataFim
     */
    public function setDataFim($dataFim){
        $this->dataFim = $dataFim;
        return $this;
    }

    /**
     * Get dataFim
     *
     * @return datetime
     */
    public function getDataFim(){
        return $this->dataFim;
    }

    /**
     * Set dataAprovacao
     *
     * @param datetime $dataAprovacao
     */
    public function setDataAprovacao($dataAprovacao){
        $this->dataAprovacao = $dataAprovacao;
        return $this;
    }

    /**
     * Get dataAprovacao
     *
     * @return datetime
     */
    public function getDataAprovacao(){
        return $this->dataAprovacao;
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
     * Set quantidadeDias
     *
     * @param integer $quantidadeDias
     */
    public function setQuantidadeDias($quantidadeDias){
        $this->quantidadeDias = $quantidadeDias;
        return $this;
    }

    /**
     * Get quantidadeDias
     *
     * @return integer
     */
    public function getQuantidadeDias(){
        return $this->quantidadeDias;
    }

    /**
     * Set statusFinanceiro
     *
     * @param StatusFinanceiro $statusFinanceiro
     */
    public function setStatusFinanceiro(StatusFinanceiro $statusFinanceiro){
        $this->statusFinanceiro = $statusFinanceiro;
        return $this;
    }

    /**
     * Get statusFinanceiro
     *
     * @return StatusFinanceiro
     */
    public function getStatusFinanceiro(){
        return $this->statusFinanceiro;
    }

    /**
     * Set statusArrecadacao
     *
     * @param StatusArrecadacao $statusArrecadacao
     */
    public function setStatusArrecadacao(StatusArrecadacao $statusArrecadacao){
        $this->statusArrecadacao = $statusArrecadacao;
        return $this;
    }

    /**
     * Get statusArrecadacao
     *
     * @return StatusArrecadacao
     */
    public function getStatusArrecadacao(){
        return $this->statusArrecadacao;
    }

    /**
     * Set publicado
     *
     * @param boolean $publicado
     */
    public function setPublicado($publicado){
        $this->publicado = $publicado;
        return $this;
    }

    /**
     * Get publicado
     *
     * @return boolean
     */
    public function getPublicado(){
        return $this->publicado;
    }

    /**
     * get recompensas
     *
     * @return Recompensa[]
     */
    public function getRecompensas(){
        return $this->recompensas;
    }

    /**
     * @param Recompensa $recompensa
     */
    public function addRecompensa(Recompensa $recompensa){
        $this->recompensas[] = $recompensa;
        return $this;
    }

    /**
     * @return ProjetoImagem[]
     */
    public function getImagens(){
        return $this->imagens;
    }

    /**
     * @param ProjetoImagem $imagem
     */
    public function addImagem(ProjetoImagem $imagem){
        $this->imagens[] = $imagem;
        return $this;
    }

    public function toArray(){
        return array(
            'id' => $this->getId(),
            'titulo' => $this->getNome(),
            'autor' => $this->getUsuario()->getNome(),
            'descricaoCurta' => $this->getDescricaoCurta(),
            'urlImagemThumb' => $this->getImagemThumb()->getWebPath(),
            'urlImagemDestaque' => $this->getImagemDestaque()->getWebPath(),
            'urlImagemDestaqueSecundario' => $this->getImagemDestaqueSecundario()->getWebPath(),
            'urlImagemOriginal' => $this->getImagemOriginal()->getWebPath(),
            'valorArrecadado' => $this->getValorArrecadado(),
            'valorArrecadadoFormatado' => $this->getValorArrecadadoFormatado(),
            'percentual' => $this->getPercentualArrecadado(),
            'diasRestantes' => $this->getDiasRestantes(),
            'urlProjeto' => '/'.$this->getSlug(),
            'labelTempoRestante' => $this->getLabelTempoRestante(),
            'statusArrecadacao' => $this->getStatusArrecadacao()->getId()
        );
    }

    /**
     * @return float
     */
    public function getPercentualArrecadado(){
        return (int) floor($this->getValorArrecadado() * 100 / $this->getValor());
    }

    /**
     * @return ProjetoImagem
     */
    public function getImagemDestaque(){
        foreach($this->getImagens() as $imagem){
            if($imagem->getTipoProjetoImagem()->getId() == TipoProjetoImagem::TIPO_DESTAQUE){
                return $imagem;
            }
        }
    }

    /**
     * @return ProjetoImagem
     */
    public function getImagemDestaqueSecundario(){
        foreach($this->getImagens() as $imagem){
            if($imagem->getTipoProjetoImagem()->getId() == TipoProjetoImagem::TIPO_DESTAQUE_SECUNDARIO){
                return $imagem;
            }
        }
    }


    /**
     * @return ProjetoImagem
     */
    public function getImagemThumb(){
        foreach($this->getImagens() as $imagem){
            if($imagem->getTipoProjetoImagem()->getId() == TipoProjetoImagem::TIPO_THUMB){
                return $imagem;
            }
        }
    }


    /**
     * @return ProjetoImagem
     */
    public function getImagemOriginal(){
        foreach($this->getImagens() as $imagem){
            if($imagem->getTipoProjetoImagem()->getId() == TipoProjetoImagem::TIPO_ORIGINAL){
                return $imagem;
            }
        }
    }

    /**
     * @return string
     */
    public function getSlug(){
        return $this->slug;
    }

    public function getDiasRestantes(){
        return Date::getDateDiff($this)->days;
    }

    /**
     * @return string
     */
    public function getValorArrecadadoFormatado(){
        return number_format($this->valorArrecadado, 2, ',', '.');
    }
    
    public function getLabelTempoRestante(){
        if($this->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_EM_ANDAMENTO){

            $date = Date::getDateDiff($this);
            if($date->days == 0){
                if($date->h > 0): 
                    $numero = $date->h; 
                    $tempo = ($numero == 1 ? 'hora' : 'horas'); 
                else: 
                    $numero = $date->i; 
                    $tempo = ($numero == 1 ? 'minuto' : 'minutos'); 
                endif; 
            }else{
                $numero = $date->days; 
                $tempo = ($numero == 1 ? 'dia' : 'dias'); 
            } 
            $faltam = ($numero == 1 ? 'Falta' : 'Faltam'); 
            $retorno = '<span class="time-left project-time-left"> ' . $faltam . ' <span class="time-left-days"> ' . 
                    $numero . ' </span> ' . $tempo . ' </span>';

        }else{
            $retorno = '<span class="time-left project-time-left">Finalizado</span>';
        }; 
        return $retorno;
    }
    
}