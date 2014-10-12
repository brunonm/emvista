<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<div class="container">
    <p><h1>Termos de uso</h1></p>
    <?php echo ($termosUso->getTermoUsoFormatado()); ?>
</div>

<?php $view['slots']->stop(); ?>
