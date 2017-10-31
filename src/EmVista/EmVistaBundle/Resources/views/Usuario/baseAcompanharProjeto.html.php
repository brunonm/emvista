<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2><?php echo $projeto->getNome(); ?></h2>
        </div>
    </div>
    <h3 class="row">
        <div class="col-sm-12">
            Apoiadores
        </div>
    </h3>
    <div class="row">
        <div class="col-sm-12">
            <?php $view['slots']->output('tab-body'); ?>
        </div>
    </div>
</div>


<?php $view['slots']->stop(); ?>
