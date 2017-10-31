<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>


<section id="intro" class="section" style="position: relative; z-index: 0; background: none;">

    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="hello wow bounceInDown animated" style="visibility: visible; -webkit-animation: bounceInDown;">
                    <h1>A capital de projetos criativos</h1>
                </div>

                <span href="javascript:;" data-toggle="modal" data-target="#myVideo" style="cursor: pointer">
                    <img src="<?php echo $view['assets']->getUrl('bundles/emvista/images/play.png') ?>">
                </span>
                <div class="saibaMais">
                    <span class="text">SAIBA MAIS SOBRE CROWDFUNDING</span>
                </div>
            </div>
            <div class="col-md-offset-3 col-md-6">
                <div class="row">
                    <a class="btn btn-special col-md-6 col-md-offset-3 my-btn" href="<?php echo $view['router']->generate('home_cadastre'); ?>">
                        ENVIE SEU PROJETO
                    </a>
                </div>
            </div>
            <a class="angle-down-content col-md-12" href="#projects">
                <div class="row">
                    <div class="col-md-12 angle-down">
                        <span class="text-conheca-projetos fa fa-angle-down"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-conheca-projetos">CONHEÇA OS PROJETOS</span>
                    </div>
                </div>
            </a>
        </div><!-- .row -->
    </div><!-- .container -->
</section>

<section id="projects" class="section">
    <div class="container">
        <?php if(!empty($projetos)): ?>
            <div class="row">
                <?php foreach($projetos as $projeto): ?>
                    <?php echo $view->render('EmVistaBundle:Home:thumbProjeto.html.php', array('projeto' => $projeto)); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<div id="postsWrapper">
    <div id="loadMoreAjaxLoader" style="display:none;text-align: center">Aguarde...</div>
</div>
<?php $view['slots']->start('modal') ?>
<div class="modal fade" id="myVideo">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: transparent">
            <iframe width="600" height="338" src="//www.youtube.com/embed/D1MStXYieBc?rel=0&amp;&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $view['slots']->stop(); ?>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

<?php foreach($view['assetic']->javascripts(
    array('@EmVistaBundle/Resources/public/js/emvista/home/index.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>
