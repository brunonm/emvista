<?php use EmVista\EmVistaBundle\Entity\TipoDestaque; ?>
<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body'); ?>

    <fieldset>
        <legend>Projetos</legend>
        <div class="control-group">
            <?php foreach($projetos as $projetoFilho): ?>
            <?php echo $view->render('EmVistaBundle:Projeto:thumbProjeto.html.php', //_admin_projetos_principais_alterar
                                     array(
                                     'projeto' => $projetoFilho,
                                     'link' => $view['router']->generate(
                                         '_admin_projetos_principais_alterar',
                                         array(
                                             'projetoAntigoId' => $projeto ? $projeto->getId() : 0,
                                             'tipoDestaque' => $tipoDestaque,
                                             'projetoId' => $projetoFilho->getId())))); ?>
            <?php endforeach; ?>
        </div>
    </fieldset>

<?php $view['slots']->stop() ?>
