<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('submissao_salvar-dados-basicos', array('submissaoId' => $submissao->getId())); ?>">

    <input type="hidden" name="submissaoId" id="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <fieldset>
        <legend>Dados Básicos</legend>
        <div class="control-group">
            <label class="control-label" for="nome">Título do projeto</label>
            <div class="controls">
                <input type="text" name="nome" class="input-xlarge" minlength="2" maxlength="100"
                       value="<?php echo $submissao->getProjeto()->getNome(); ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="categoria">Categoria</label>
            <div class="controls">
                <select type="text" name="categoriaId" class="input-xlarge">
                    <option></option>
                    <?php foreach($categorias as $categoria): ?>
                        <?php $categoriaProjetoId = ($submissao->getProjeto() && $submissao->getProjeto()->getCategoria() ? $submissao->getProjeto()->getCategoria()->getId() : null); ?>
                        <?php $selected = ($categoria->getId() == $categoriaProjetoId ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?> value="<?php echo $categoria->getId(); ?>"><?php echo $categoria->getNome(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="quantidadeDias">Quantidade de dias</label>
            <div class="controls">
                <div class="input-append">
                    <input name="quantidadeDias" type="text" class="input-small"
                           value="<?php echo $submissao->getProjeto()->getQuantidadeDias(); ?>"/>
                    <span class="add-on"><?php echo "{$quantidadeDiasMinimo} a {$quantidadeDiasMaximo} dias"; ?></span>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="valor">Valor desejado</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">R$</span>
                    <input name="valor" type="text" class="input-small"
                           value="<?php echo $submissao->getProjeto()->getValor(); ?>"/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn">Avançar</button>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>
