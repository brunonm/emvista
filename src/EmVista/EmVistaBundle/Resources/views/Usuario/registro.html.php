<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>


<div class="row signUpOrLogIn" >
    <div class="span4 offset1 agrupador <?php echo $focado == 'login' ? 'focado' : '';?>">

        <form action="<?php echo $view['router']->generate('login_check') ?>" method="post" id="loginForm">
            <fieldset>

                <div class="page-header">
                    <h4>Login</h4>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge validate[required,custom[email]]" id="email" name="_username" value="<?php echo $last_username ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="senha">Senha</label>
                    <div class="controls">
                        <input type="password" class="input-xlarge validate[required,custom[onlyLetterNumber,minSize[6],maxSize[50]]]" id="senha" name="_password">
                    </div>
                </div>
                <div class="form-inline button-field">
                    <div class="control-group">
                        <div class="controls">

                            <button type="submit" class="btn btn-success">Entrar</button>
                            <label class="checkbox">
                                <input type="checkbox" id="rememberme" value="1">
                                Continuar conectado
                            </label>
                        </div>
                    </div>
                </div>

                <br>
                <p><a href="<?php echo $view['router']->generate('usuario_esqueci-minha-senha') ?>">Esqueci minha senha</a></p>

            </fieldset>

        </form>
    </div>
    <div class="span4 offset1 agrupador <?php echo $focado == 'registro' ? 'focado' : '';?>">
        <form  action="<?php echo $view['router']->generate('usuario_registrar') ?>" method="post">
            <fieldset>
                <div class="page-header">
                    <h4>Registre-se</h4>
                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario-nome">Nome</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge validate[required,minSize[2],maxSize[100]]" id="usuario-nome" name="usuario[nome]">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario-email">Email</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge validate[required,custom[email]]" id="usuario-email" name="usuario[email]">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario-email">Repita o Email</label>
                    <div class="controls">
                        <input type="text" class="input-xlarge  validate[required, equals[usuario-email]]" id="confirma-usuario-email" name="usuario[confirmaEmail]">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario-senha">Senha </label>

                    <div class="controls">
                        <input type="password" class="input-medium validate[required,custom[onlyLetterNumber,minSize[6],maxSize[50]]]" id="usuario-senha" name="usuario[senha]" >
                    </div>

                    <p class="help-block">No mínimo 6 caracteres alfanuméricos.</p>

                </div>
                <div class="control-group">
                    <label class="control-label" for="usuario-senha">Repita a  Senha</label>
                    <div class="controls">
                        <input type="password" class="input-medium validate[required, equals[usuario-senha]]" id="confirma-usuario-senha" name="usuario[confirmaSenha]">
                    </div>
                </div>
                <div class="button-field">
                    <button type="submit" class="btn btn-success">Criar Conta</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<?php $view['slots']->stop();

$view['slots']->start('js');
foreach($view['assetic']->javascripts(array(
    '@EmVistaBundle/Resources/public/js/jQueryValidationEngine/js/jquery.validationEngine.js',
    '@EmVistaBundle/Resources/public/js/jQueryValidationEngine/js/languages/jquery.validationEngine-pt_BR.js',
    '@EmVistaBundle/Resources/public/js/emvista/usuario/registro.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>
<?php $view['slots']->stop(); ?>
