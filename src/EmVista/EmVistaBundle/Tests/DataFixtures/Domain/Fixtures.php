<?php

namespace EmVista\EmVistaBundle\Tests\DataFixtures\Domain;

use EmVista\EmVistaBundle\Entity\Role;
use EmVista\EmVistaBundle\Entity\Email;
use EmVista\EmVistaBundle\Entity\TermoUso;
use EmVista\EmVistaBundle\Entity\SiteVideo;
use EmVista\EmVistaBundle\Entity\Categoria;
use EmVista\EmVistaBundle\Entity\StatusDoacao;
use Doctrine\Common\Persistence\ObjectManager;
use EmVista\EmVistaBundle\Entity\FormaPagamento;
use EmVista\EmVistaBundle\Entity\StatusPagamento;
use EmVista\EmVistaBundle\Entity\StatusSubmissao;
use EmVista\EmVistaBundle\Entity\GatewayPagamento;
use Doctrine\Common\DataFixtures\FixtureInterface;
use EmVista\EmVistaBundle\Entity\StatusFinanceiro;
use EmVista\EmVistaBundle\Entity\StatusArrecadacao;
use EmVista\EmVistaBundle\Entity\TipoProjetoImagem;
use EmVista\EmVistaBundle\Entity\TipoMovimentacaoFinanceira;

class Fixtures implements FixtureInterface{

    public function load(ObjectManager $em){

        //CATEGORIAS

        $categoriaArte = new Categoria();
        $categoriaArte->setNome('Arte');
        $em->persist($categoriaArte);

        $categoriaComunidade = new Categoria();
        $categoriaComunidade->setNome('Comunidade');
        $em->persist($categoriaComunidade);

        $categoriaVideo = new Categoria();
        $categoriaVideo->setNome('Vídeo');
        $em->persist($categoriaVideo);

        $categoriaDanca = new Categoria();
        $categoriaDanca->setNome('Dança');
        $em->persist($categoriaDanca);

        $categoriaDesign = new Categoria();
        $categoriaDesign->setNome('Design');
        $em->persist($categoriaDesign);

        $categoriaEsporte = new Categoria();
        $categoriaEsporte->setNome('Esporte');
        $em->persist($categoriaEsporte);

        $categoriaEventos = new Categoria();
        $categoriaEventos->setNome('Eventos');
        $em->persist($categoriaEventos);

        $categoriaFotografia = new Categoria();
        $categoriaFotografia->setNome('Fotografia');
        $em->persist($categoriaFotografia);

        $categoriaGastronomia = new Categoria();
        $categoriaGastronomia->setNome('Gastronomia');
        $em->persist($categoriaGastronomia);

        $categoriaJogos = new Categoria();
        $categoriaJogos->setNome('Jogos');
        $em->persist($categoriaJogos);

        $categoriaModa = new Categoria();
        $categoriaModa->setNome('Moda');
        $em->persist($categoriaModa);

        $categoriaMusica = new Categoria();
        $categoriaMusica->setNome('Música');
        $em->persist($categoriaMusica);

        $categoriaPublicacoes = new Categoria();
        $categoriaPublicacoes->setNome('Publicações');
        $em->persist($categoriaPublicacoes);

        $categoriaTeatro = new Categoria();
        $categoriaTeatro->setNome('Teatro');
        $em->persist($categoriaTeatro);

        $categoriaTecnologia = new Categoria();
        $categoriaTecnologia->setNome('Tecnologia');
        $em->persist($categoriaTecnologia);

        //ROLES

        $roleUser = new Role();
        $roleUser->setNome('ROLE_USER');
        $em->persist($roleUser);

        $roleAdmin = new Role();
        $roleAdmin->setNome('ROLE_ADMIN');
        $em->persist($roleAdmin);

        //STATUS SUBMISSAO

        $statusSubmissaoInicial = new StatusSubmissao();
        $statusSubmissaoInicial->setNome('INICIAL')
                               ->setDescricao('Inicial');
        $em->persist($statusSubmissaoInicial);

        $statusSubmissaoAguardandoAprovacao = new StatusSubmissao();
        $statusSubmissaoAguardandoAprovacao->setNome('AGUARDANDO_APROVACAO')
                                           ->setDescricao('Aguardando aprovação');
        $em->persist($statusSubmissaoAguardandoAprovacao);

        $statusSubmissaoAprovado = new StatusSubmissao();
        $statusSubmissaoAprovado->setNome('APROVADO')
                                ->setDescricao('Aprovado');
        $em->persist($statusSubmissaoAprovado);

        $statusSubmissaoRejeitado = new StatusSubmissao();
        $statusSubmissaoRejeitado->setNome('REJEITADO')
                                 ->setDescricao('Rejeitado');
        $em->persist($statusSubmissaoRejeitado);

        //STATUS FINANCEIRO

        $statusFinanceiroPago = new StatusFinanceiro();
        $statusFinanceiroPago->setNome('PAGO')
                             ->setDescricao('Pago');
        $em->persist($statusFinanceiroPago);

        $statusFinanceiroEstornado = new StatusFinanceiro();
        $statusFinanceiroEstornado->setNome('ESTORNADO')
                                  ->setDescricao('Estornado');
        $em->persist($statusFinanceiroEstornado);

        //STATUS ARRECADACAO

        $statusArrecadacaoEmAndamento = new StatusArrecadacao();
        $statusArrecadacaoEmAndamento->setNome('EM_ANDAMENTO')
                                    ->setDescricao('Em andamento');
        $em->persist($statusArrecadacaoEmAndamento);

        $statusArrecadacaoSucesso = new StatusArrecadacao();
        $statusArrecadacaoSucesso->setNome('SUCESSO')
                                 ->setDescricao('Sucesso');
        $em->persist($statusArrecadacaoSucesso);

        $statusArrecadacaoInsucesso = new StatusArrecadacao();
        $statusArrecadacaoInsucesso->setNome('INSUCESSO')
                                   ->setDescricao('Insucesso');
        $em->persist($statusArrecadacaoInsucesso);

        $statusArrecadacaoAguardandoBoleto = new StatusArrecadacao();
        $statusArrecadacaoAguardandoBoleto->setNome('AGUARDANDO_BOLETO')
                                          ->setDescricao('Aguardando boleto');
        $em->persist($statusArrecadacaoAguardandoBoleto);

        $statusArrecadacaoCancelado = new StatusArrecadacao();
        $statusArrecadacaoCancelado->setNome('CANCELADO')
                                   ->setDescricao('Cancelado');
        $em->persist($statusArrecadacaoCancelado);

        //STATUS DOACAO

        $statusDoacaoAprovada = new StatusDoacao();
        $statusDoacaoAprovada->setNome('Aprovada');
        $statusDoacaoAprovada->setDescricao('Aprovada pela instituição financeira');

        $em->persist($statusDoacaoAprovada);

        $statusDoacaoPendente = new StatusDoacao();
        $statusDoacaoPendente->setNome('Pendente');
        $statusDoacaoPendente->setDescricao('Engloba boletos impressos e cartão sem aprovacao ainda.');

        $em->persist($statusDoacaoPendente);

        $statusDoacaoCancelado = new StatusDoacao();
        $statusDoacaoCancelado->setNome('Cancelado');
        $statusDoacaoCancelado->setDescricao('Pagamentos não concluidos.');

        $em->persist($statusDoacaoCancelado);

        $statusDoacaoFalhado = new StatusDoacao();
        $statusDoacaoFalhado->setNome('Falhado');
        $statusDoacaoFalhado->setDescricao('Ouve falha no pagamentos.');

        $em->persist($statusDoacaoFalhado);

        $statusDoacaoEstornado = new StatusDoacao();
        $statusDoacaoEstornado->setNome('Estornado');
        $statusDoacaoEstornado->setDescricao('Pagamento reembolsado.');

        $em->persist($statusDoacaoEstornado);

        $statusDoacaoAguardando = new StatusDoacao();
        $statusDoacaoAguardando->setNome('Estornado');
        $statusDoacaoAguardando->setDescricao('Pagamento reembolsado.');

        $em->persist($statusDoacaoAguardando);


        //GATEWAYS DE PAGAMENTOS

        $moipGateway = new GatewayPagamento();
        $moipGateway->setNome('MoIP');

        $em->persist($moipGateway);

        //STATUS PAGAMENTO

        $statusMoipAutorizado = new StatusPagamento();
        $statusMoipAutorizado->setGatewayPagamento($moipGateway);
        $statusMoipAutorizado->setGatewayStatus(1);
        $statusMoipAutorizado->setValorGatewayStatus('Autorizado');
        $statusMoipAutorizado->setDescricaoGatewayStatus('Pagamento autorizado pelo pagador, porém ainda não creditado para o recebedor em razão do floating');
        $statusMoipAutorizado->setStatusDoacao($statusDoacaoPendente);

        $em->persist($statusMoipAutorizado);

        $statusMoipIniciado = new StatusPagamento();
        $statusMoipIniciado->setGatewayPagamento($moipGateway);
        $statusMoipIniciado->setGatewayStatus(2);
        $statusMoipIniciado->setValorGatewayStatus('Iniciado');
        $statusMoipIniciado->setDescricaoGatewayStatus('Pagamento foi iniciado, mas não existem garantias de que será finalizado');
        $statusMoipIniciado->setStatusDoacao($statusDoacaoPendente);

        $em->persist($statusMoipIniciado);

        $statusMoipBoletoImpresso = new StatusPagamento();
        $statusMoipBoletoImpresso->setGatewayPagamento($moipGateway);
        $statusMoipBoletoImpresso->setGatewayStatus(3);
        $statusMoipBoletoImpresso->setValorGatewayStatus('Boleto Impresso');
        $statusMoipBoletoImpresso->setDescricaoGatewayStatus('Pagamento ainda não foi confirmado, porém boleto bancário foi impresso e pode ter sido pago (não existem garantias de que será pago)');
        $statusMoipBoletoImpresso->setStatusDoacao($statusDoacaoPendente);

        $em->persist($statusMoipBoletoImpresso);

        $statusMoipConcluido = new StatusPagamento();
        $statusMoipConcluido->setGatewayPagamento($moipGateway);
        $statusMoipConcluido->setGatewayStatus(4);
        $statusMoipConcluido->setValorGatewayStatus('Concluido');
        $statusMoipConcluido->setDescricaoGatewayStatus('Pagamento foi concluído, dinheiro debitado do pagador e creditado para o recebedor');
        $statusMoipConcluido->setStatusDoacao($statusDoacaoAprovada);

        $em->persist($statusMoipConcluido);

        $statusMoipCancelado = new StatusPagamento();
        $statusMoipCancelado->setGatewayPagamento($moipGateway);
        $statusMoipCancelado->setGatewayStatus(5);
        $statusMoipCancelado->setValorGatewayStatus('Cancelado');
        $statusMoipCancelado->setDescricaoGatewayStatus('Pagamento foi cancelado por quem estava pagando');
        $statusMoipCancelado->setStatusDoacao($statusDoacaoCancelado);

        $em->persist($statusMoipCancelado);

        $statusMoipAnalise = new StatusPagamento();
        $statusMoipAnalise->setGatewayPagamento($moipGateway);
        $statusMoipAnalise->setGatewayStatus(6);
        $statusMoipAnalise->setValorGatewayStatus('Em Analise');
        $statusMoipAnalise->setDescricaoGatewayStatus('Pagamento autorizado pelo pagador, mas está em análise e não tem garantias de que será autorizado');
        $statusMoipAnalise->setStatusDoacao($statusDoacaoPendente);

        $em->persist($statusMoipAnalise);

        $statusMoipEstornado = new StatusPagamento();
        $statusMoipEstornado->setGatewayPagamento($moipGateway);
        $statusMoipEstornado->setGatewayStatus(7);
        $statusMoipEstornado->setValorGatewayStatus('Estornado');
        $statusMoipEstornado->setDescricaoGatewayStatus('Pagamento foi concluído, dinheiro creditado para o recebedor, porém estornado para o cartão de crédito do pagador');
        $statusMoipEstornado->setStatusDoacao($statusDoacaoEstornado);

        $em->persist($statusMoipEstornado);

        $statusMoipReembolsado = new StatusPagamento();
        $statusMoipReembolsado->setGatewayPagamento($moipGateway);
        $statusMoipReembolsado->setGatewayStatus(8);
        $statusMoipReembolsado->setValorGatewayStatus('Reembolsado');
        $statusMoipReembolsado->setDescricaoGatewayStatus('Pagamento foi concluído, dinheiro creditado para o recebedor, porém houve o reembolso para a Carteira Moip do pagador');
        $statusMoipReembolsado->setStatusDoacao($statusDoacaoEstornado);

        $em->persist($statusMoipReembolsado);


        //TIPO MOVIMENTACAO FINANCEIRA

        $tipoMovFinaneiraPagamento = new TipoMovimentacaoFinanceira();
        $tipoMovFinaneiraPagamento->setNome('Pagamento');

        $em->persist($tipoMovFinaneiraPagamento);

        $tipoMovFinaneiraEstorno = new TipoMovimentacaoFinanceira();
        $tipoMovFinaneiraEstorno->setNome('Estorno');

        $em->persist($tipoMovFinaneiraEstorno);

        $fpMoipSaldoMoip = new FormaPagamento();
        $fpMoipSaldoMoip->setGatewayPagamento($moipGateway);
        $fpMoipSaldoMoip->setCodigo(1);
        $fpMoipSaldoMoip->setValor('MoIP');
        $fpMoipSaldoMoip->setDescricao('Saldo na Carteira MoIP');

        $em->persist($fpMoipSaldoMoip);

        $fpMoipVisa = new FormaPagamento();
        $fpMoipVisa->setGatewayPagamento($moipGateway);
        $fpMoipVisa->setCodigo(3);
        $fpMoipVisa->setValor('Visa');
        $fpMoipVisa->setDescricao('Bandeira de cartão de crédito Visa');

        $em->persist($fpMoipVisa);

        $fpMoipAmerican = new FormaPagamento();
        $fpMoipAmerican->setGatewayPagamento($moipGateway);
        $fpMoipAmerican->setCodigo(3);
        $fpMoipAmerican->setValor('AmericanExpress');
        $fpMoipAmerican->setDescricao('Bandeira de cartão de crédito American Express');

        $em->persist($fpMoipAmerican);

        $fpMoipMaster = new FormaPagamento();
        $fpMoipMaster->setGatewayPagamento($moipGateway);
        $fpMoipMaster->setCodigo(5);
        $fpMoipMaster->setValor('Mastercard');
        $fpMoipMaster->setDescricao('Bandeira de cartão de crédito Mastercard');

        $em->persist($fpMoipMaster);

        $fpMoipDiners = new FormaPagamento();
        $fpMoipDiners->setGatewayPagamento($moipGateway);
        $fpMoipDiners->setCodigo(6);
        $fpMoipDiners->setValor('Diners');
        $fpMoipDiners->setDescricao('Bandeira de cartão de crédito Diners');

        $em->persist($fpMoipDiners);

        $fpMoipBB = new FormaPagamento();
        $fpMoipBB->setGatewayPagamento($moipGateway);
        $fpMoipBB->setCodigo(8);
        $fpMoipBB->setValor('BancoDoBrasil');
        $fpMoipBB->setDescricao('Débito em conta Banco do Brasil');

        $em->persist($fpMoipBB);

        $fpMoipBradesco = new FormaPagamento();
        $fpMoipBradesco->setGatewayPagamento($moipGateway);
        $fpMoipBradesco->setCodigo(22);
        $fpMoipBradesco->setValor('Bradesco');
        $fpMoipBradesco->setDescricao('Débito em conta banco Bradesco');

        $em->persist($fpMoipBradesco);

        $fpMoipItau = new FormaPagamento();
        $fpMoipItau->setGatewayPagamento($moipGateway);
        $fpMoipItau->setCodigo(13);
        $fpMoipItau->setValor('Itau');
        $fpMoipItau->setDescricao('Débito em conta banco Itau');

        $em->persist($fpMoipItau);

        $fpMoipHipercard = new FormaPagamento();
        $fpMoipHipercard->setGatewayPagamento($moipGateway);
        $fpMoipHipercard->setCodigo(75);
        $fpMoipHipercard->setValor('Hipercard');
        $fpMoipHipercard->setDescricao('Débito em conta banco Hipercard');

        $em->persist($fpMoipHipercard);

        $fpMoipPaggo = new FormaPagamento();
        $fpMoipPaggo->setGatewayPagamento($moipGateway);
        $fpMoipPaggo->setCodigo(76);
        $fpMoipPaggo->setValor('Paggo');
        $fpMoipPaggo->setDescricao('Cobrança em conta Oi Paggo');

        $em->persist($fpMoipPaggo);


        $fpMoipBanrisul = new FormaPagamento();
        $fpMoipBanrisul->setGatewayPagamento($moipGateway);
        $fpMoipBanrisul->setCodigo(88);
        $fpMoipBanrisul->setValor('Banrisul');
        $fpMoipBanrisul->setDescricao('Débito em conta banco Banrisul');

        $em->persist($fpMoipBanrisul);



        //TIPO PROJETO IMAGEM

        $tipoProjetoImagemDestaque = new TipoProjetoImagem();
        $tipoProjetoImagemDestaque->setNome('DESTAQUE')
                                  ->setAspectRatio(860 / 200)
                                  ->setLargura(860)
                                  ->setAltura(200);

        $em->persist($tipoProjetoImagemDestaque);

        $tipoProjetoImagemDestaqueSecundario = new TipoProjetoImagem();
        $tipoProjetoImagemDestaqueSecundario->setNome('DESTAQUE_SECUNDARIO')
                                            ->setAspectRatio(360 / 200)
                                            ->setLargura(360)
                                            ->setAltura(200);

        $em->persist($tipoProjetoImagemDestaqueSecundario);

        $tipoProjetoImagemThumb = new TipoProjetoImagem();
        $tipoProjetoImagemThumb->setNome('THUMB')
                               ->setAspectRatio(220 / 300)
                               ->setLargura(220)
                               ->setAltura(300);

        $em->persist($tipoProjetoImagemThumb);

        $tipoProjetoImagemOriginal = new TipoProjetoImagem();
        $tipoProjetoImagemOriginal->setNome('ORIGINAL');
        $em->persist($tipoProjetoImagemOriginal);

        // SITE VIDEO

        $siteVideoYT = new SiteVideo();
        $siteVideoYT->setEmbed('<iframe width="620" height="344" src="http://www.youtube.com/embed/{IDENTIFICADOR}?rel=0" frameborder="0" allowfullscrenn></iframe>')
                    ->setNome('Youtube')
                    ->setWatchUrl('http://www.youtube.com/watch?v={IDENTIFICADOR}');
        $em->persist($siteVideoYT);

        $siteVideoVimeo = new SiteVideo();
        $siteVideoVimeo->setEmbed('<iframe src="http://player.vimeo.com/video/{IDENTIFICADOR}" width="620" height="344" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>')
                  ->setNome('Vimeo')
                  ->setWatchUrl('http://vimeo.com/{IDENTIFICADOR}');
        $em->persist($siteVideoVimeo);

        //TERMOS DE USO

        $termoUso = new TermoUso();
        $termoUso->setTermoUso(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'termoUso'));
        $em->persist($termoUso);

        //EMAILS

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
    }
}