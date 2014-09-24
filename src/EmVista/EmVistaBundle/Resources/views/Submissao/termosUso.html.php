<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<form method="post" action="<?php echo $view['router']->generate('submissao_iniciar') ?>">
    <div class="row">
        <div class="span12">
            <h3>Termos de uso</h3>
            <p class="text-info">Antes de continuar, é necessário que leia e concorde com os termos de uso do EmVista.</p>
        </div>
    </div>

    <div class="row">
        <div class="span12" style="height: 300px;overflow: auto;    ">
            <?php echo $termosUso->getTermoUsoFormatado(); ?>
        </div>
    </div>

    <div class="form-actions" style="text-align: center">
        <button type="submit" class="btn btn-success">Li e concordo com os termos acima.</button>
    </div>
</form>

<?php $view['slots']->stop(); ?>
