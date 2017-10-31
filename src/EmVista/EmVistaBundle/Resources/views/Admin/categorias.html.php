<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<legend>Categorias</legend>

<div class="col-md-12">
    <form class="form-horizontal" method="post" action="<?php echo $view['router']->generate('admin_salvar-categoria'); ?>">
        <div class="form-group col-md-7">
            <label>Nova categoria</label>
            <input class="form-control" type="text" name="categoria[nome]"/>
        </div>
        <div class="form-group col-md-7">
            <input class="btn btn-success" type="submit" value="Inserir"/>
        </div>
    </form>
</div>

<div class="col-md-12">
<?php if(count($categorias) > 0): ?>

    <form class="form-horizontal" method="post" action="<?php echo $view['router']->generate('admin_salvar-categoria'); ?>">
        
        <?php foreach($categorias as $categoria): ?>
        <div class="radio">
            <label>
                <input type="radio" name="categoria[id]" value="<?php echo $categoria->getId(); ?>">
                <?php echo $categoria->getNome(); ?>
            </label>
        </div>
        <?php endforeach; ?>
 
        <br>
        
        <div class="form-group col-md-7">
            <label>Novo nome</label>
            <input class="form-control" type="text" name="categoria[nome]"/>
        </div>        
        
        <div class="form-group col-md-7">
            <input class="btn btn-success" type="submit" value="Alterar"/>
        </div>
        
    </form>

<?php endif; ?>
</div>

<?php $view['slots']->stop(); ?>
