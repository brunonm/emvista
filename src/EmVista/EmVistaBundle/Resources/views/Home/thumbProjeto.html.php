<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php use EmVista\EmVistaBundle\Entity\StatusArrecadacao; ?>

<article class="entry project format-narrow" id="project-11">
    <header class="entry-header">
        <h3 class="entry-title project-title">
            <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>">
                <?php echo $projeto->getNome(); ?>
            </a>
        </h3>
        <div class="entry-meta">
            <span class="by-author">por <span class="author vcard"><?php echo $projeto->getUsuario()->getNome(); ?></span></span>
        </div>
    </header>
    <div class="entry-content">
        <div class="project-thumb">
            <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>">
                <img src="<?php echo $projeto->getImagemThumb()->getWebPath(); ?>"/>
            </a>
        </div>
        <div class="project-description">
            <p><?php echo $projeto->getDescricaoCurta(); ?></p>
        </div>
    </div>
    <footer class="entry-meta project-meta">

        <?php if($projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_EM_ANDAMENTO): ?>

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

            <span class="time-left project-time-left"><?php echo $faltam; ?> <span class="time-left-days"><?php echo $numero; ?></span> <?php echo $tempo; ?></span>

        <?php else: ?>
            <span class="time-left project-time-left">Finalizado</span>

        <?php endif; ?>

        <span class="price project-price">
            <span class="currency-symbol">R$</span> <?php echo number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?>
        </span>

        <?php if($projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_EM_ANDAMENTO): ?>

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

        <?php elseif($projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_SUCESSO): ?>

            <div class="project-success-bar" >
                <i class="icon icon-star icon-white"></i> Projeto financiado
            </div>

        <?php elseif($projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_INSUCESSO): ?>

            <div class="project-fail-bar" >
                Projeto não financiado
            </div>

        <?php elseif($projeto->getStatusArrecadacao()->getId() == StatusArrecadacao::STATUS_AGUARDANDO_BOLETO): ?>

            <div class="project-waitingPayment-bar" >
                Aguardando boletos
            </div>

        <?php endif; ?>
    </footer>
</article>