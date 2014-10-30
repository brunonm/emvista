<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<legend>Aprovação de submissão</legend>

<?php $projeto = $submissao->getProjeto(); ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('admin_salvar-aprovacao-submissao'); ?>">

    <input type="hidden" name="submissaoId" value="<?php echo $submissao->getId(); ?>"/>
    
    <div class="form-group">
        <label class="control-label col-md-2">Título do projeto</label>
        <div class="col-md-9">
            <input type="text" class="form-control" readonly
                   value="<?php echo $projeto->getNome(); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Data de envio</label>
        <div class="col-md-2">
            <input type="text" class="form-control" readonly
                   value="<?php echo $submissao->getDataEnvio()->format('d/m/Y H:i:s'); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Categoria</label>
        <div class="col-md-3">
            <input type="text" class="form-control" readonly
                   value="<?php echo $projeto->getCategoria()->getNome(); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Valor</label>
        <div class="col-md-2">
            <input type="text" class="form-control" readonly
                   value="R$ <?php echo number_format($submissao->getProjeto()->getValor(), 2, ',', '.'); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Video</label>
        <div class="col-md-9">
            <input type="text" class="form-control" readonly
                   value="<?php echo $projeto->getVideo()->getWatchUrl(); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Quantidade de dias</label>
        <div class="col-md-1">
            <input type="text" class="form-control" readonly
                   value="<?php echo $projeto->getQuantidadeDias(); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Descrição Curta</label>
        <div class="col-md-9">
            <textarea class="col-sm-6 form-control" readonly><?php echo $projeto->getDescricaoCurta(); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Descrição</label>
        <div class="col-md-9">
            <textarea class="col-sm-6 form-control" readonly rows="6"><?php echo $projeto->getDescricao(); ?></textarea>
        </div>
    </div>

    <legend>Recompensas</legend>

    <?php foreach($projeto->getRecompensas() as $recompensa): ?>
        <div class="form-group">
            <label class="control-label col-md-2">Título</label>
            <div class="col-md-9">
                <input type="text" class="form-control" readonly
                    value="<?php echo $recompensa->getTitulo(); ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Valor mínimo</label>
            <div class="col-md-2">
                <input type="text" class="form-control" readonly
                    value="R$ <?php echo number_format($recompensa->getValorMinimo(), 2, ',', '.'); ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Limite de apoiadores</label>
            <div class="col-md-2">
                <input type="text" class="form-control" readonly
                    value="<?php echo ((int) $recompensa->getQuantidadeMaximaApoiadores() ?: 'Sem limite' )?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Descrição</label>
            <div class="col-md-9">
                <textarea class="col-sm-6 form-control" readonly><?php echo $recompensa->getDescricao(); ?></textarea>
            </div>
        </div>

    <?php endforeach; ?>

    <legend>Dados pessoais</legend>

    <div class="form-group">
        <label class="control-label col-md-2">Nome</label>
        <div class="col-md-9">
            <input type="text" class="form-control" readonly
                value="<?php echo $pessoa->getNome(); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Email</label>
        <div class="col-md-9">
            <input type="text" class="form-control" readonly
                value="<?php echo $pessoa->getUsuario()->getEmail(); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Tipo</label>
        <div class="col-md-3">
            <input type="text" class="form-control" readonly
                value="<?php echo ($pessoa->getTipo() == 'f' ? 'Física' : 'Jurídica'); ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Documento</label>
        <div class="col-md-2">
            <input type="text" class="form-control" readonly
                value="<?php echo $pessoa->getDocumento(); ?>"/>
        </div>
    </div>

    <legend>Imagem</legend>
    <div class="form-group col-sm-12">
        <img src="<?php echo $projeto->getImagemThumb()->getWebPath(); ?>"/>
    </div>

    <legend>Avaliação</legend>

    <div class="form-group">
        <label class="control-label col-md-2">Resultado</label>
        <div class="col-md-3">
            <select class="form-control" name="statusSubmissaoId">
                <option value="<?php echo EmVista\EmVistaBundle\Entity\StatusSubmissao::STATUS_APROVADO?>">Aprovado</option>
                <option value="<?php echo EmVista\EmVistaBundle\Entity\StatusSubmissao::STATUS_REJEITADO?>">Rejeitado</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2">Observação</label>
        <div class="col-md-3">
            <textarea name="observacaoResposta" class="col-sm-6 form-control" placeholder="Se for aprovado, não inserir observação"></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="controls col-md-2">
            <button type="submit" class="btn btn-large btn-success">Salvar</button>
        </div>
    </div>

</form>

<?php $view['slots']->stop(); ?>
