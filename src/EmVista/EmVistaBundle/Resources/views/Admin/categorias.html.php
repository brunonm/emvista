<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<form class="form-horizontal" method="post" action="<?php echo $view['router']->generate('admin_salvarCategoria'); ?>">
    <div class="control-group">
        <label class="control-label">Nova categoria</label>
        <div class="controls">
            <input type="text" name="categoria[nome]"/>
            <input class="btn btn-success" type="submit" value="Inserir"/>
        </div>
    </div>
</form>

<?php if(count($categorias) > 0): ?>

    <form class="form-horizontal" method="post" action="<?php echo $view['router']->generate('admin_salvarCategoria'); ?>">

        <div class="control-group">
            <label class="control-label">Categorias</label>
            <div class="controls">
                <?php foreach($categorias as $categoria): ?>
                    <label class="radio">
                        <input type="radio" name="categoria[id]" value="<?php echo $categoria->getId(); ?>">
                        <?php echo $categoria->getNome().' - '.$categoria->getSlug(); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Novo nome</label>
            <div class="controls">
                <input type="text" name="categoria[nome]"/>
                <input class="btn btn-success" type="submit" value="Alterar"/>
            </div>
        </div>

    </form>

<?php endif; ?>

<?php $view['slots']->stop(); ?>