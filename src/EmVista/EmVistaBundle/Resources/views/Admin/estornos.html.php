<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<legend>Estornos</legend>

<?php if(count($projetos) > 0): ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Projeto</th>
            <th>Valor arrecadado</th>
            <th>Data finalização</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projetos as $projeto): ?>
            <tr>
                <td><?php echo $projeto->getNome(); ?></td>
                <td>R$ <?php echo $projeto->getValorArrecadadoFormatado(); ?></td>
                <td><?php echo $projeto->getDataFim()->format('d/m/Y'); ?></td>
                <td>
                    <a href="<?php echo $view['router']->generate('admin_estornos-projeto', array('projetoId' => $projeto->getId())); ?>">Visualizar contribuições</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Não existem projetos finalizados sem sucesso ainda não estornados.</p>
<?php endif; ?>

<?php $view['slots']->stop(); ?>
