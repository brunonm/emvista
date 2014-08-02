<?php use EmVista\EmVistaBundle\Util\Date ?>

<?php if($view['security']->isGranted('IS_AUTHENTICATED_FULLY') && $usuario->getId() == $projeto->getUsuario()->getId()): ?>
<?php echo $view->render('EmVistaBundle:Projeto:formAtualizacao.html.php', array('projeto' => $projeto)); ?>
<?php endif; ?>
<div class="blog">
<?php if(!empty($atualizacoes)): ?>
    <?php foreach($atualizacoes as $atualizacao): ?>
    <div class="post row">
        <div class="span8">
            <span><?php echo Date::formatdmY($atualizacao->getDataCadastro()) ?></span>
            <p><strong><?php echo $atualizacao->getTitulo(); ?></strong></p>
            <div><?php echo nl2br($atualizacao->getTexto()); ?></div>
        </div>
    </div>
<?php endforeach; ?>


<?php else: ?>
    <div class="post row">
        <div class="span8">
            Nenhuma atualização foi inserida ainda.
        </div>
    </div>
<?php endif; ?>
</div>