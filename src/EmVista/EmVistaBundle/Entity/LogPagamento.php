<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmVista\EmVistaBundle\Entity\LogPaypal
 *
 */
class LogPagamento
{
    /**
     * @var integer $id
     *
     */
    private $id;

    /**
     * @var text $conteudoRetorno
     *
     */
    private $conteudoRetorno;

    /**
     * @var MovimentacaoFinanceira
     *
     */
    private $movimentacaoFinanceira;

    /**
     * @var text $conteudo
     *
     */
    private $conteudoEnvio;

    /**
     * @var text $host
     *
     */
    private $host;

    /**
     * @var datetime $dataCadastro
     *
     */
    private $dataCadastro;

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
     * Set conteudoRetorno
     *
     * @param text $conteudoRetorno
     */
    public function setConteudoRetorno($conteudoRetorno)
    {
        $this->conteudoRetorno = $conteudoRetorno;

        return $this;
    }

    /**
     * Get resposta
     *
     * @return text
     */
    public function getConteudoRetorno()
    {
        return $this->conteudoRetorno;
    }

    /**
     * Set movimentacaoFinanceira
     *
     * @param MovimentacaoFinanceira $movimentacaoFinanceira
     */
    public function setMovimentacaoFinanceira(MovimentacaoFinanceira $movimentacaoFinanceira)
    {
        $this->movimentacaoFinanceira = $movimentacaoFinanceira;

        return $this;
    }

    /**
     * Get movimentacaoFinanceira
     *
     * @return MovimentacaoFinanceira
     */
    public function getMovimentacaoFinanceira()
    {
        return $this->movimentacaoFinanceira;
    }

    /**
     * Set conteudo do envio
     *
     * @param text $conteudoEnvio
     */
    public function setConteudoEnvio($conteudo)
    {
        $this->conteudoEnvio = $conteudo;

        return $this;
    }

    /**
     * Get conteudo
     *
     * @return text
     */
    public function getConteudoEnvio()
    {
        return $this->conteudoEnvio;
    }

    /**
     * Set host
     *
     * @param text $host
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return text
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set dataCadastro
     *
     * @param datetime $dataCadastro
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

}
