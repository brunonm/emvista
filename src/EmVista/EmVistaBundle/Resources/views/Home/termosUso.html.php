<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<p><h1>Termos de uso</h1></p>

<?php echo ($termosUso->getTermoUsoFormatado()); ?>

<?php $view['slots']->stop(); ?>
