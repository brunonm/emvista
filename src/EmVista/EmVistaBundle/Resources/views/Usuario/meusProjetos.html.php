<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php use EmVista\EmVistaBundle\Entity\StatusArrecadacao; ?>
<?php use EmVista\EmVistaBundle\Entity\StatusSubmissao; ?>
<?php $view->extend('EmVistaBundle:Usuario:base.html.php'); ?>
<?php $view['slots']->start('usuario-body') ?>

<legend>Meus projetos</legend>

<?php if(count($submissoes) == 0): ?>

<p>Você ainda não enviou nenhum projeto.</p>

<?php else: ?>

<p>Você pode continuar a submissão de um projeto que não concluiu ou editar um projeto já publicado selecionando o seu título.</p>
<p>Para obter mais detalhes de quem apoiou o seu projeto, ou mesmo informações gerenciais sobre a arrecadação, clique no botão <i class="fa fa-wrench"></i> a direita dos projetos.</p>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Título</th>
            <th>Status</th>
            <th>Data de envio</th>
            <th>Publicado?</th>
            <th>Valor arrecadado</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($submissoes as $submissao) : ?>
            <?php $projeto = $submissao->getProjeto(); ?>
            <tr>
                <td>
                    <?php if (!$submissao->isRejeitada() && ($projeto->getStatusArrecadacao() == null || $projeto->isArrecadando())): ?>
                        <?php if ($projeto->isArrecadando()) : ?>

                        <a href="<?php echo $view['router']->generate('submissao_descricao', array('submissaoId' => $submissao->getId())); ?>">
                            <?php $nome = $projeto->getNome(); ?>
                            <?php echo empty($nome) ? 'Aguardando preenchimento' : $nome; ?>
                        <a/>
                        
                        <?php else: ?>
                        
                        <a href="<?php echo $view['router']->generate('submissao_dados-basicos', array('submissaoId' => $submissao->getId())); ?>">
                            <?php $nome = $projeto->getNome(); ?>
                            <?php echo empty($nome) ? 'Aguardando preenchimento' : $nome; ?>
                        <a/>
                        
                        <?php endif; ?>

                    <?php else: ?>

                    <?php echo $projeto->getNome(); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo $submissao->getStatus()->getDescricao(); ?></td>

                <td><?php echo Date::formatdmY($projeto->getDataCadastro()); ?></td>

                <td><?php echo $projeto->getPublicado() ? '<i class="fa fa-check"></i>' : '<i class="fa fa-remove"></i>'; ?></td>

                <td><?php echo 'R$ ' . number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?></td>

                <td><a href="<?php echo $view['router']->generate('usuario_apoiadores-projeto', array('projetoId' => $projeto->getId())); ?>"
                       title="Acompanhar" alt="Acompanhar" class="btn"><i class="fa-wrench fa"/></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php $view['slots']->stop(); ?>
