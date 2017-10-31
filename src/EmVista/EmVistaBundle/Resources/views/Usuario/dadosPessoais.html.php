<?php $view->extend('EmVistaBundle:Usuario:base.html.php'); ?>
<?php $view['slots']->start('usuario-body') ?>

<form class="form-horizontal"  action="<?php echo $view['router']->generate('usuario_alterar-dados-pessoais') ?>" method="post">
    <input type="hidden" name="usuario[id]" value="<?php echo $usuario->getId(); ?>"/>
    <legend>Dados Pessoais</legend>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="usuario-nome">Nome</label>
        <div class="col-sm-6">
            <input type="text" class="form-control validate[required,minSize[2],maxSize[100]]" id="usuario-nome" name="usuario[nome]" value="<?php echo $usuario->getNome(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="usuario-email">Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control validate[required,custom[email]]" id="usuario-email" name="usuario[email]" value="<?php echo $usuario->getEmail(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="usuario-confirma-email">Repita o Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control validate[required,equals[usuario-email]]" id="usuario-confirma-email" name="usuario[confirmaEmail]" value="<?php echo $usuario->getEmail(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="usuario-senha">Senha</label>
        <div class="col-sm-3">
            <input type="password" class="form-control validate[custom[onlyLetterNumber,minSize[6],maxSize[50]]]" id="usuario-senha" name="usuario[senha]" placeholder="**********">
            <p class="help-block">A senha deverá ter no mínimo 6 caracteres alfanuméricos.</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="usuario-confirma-senha">Repita a Senha</label>
        <div class="col-sm-3">
            <input type="password" class="form-control validate[equals[usuario-senha]]" id="usuario-confirma-senha" name="usuario[confirmaSenha]" placeholder="**********">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-success">Alterar</button>
            <p><a id="inativar" href="<?php echo $view['router']->generate('usuario_confirmacao-inativar-conta') ?>">Inativar Conta</a></p>
        </div>
    </div>    
    
    <legend>Endereço</legend>
    <div class="form-group">
        <label class="col-sm-2 control-label"  for="usuario-endereco-cep">CEP</label>
        <div class="col-sm-3">
            <input type="text" class="form-control validate[custom[onlyNumberSp,minSize[8],maxSize[8]]]"
                   id="usuario-senha" name="usuario[endereco][cep]" placeholder=""
                   value="<?php $endereco = $usuario->getEndereco(); echo $endereco !== NULL ? $endereco->getCep() : '';  ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">UF</label>
        <div class="col-sm-3">
            <select class="form-control" id="usuario-endereco-uf" name="usuario[endereco][uf]">
                <?php $endereco = $usuario->getEndereco(); ?>
                <option value=""> -- </option>
                <option value="AC" <?php if($endereco !== NULL && $endereco->getUf() == 'AC'):?> selected="selected" <?php endif;?>>AC</option>
                <option value="AL" <?php if($endereco !== NULL && $endereco->getUf() == 'AL'):?> selected="selected" <?php endif;?>>AL</option>
                <option value="AM" <?php if($endereco !== NULL && $endereco->getUf() == 'AM'):?> selected="selected" <?php endif;?>>AM</option>
                <option value="AP" <?php if($endereco !== NULL && $endereco->getUf() == 'AP'):?> selected="selected" <?php endif;?>>AP</option>
                <option value="BA" <?php if($endereco !== NULL && $endereco->getUf() == 'BA'):?> selected="selected" <?php endif;?>>BA</option>
                <option value="CE" <?php if($endereco !== NULL && $endereco->getUf() == 'CE'):?> selected="selected" <?php endif;?>>CE</option>
                <option value="DF" <?php if($endereco !== NULL && $endereco->getUf() == 'DF'):?> selected="selected" <?php endif;?>>DF</option>
                <option value="ES" <?php if($endereco !== NULL && $endereco->getUf() == 'ES'):?> selected="selected" <?php endif;?>>ES</option>
                <option value="GO" <?php if($endereco !== NULL && $endereco->getUf() == 'GO'):?> selected="selected" <?php endif;?>>GO</option>
                <option value="MA" <?php if($endereco !== NULL && $endereco->getUf() == 'MA'):?> selected="selected" <?php endif;?>>MA</option>
                <option value="MG" <?php if($endereco !== NULL && $endereco->getUf() == 'MG'):?> selected="selected" <?php endif;?>>MG</option>
                <option value="MS" <?php if($endereco !== NULL && $endereco->getUf() == 'MS'):?> selected="selected" <?php endif;?>>MS</option>
                <option value="MT" <?php if($endereco !== NULL && $endereco->getUf() == 'MT'):?> selected="selected" <?php endif;?>>MT</option>
                <option value="PA" <?php if($endereco !== NULL && $endereco->getUf() == 'PA'):?> selected="selected" <?php endif;?>>PA</option>
                <option value="PB" <?php if($endereco !== NULL && $endereco->getUf() == 'PB'):?> selected="selected" <?php endif;?>>PB</option>
                <option value="PE" <?php if($endereco !== NULL && $endereco->getUf() == 'PE'):?> selected="selected" <?php endif;?>>PE</option>
                <option value="PI" <?php if($endereco !== NULL && $endereco->getUf() == 'PI'):?> selected="selected" <?php endif;?>>PI</option>
                <option value="PR" <?php if($endereco !== NULL && $endereco->getUf() == 'PR'):?> selected="selected" <?php endif;?>>PR</option>
                <option value="RJ" <?php if($endereco !== NULL && $endereco->getUf() == 'RJ'):?> selected="selected" <?php endif;?>>RJ</option>
                <option value="RN" <?php if($endereco !== NULL && $endereco->getUf() == 'RN'):?> selected="selected" <?php endif;?>>RN</option>
                <option value="RO" <?php if($endereco !== NULL && $endereco->getUf() == 'RO'):?> selected="selected" <?php endif;?>>RO</option>
                <option value="RR" <?php if($endereco !== NULL && $endereco->getUf() == 'RR'):?> selected="selected" <?php endif;?>>RR</option>
                <option value="RS" <?php if($endereco !== NULL && $endereco->getUf() == 'RS'):?> selected="selected" <?php endif;?>>RS</option>
                <option value="SC" <?php if($endereco !== NULL && $endereco->getUf() == 'SC'):?> selected="selected" <?php endif;?>>SC</option>
                <option value="SE" <?php if($endereco !== NULL && $endereco->getUf() == 'SE'):?> selected="selected" <?php endif;?>>SE</option>
                <option value="SP" <?php if($endereco !== NULL && $endereco->getUf() == 'SP'):?> selected="selected" <?php endif;?>>SP</option>
                <option value="TO" <?php if($endereco !== NULL && $endereco->getUf() == 'TO'):?> selected="selected" <?php endif;?>>TO</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Cidade</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="usuario-endereco-cidade" name="usuario[endereco][cidade]"
                   value="<?php $endereco = $usuario->getEndereco(); echo $endereco !== NULL ? $endereco->getCidade() : '';  ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Bairro</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="usuario-endereco-bairro" name="usuario[endereco][bairro]"
                    value="<?php $endereco = $usuario->getEndereco(); echo $endereco !== NULL ? $endereco->getBairro() : '';  ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Endereço</label>
        <div class="col-sm-5">
            <input type="text" class="form-control" id="usuario-endereco-endereco" name="usuario[endereco][endereco]"
                   value="<?php $endereco = $usuario->getEndereco(); echo $endereco !== NULL ? $endereco->getEndereco() : '';  ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-success">Alterar</button>
        </div>
    </div>

</form>

<?php $view['slots']->stop(); ?>

<?php
$view['slots']->start('usuarioJs');
foreach($view['assetic']->javascripts(array(
    '@EmVistaBundle/Resources/public/js/jQueryValidationEngine/js/jquery.validationEngine.js',
    '@EmVistaBundle/Resources/public/js/jQueryValidationEngine/js/languages/jquery.validationEngine-pt_BR.js',
    '@EmVistaBundle/Resources/public/js/emvista/usuario/dadosPessoais.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>
<?php $view['slots']->stop(); ?>
