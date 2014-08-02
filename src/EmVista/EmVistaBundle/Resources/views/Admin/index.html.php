<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="row">
    <div class="span2">
        <ul class="nav nav-pills nav-stacked">
            <li>
                <a href="<?php echo $view['router']->generate('admin_categorias') ?>">Categorias</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_registroTermoUso') ?>">Termos de uso</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_gerenciarAdministradores') ?>">Gerenciar administradores</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_listaAprovacaoSubmissao') ?>">Aprovação de submissões</a>
            </li>
            <li>
                <a href="<?php echo $view['router']->generate('admin_publicacaoProjetos') ?>">Publicação de projetos</a>
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
    <div class="span10">
        <?php $view['slots']->output('admin-body', 'Selecione uma opção ao lado.'); ?>
    </div>
</div>


<?php $view['slots']->stop(); ?>