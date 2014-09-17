<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
 *
 */
class MovimentacaoFinanceira
{
    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var TipoMovimentacaoFinanceira
     *
     */
    private $tipoMovimentacaoFinanceira;

    /**
     * @var Doacao
     *
     */
    private $doacao;

    /**
     * @var decimal $valor
     *
     */
    private $valor;

    /**
     * @var string $transacaoId
     *
     */
    private $transacaoId;

    /**
     * @var string $status
     *
     */
    private $status;

    /**
     * @var string $razaoPendencia
     *
     */
    private $razaoPendencia;

    /**
     * @var string $codigoRazao
     *
     */
    private $codigoRazao;

    /**
     * @var string $errorCode
     *
     */
    private $errorCode;

    /**
     * @var string $token
     *
     */
    private $token;
    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

    /**
     * @var datetime $dataEdicao
     *
     */
    private $dataEdicao;

    /**
     * @var datetime $taxa
     *
     */
    private $taxa;

    /**
     * @var datetime $valorLiquido
     *
     */
    private $valorLiquido;

    /**
     * @var GatewayPagamento
     *
     */
    private $gatewayPagamento;

    public function __construct()
    {
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
     * Set tipoMovimentacaoFinanceira
     *
     * @param  integer                                                  $tipoMovimentacaoFinanceira
     * @return \EmVista\EmVistaBundle\Entity\TipoMovimentacaoFinanceira
     */
    public function setTipoMovimentacaoFinanceira($tipoMovimentacaoFinanceira)
    {
        $this->tipoMovimentacaoFinanceira = $tipoMovimentacaoFinanceira;

        return $this;
    }

    /**
     * Get tipoMovimentacaoFinanceira
     *
     * @return integer
     */
    public function getTipoMovimentacaoFinanceira()
    {
        return $this->tipoMovimentacaoFinanceira;
    }

    /**
     * Set doacao
     *
     * @param  integer                                              $doacao
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setDoacao(Doacao $doacao)
    {
        $this->doacao = $doacao;

        return $this;
    }

    /**
     * Get doacao
     *
     * @return Doacao
     */
    public function getDoacao()
    {
        return $this->doacao;
    }

    /**
     * Set valor
     *
     * @param  decimal                                              $valor
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
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
     * Set transacaoId
     *
     * @param  string                                               $transacaoId
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setTransacaoId($transacaoId)
    {
        $this->transacaoId = $transacaoId;

        return $this;
    }

    /**
     * Get transacaoId
     *
     * @return string
     */
    public function getTransacaoId()
    {
        return $this->transacaoId;
    }

    /**
     * Set status
     *
     * @param  string                                               $status
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set razaoPendencia
     *
     * @param  string                                               $razaoPendencia
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setRazaoPendencia($razaoPendencia)
    {
        $this->razaoPendencia = $razaoPendencia;

        return $this;
    }

    /**
     * Get razaoPendencia
     *
     * @return string
     */
    public function getRazaoPendencia()
    {
        return $this->razaoPendencia;
    }

    /**
     * Set codigoRazao
     *
     * @param  string                                               $codigoRazao
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setCodigoRazao($codigoRazao)
    {
        $this->codigoRazao = $codigoRazao;

        return $this;
    }

    /**
     * Get codigoRazao
     *
     * @return string
     */
    public function getCodigoRazao()
    {
        return $this->codigoRazao;
    }

    /**
     * Set errorCode
     *
     * @param  string                                               $errorCode
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Get errorCode
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Set dataCadastro
     *
     * @param  datetime                                             $dataCadastro
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
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
     * Set dataEdicao
     *
     * @param  datetime                                             $dataEdicao
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setDataEdicao($dataEdicao)
    {
        $this->dataEdicao = $dataEdicao;

        return $this;
    }

    /**
     * Get dataEdicao
     *
     * @return datetime
     */
    public function getDataEdicao()
    {
        return $this->dataEdicao;
    }

    /**
     * Set token
     *
     * @param  string                                               $token
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     *
     * @return decimal
     */
    public function getTaxa()
    {
        return $this->taxa;
    }
    /**
     *
     * @param  decimal                                              $taxa
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setTaxa($taxa)
    {
        $this->taxa = $taxa;

        return $this;
    }
    /**
     *
     * @return decimal
     */
    public function getValorLiquido()
    {
        return $this->valorLiquido;
    }
    /**
     *
     * @param  decimal                                              $valorLiquido
     * @return \EmVista\EmVistaBundle\Entity\MovimentacaoFinanceira
     */
    public function setValorLiquido($valorLiquido)
    {
        $this->valorLiquido = $valorLiquido;

        return $this;
    }

    /**
     *
     * @return GatewayPagamento
     */
    public function getGatewayPagamento()
    {
        return $this->gatewayPagamento;
    }

    /**
     *
     * @param  GatewayPagamento       $gateway
     * @return MovimentacaoFinanceira
     */
    public function setGatewayPagamento(GatewayPagamento $gateway)
    {
        $this->gatewayPagamento = $gateway;

        return $this;
    }

}
