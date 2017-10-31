<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<?php if(count($projetos) > 0): ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Projeto</th>
            <th>Valor arrecadado</th>
            <th>Data de início</th>
            <th>Data de finalização</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projetos as $projeto): ?>
            <tr>
                <td><?php echo $projeto->getNome(); ?></td>
                <td><?php echo 'R$ ' . number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?></td>
                <td><?php echo Date::formatdmY($projeto->getDataInicio()); ?></td>
                <td><?php echo Date::formatdmY($projeto->getDataFim()); ?></td>
                <td>
                    <a href="javascript:;" class="pagar" id="pagar-<?php echo $projeto->getId(); ?>">
                        Marcar como pago
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<p>Não existem projetos concluídos que ainda não foram pagos.</p>
<?php endif; ?>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

<?php foreach($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/emvista/pagamento/pagamentos.js')) as $url):
?>
<script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>
