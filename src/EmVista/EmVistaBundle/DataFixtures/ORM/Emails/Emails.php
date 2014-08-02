<?php

namespace EmVista\EmVistaBundle\DataFixtures\ORM\Emails;

use EmVista\EmVistaBundle\Entity\Email;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Emails implements FixtureInterface{

    public function load(ObjectManager $em){

$texto = <<<TEXTO
<p>Obrigado,&nbsp;</p>
<p>A sua contribui&ccedil;&atilde;o para o projeto {PROJETO} foi registrada no EmVista e aguardamos a confirma&ccedil;&atilde;o da institui&ccedil;&atilde;o financeira sobre o pagamento.</p>
<p>Boletos banc&aacute;rios podem levar at&eacute; 4 dias &uacute;teis para processamento.</p>
<p>Voc&ecirc; contribuiu com R$ {VALOR} e escolheu a recompensa: {RECOMPENSA}.</p>
<p>Avisaremos quando o seu pagamento for confirmado.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Recebemos sua contribuição');

        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>Informamos que o pagamento da sua contribui&ccedil;&atilde;o para o projeto {PROJETO} foi confirmado.</p>
<p>Voc&ecirc; contribuiu com R$ {VALOR} e escolheu a recompensa: {RECOMPENSA}.</p>
<p>Agora voc&ecirc; faz parte disso! Continue impulsionando novas ideias criativas.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Confirmação de pagamento');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>Agradecemos por seu interesse em participar do EmVista mas infelizmente o seu projeto n&atilde;o se enquadra na proposta do site.</p>
<p>{DESCRICAO}</p>
<p>Qualquer d&uacute;vida estamos a disposi&ccedil;&atilde;o.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Analisamos o seu projeto');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>O seu projeto foi recebido com sucesso por nossa equipe e em breve o analisaremos.</p>
<p>Estamos entusiasmados com a oportunidade de tirar sua ideia do papel e esperamos que esse seja o start que ela precisa.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Recebemos o seu projeto');
        $em->persist($email);



$texto = <<<TEXTO
<p>Parab&eacute;ns,</p>
<p>O seu projeto foi aprovado! Fique atento com as datas e hor&aacute;rios em que seu projeto estar&aacute; aberto para arrecada&ccedil;&atilde;o no site. Seguem abaixo:</p>
<p>In&iacute;cio: {DATA_INICIO}</p>
<p>Fim: {DATA_FIM}</p>
<p>Divulgue, curta, compartilhe, fa&ccedil;a barulho, agora &eacute; a sua hora.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Seu projeto foi aprovado!');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute; {NOME},</p>
<p>Seja bem-vindo,</p>
<p>Seu registro no EmVista foi feito com sucesso.</p>
<p>N&atilde;o perca tempo, descubra agora mesmo os projetos incr&iacute;veis que reunimos pra voc&ecirc;.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Seja bem-vindo');
        $em->persist($email);



$texto = <<<TEXTO
<p>Parab&eacute;ns,</p>
<p>O seu projeto acabou de atingir a meta estipulada. Continue trabalhando firme para atingir objetivos ainda maiores.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Meta alcançada');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>Sua conta no EmVista foi inativada com sucesso.</p>
<p>As contribui&ccedil;&otilde;es realizadas para projetos ainda n&atilde;o finalizados continuar&atilde;o sendo contabilizadas normalmente. Voc&ecirc; ser&aacute; informado da conclus&atilde;o que o projeto ter&aacute;.</p>
<p>Se for poss&iacute;vel, nos envie um depoimento para contato@emvista.me explicando o motivo do desligamento.</p>
<p>Caso mude de ideia, as portas estar&atilde;o abertas. N&atilde;o hesite em nos avisar.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Sentiremos sua falta');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>Foi confirmada pela institui&ccedil;&atilde;o financeira uma contribui&ccedil;&atilde;o do usu&aacute;rio {NOME} ({EMAIL}), de valor R$ {VALOR}, para o projeto {PROJETO}.</p>
<p>Recompensa escolhida: {RECOMPENSA}.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Contribuição recebida');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>&Eacute; com grande prazer que informamos que o seu projeto foi financiado!</p>
<p>Fazer parte dessa hist&oacute;ria foi muito gratificante para n&oacute;s. Desejamos sucesso nas pr&oacute;ximas etapas.</p>
<p>N&atilde;o deixe de honrar as contribui&ccedil;&otilde;es recebidas enviando as recompensas, al&eacute;m de atualizar a p&aacute;gina do projeto no EmVista com as &uacute;ltimas novidades.</p>
<p>Cadastre a sua conta Moip em &quot;Minha conta&quot; para que possamos transferir o seu dinheiro.</p>
<p>Obrigado novamente.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - O seu projeto foi financiado');
        $em->persist($email);



$texto = <<<TEXTO
<p>&nbsp;</p>
<p>Ol&aacute;,</p>
<p>Infelizmente o seu projeto {PROJETO} n&atilde;o conseguiu arrecadar o valor estipulado. Nos pr&oacute;ximos dias estaremos estornando as contribui&ccedil;&otilde;es recebidas.</p>
<p>N&atilde;o desanime, talvez seu projeto se enquadre melhor nas alternativas tradicionais de financiamento.</p>
<p>Conte conosco para novas ideias.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
<p>&nbsp;</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Prazo finalizado');
        $em->persist($email);



$texto = <<<TEXTO
<p>&nbsp;</p>
<p>Ol&aacute;,</p>
<p>Infelizmente o projeto {PROJETO} n&atilde;o conseguiu arrecadar o valor estipulado. Nos pr&oacute;ximos dias estaremos estornando a sua contribui&ccedil;&atilde;o.</p>
<p>Obrigado.</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
<p>&nbsp;</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Estorno');
        $em->persist($email);



$texto = <<<TEXTO
<p>Ol&aacute;,</p>
<p>Para alterar sua senha, clique no link abaixo:</p>
<p>&nbsp;{LINK}</p>
<p>Se voc&ecirc; n&atilde;o tiver solicitado altera&ccedil;&atilde;o de senha, favor desconsiderar esta mensagem.&nbsp;</p>
<p>&nbsp;</p>
<p>Atenciosamente,</p>
<p>Equipe EmVista</p>
<p>&nbsp;</p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Alteração de senha');
        $em->persist($email);


        $em->flush();


$texto = <<<TEXTO
<p>Ol&aacute;, {NOME}</p>
<p>Este email &eacute; a confirma&ccedil;&atilde;o do pr&eacute;-cadastro do seu projeto no EmVista.</p>
<p>Estamos entusiasmados com a oportunidade de tirar sua ideia do papel e esperamos que esse seja o start que ela precisa.</p>
<p>Nos pr&oacute;ximos dias avaliaremos as informa&ccedil;&otilde;es que voc&ecirc; nos enviou e entraremos em contato.</p>
<p>Enquanto isso, continue fomentando suas ideias.</p>
<p>Seja bem vindo!</p>
<p>Atenciosamente,</p>
<p><strong>Equipe EmVista</strong></p>
<p>*** Este &eacute; um email autom&aacute;tico.</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('EmVista - Confirmação de pré-cadastro');
        $em->persist($email);


        $em->flush();


$texto = <<<TEXTO
<p><strong>Nome completo:</strong> {NOME}</p>
<p><strong>Email:</strong> {EMAIL}</p>
<p><strong>T&iacute;tulo do projeto:</strong> {TITULO}</p>
<p><strong>Descri&ccedil;&atilde;o do projeto:</strong>&nbsp;</p>
<p>{DESCRICAO}</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Enviado em {DATETIME}</p>
TEXTO;

        $email = new Email();
        $email->setTexto($texto)
              ->setTitulo('Cadastro de pré-projeto');
        $em->persist($email);


        $em->flush();
    }
}