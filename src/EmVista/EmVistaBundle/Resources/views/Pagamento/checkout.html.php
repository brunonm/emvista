<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<style>

</style>

<div class="container">
    <form class="form-horizontal" method="post" id="form-checkout"
            action="<?php echo $view['router']->generate('pagamento_continue-checkout'); ?>">
        <div class="row">
            <div class="col-sm-8">
                <h3 class="titulo">Estamos quase lá!</h3>
                <div class="voceIraApoiar">
                    Você irá apoiar o projeto: <span class="nomeDoProjeto"><?php echo $projeto->getNome() ?></span>
                </div>
                <div class="choice_pledge" id="makeChoice">Escolha sua recompensa:</div>
                <div style="display:none" id="confirmeRecompensa" class="titulo">Confirme a recompensa</div>
                <div class="recompensas">
                    <?php
                    foreach($projeto->getRecompensas() as $indice => $recompensa):
                        $valor = round($recompensa->getValorMinimo(),2);
                        $recompensaValida = true;
                        if($recompensa->getQuantidadeMaximaApoiadores() > 0):
                            if($recompensa->getQuantidadeMaximaApoiadores() <= $recompensa->getQuantidadeApoiadores()):
                                $recompensaValida = false;
                            endif;
                        endif;
                        ?>

                        <div class="recompensa row">
                            <label style="width: 100%">
                            <?php if(!$recompensaValida): ?>
                            <div class="disabled_box">
                                <div class="disabled_box_text">
                                    <h4>Quantidade maxima de apoiadores atingida</h4>
                                </div>
                            </div>
                            <?php
                            endif;
                            ?>
                            <div class="col-sm-3 block_pledge <?php echo $recompensaValida ? '' : 'block_pledge_disabled'?>">
                                R$ <?php echo $valor?>
                                <input type="radio" style="display:none" <?php echo $recompensaValida ? '' : 'disabled="disabled"'?> name="apoio[recompensaId]"
                                       valor="<?php echo $valor;?>" class="checkbox-recompensa" value="<?php echo $recompensa->getId() ?>"><br>
                            </div>
                            <div class="col-sm-9">
                                <div class="tituloRecompensa"><?php echo $recompensa->getTitulo()?></div>
                                <?php echo $recompensa->getDescricao();?>
                            </div>
                        </label>
                        </div>
                        <?php
                    endforeach;
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        Informe o valor:
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4">
                        <div class="input-group valorPago">
                            <span class="input-group-addon">R$</span>
                            <input class="input-sm form-control" id="input-valor" name="apoio[valor]" type="text">
                        </div>
                    </div>
                </div>

                <br />
                <br />
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-4" style="text-align: center">
                        <a href="javascript:void(0)" id="naoEraIsso" style="display: none">Não era isso que eu queria!</a>
                        <input type="submit" class="btn-special-apoiar" id="btn-apoiar" value="APOIAR" />
                    </div>
                </div>
            </div>

            <div class="col-sm-4 col_lateral_checkout" >
                <div class="lateral_content">
                    <h2 class="titulo">MUITO IMPORTANTE</h2>
                    <div>
                        Se o projeto não atingir a meta de arrecadação, seu dinheiro será totalmente
                        devolvido por meio da forma de pagamento que escolheu. Se o pagamento foi
                        realizado via boleto bancário, será possível sacar através da sua conta MoIP.
                    </div>
                    <h2 class="titulo">PERGUNTAS FREQUENTES</h2>
                    <div class="faq_lateral">
                        <div class="faqbox">
                            <div class="question">
                                 + Fiz minha contribuição mas até agora não recebi a confirmação. O que aconteceu?
                            </div>
                            <div class="hidden-content">
                                As vezes ocorre da instituição financeira demorar um pouco para aprovar e
                                confirmar o pagamento. Se foi escolhido boleto bancário, o prazo varia de 1
                                a 3 dias úteis. Em caso de dúvidas entre em contato conosco.
                            </div>
                        </div>
                        <div class="faqbox">
                            <div class="question">
                                + Posso escolher uma recompensa mas contribuir com um valor superior?
                            </div>
                            <div class="hidden-content">
                                Sim. Você precisa contribuir com o valor mínimo definido pela
                                recompensa, mas não existe restrição quanto ao valor máximo. Para alterar o
                                valor, selecione a recompensa desejada e depois edite diretamente o valor no
                                campo do formulário.
                            </div>
                        </div>
                        <div class="faqbox">
                            <div class="question">
                                + O que é Moip?
                            </div>
                            <div class="hidden-content">
                                É um dos líderes no mercado de pagamentos online no Brasil. Porporciona
                                segurança, flexibilidade, agilidade e comodidade nas movimentações
                                financeiras realizadas pela internet.
                            </div>
                        </div>
                    </div>
                    <h2 class="titulo">FORMAS DE PAGAMENTO</h2>
                    <div>
                        <img src="/bundles/emvista/images/formasPagamento.png" />
                    </div>
                </div>
            </div>
        </div>

    </form>
    </div>
<div style="color: #999;text-align: center;display: none;" id="mensagemLoading">
    Aguarde, você será redirecionado para o Moip. Após clicar no botão acima,
    não atualize ou utilize os botões de navegação do seu browser.
</div>



<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

    <?php foreach ($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/emvista/pagamento/checkout.js')) as $url): ?>
        <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
    <?php endforeach; ?>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('css') ?>

        <?php foreach($view['assetic']->stylesheets(
                array('@EmVistaBundle/Resources/public/css/emvista/pagamento/checkout.css')) as $url): ?>
            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

<?php $view['slots']->stop(); ?>
