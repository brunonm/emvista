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

                <div class="control-group">
                    <label class="control-label" for="titulo">Título</label>
                    <div class="controls">
                        <input type="text" name="recompensas[<?php echo $key; ?>][titulo]" maxlength="100"
                               class="input-xlarge" value="<?php echo $recompensa->getTitulo(); ?>">

                        <?php if($key > 0): ?>
                        <a href="javascript:;" class="btn btn-danger btn-excluir-recompensa"><i class="icon-trash icon-white"></i> Excluir recompensa</a>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="valorMinimo">Valor</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">R$</span>
                            <input name="recompensas[<?php echo $key; ?>][valorMinimo]" type="text"
                                   class="input-small" value="<?php echo $recompensa->getValorMinimo(); ?>"/>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="descricao">Descrição</label>
                    <div class="controls">
                        <input type="text" name="recompensas[<?php echo $key; ?>][descricao]" 
                               class="input-xxlarge" value="<?php echo $recompensa->getDescricao(); ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
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
                <div class="control-group div-limite-recompensa <?php echo $classOculto; ?>">
                    <label class="control-label" for="quantidadeMaximaApoiadores">Quantidade disponível</label>
                    <div class="controls">
                        <input type="text" name="recompensas[<?php echo $key; ?>][quantidadeMaximaApoiadores]"
                               class="input-small" value="<?php echo $recompensa->getQuantidadeMaximaApoiadores(); ?>"/>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>

        </div>
        <div class="control-group">
            <div class="controls">
                <a class="btn btn-success" id="btn-adicionar-recompensa" href="javascript:;">
                    <i class="icon-plus-sign icon-white"> </i> Adicionar recompensa</a>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
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