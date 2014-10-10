<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('submissao_salvar-descricao', array('submissaoId' => $submissao->getId())); ?>">

    <input type="hidden" name="submissaoId" id="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <fieldset>
        <legend class="row">
            <div class="col-sm-12">
                Descrição
            </div>
        </legend>
        <div class="row">
            <div class="form-group">
                <label class="control-label  col-sm-2" for="descricaoCurta">Descrição curta</label>
                <div class="col-sm-9">
                    <span class="help-block">
                        <small>A descrição curta é utilizada quando a miniatura do seu projeto for exibida na busca ou na página inicial do EmVista.</small>
                    </span>
                    <textarea  name="descricaoCurta" class="col-sm-7" maxlength="130"><?php echo $submissao->getProjeto()->getDescricaoCurta(); ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-2" for="descricao">Descrição completa</label>
                <div class="col-sm-9">
                    <span class="help-block">
                        <small>Descreva quem é você, o objetivo do projeto, as pessoas envolvidas, como o dinheiro vai ser utilizado, riscos que podem impedir a execução, prazos, recompensas e etc. Seja criativo, venda o seu peixe. :-)</small>
                    </span>
                    <textarea rows="20" class="col-sm-7" name="descricao"><?php echo $submissao->getProjeto()->getDescricao(); ?></textarea>
                </div>
            </div>
        </div>
        <br />
        <br />
        <div class="row">
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-2">
                    <a href="<?php echo $view['router']->generate('submissao_dados-basicos', array('submissaoId' => $submissao->getId())); ?>"
                       class="btn">Voltar</a>
                    <button type="submit" class="btn btn-primary">Avançar</button>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>
