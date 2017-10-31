<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>
<link rel="stylesheet" href="/bundles/emvista/css/rte.css" />
<form class="form-horizontal" action="<?php echo $view['router']->generate('admin_registrar-termo-uso') ?>" method="post">
    <legend>Termos de uso</legend>
    <div class="form-group col-md-10">
        <textarea class="form-control" rows="20" id="termoUso[termoUso]" name="termoUso[termoUso]"><?php
                if(isset($termoUso) && !empty($termoUso)):
                    echo $termoUso->getTermoUso();
                endif; ?>
        </textarea>
    </div>
    <div class="form-group col-md-10">
    <input type="submit" class="btn btn-success" value="Salvar">
    </div>
</form>
<?php $view['slots']->stop() ?>
