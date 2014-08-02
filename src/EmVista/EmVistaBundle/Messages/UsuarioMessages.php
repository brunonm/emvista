<?php

namespace EmVista\EmVistaBundle\Messages;

use EmVista\EmVistaBundle\Messages\BaseMessages;

class UsuarioMessages extends BaseMessages{

    const ERRO_EMAIL_OUTRA_CONTA = 'O email informado já existe no EmVista e pertence a outra conta.';
    const SUCESSO_DADOS_ALTERADOS = 'Dados alterados com sucesso.';
    const SUCESSO_CONTA_INATIVADA = 'Conta inativada com sucesso.';
    const SUCESSO_REMOVIDO_ACESSO_ADMINISTRADOR = 'Acesso administrativo removido com sucesso.';
    const SUCESSO_ACESSO_ADMINISTRADOR = 'Acesso administrativo concedido com sucesso.';
    const ERROR_JA_POSSUI_ACESSO_ADMINISTRADOR = 'O usuário selecionado já possui acesso administrativo.';
    const ERROR_NAO_POSSUI_ACESSO_ADMINISTRADOR = 'O usuário selecionado não possui acesso administrativo.';

    const ERROR_LOGIN = 'Credenciais incorretas. Por favor, verifique novamente o email e senha informados.';

    const ERRO_USUARIO_JA_EXISTE = 'Este email já foi cadastrado no EmVista.';

    const SUCESSO_ENVIO_ESQUECI_MINHA_SENHA = 'Email enviado com sucesso. Verifique sua caixa de entrada.';
    const SUCESSO_ALTERAÇÃO_SENHA = 'Senha alterada com sucesso.';
    const ERRO_ALTERAÇÃO_SENHA = 'Senha inválida. Tente novamente.';
}