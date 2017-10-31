<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php $view['slots']->output('title', 'cultura crowdfunding'); ?></title>
        <link rel="shortcut icon" href="<?php $view['slots']->output('title', 'favicon.ico'); ?>" />
    </head>

    <body>
        <h1>Aguarde, processando estornos...</h1>
        <div id="container">
            <form id="form-estorno" method="post"
                  action="<?php echo $view['router']->generate('_pagamento_estorno_estornar') ?>">
                <input type="hidden" value="<?php echo $projeto->getId(); ?>" name="projetoId"/>
            </form>
        </div>
        <?php foreach($view['assetic']->javascripts(array(
            '@EmVistaBundle/Resources/public/js/jquery-1.7.1.min.js',
            '@EmVistaBundle/Resources/public/js/emvista/main.js',
            '@EmVistaBundle/Resources/public/js/emvista/pagamento/popupEstorno.js')) as $url): ?>
            <script src="<?php echo $view->escape($url) ?>" type="text/javascript"></script>
        <?php endforeach; ?>
    </body>
</html>
