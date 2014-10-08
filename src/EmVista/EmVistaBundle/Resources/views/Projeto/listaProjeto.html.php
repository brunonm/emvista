<?php $view->extend('EmVistaBundle::base.html.php'); ?>

<?php $view['slots']->start('body') ?>

<div class="container">
    <div class="row">
        <div class="span9" >
            <div class="row">
                <div class="project-listing">
                    <div class="span9">&nbsp;</div>
                    <?php foreach($projetos as $i => $projeto): ?>
                    <div class="span3">
                        <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php', array('projeto' => $projeto)); ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="span3">
            <ul class="rightBarDiscovery nav">
                <ol><i class="icon icon-th-large"></i> Categorias</ol>
                <?php foreach($categorias as $indice => $categoria): ?>
                <li>
                    <a class="label-category" href="<?php echo $view['router']->generate('projeto_descubra-search', array('search' => $categoria->getSlug())); ?>"><?php echo $categoria->getNome(); ?>
                        <i class="icon-remove-sign icon-white pull-right active-sign"></i>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?php $view['slots']->stop(); ?>
