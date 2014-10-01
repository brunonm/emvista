 <?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<div class="container">
    <div class="row">
        <div class="col-sm-9" >
            <div class="row">

                <?php
                foreach($projetos as $i => $projeto):
                ?>
                    <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php',
                                array('projeto' => $projeto, 'smSize' => '6', 'lgSize' => '4')
                            );
                    ?>
                <?php
                endforeach;
                ?>
            </div>
        </div>
        <div class="col-sm-3">
            <ul class="rightBarDiscovery nav">
                <ol><i class="icon icon-th-large"></i> Categorias</ol>
                <?php
                foreach($categorias as $indice => $categoria):
                    ?>
                    <li  categoria="category:<?php echo $categoria->getSlug()?>">
                        <a class="label-category" href="<?php echo $view['router']->generate('projeto_descubra-search',array('search' => 'category:'.$categoria->getSlug())) ?>" data-toggle="tab"><?php echo $categoria->getNome()?>
                            <i class="icon-remove-sign icon-white pull-right active-sign"></i>
                        </a>
                    </li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
    </div>
</div>
<input type="hidden" id="normalPath" value="<?php echo $view['router']->generate('projeto_descubra')?>" />
<?php $view['slots']->stop();
 $view['slots']->start('js') ;
    foreach($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/emvista/projeto/listaProjeto.js',)) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach;
$view['slots']->stop(); ?>
