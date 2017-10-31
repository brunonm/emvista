<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6">

            <form action="<?php echo $view['router']->generate('usuario_enviar-esqueci-minha-senha') ?>" method="post">
                <fieldset>
                    <div class="page-header">
                        <h3>Esqueci minha senha</h3>
                        <small>
                            <p>Insira abaixo o email da sua conta cadastrada no cultura crowdfunding para alterar sua senha.</p>
                            <p>Você será notificado no endereço informado com os procedimentos necessários.</p>
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Enviar</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>


<?php $view['slots']->stop(); ?>
