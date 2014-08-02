<?php
use EmVista\EmVistaBundle\Entity\TipoDestaque;
$view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body'); ?>
    <fieldset>
        <legend>Principal <small>Clique no projeto para alterar</small></legend>
        <div class="control-group">
            <?php if(isset($projetosDestaque[TipoDestaque::HOME_PRIMARIO])): ?>
            <?php echo $view->render('EmVistaBundle:Projeto:thumbProjeto.html.php',
                                     array(
                                         'projeto' => $projetosDestaque[TipoDestaque::HOME_PRIMARIO],
                                         'link' =>$view['router']->generate(
                                             '_admin_projetos_principais_listar',
                                             array(
                                                 'projetoId' => $projetosDestaque[TipoDestaque::HOME_PRIMARIO]->getId(),
                                                 'tipoDestaque' => TipoDestaque::HOME_PRIMARIO)))); ?>
            <?php else: ?>
            <a href="<?php echo $view['router']->generate('_admin_projetos_principais_listar',
                                                          array('projetoId' => 0,
                                                                'tipoDestaque' => TipoDestaque::HOME_PRIMARIO)) ?>">
                Adicione projeto principal
            </a>
            <?php endif; ?>
        </div>
    </fieldset>
    <fieldset>
        <legend>Secundário <small>Clique no projeto para alterar</small></legend>
        <div class="control-group">
            <?php $i = 0; ?>
            <?php if(isset($projetosDestaque[TipoDestaque::HOME_SECUNDARIO])): ?>
                <?php foreach($projetosDestaque[TipoDestaque::HOME_SECUNDARIO] as $projetoSecundario): ?>
                    <?php $i++; ?>
                    <?php echo $view->render('EmVistaBundle:Projeto:thumbProjeto.html.php',
                                             array(
                                                 'projeto' => $projetoSecundario,
                                                 'link' => $view['router']->generate('_admin_projetos_principais_listar',
                                                                                    array('projetoId' => $projetoSecundario->getId(),
                                                                                          'tipoDestaque' => TipoDestaque::HOME_SECUNDARIO)))); ?>

                <?php endforeach; ?>
            <?php endif; ?>
            <?php for($i; $i < 2; $i++): ?>
                <a href="<?php echo $view['router']->generate('_admin_projetos_principais_listar',
                                                              array('projetoId' => 0,
                                                                    'tipoDestaque' => TipoDestaque::HOME_SECUNDARIO)) ?>">
                    Adicione projetos secundarios
                 </a>
            <?php endfor; ?>
        </div>
    </fieldset>
<?php $view['slots']->stop() ?>
