<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<legend>Usuários</legend>
<p>As alterações terão efeito no próximo login.</p>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario->getNome(); ?></td>
                <td><?php echo $usuario->getEmail(); ?></td>
                <td>
                    <?php if($usuario->isAdmin()): ?>
                        <a href="<?php echo $view['router']->generate('admin_remover-administrador', array('usuarioId' => $usuario->getId())); ?>">Remover acesso</a>
                    <?php else: ?>
                        <a href="<?php echo $view['router']->generate('admin_adicionar-administrador', array('usuarioId' => $usuario->getId())); ?>">Adicionar acesso</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a class="btn" href="<?php echo $view['router']->generate('admin_gerenciar-administradores') ?>">Administradores</a>

<?php $view['slots']->stop(); ?>
