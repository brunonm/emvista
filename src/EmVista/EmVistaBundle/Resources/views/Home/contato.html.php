<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="container">
    <div class="row">
        <h1>Fale conosco</h1>
        <form method="post" action="<?php echo $view['router']->generate('home_contato_enviar-email'); ?>">
            <div class="form-group col-sm-7">
                <label>Nome</label>
                <input name="nome" type="text" required class="form-control" placeholder="Nome">
            </div>
            <div class="form-group col-sm-7">
                <label>Email</label>
                <input name="email" type="email" required class="form-control" placeholder="seu@email.com">
            </div>
            <div class="form-group col-sm-7">
                <label>Assunto</label>
                <input name="assunto" type="text" required class="form-control" placeholder="Assunto">
            </div>
            <div class="form-group col-sm-7">
                <label>Mensagem</label>
                <textarea class="form-control" required name="mensagem"></textarea>
            </div>
            <div class="form-group col-sm-7">
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </form>
    </div>
</div>
<?php $view['slots']->stop(); ?>
