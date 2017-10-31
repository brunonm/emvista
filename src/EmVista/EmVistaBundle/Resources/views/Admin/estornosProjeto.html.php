<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<legend>Contribuições - <?php echo $projeto->getNome(); ?></legend>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Valor</th>
            <th>Apoiador</th>
            <th>Email</th>
            <th>Recompensa</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($doacoes as $doacao): ?>
            <tr>
                <td>R$ <?php echo $doacao->getValorFormatado(); ?></td>
                <td><?php echo $doacao->getUsuario()->getNome(); ?></td>
                <td><?php echo $doacao->getUsuario()->getEmail(); ?></td>
                <td><?php echo $doacao->getRecompensa()->getTitulo(); ?></td>
                <td><?php echo $doacao->getDataCadastro()->format('d/m/Y H:i:s'); ?></td>
                <td>
                    <a href="<?php echo $view['router']->generate('admin_estornar-doacao', array('doacaoId' => $doacao->getId())); ?>">Marcar como estornado</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $view['slots']->stop(); ?>
