<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<p><strong>Administradores</strong></p>
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
        <?php foreach($administradores as $administrador): ?>
            <tr>
                <td><?php echo $administrador->getNome(); ?></td>
                <td><?php echo $administrador->getEmail(); ?></td>
                <td>
                    <a href="<?php echo $view['router']->generate('admin_remover-administrador', array('usuarioId' => $administrador->getId())); ?>">Remover acesso</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a class="btn" href="<?php echo $view['router']->generate('admin_vincular-usuario-administrador') ?>">Usuários</a>

<?php $view['slots']->stop(); ?>
