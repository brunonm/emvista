<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('submissao_salvar-mais-sobre-voce', array('submissaoId' => $submissao->getId())); ?>">

    <?php if(empty($pessoa)): $pessoa = new \EmVista\EmVistaBundle\Entity\Pessoa(); endif; ?>
    <?php $readOnly = ($pessoa->getId() ? 'readonly' : ''); ?>

    <fieldset>
        <legend>Mais sobre você</legend>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="tipoPessoa">Tipo de pessoa</label>
            <div class="col-sm-6 radio">
                <label class="radio">
                    <?php $checked  = ($pessoa->getTipo() == 'f' ? 'checked' : ''); ?>
                    <?php $disabled = ($pessoa->getId() && $pessoa->getTipo() == 'j' ? 'disabled' : ''); ?>
                    <input type="radio" name="tipoPessoa" id="radio-tipo-pessoa-fisica" value="f"
                           <?php echo "$checked $disabled" ?>> Física
                </label>
                <label class="radio">
                    <?php $checked  = ($pessoa->getTipo() == 'j' ? 'checked' : ''); ?>
                    <?php $disabled = ($pessoa->getId() && $pessoa->getTipo() == 'f' ? 'disabled' : ''); ?>
                    <input type="radio" name="tipoPessoa" id="radio-tipo-pessoa-juridica" value="j"
                           <?php echo "$checked $disabled" ?>> Jurídica
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="nome">Nome</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nome" name="nome"
                       value="<?php echo $submissao->getProjeto()->getPreCadastro() ? $submissao->getProjeto()->getNomeAutorPreCadastro() : $pessoa->getNome(); ?>" <?php echo $readOnly; ?>/>
                <span class="help-block">
                    <small>Informe o nome completo verdadeiro sem abreviações. O seu usuário não precisa necessariamente ter o mesmo nome.</small>
                </span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="email" readonly="readonly"
                       value="<?php echo $user->getEmail(); ?>"/>
            </div>
        </div>
        <div class="form-group" <?php echo $submissao->getProjeto()->getPreCadastro() ? 'style="display:none"' : ''; ?>>
            <label class="col-sm-2 control-label" for="documento">CPF</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="documento" name="documento"
                       value="<?php echo $pessoa->getDocumento(); ?>" <?php echo $readOnly; ?>/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-2">
                <a href="<?php echo $view['router']->generate('submissao_imagens', array('submissaoId' => $submissao->getId())); ?>"
                   class="btn">Voltar</a>
                <button type="submit" class="btn btn-success">Concluir cadastro</button>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

<?php foreach($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/emvista/submissao/maisSobreVoce.js',
              '@EmVistaBundle/Resources/public/js/jquery.maskedinput.min.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>
