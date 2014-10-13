<?php $view->extend('EmVistaBundle:Usuario:base.html.php'); ?>
<?php $view['slots']->start('usuario-body') ?>

<legend>Atenção!</legend>
<p>Após essa operação você perderá acesso ao cultura crowdfunding e só poderá recuperar sua conta caso solicite.</p>
<p>Se você tiver apoiado algum projeto que ainda não foi concluído, o resultado será informado por email.<p>
<p>Deseja confirmar a inativação da conta?</p>

<form class="form-horizontal" action="<?php echo $view['router']->generate('usuario_inativarConta') ?>" method="post">
    <fieldset>
        <div class="form-actions">
            <button id="inativar" type="submit" class="btn btn-danger">Inativar minha conta</button>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

    <?php foreach ($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/emvista/usuario/dadosPessoais.js')) as $url): ?>
        <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
    <?php endforeach; ?>
<?php $view['slots']->stop(); ?>
