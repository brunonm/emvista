<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>
<link rel="stylesheet" href="/bundles/emvista/css/rte.css" />
<form class="form-horizontal" action="<?php echo $view['router']->generate('admin_registrar-termo-uso') ?>" method="post">
    <fieldset>
        <legend>Termos de uso</legend>
        <div class="control-group">
            <textarea class="col-sm-9" rows="20" id="termoUso[termoUso]" name="termoUso[termoUso]"><?php
                    if(isset($termoUso) && !empty($termoUso)):
                        echo $termoUso->getTermoUso();
                    endif;
                ?></textarea>
        </div>
        <div class="form-actions">
            <input type="submit" class="btn btn-success" value="Salvar">
        </div>
    </fieldset>
</form>
<?php $view['slots']->stop() ?>
