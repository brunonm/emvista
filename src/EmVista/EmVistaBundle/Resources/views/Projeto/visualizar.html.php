<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php use EmVista\EmVistaBundle\Entity\StatusArrecadacao; ?>
<?php $view->extend('EmVistaBundle::base.html.php'); ?>

<?php $view['slots']->start('title') ?>
<?php echo $projeto->getNome(); ?> | Cultura Crowdfunding <?php $view['slots']->stop(); ?>

<?php $view['slots']->start('image') ?>
<?php ?>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('description') ?>
<?php echo $projeto->getDescricaoCurta(); ?>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('projectHeader'); ?>
<div class="row">
    <div class="col-sm-6">
        <h3 class="project-title">
            <?php echo $projeto->getNome(); ?>
        </h3>
    </div>
</div>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('body');

/**
 * @var \EmVista\EmVistaBundle\Entity\Projeto $projeto
 */
?>


<section id="project-title" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>
                    <?php echo $projeto->getNome(); ?>
                </h2>
                <p>por <?php echo $projeto->getUsuario()->getNome(); ?></p>

            </div>
        </div>
    </div>
</section>
<section id="tabs" class="section" >
    <div class="navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="container">
            <ul class="nav nav-pills navbar-left" >
                <li class="invert"><a href="#">Home</a></li>
                <li><a href="#">Apoiadores</a></li>
                <li><a href="#">Comentários</a></li>
            </ul>
            <ul class="nav nav-pills navbar-right">
                <?php
                if ($projeto->getUsuario()->getEndereco()) :
                ?>
                <li>
                    <a href="#"><i class="fa fa-map-marker"></i>
                    <?php echo $projeto->getUsuario()->getEndereco()->getCidade()?>,
                    <?php echo $projeto->getUsuario()->getEndereco()->getUf()?></a>
                </li>

                <?php
                endif;?>
                <li><a href="#"><i class="fa fa-tag"></i> <?php echo $projeto->getCategoria()->getNome()?></a></li>
            </ul>
        </div>
    </div>

</section>
<section id="project" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="video-container">
                            <?php echo $projeto->getVideo()->getEmbed() ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style ">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                            <a class="addthis_counter addthis_pill_style"></a>
                        </div>
                        <script type="text/javascript"
                                src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fae20f61f85c3f5"></script>
                        <!-- AddThis Button END -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo nl2br($projeto->getDescricao()); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">

                <div class="row">
                    <div class="col-sm-12  results-container">
                        <h1>
                            <div class="result-number"><?php echo $countDoacoes; ?></div>
                            <h4>
                                contribuições
                            </h4>
                        </h1>
                        <h1>
                            <div class="result-number"><span
                                    style="font-size:11px">R$</span><?php echo number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?>
                            </div>
                            <h4>da meta de R$ <?php echo number_format($projeto->getValor(), 2, ',', '.'); ?></h4>
                        </h1>

                        <?php $date = Date::getDateDiff($projeto); ?>
                        <?php if ($date->days == 0 && $date->invert == 0): ?>
                            <h1>
                                <div class="result-number"><?php echo $date->format('%H:%I:%S') ?></div>
                                <h4 class="colaboradores">para o fim</h4>
                            </h1>
                            <input type="hidden" id="dataFim"
                                   value="<?php echo $projeto->getDataFim()->format('F d, Y H:i:s') ?>"/>
                            <h1>
                                <div class="result-number">{hnn}:{mnn}:{snn}</div>
                                <h4 class="colaboradores">para o fim</h4>
                            </h1>

                        <?php elseif ($date->invert == 1): ?>
                            <h1>
                                <div class="result-number">00:00:00</div>
                                <h4 class="colaboradores">para o fim</h4>
                            </h1>
                        <?php
                        else: ?>
                            <?php $numero = $date->days; ?>
                            <?php $tempo = ($numero == 1 ? 'dia' : 'dias'); ?>

                            <h1>
                                <div class="result-number"><?php echo $numero; ?></div>
                                <h4 class="colaboradores"><?php echo $tempo; ?> para o fim</h4>
                            </h1>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row apoiar-projeto-field">
                    <a class="btn btn-special col-sm-8 col-sm-offset-2 my-btn">APOIAR PROJETO</a>
                </div>

                <div class="recompensas">
                    <?php foreach ($projeto->getRecompensas() as $indice => $recompensa): ?>
                        <div class="row recompensa">

                            <div class="col-sm-12">
                                <h4>R$ <?php echo number_format($recompensa->getValorMinimo(), 2, ',', '.') ?> ou
                                    mais</h4>
                                <h5><?php $recompensa->getTitulo(); ?></h5>
                                <?php echo $recompensa->getDescricao(); ?>
                                <?php $quantidadeMaxima = (int)$recompensa->getQuantidadeMaximaApoiadores(); ?>

                                <?php if ($quantidadeMaxima > 0): ?>

                                    <?php $lblQtd = ''; ?>
                                    <?php $quantidadeApoiadores = $recompensa->getQuantidadeApoiadores(); ?>
                                    <?php if ($quantidadeApoiadores >= $quantidadeMaxima): ?>
                                        <?php $lblQtd = 'Esgotado'; ?>

                                    <?php else: ?>
                                        <?php $lblQtd = $quantidadeApoiadores . '/' . $quantidadeMaxima . ' disponíveis' ?>

                                    <?php endif; ?>
                                    <div class="limite"><?php echo $lblQtd ?></div>
                                <?php endif; ?>


                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>

                <div class="row created-by">
                    <div class="col-sm-4 col-sm-offset-1">
                        <img src="<?php echo $projeto->getUsuario()->getImagemProfile()->getWebPath()?>" class="img-circle"/>
                    </div>
                    <div class="col-sm-6">
                        <div>Projetado por</div>
                        <h4><?php echo $projeto->getUsuario()->getNome()?></h4>

                        <?php
                        if ($projeto->getUsuario()->getEndereco()) :
                        ?>
                        <div><i class="fa fa-map-marker"></i> Brasília, DF</div>
                        <?php
                        endif;
                        ?>
                        <div><i class="fa fa-heart"></i> apoiou 2 Projetos</div>
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

<?php $view['slots']->start('css1') ?>

        <?php foreach($view['assetic']->stylesheets(
                array('@EmVistaBundle/Resources/public/css/emvista/projeto/visualizar.css')) as $url): ?>
            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

<?php $view['slots']->stop(); ?>
