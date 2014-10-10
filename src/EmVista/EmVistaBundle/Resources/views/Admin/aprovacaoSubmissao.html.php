<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<p><strong>Aprovação de submissão</strong></p>

<?php $projeto = $submissao->getProjeto(); ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('admin_salvar-aprovacao-submissao'); ?>">

    <input type="hidden" name="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <p><strong>Projeto</strong></p>

    <div class="control-group">
        <label class="control-label">Título do projeto</label>
        <div class="controls">
            <input type="text" class="input-xlarge" readonly
                   value="<?php echo $projeto->getNome(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Data de envio</label>
        <div class="controls">
            <input type="text" class="input-large" readonly
                   value="<?php echo $submissao->getDataEnvio()->format('d/m/Y H:i:s'); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Categoria</label>
        <div class="controls">
            <input type="text" class="input-large" readonly
                   value="<?php echo $projeto->getCategoria()->getNome(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Valor</label>
        <div class="controls">
            <input type="text" class="input-large" readonly
                   value="R$ <?php echo number_format($submissao->getProjeto()->getValor(), 2, ',', '.'); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Video</label>
        <div class="controls">
            <input type="text" class="input-xlarge" readonly
                   value="<?php echo $projeto->getVideo()->getWatchUrl(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Quantidade de dias</label>
        <div class="controls">
            <input type="text" class="input-large" readonly
                   value="<?php echo $projeto->getQuantidadeDias(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Descrição Curta</label>
        <div class="controls">
            <textarea class="col-sm-6" readonly><?php echo $projeto->getDescricaoCurta(); ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Descrição</label>
        <div class="controls">
            <textarea class="col-sm-6" readonly rows="6"><?php echo $projeto->getDescricao(); ?></textarea>
        </div>
    </div>

    <hr/>

    <p><strong>Recompensas</strong></p>

    <?php foreach($projeto->getRecompensas() as $recompensa): ?>
        <div class="control-group">
            <label class="control-label">Título</label>
            <div class="controls">
                <input type="text" class="input-xlarge" readonly
                    value="<?php echo $recompensa->getTitulo(); ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Valor mínimo</label>
            <div class="controls">
                <input type="text" class="input-large" readonly
                    value="R$ <?php echo number_format($recompensa->getValorMinimo(), 2, ',', '.'); ?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Limite de apoiadores</label>
            <div class="controls">
                <input type="text" class="input-large" readonly
                    value="<?php echo ((int) $recompensa->getQuantidadeMaximaApoiadores() ?: 'Sem limite' )?>"/>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Descrição</label>
            <div class="controls">
                <textarea class="col-sm-6" readonly><?php echo $recompensa->getDescricao(); ?></textarea>
            </div>
        </div>

        <hr/>
    <?php endforeach; ?>

    <p><strong>Dados pessoais</strong></p>

    <div class="control-group">
        <label class="control-label">Nome</label>
        <div class="controls">
            <input type="text" class="input-xlarge" readonly
                value="<?php echo $pessoa->getNome(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Email</label>
        <div class="controls">
            <input type="text" class="input-xlarge" readonly
                value="<?php echo $pessoa->getUsuario()->getEmail(); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tipo</label>
        <div class="controls">
            <input type="text" class="input-xlarge" readonly
                value="<?php echo ($pessoa->getTipo() == 'f' ? 'Física' : 'Jurídica'); ?>"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Documento</label>
        <div class="controls">
            <input type="text" class="input-xlarge" readonly
                value="<?php echo $pessoa->getDocumento(); ?>"/>
        </div>
    </div>
    <hr/>

    <p><strong>Imagem original</strong></p>
    <div class="col-sm-9">
        <img src="<?php echo $projeto->getImagemOriginal()->getWebPath(); ?>"/>
    </div>
    <hr/>

    <p><strong>Imagem thumb</strong></p>
    <div class="col-sm-9">
        <img src="<?php echo $projeto->getImagemThumb()->getWebPath(); ?>"/>
    </div>
    <hr/>

    <p><strong>Imagem destaque</strong></p>
    <div class="col-sm-9">
        <img src="<?php echo $projeto->getImagemDestaque()->getWebPath(); ?>"/>
    </div>
    <hr/>

    <p><strong>Imagem destaque secundário</strong></p>
    <div class="col-sm-9">
        <img src="<?php echo $projeto->getImagemDestaqueSecundario()->getWebPath(); ?>"/>
    </div>
    <hr/>

    <p><strong>Avaliação</strong></p>

    <div class="control-group">
        <label class="control-label">Resultado</label>
        <div class="controls">
            <select name="statusSubmissaoId">
                <option value="<?php echo EmVista\EmVistaBundle\Entity\StatusSubmissao::STATUS_APROVADO?>">Aprovado</option>
                <option value="<?php echo EmVista\EmVistaBundle\Entity\StatusSubmissao::STATUS_REJEITADO?>">Rejeitado</option>
            </select>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Observação</label>
        <div class="controls">
            <textarea name="observacaoResposta" class="col-sm-6" placeholder="Se for aprovado, não inserir observação"></textarea>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-large btn-success">Salvar</button>
        </div>
    </div>

</form>

<?php $view['slots']->stop(); ?>
