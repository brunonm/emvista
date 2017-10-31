<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<?php $params = array('submissaoId' => $submissao->getId()); ?>

<?php $projeto = $submissao->getProjeto(); ?>

<div class="row submissao">
    <div class="col-sm-2">
        <ul class="nav nav-pills nav-stacked">
            <?php if (!$projeto->isArrecadando()): ?>
            <li class="<?php echo ($step == 1 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_dados-basicos', $params) ?>">Dados básicos</a>
            </li>
            <?php endif; ?>
            <li class="<?php echo ($step == 2 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_descricao', $params) ?>">Descrição</a>
            </li>
            <li class="<?php echo ($step == 3 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_recompensas', $params) ?>">Recompensas</a>
            </li>
            <?php if (!$projeto->isArrecadando()): ?>
            <li class="<?php echo ($step == 4 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_video', $params) ?>">Video</a>
            </li>
            <li class="<?php echo ($step == 5 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_imagens', $params) ?>">Imagens</a>
            </li>
            <li class="<?php echo ($step == 6 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_mais-sobre-voce', $params) ?>">Mais sobre você</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="col-sm-10">
        <?php $view['slots']->output('submissao-body', 'Selecione uma opção ao lado.'); ?>
    </div>
</div>


<?php $view['slots']->stop(); ?>
