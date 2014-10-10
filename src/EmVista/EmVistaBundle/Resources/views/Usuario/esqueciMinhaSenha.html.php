<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>


<div class="col-sm-8 col-sm-offset-2">

    <form action="<?php echo $view['router']->generate('usuario_enviar-esqueci-minha-senha') ?>" method="post">
        <fieldset>
            <div class="page-header">
                <h3>Esqueci minha senha</h3>
                <small>
                    <p>Insira abaixo o email da sua conta cadastrada no EmVista para alterar sua senha.</p>
                    <p>Você será notificado no endereço informado com os procedimentos necessários.</p>
                </small>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="email" name="email" value="">
                </div>
            </div>
            <div class="form-inline button-field">
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>


<?php $view['slots']->stop(); ?>
