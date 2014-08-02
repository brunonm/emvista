
<form class="form-horizontal" method="post" action="<?php echo $view['router']->generate('projeto_salvarAtualizacao'); ?>">
    <input type="hidden" name="atualizacao[projetoId]" value="<?php echo $projeto->getId(); ?>"/>
    <fieldset>
        <legend>Inserir atualização</legend>
        <div class="control-group">
            <label class="control-label" for="titulo">Titulo</label>
            <div class="controls">
                <input type="text" name="atualizacao[titulo]" class="input-xlarge" id="titulo">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="texto">Texto</label>
            <div class="controls">
                <textarea class="input-xlarge" name="atualizacao[texto]" id="texto" rows="3"></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Inserir</button>
        </div>
    </fieldset>
</form>