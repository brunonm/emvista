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
            '@EmVistaBundle/Resources/public/vendor/css/bootstrap/bootstrap.min.css',
            '@EmVistaBundle/Resources/public/vendor/css/font-awesome/css/font-awesome.min.css',
            '@EmVistaBundle/Resources/public/css/cultura.css')) as $url): ?>

            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

        <?php $view['slots']->output('css'); ?>

        <link rel="shortcut icon" href="<?php $view['slots']->output('title', 'favicon.ico'); ?>" />
    </head>

    <body cz-shortcut-listen="true">
        <div class="wrapper">
            <div id="fb-root"></div>

            <?php echo $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('EmVistaBundle:Home:topbar')); ?>
            <?php if($fm = $view['session']->getFlashes()): ?>
                <header id="masthead">
                    <div class="inner">

                        <div class="subnav subnav-fixed flash-message-container">
                            <?php $class = ''; ?>
                            <?php foreach($fm as $type => $messages): ?>
                                <?php
                                    switch ($type) {
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
                </header>
            <?php
            endif;
            ?>
            <div id="content">
                <?php $view['slots']->output('body'); ?>
            </div>

            <footer id="footer" class="footer">
                <?php echo $view['actions']->render(new \Symfony\Component\HttpKernel\Controller\ControllerReference('EmVistaBundle:Home:footer')); ?>
            </footer>

            <div id="modal"><?php $view['slots']->output('modal'); ?></div>
        </div>
        <?php foreach($view['assetic']->javascripts(array(
            '@EmVistaBundle/Resources/public/js/html5.js',
            '@EmVistaBundle/Resources/public/vendor/js/jquery-1.11.0.min.js',
            '@EmVistaBundle/Resources/public/vendor/js/jquery.backstretch.min.js',
            '@EmVistaBundle/Resources/public/js/typing/jquery.typing-0.2.0.min.js',
            '@EmVistaBundle/Resources/public/vendor/css/bootstrap/bootstrap.min.js',
            'bundles/fosjsrouting/js/router.js',
            '@EmVistaBundle/Resources/public/js/emvista/cultura.js',
            'js/fos_js_routes.js',
            '@EmVistaBundle/Resources/public/vendor/js/jquery.maskMoney.min.js',
            )) as $url): ?>
            <script src="<?php echo $view->escape($url) ?>" type="text/javascript"></script>
        <?php endforeach; ?>

        <?php $view['slots']->output('js'); ?>
    </body>

</html>
