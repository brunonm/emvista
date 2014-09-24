<!DOCTYPE html>
<html>
    <head>
        <?php $description = 'Conheça o EmVista, a plataforma de Crowdfunding no Brasil. Com o financiamento colaborativo, é possível solucionar o velho problema de investimento em boas ideias e talentos. Isto é o EmVista, a evolução da vaquinha através do Crowdfunding.'; ?>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php echo $description?>" />
        <meta property="og:description" content="<?php $view['slots']->output('description', $description); ?>" />
        <meta property="og:title" content="<?php $view['slots']->output('title', 'EmVista | Crowdfunding no Brasil'); ?>" />
        <meta property="og:image" content="<?php $view['slots']->output('image', $app->getRequest()->getUriForPath("/bundles/emvista/images/emvista-logo.png")); ?>" />
        <meta property="og:url" content="<?php echo $app->getRequest()->getUri() ?>">
        <meta property="og:site_name" content="EmVista">
        <meta name="keywords" content="EmVista, Crowdfunding, Vaquinha, Crowdfunding no Brasil, Financiamento Coletivo, Financiamento Colaborativo"/>
        <meta name="robots" content="index,follow,noodp,noydir" />
        <link rel="canonical" href="<?php echo $app->getRequest()->getUri() ?>" />
        <title><?php $view['slots']->output('title', 'EmVista | Crowdfunding no Brasil'); ?></title>

        <?php foreach($view['assetic']->stylesheets(array(
            '@EmVistaBundle/Resources/public/css/bootstrap/css/bootstrap.min.css',
            '@EmVistaBundle/Resources/public/css/reset.css',
            '@EmVistaBundle/Resources/public/css/main.css')) as $url): ?>

            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

        <?php $view['slots']->output('css'); ?>

        <link rel="shortcut icon" href="<?php $view['slots']->output('title', 'favicon.ico'); ?>" />
    </head>

    <body>
        <div id="fb-root"></div>

        <div class="topbar navbar" id="topbar">
            <?php echo $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('EmVistaBundle:Home:topbar')); ?>
        </div>

        <header id="masthead">
            <div class="inner">

                <div class="subnav subnav-fixed flash-message-container">
                    <?php $class = ''; ?>
                    <?php foreach($view['session']->getFlashes() as $type => $messages): ?>
                        <?php
                            switch($type){
                                case 'notice' : $class = 'alert-info';    break;
                                case 'warning': $class = '';              break;
                                case 'error'  : $class = 'alert-error';   break;
                                case 'success': $class = 'alert-success'; break;
                            }
                        ?>
                        <?php foreach($messages as $message): ?>
                                <div class="flash-message alert <?php echo $class; ?>">
                                <button class="close" data-dismiss="alert">×</button>
                                <?php echo $message; ?>
                                </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="span6">
                            <p class="emvista-logo"><a href="/">EmVista</a></p>
                        </div>
                        <div class="span6 " style="padding-top: 10px;padding-bottom: 10px;">
                            <div class="project-signup-menu-parent">
                                <ul class="project-signup-menu">
                                    <li class="menu-item first-item">
                                        <a href="<?php echo $view['router']->generate('projeto_descubra'); ?>">Descubra <span>projetos</span></a></li>

                                    <li class="menu-item last-item"><a href="<?php echo $view['router']->generate('home_cadastre'); ?>">Cadastre <span>seu projeto</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="quickSearchContent" style="display: none">
                        <div>
                            <a class="close" href="#">×</a>
                        </div>
                        <ul class="row unstyled" id="quickSearch">

                        </ul>
                    </div>
                    <?php $view['slots']->output('projectHeader'); ?>
                </div>
            </div>
        </header>
        <div class="container" id="content">
            <?php $view['slots']->output('body'); ?>
        </div>

        <footer id="footer" class="footer">
            <?php echo $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('EmVistaBundle:Home:footer')); ?>
        </footer>

        <div id="modal"><?php $view['slots']->output('modal'); ?></div>

        <?php foreach($view['assetic']->javascripts(array(
            '@EmVistaBundle/Resources/public/js/html5.js',
            '@EmVistaBundle/Resources/public/js/jquery-1.7.1.min.js',
            '@EmVistaBundle/Resources/public/js/typing/jquery.typing-0.2.0.min.js',
            '@EmVistaBundle/Resources/public/js/emvista/main.js',
            '@EmVistaBundle/Resources/public/css/bootstrap/js/bootstrap.min.js',
            'bundles/fosjsrouting/js/router.js',
            'js/fos_js_routes.js'
            )) as $url): ?>
            <script src="<?php echo $view->escape($url) ?>" type="text/javascript"></script>
        <?php endforeach; ?>

        <?php $view['slots']->output('js'); ?>
    </body>

</html>