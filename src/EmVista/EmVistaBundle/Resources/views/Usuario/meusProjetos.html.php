<?php use EmVista\EmVistaBundle\Util\Date; ?>
<?php $view->extend('EmVistaBundle:Usuario:base.html.php'); ?>
<?php $view['slots']->start('usuario-body') ?>

<legend>Meus projetos</legend>

<?php if(count($submissoes) == 0): ?>

<p>Você ainda não enviou nenhum projeto.</p>

<?php else: ?>

<p>Você pode continuar a submissão de um projeto que não concluiu selecionando o seu título.</p>
<p>Para obter mais detalhes de quem apoiou o seu projeto, ou mesmo informações gerenciais sobre a arrecadação, clique no botão <i class="icon-wrench"></i> a direita dos projetos.</p>

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
        <?php foreach($submissoes as $submissao): ?>
            <?php $projeto = $submissao->getProjeto(); ?>
            <tr>
                <td>
                    <?php if($submissao->getStatus()->getId() == \EmVista\EmVistaBundle\Entity\StatusSubmissao::STATUS_INICIAL): ?>

                    <a href="<?php echo $view['router']->generate('submissao_dadosBasicos', array('submissaoId' => $submissao->getId())); ?>">
                        <?php $nome = $projeto->getNome(); ?>
                        <?php echo empty($nome) ? 'Aguardando preenchimento' : $nome; ?>
                    <a/>

                    <?php elseif($submissao->getStatus()->getId() == \EmVista\EmVistaBundle\Entity\StatusSubmissao::STATUS_AGUARDANDO_APROVACAO): ?>

                    <?php echo $projeto->getNome(); ?>

                    <?php else: ?>

                    <a href="<?php echo $view['router']->generate('projeto_visualizar', array('projetoSlug' => $projeto->getSlug())); ?>">
                        <?php echo $projeto->getNome(); ?>
                    <a/>

                    <?php endif; ?>
                </td>
                <td><?php echo $submissao->getStatus()->getDescricao(); ?></td>

                <td><?php echo Date::formatdmY($projeto->getDataCadastro()); ?></td>

                <td><?php echo $projeto->getPublicado() ? '<i class="icon-ok"></i>' : '<i class="icon-remove"></i>'; ?></td>

                <td><?php echo 'R$ ' . number_format($projeto->getValorArrecadado(), 2, ',', '.'); ?></td>

                <td><a href="<?php echo $view['router']->generate('usuario_apoiadoresProjeto', array('projetoId' => $projeto->getId())); ?>"
                       title="Acompanhar" alt="Acompanhar" class="btn"><i class="icon-wrench"/></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php $view['slots']->stop(); ?>