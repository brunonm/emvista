<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('submissao_salvar-recompensas', array('submissaoId' => $submissao->getId())); ?>">

    <input type="hidden" name="submissaoId" id="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <fieldset>
        <legend>Recompensas</legend>
        <div class="container-recompensas" id="submissao-container-recompensas">

            <?php $recompensas = $submissao->getProjeto()->getRecompensas(); ?>

            <?php if(count($recompensas) == 0): $recompensas[] = new \EmVista\EmVistaBundle\Entity\Recompensa(); ?>
            <?php endif; ?>

            <?php foreach($recompensas as $key => $recompensa): ?>

            <div class="recompensa" count="<?php echo $key; ?>">

                <input type="hidden" name="recompensas[<?php echo $key; ?>][recompensaId]"
                       class="recompensaId" value="<?php echo $recompensa->getId(); ?>"/>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="titulo">Título</label>
                    <div class="col-sm-9">
                        <input type="text" name="recompensas[<?php echo $key; ?>][titulo]" maxlength="100"
                               class="form-control" value="<?php echo $recompensa->getTitulo(); ?>">

                        <?php if($key > 0): ?>
                        <a href="javascript:;" class="btn btn-danger btn-excluir-recompensa"><i class="icon-trash icon-white"></i> Excluir recompensa</a>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="valorMinimo">Valor</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">R$</span>
                            <input name="recompensas[<?php echo $key; ?>][valorMinimo]" type="text"
                                   class="form-control" value="<?php echo $recompensa->getValorMinimo(); ?>"/>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="descricao">Descrição</label>
                    <div class="col-sm-9">
                        <input type="text" name="recompensas[<?php echo $key; ?>][descricao]"
                               class="form-control" value="<?php echo $recompensa->getDescricao(); ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-2">
                        <label class="checkbox">
                            <?php $checked = ($recompensa->getQuantidadeMaximaApoiadores() > 0) ? '' : 'checked="checked"'; ?>
                            <input type="checkbox" <?php echo $checked; ?> class="checkbox-limite"> Sem limites
                            <span class="help-block">
                                <small>Esta opção permite limitar a quantidade disponível dessa recompensa.</small>
                            </span>
                        </label>
                    </div>
                </div>

                <?php $classOculto = ($recompensa->getQuantidadeMaximaApoiadores() > 0) ? '' : 'oculto'; ?>
                <div class="form-group div-limite-recompensa <?php echo $classOculto; ?>">
                    <label class="control-label col-sm-2" for="quantidadeMaximaApoiadores">Quantidade disponível</label>
                    <div class="col-sm-9">
                        <input type="text" name="recompensas[<?php echo $key; ?>][quantidadeMaximaApoiadores]"
                               class="form-control" value="<?php echo $recompensa->getQuantidadeMaximaApoiadores(); ?>"/>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

        </div>
        <br />
        <br />
        <div class="row">
                <a class="btn btn-success col-sm-4 col-sm-offset-4" id="btn-adicionar-recompensa" href="javascript:;">
                    <i class="fa-plus-circle fa"> </i> Adicionar recompensa
                </a>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-2">
                <a href="<?php echo $view['router']->generate('submissao_descricao', array('submissaoId' => $submissao->getId())); ?>"
                   class="btn">Voltar</a>
                <input type="submit" class="btn" value="Avançar"/>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

<?php foreach($view['assetic']->javascripts(array('@EmVistaBundle/Resources/public/js/emvista/submissao/recompensas.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>
