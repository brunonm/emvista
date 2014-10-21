<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>
<style>.embed-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        max-width: 100%;
        height: auto;
        margin-top: 5px
    }

    .embed-container iframe, .embed-container object, .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }</style>
<div >

<div class="container">
    <div class="row">
        <h3 class="col-sm-12">Crowdfunding Festival</h3>
        <div class="col-sm-12">
            O Crowdfunding Festival é um evento de abrangência nacional no qual expõe projetos realizados através do
            Financiamento Coletivo, como também a apresentação de um mecanismo simples para a captação de recursos e
            integrado às possibilidades das tecnologias da comunicação e informática – principalmente as redes sociais.
            Alem disso o Crowdfunding Festival se propõe a propiciar palestras com as principais plataformas de
            crowdfunding brasileira, que alem de mostrar o funcionamento de seus sites também apresentarão suas técnicas
            e metodologias de trabalho para que os participantes do evento aprendam e alcancem os objetivos de captação
            financeira em micro-investimentos específicos do crowdfunding. <br/><br/>
        </div>
    </div>
    <?php
    foreach ($videos as $video) :
        ?>
        <div class="col-sm-4">
            <div class='embed-container'>
            <?php
            /**
             * @var \EmVista\EmVistaBundle\Entity\SiteVideo $siteVideo
             */
            echo str_replace('{IDENTIFICADOR}', $video['unique'], $siteVideo->getEmbed())
            ?>
            </div>
        </div>
        <?php
    endforeach;
    ?>
</div>

<?php $view['slots']->stop(); ?>
