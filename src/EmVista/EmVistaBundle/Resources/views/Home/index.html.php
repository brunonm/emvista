<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<?php if(!empty($primario) || !empty($secundario)): ?>
    <section id="featureds" class="project-listing">
        <?php if(count($primario)):
            $aPrimario = $primario;
            foreach($aPrimario as $primario):
        ?>
            <div class="row">
                <div class="span12 col">
                    <article class="entry project format-full" id="project-1">
                        <header class="entry-header">
                            <h3 class="entry-title project-title">
                                <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $primario->getSlug())); ?>">
                                    <?php echo $primario->getNome(); ?>
                                </a>
                            </h3>
                            <div class="entry-meta">
                                <span class="by-author">por
                                    <span class="author vcard">
                                        <?php echo $primario->getUsuario()->getNome(); ?>
                                    </span>
                                </span>
                            </div>
                        </header>
                        <div class="entry-content">
                            <div class="project-thumb">
                                <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $primario->getSlug())); ?>">
                                    <img src="<?php echo $primario->getImagemDestaque()->getWebPath(); ?>"/>
                                </a>
                            </div>
                            <div class="project-description">
                                <p><?php echo $primario->getDescricaoCurta(); ?></p>
                            </div>
                        </div>
                        <footer class="entry-meta project-meta">
                            <span class="time-left project-time-left">
                                <?php $date = Date::getDateDiff($primario); ?>
                                <?php if($date->days == 0): ?>
                                    <?php if($date->h > 0): ?>
                                        <?php $numero = $date->h; ?>
                                        <?php $tempo = ($numero == 1 ? 'hora' : 'horas'); ?>
                                    <?php else: ?>
                                        <?php $numero = $date->i; ?>
                                        <?php $tempo = ($numero == 1 ? 'minuto' : 'minutos'); ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php $numero = $date->days; ?>
                                    <?php $tempo = ($numero == 1 ? 'dia' : 'dias'); ?>
                                <?php endif; ?>
                                <?php $faltam = ($numero == 1 ? 'Falta' : 'Faltam'); ?>
                                <?php echo $faltam . ' ' . $numero . ' ' . $tempo; ?>
                            </span>
                            <span class="price project-price">
                                <span class="currency-symbol">R$</span> <?php echo number_format($primario->getValorArrecadado(), 2, ',', '.'); ?>
                            </span>
                            <span class="progress-status project-progress-status">
                                <span class="progress-bar-container">
                                    <span class="progress-bar" style="width: <?php echo $primario->getPercentualArrecadado(); ?>%">
                                        <?php $class = $primario->getPercentualArrecadado() > 91 ? 'alternate-color' : ''; ?>
                                        <span class="progress-number <?php echo $class; ?>">
                                            <?php echo $primario->getPercentualArrecadado(); ?>%
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </footer>
                    </article>
                </div>
            </div>
        <?php
            endforeach;
        endif; ?>

        <?php if(!empty($secundario)): ?>
            <div class="row">
                <?php foreach($secundario as $projeto): ?>
                <div class="span6 col">
                    <article class="entry project format-wide" id="project-2">
                        <header class="entry-header">
                            <h3 class="entry-title project-title">
                                <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>">
                                    <?php echo $projeto->getNome(); ?>
                                </a>
                            </h3>
                            <div class="entry-meta">
                                <span class="by-author">por
                                    <span class="author vcard">
                                        <?php echo $projeto->getUsuario()->getNome(); ?>
                                    </span>
                                </span>
                            </div>
                        </header>
                        <div class="entry-content">
                            <div class="project-thumb">
                                <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>">
                                    <img src="<?php echo $projeto->getImagemDestaqueSecundario()->getWebPath(); ?>"/>
                                </a>
                            </div>
                            <div class="project-description">
                                <p><?php echo $projeto->getDescricaoCurta(); ?></p>
                            </div>
                        </div>
                        <footer class="entry-meta project-meta">
                            <span class="time-left project-time-left">
                                <?php $date = Date::getDateDiff($projeto); ?>
                                <?php if($date->days == 0): ?>
                                    <?php if($date->h > 0): ?>
                                        <?php $numero = $date->h; ?>
                                        <?php $tempo = ($numero == 1 ? 'hora' : 'horas'); ?>
                                    <?php else: ?>
                                        <?php $numero = $date->i; ?>
                                        <?php $tempo = ($numero == 1 ? 'minuto' : 'minutos'); ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php $numero = $date->days; ?>
                                    <?php $tempo = ($numero == 1 ? 'dia' : 'dias'); ?>
                                <?php endif; ?>

                                <?php $faltam = ($numero == 1 ? 'Falta' : 'Faltam'); ?>
                                <?php echo $faltam . ' ' . $numero . ' ' . $tempo; ?>
                            </span>
                            <span class="price project-price">
                                <span class="currency-symbol">R$</span> <?php echo number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?>
                            </span>
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
                        </footer>
                    </article>
                </div>
                <?php endforeach; ?>
            </div>
<!--            <div class="row">
                <div class="span12">
                    <p class="see-more"><a href="#">Veja mais destaques >></a></p>
                </div>
            </div>-->
        <?php endif; ?>
    </section>
<?php else: ?>
<?php //Nenhum destaque configurado. ?>
<?php endif; ?>

<?php if(!empty($retaFinal)): ?>
    <section id="finals">
        <div class="page-header">
            <h2>Reta Final</h2>
        </div>
        <div class="row">
            <?php foreach($retaFinal as $projeto): ?>
                <div class="span3 col">
                    <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php', array('projeto' => $projeto)); ?>
                </div>
            <?php endforeach; ?>
        </div>
<!--        <div class="row">
            <div class="span12">
                <p class="see-more"><a href="#">Veja mais projetos na reta final >></a></p>
            </div>
        </div>-->
    </section>
<?php endif; ?>

<?php if(!empty($novos) && count($novos) >= 4): ?>
    <section id="babies">
        <div class="page-header">
            <h2>Quase um bebê</h2>
        </div>
        <div class="row">
            <?php foreach($novos as $projeto): ?>
                <div class="span3 col">
                    <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php', array('projeto' => $projeto)); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <!--    <div class="row">
            <div class="span12">
                <p class="see-more"><a href="#">Veja mais projetos baby >></a></p>
            </div>
        </div>-->
    </section>
<?php endif; ?>

<?php if(!empty($finalizados)): ?>
    <section id="finishes">
        <div class="page-header">
            <h2>últimos finalizados</h2>
        </div>
        <div class="row">
            <?php foreach($finalizados as $projeto): ?>
                <div class="span3 col">
                    <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php', array('projeto' => $projeto)); ?>
                </div>
            <?php endforeach; ?>
        </div>
<!--        <div class="row">
            <div class="span12">
                <p class="see-more"><a href="#">Veja mais projetos na reta final >></a></p>
            </div>
        </div>-->
    </section>
<?php endif; ?>

<?php $view['slots']->stop(); ?>