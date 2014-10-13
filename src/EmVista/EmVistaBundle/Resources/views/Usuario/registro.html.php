<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="container">
    <div class="row" >
        <div class="col-sm-6">
            <form action="<?php echo $view['router']->generate('login_check') ?>" method="post" id="loginForm">
                <fieldset>
                    <div class="page-header">
                        <h4>Login</h4>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="<?php echo $view['router']->generate('hwi_oauth_service_redirect', array('service' => 'facebook')); ?>"><span class="fa fa-facebook fa-2x"></span></a>
                        <a class="btn btn-default" href="<?php echo $view['router']->generate('hwi_oauth_service_redirect', array('service' => 'twitter')); ?>"><span class="fa fa-twitter fa-2x"></span></a>
                        <a class="btn btn-default" href="<?php echo $view['router']->generate('hwi_oauth_service_redirect', array('service' => 'google')); ?>"><span class="fa fa-google-plus fa-2x"></span></a>
                    </div>                    
                    <p class="lead">OU</p>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control validate[required,custom[email]]" id="email" name="_username" value="<?php echo $last_username ?>">
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" class="form-control validate[required,custom[onlyLetterNumber,minSize[6],maxSize[50]]]" id="senha" name="_password">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="rememberme" value="1"> Continuar conectado
                            </label>
                        </div>
                    </div>         
                    <button type="submit" class="btn btn-success">Entrar</button>
                    <br><br>
                    <p><a href="<?php echo $view['router']->generate('usuario_esqueci-minha-senha') ?>">Esqueci minha senha</a></p>
                </fieldset>
            </form>
        </div>
        <div class="col-sm-6">
            <form action="<?php echo $view['router']->generate('usuario_registrar') ?>" method="post">
                <fieldset>
                    <div class="page-header">
                        <h4>Registre-se</h4>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-default" href="<?php echo $view['router']->generate('hwi_oauth_service_redirect', array('service' => 'facebook')); ?>"><span class="fa fa-facebook fa-2x"></span></a>
                        <a class="btn btn-default" href="<?php echo $view['router']->generate('hwi_oauth_service_redirect', array('service' => 'twitter')); ?>"><span class="fa fa-twitter fa-2x"></span></a>
                        <a class="btn btn-default" href="<?php echo $view['router']->generate('hwi_oauth_service_redirect', array('service' => 'google')); ?>"><span class="fa fa-google-plus fa-2x"></span></a>
                    </div>                    
                    <p class="lead">OU</p>                    
                    <div class="form-group">
                        <label for="usuario-nome">Nome</label>
                        <input type="text" class="form-control validate[required,minSize[2],maxSize[100]]" id="usuario-nome" name="usuario[nome]">
                    </div>
                    <div class="form-group">
                        <label for="usuario-email">Email</label>
                        <input type="text" class="form-control validate[required,custom[email]]" id="usuario-email" name="usuario[email]">
                    </div>
                    <div class="form-group">
                        <label for="usuario-email">Repita o Email</label>
                        <input type="text" class="form-control validate[required, equals[usuario-email]]" id="confirma-usuario-email" name="usuario[confirmaEmail]">
                    </div>
                    <div class="form-group">
                        <label for="usuario-senha">Senha </label>
                        <input type="password" class="form-control validate[required,custom[onlyLetterNumber,minSize[6],maxSize[50]]]" id="usuario-senha" name="usuario[senha]" >
                        <p class="help-block">No mínimo 6 caracteres alfanuméricos.</p>
                    </div>
                    <div class="form-group">
                        <label for="usuario-senha">Repita a  Senha</label>
                        <input type="password" class="form-control validate[required, equals[usuario-senha]]" id="confirma-usuario-senha" name="usuario[confirmaSenha]">
                    </div>
                    <button type="submit" class="btn btn-success">Criar Conta</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js'); ?>

<?php foreach ($view['assetic']->javascripts(array(
    '@EmVistaBundle/Resources/public/js/jQueryValidationEngine/js/jquery.validationEngine.js',
    '@EmVistaBundle/Resources/public/js/jQueryValidationEngine/js/languages/jquery.validationEngine-pt_BR.js',
    '@EmVistaBundle/Resources/public/js/emvista/usuario/registro.js')) as $url):
?>

<script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>

<?php endforeach; ?>

<?php $view['slots']->stop(); ?>
