<?php use EmVista\EmVistaBundle\Entity\StatusDoacao; ?>
<?php $view->extend('EmVistaBundle:Usuario:baseAcompanharProjeto.html.php'); ?>
<?php $view['slots']->start('tab-body') ?>

<?php if(count($apoiadores) == 0): ?>
    <div class="row">
        <div class="col-sm-12">
            <p>Nenhum apoiador para este projeto.</p>
        </div>
    </div>
<?php endif; ?>

<?php foreach($apoiadores as $apoiador): ?>
    <div class="row">
        <div class="col-sm-2">
            <img src="<?php echo $apoiador->getImageProfileWebPath(); ?>"/>
        </div>
        <div class="col-sm-3">
            <h4><?php echo $apoiador->getNome(); ?></h4>
            <p><?php echo $apoiador->getEmail(); ?></p>
            <p>
                <?php if($apoiador->getEndereco()): ?>
                    <?php $endereco = $apoiador->getEndereco(); ?>
                    <address>
                        <strong><?php echo $endereco->getCidade() . ' - ' . $endereco->getUf(); ?></strong><br>
                        <?php echo $endereco->getEndereco(); ?><br>
                        <?php echo $endereco->getBairro(); ?><br>
                        <?php echo 'CEP ' . $endereco->getCep(); ?><br>
                    </address>
                <?php endif; ?>
            </p>
        </div>
        <div class="col-sm-7">
            <table class="table table-ondensed">
                <thead>
                    <tr>
                        <th class="col-sm-4">Recompensa escolhida</th>
                        <th class="col-sm-1">Data</th>
                        <th class="col-sm-2">Valor pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($apoiador->getDoacoes() as $doacao):
                        if($doacao->getStatus()->getId() == StatusDoacao::APROVADO):
                            if($doacao->getRecompensa()->getProjeto()->getId() == $projeto->getId()):
                        ?>
                            <tr>
                                <td><?php echo $doacao->getRecompensa()->getDescricao(); ?></td>
                                <td><?php echo $doacao->getDataCadastro()->format('d/m/Y'); ?></td>
                                <td>R$ <?php echo $doacao->getValorFormatado(); ?></td>
                            </tr>
                            <?php endif;?>
                        <?php endif;?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>
