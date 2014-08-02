<?php

namespace EmVista\EmVistaBundle\Messages;

use EmVista\EmVistaBundle\Messages\BaseMessages;

class PagamentoMessages extends BaseMessages{

    const QUANTIDADE_MAX_RECOMPENSAS_ATINGIDA = 'Quantidade maxima foi atingida, na recompensa escolhida!';
    const VALOR_INVALIDO_PARA_RECOMPENSA = 'Valor inválido para a recompensa escolhida.';
    const REPASSE_SUCESSO = 'Repasse finalizado com sucesso.';
    const REPASSE_ERRO = 'Não é permitido fazer o repasse desse projeto.';
}