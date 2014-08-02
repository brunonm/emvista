<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<?php $usuario = $token->getUsuario(); ?>

<div class="span8 offset2">
    <form action="<?php echo $view['router']->generate('usuario_alterarSenha') ?>" method="post">
        
        <input type="hidden" name="usuarioId" value="<?php echo $usuario->getId(); ?>"/>
        <input type="hidden" name="token" value="<?php echo $token->getToken(); ?>"/>

        <fieldset>
            <div class="page-header">
                <h3>Esqueci minha senha</h3>
                <small>
                    <p>A senha deverá ter no mínimo 6 caracteres alfanuméricos.</p>
                </small>
            </div>
            <div class="control-group">
                <label class="control-label" for="usuario-senha">Senha </label>
                <div class="controls">
                    <input type="password" class="input-medium" id="usuario-senha" name="senha">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="usuario-senha">Repita a  Senha</label>
                <div class="controls">
                    <input type="password" class="input-medium" id="usuario-senha" name="confirmaSenha">
                </div>
            </div>
            <div class="form-inline button-field">
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
</div>


<?php $view['slots']->stop(); ?>