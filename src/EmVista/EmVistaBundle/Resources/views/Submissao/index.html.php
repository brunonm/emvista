<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<?php $params = array('submissaoId' => $submissao->getId()); ?>

<div class="row submissao">
    <div class="span2">
        <ul class="nav nav-pills nav-stacked">
            <li class="<?php echo ($step == 1 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_dados-basicos', $params) ?>">Dados básicos</a>
            </li>
            <li class="<?php echo ($step == 2 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_descricao', $params) ?>">Descrição</a>
            </li>
            <li class="<?php echo ($step == 3 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_recompensas', $params) ?>">Recompensas</a>
            </li>
            <li class="<?php echo ($step == 4 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_video', $params) ?>">Video</a>
            </li>
            <li class="<?php echo ($step == 5 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_imagens', $params) ?>">Imagens</a>
            </li>
            <li class="<?php echo ($step == 6 ? 'active' : ''); ?>">
                <a href="<?php echo $view['router']->generate('submissao_mais-sobre-voce', $params) ?>">Mais sobre você</a>
            </li>
        </ul>
    </div>
    <div class="span10">
        <?php $view['slots']->output('submissao-body', 'Selecione uma opção ao lado.'); ?>
    </div>
</div>


<?php $view['slots']->stop(); ?>