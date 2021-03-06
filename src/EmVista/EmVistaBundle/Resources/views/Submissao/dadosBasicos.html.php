<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('submissao_salvar-dados-basicos', array('submissaoId' => $submissao->getId())); ?>">

    <input type="hidden" name="submissaoId" id="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <fieldset>
        <legend>Dados Básicos</legend>
        
        <?php if($view['security']->isGranted('ROLE_ADMIN')): ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="preCadastro" <?php echo $submissao->getProjeto()->getPreCadastro() ? 'checked="checked"' : ''; ?>
                               value="1"> Pré cadastro
                    </label>
                </div>
                <small>Marque essa opção caso o projeto fique aguardando o início pelo proponente</small>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="nome">Título do projeto</label>
            <div class="col-sm-7">
                <input type="text" name="nome" class="form-control" minlength="2" maxlength="100"
                       value="<?php echo $submissao->getProjeto()->getNome(); ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="categoria">Categoria</label>
            <div class="col-sm-3">
                <select type="text" name="categoriaId" class="form-control">
                    <option></option>
                    <?php foreach($categorias as $categoria): ?>
                        <?php $categoriaProjetoId = ($submissao->getProjeto() && $submissao->getProjeto()->getCategoria() ? $submissao->getProjeto()->getCategoria()->getId() : null); ?>
                        <?php $selected = ($categoria->getId() == $categoriaProjetoId ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?> value="<?php echo $categoria->getId(); ?>"><?php echo $categoria->getNome(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="quantidadeDias">Quantidade de dias</label>
            <div class="col-sm-2">
                <div class="input-group">
                    <input name="quantidadeDias" type="text" class="form-control "
                           value="<?php echo $submissao->getProjeto()->getQuantidadeDias(); ?>"/>
                    <span class="input-group-addon"><?php echo "{$quantidadeDiasMinimo} a {$quantidadeDiasMaximo} dias"; ?></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="valor">Valor desejado</label>
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-addon">R$</span>
                    <input name="valor" type="text" class="form-control money" <?php echo $submissao->getProjeto()->getPreCadastro() ? 'disabled="disabled"' : ''; ?>
                           value="<?php echo $submissao->getProjeto()->getPreCadastro() ? '' : $submissao->getProjeto()->getValorFormatado(); ?>"/>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-2">
                <button type="submit" class="btn btn-success">Avançar</button>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

<?php foreach($view['assetic']->javascripts(array(
    '@EmVistaBundle/Resources/public/js/emvista/submissao/dadosBasicos.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>