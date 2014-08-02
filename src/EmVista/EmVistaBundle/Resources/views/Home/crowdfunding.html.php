<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="row">
    <div class="span12 helpTitle">
        <h1>
            Como funciona o Crowdfunding e o EmVista?
        </h1>
    </div>
</div>
<div class="row">
    <div class="span8">
        <p>
            O EmVista é uma plataforma de Crowdfunding ou, em português, Financiamento Coletivo.
            Tem o objetivo de aproximar pessoas com uma finalidade comum: transformar ideias criativas em
            projetos bem sucedidos.
        </p>
        <p>
            Nos dias de hoje, uma variedade de ideias não conseguem sair do papel pelas dificuldades em
            captar recursos. Por meio da plataforma, seu projeto terá visibilidade e as pessoas que acreditam
            nele terão a oportunidade de contribuir e divulgá-lo. Para cada contribuição o apoiador receberá
            uma recompensa do autor do projeto, proporcional ao valor, criando um vínculo de reciprocidade
            muito forte entre todos os envolvidos.
        </p>
        <p class="lead">
            <strong>Assista o vídeo abaixo e entenda como funciona.</strong>
        </p>
    </div>
    <div class="spanLogoField">
        <img src="/bundles/emvista/images/favicon_envista.png" />
    </div>
</div>
<div class="row">
    <div class="span10">
        <iframe width="940" height="529" src="http://www.youtube.com/embed/1gwfVefwmLM?rel=0" frameborder="0" allowfullscreen></iframe>
    </div>
</div>

<?php $view['slots']->stop(); ?>


<?php $view['slots']->start('css') ?>

        <?php foreach($view['assetic']->stylesheets(
                array('@EmVistaBundle/Resources/public/css/emvista/home/crowdfunding.css')) as $url): ?>
            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

<?php $view['slots']->stop(); ?>