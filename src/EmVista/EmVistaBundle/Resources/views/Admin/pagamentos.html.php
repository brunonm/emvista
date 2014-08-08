<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<legend>Repasse de Pagamentos</legend>

<?php if(count($repasse) > 0): ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Projeto</th>
            <th>Data fim</th>
            <th>Contribuições</th>
            <th>Arrecadado</th>
            <th>Líquido</th>
            <th>Taxas</th>
            <th>Repasse</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($repasse as $item): ?>
            <tr>
                <td><?php echo $item['projeto']->getNome(); ?></td>
                <td><?php echo $item['projeto']->getDataFim()->format('d/m/Y'); ?></td>
                <td><?php echo $item['contribuicoes']; ?></td>
                <td>R$ <?php echo $item['projeto']->getValorArrecadadoFormatado(); ?></td>
                <td>R$ <?php echo number_format($item['valorLiquido'], 2, ',', '.'); ?></td>
                <td>R$ <?php echo number_format($item['taxas'], 2, ',', '.'); ?></td>
                <td><strong>R$ <?php echo number_format($item['valorRepasse'], 2, ',', '.'); ?></strong></td>
                <td>
                    <a href="<?php echo $view['router']->generate('admin_informar-pagamento',
                                                                  array('projetoId' => $item['projeto']->getId())); ?>">Finalizar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Não existem projetos finalizados sem sucesso ainda não estornados.</p>
<?php endif; ?>

<?php $view['slots']->stop(); ?>