<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<div class="container">
    <p><h1>Termos de uso</h1></p>
    <?php echo ($termosUso->getTermoUso()); ?>
</div>

<?php $view['slots']->stop(); ?>
