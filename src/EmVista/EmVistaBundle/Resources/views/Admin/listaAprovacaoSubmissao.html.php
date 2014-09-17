<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<p><strong>Submissões aguardando aprovação</strong></p>

<?php if(count($submissoes) > 0): ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Data de envio</th>
            <th>Título do projeto</th>
            <th>Valor</th>
            <th>Usuário</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($submissoes as $submissao): ?>
            <tr>
                <td><?php echo $submissao->getDataEnvio()->format('d/m/Y'); ?></td>
                <td>
                    <a href="<?php echo $view['router']->generate('admin_aprovacaoSubmissao', array('submissaoId' => $submissao->getId())); ?>"><?php echo $submissao->getProjeto()->getNome(); ?></a>
                </td>
                <td>R$ <?php echo number_format($submissao->getProjeto()->getValor(), 2, ',', '.'); ?></td>
                <td><?php echo $submissao->getProjeto()->getUsuario()->getNome(); ?></td>
                <td><?php echo $submissao->getProjeto()->getUsuario()->getEmail(); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php else: ?>

<p>Nenhuma submissão aguardando aprovação foi encontrada.</p>

<?php endif; ?>

<?php $view['slots']->stop(); ?>
