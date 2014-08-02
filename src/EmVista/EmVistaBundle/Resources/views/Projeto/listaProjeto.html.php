 <?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<div class="container">
    <div class="row">
        <div class="span9" >
            <form class="form-search" style="display: none" method="post">
                <div class="input-append" style="margin-bottom: 20px;">
                    <input type="text" id="inputSearch" placeholder="Pesquise ..." class="span8"/>
                    <button type="submit" class="btn">Pesquisar</button>
                </div>
                
            </form>
            <div class="row">
            
                <div class="project-listing">
                    <div class="span9">&nbsp;</div>
                <?php 
                foreach($projetos as $i => $projeto):
                ?>
                <div class="span3">
                    <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php',
                                array('projeto' => $projeto)
                            );
                    ?>
                </div>
                <?php
                endforeach;
                ?>
                </div>
            </div>
        </div>
        <div class="span3">    
            <ul class="rightBarDiscovery nav">
                <ol><i class="icon icon-th-large"></i> Categorias</ol>
                <?php
                foreach($categorias as $indice => $categoria):
                    ?>
                    <li  categoria="category:<?php echo $categoria->getSlug()?>">
                        <a class="label-category" href="<?php echo $view['router']->generate('projeto_descubraComSearch',array('search' => 'category:'.$categoria->getSlug())) ?>" data-toggle="tab"><?php echo $categoria->getNome()?>
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