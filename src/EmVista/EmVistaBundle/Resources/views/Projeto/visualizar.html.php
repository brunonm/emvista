<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php use EmVista\EmVistaBundle\Entity\StatusArrecadacao; ?>
<?php $view->extend('EmVistaBundle::base.html.php'); ?>

<?php $view['slots']->start('title') ?>
<?php echo $projeto->getNome(); ?> | EmVista | Crowdfunding no Brasil <?php $view['slots']->stop(); ?>

<?php $view['slots']->start('image') ?>
<?php ?>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('description') ?>
<?php echo $projeto->getDescricaoCurta(); ?>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('projectHeader'); ?>
<div class="row">
    <div class="span6">
        <h3 class="project-title">
            <?php echo $projeto->getNome(); ?>
        </h3>
    </div>
</div>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('body'); ?>

<div id="abasProjeto" class="abaProjeto">
    <ul>
        <li class="atual" id="Projeto">
            <a href="#">Projeto</a>
        </li>
        <li id="Comentario">
            <a href="#contentComentario">Comentários</a>
        </li>
        <li id="Atualizacoes">
            <a href="#">Atualizações</a>
        </li>
    </ul>
</div>
<section id="featureds" class="project-listing">
    <div class="row_top">
        <div class="row">
            <div class="span8">
                <article class="entry project format-full" id="project-1">
                    <?php echo $projeto->getVideo()->getEmbed() ?>
                </article>
            </div>
            <div class="span4">
                <div class="colab_numeros"><?php echo $countDoacoes; ?></div>
                <div class="colaboradores">contribuições</div>

                <?php $date = Date::getDateDiff($projeto);?>
                <?php if($date->days == 0 && $date->invert == 0): ?>
                    <div class="tempoParaFimDoProjeto">
                        <div class="colab_numeros"><?php echo $date->format('%H:%I:%S')?></div>
                        <div class="colaboradores">para o fim</div>
                    </div>
                    <input type="hidden" id="dataFim" value="<?php echo $projeto->getDataFim()->format('F d, Y H:i:s')?>" />
                    <div class="layoutTempoParaFimDoProjeto">
                        <div class="colab_numeros">{hnn}:{mnn}:{snn}</div>
                        <div class="colaboradores">para o fim</div>
                    </div>

                <?php elseif ($date->invert == 1): ?>
                    <div class="tempoParaFimDoProjeto">
                        <div class="colab_numeros">00:00:00</div>
                        <div class="colaboradores">para o fim</div>
                    </div>
                <?php else: ?>
                    <?php $numero = $date->days; ?>
                    <?php $tempo = ($numero == 1 ? 'dia' : 'dias'); ?>

                    <div class="tempoParaFimDoProjeto">
                        <div class="colab_numeros"><?php echo $numero; ?></div>
                        <div class="colaboradores"><?php echo $tempo; ?> para o fim</div>
                    </div>
                <?php endif; ?>
                <div class="colab_valor">R$ <?php echo number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?></div>
                <div class="colaboradores">da meta de R$ <?php echo number_format($projeto->getValor(), 2, ',', '.'); ?></div>

                <div class="project-progress-top">
                    <span class="progress-status project-progress-status">
                        <span class="progress-bar-container">
                            <span class="progress-bar" style="width: <?php echo $projeto->getPercentualArrecadado(); ?>%">
                                <?php $class = $projeto->getPercentualArrecadado() > 91 ? 'alternate-color' : ''; ?>
                                <span class="progress-number <?php echo $class; ?>">
                                    <?php echo $projeto->getPercentualArrecadado(); ?>%
                                </span>
                            </span>
                        </span>
                    </span>
                </div>

                <?php if($projeto->getStatusArrecadacao() && $projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_SUCESSO): ?>

                <div class="weGetTag"/>

                <?php elseif($projeto->getStatusArrecadacao() && $projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_INSUCESSO): ?>

                <div class="notReachedTag"/>

                <?php elseif($projeto->getStatusArrecadacao() && $projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_AGUARDANDO_BOLETO): ?>

                <div class="waitingPaymentTag"/>

                <?php elseif($hasUsuarioDoacao): ?>

                <div class="youGotTag"/>

                <?php endif; ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="span5">
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a>
            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fae20f61f85c3f5"></script>
            <!-- AddThis Button END -->
        </div>
    </div>
    <div class="row">
        <div class="span8 cont_principal">
            <div id="contentProjeto" class="contents">
                <?php echo nl2br($projeto->getDescricao()); ?>
            </div>
            <div id="contentComentario" class="contents" style="display: none">
                <div class="fb-comments" data-href="http://<?php echo $app->getRequest()->getHttpHost() . $app->getRequest()->getRequestUri(); ?>" data-num-posts="10" data-width="620"></div>
            </div>
            <div id="contentAtualizacoes" class="contents" style="display: none">
                <?php echo $view->render('EmVistaBundle:Projeto:atualizacoes.html.php', array('atualizacoes' => $atualizacoes, 'usuario' => $usuario, 'projeto' => $projeto)); ?>
            </div>
        </div>
        <div class="span3 col_lateral">
            <?php
            if($projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_EM_ANDAMENTO):
            ?>
            <div class="apoiar">
                <a href="<?php echo $view['router']->generate('pagamento_checkout', array('projetoId' => $projeto->getId())); ?>">
                    <img src="/bundles/emvista/images/btn_apoiar.png">
                </a>
            </div>
            <?php
            endif;
            ?>

            <div class="recompensas">
                <h2>RECOMPENSAS</h2>
                <?php foreach($projeto->getRecompensas() as $indice => $recompensa): ?>
                    <div class="conteudo">
                        <img class="grafico" src="/bundles/emvista/images/icon-chart.png">
                        <h3>R$ <?php echo number_format($recompensa->getValorMinimo(), 2, ',', '.') ?></h3>

                        <?php $quantidadeMaxima     = (int) $recompensa->getQuantidadeMaximaApoiadores(); ?>
                        <?php $quantidadeApoiadores = $recompensa->getQuantidadeApoiadores(); ?>

                        <?php $lblQtd = ''; ?>

                        <?php if($quantidadeMaxima > 0): ?>

                            <?php if($quantidadeApoiadores >= $quantidadeMaxima): ?>
                                <?php $lblQtd = 'Esgotado'; ?>

                            <?php else: ?>
                                <?php $lblQtd = $quantidadeMaxima - $quantidadeApoiadores; ?>
                                <?php $lblQtd = ($lblQtd == 1 ? $lblQtd . ' disponível' : $lblQtd . ' disponíveis'); ?>

                            <?php endif; ?>

                        <?php endif; ?>

                        <h4><?php echo $lblQtd; ?></h4>
                        <div>
                            <strong><?php echo $recompensa->getTitulo(); ?></strong>
                        </div>
                        <?php echo $recompensa->getDescricao(); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="autor">
                <div class="row autorField">
                    <Div class="span3">
                        <h2>AUTOR</h2>
                        <div class="conteudo semDivisao">
                            <h5><?php echo $projeto->getUsuario()->getNome(); ?>
                            </h5>
                                <img class="autorImagem" src="<?php echo $projeto->getUsuario()->getImageProfileWebPath()?>">
                                <br>
        <!--                    <ul>
                                <li><span><img src="/bundles/emvista/images/icon-locate.gif"></span>Taguatinga - DF</li>
                                <li><span><img src="/bundles/emvista/images/icon-twitter.gif"></span>@andrenunes</li>
                            </ul>-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php
$view['slots']->stop();?>

<?php $view['slots']->start('js'); ?>

<?php
    foreach($view['assetic']->javascripts(
        array(
            '@EmVistaBundle/Resources/public/js/jquery.countdown/jquery.countdown.min.js',
            '@EmVistaBundle/Resources/public/js/jquery.countdown/jquery.countdown-pt-BR.js',
            '@EmVistaBundle/Resources/public/js/emvista/projeto/visualizar.js',
            )) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('css') ?>

        <?php foreach($view['assetic']->stylesheets(
                array('@EmVistaBundle/Resources/public/css/emvista/projeto/visualizar.css')) as $url): ?>
            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

<?php $view['slots']->stop(); ?>
