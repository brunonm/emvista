<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * EmVista\EmVistaBundle\Entity\Doacao
 *
 */
class Doacao
{
    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var Usuario
     *
     */
    private $usuario;

    /**
     * @var Recompensa
     *
     */
    private $recompensa;

    /**
     * @var decimal $valor
     *
     */
    private $valor;

    /**
     * @var StatusDoacao
     *
     */
    private $status;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    /**
     * @var MovimentacaoFinanceira[]
     *
     */
    private $movimentacoesFinanceiras;

    public function __construct()
    {
        $this->setDataCadastro(new \DateTime("now"));
        $this->movimentacoesFinanceiras = new ArrayCollection();
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
     * @param  Usuario                              $usuario
     * @return \EmVista\EmVistaBundle\Entity\Doacao
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
     * Set recompensa
     *
     * @param  Recompensa                           $recompensa
     * @return \EmVista\EmVistaBundle\Entity\Doacao
     */
    public function setRecompensa(Recompensa $recompensa)
    {
        $this->recompensa = $recompensa;

        return $this;
    }

    /**
     * Get recompensa
     *
     * @return Recompensa
     */
    public function getRecompensa()
    {
        return $this->recompensa;
    }

    /**
     * Set valor
     *
     * @param  decimal                              $valor
     * @return \EmVista\EmVistaBundle\Entity\Doacao
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return decimal
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set status
     *
     * @param  StatusDoacao                         $status
     * @return \EmVista\EmVistaBundle\Entity\Doacao
     */
    public function setStatus(StatusDoacao $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return StatusDoacao
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dataCadastro
     *
     * @param  datetime                             $dataCadastro
     * @return \EmVista\EmVistaBundle\Entity\Doacao
     */
    public function setDataCadastro(\DateTime $dataCadastro)
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
     * @var MovimentacaoFinanceira
     * @return \EmVista\EmVistaBundle\Entity\Doacao
     */
    public function addMovimentacaoFinanceira(MovimentacaoFinanceira $movimentacaoFinanceira)
    {
        $this->movimentacoesFinanceiras[] = $movimentacaoFinanceira;

        return $this;
    }

    /**
     * @return MovimentacaoFinanceira[]
     */
    public function getMovimentacoesFinanceiras()
    {
        return $this->movimentacoesFinanceiras;
    }

    /**
     * @return string
     */
    public function getValorFormatado()
    {
        return number_format($this->valor, 2, ',', '.');
    }
}
