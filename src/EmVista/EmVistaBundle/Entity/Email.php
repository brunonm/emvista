<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * Email
 *
 */
class Email extends EntityAbstract{

    # TIPO USUARIO DESTINO _ TITULO

    const APOIADOR_RECEMOS_SUA_CONTRIBUICAO = 1;
    const APOIADOR_CONFIRMACAO_DE_PAGAMENTO = 2;
    const AUTOR_ANALISAMOS_SEU_PROJETO      = 3;
    const AUTOR_RECEBEMOS_SEU_PROJETO       = 4;
    const AUTOR_PROJETO_APROVADO            = 5;
    const USUARIO_SEJA_BEM_VINDO            = 6;
    const AUTOR_META_ALCANCADA              = 7;
    const USUARIO_SENTIREMOS_SUA_FALTA      = 8;
    const AUTOR_CONTRIBUICAO_RECEBIDA       = 9;
    const AUTOR_PROJETO_FINANCIADO          = 10;
    const AUTOR_PRAZO_FINALIZADO            = 11;
    const APOIADOR_ESTORNO                  = 12;
    const USUARIO_ALTERACAO_SENHA           = 13;
    const AUTOR_CONFIRMACAO_PRE_CADASTRO    = 14;
    const ADMIN_CADASTRO_PRE_PROJETO        = 15;

    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $titulo;

    /**
     * @var string
     *
     */
    private $texto;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Email
     */
    public function setTitulo($titulo){
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo(){
        return $this->titulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Email
     */
    public function setTexto($texto){
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto(){
        return $this->texto;
    }
}