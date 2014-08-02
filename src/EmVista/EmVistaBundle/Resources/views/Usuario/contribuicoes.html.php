<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php $view->extend('EmVistaBundle:Usuario:base.html.php'); ?>
<?php $view['slots']->start('usuario-body') ?>

<legend>Contribuições</legend>

<?php if(count($doacoes) == 0): ?>

<p>Você ainda não apoiou nenhum projeto.</p>

<?php else: ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Projeto</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Recompensa</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($doacoes as $doacao): ?>
            <tr>
                <?php $projeto = $doacao->getRecompensa()->getProjeto(); ?>
                <td>
                    <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>">
                        <?php echo $projeto->getNome(); ?>
                    <a/>
                </td>
                <td><?php echo 'R$ ' . number_format($doacao->getValor(), 2, ',', '.'); ?></td>
                <td><?php echo $doacao->getStatus()->getDescricao(); ?></td>
                <td><?php echo $doacao->getRecompensa()->getTitulo(); ?></td>
                <td><?php echo Date::formatdmY($doacao->getDataCadastro()); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php $view['slots']->stop(); ?>