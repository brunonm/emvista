<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php use EmVista\EmVistaBundle\Entity\StatusArrecadacao; ?>
<?php
if (!isset($smSize)) {
    $smSize = 4;
}

if (!isset($lgSize)) {
    $lgSize = 3;
}

if (!isset($xsSize)) {
    $xsSize = 12;
}
?>
<div class="col-sm-<?php echo $smSize?> col-lg-<?php echo $lgSize?> col-xs-<?php echo $xsSize?> project-container" project-id="<?php echo $projeto->getId()?>">
    <div class="project-image-content">

        <div class="mask">
            <div class="content-btn-apoiar">
                <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>"
                   class="btn-special-apoiar col-md-12 btn my-btn" >APOIAR</a>
            </div>
        </div>
        <img class="avatar" src="<?php echo $projeto->getImagemThumb()->getWebPath(); ?>" alt="Projeto">
    </div>
    <div class="project-content">
        <h5><?php echo $projeto->getNome(); ?></h5>
        <legend>por <?php echo $projeto->getUsuario()->getNome(); ?></legend>
        <?php echo $projeto->getDescricaoCurta(); ?>
    </div>
    <div class="project-group">
        <div class="col-sm-3 project-funded">
            <div class="value"><?php echo $projeto->getPercentualArrecadado()?>%</div>
            <div class="label">Meta</div>
        </div>
        <div class="col-sm-5 project-pleged">
            <div class="value">R$</span> <?php echo number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?> </div>
            <div class="label">valor</div>
        </div>
        <div class="col-sm-4 project-togo">
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
                <div class="value"> <span class="time-left-days"><?php echo $numero; ?></span> <?php echo $tempo; ?></div>
                <div class="label"><?php echo $faltam; ?></div>
            <?php else:?>
                <div class="label"> Finalizado </div>
            <?php endif;?>
        </div>
    </div>
</div>