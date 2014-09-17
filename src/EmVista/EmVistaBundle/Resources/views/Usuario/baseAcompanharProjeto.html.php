<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="row">
    <div class="span12">
        <h2><?php echo $projeto->getNome(); ?></h2>
    </div>
</div>
<div class="row">
    <div class="span12">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="<?php echo $view['router']->generate('usuario_apoiadores-projeto', array('projetoId' => $projeto->getId())); ?>">Apoiadores</a>
            </li>
<!--            <li>
                <a href="#">Arrecadação</a>
            </li>-->
        </ul>
    </div>
</div>
<div class="row">
    <div class="span12">
        <?php $view['slots']->output('tab-body'); ?>
    </div>
</div>


<?php $view['slots']->stop(); ?>
