<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="row">
    <div class="col-sm-2">
        <ul class="nav nav-pills nav-stacked">
            <li>
                <a href="<?php echo $view['router']->generate('admin_categorias') ?>">Categorias</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_registro-termo-uso') ?>">Termos de uso</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_gerenciar-administradores') ?>">Gerenciar administradores</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_lista-aprovacao-submissao') ?>">Aprovação de submissões</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_estornos') ?>">Estornos</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_pagamentos') ?>">Repasse de pagamentos</a>
            </li>
<!--            <li>
                <a href="<?php //echo $view['router']->generate('_admin_projetos_principais') ?>">Administrar projetos em destaque</a>
            </li>-->
        </ul>
    </div>
    <div class="col-sm-10">
        <?php $view['slots']->output('admin-body', 'Selecione uma opção ao lado.'); ?>
    </div>
</div>


<?php $view['slots']->stop(); ?>
