<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="container">
    <h1>Parabéns!</h1>
    <br/>
    <p>
        Estamos entusiasmados com a oportunidade de tirar sua ideia do papel e<br>
        esperamos que esse seja o start que ela precisa.<br>
        Nos próximos dias avaliaremos as informações que você nos enviou e<br>
        entraremos em contato.<br>
        Enquanto isso, <a href="<?php echo $view['router']->generate('projeto_descubra'); ?>">descubra novos projetos</a>.</p>
</div>

<?php $view['slots']->stop(); ?>
