<?php $view->extend('EmVistaBundle:Admin:index.html.php'); ?>
<?php $view['slots']->start('admin-body') ?>

<p><strong>Publicação de projetos</strong></p>
<p>Todos os projetos aprovados e ainda não publicados serão publicados.</p>
<p>Esta funionalidade deverá ser executada por uma TASK / CRON. Disponibilizada por aqui temporariamente.</p>

<a class="btn btn-success" href="<?php echo $view['router']->generate('admin_publicacao-projetos') ?>">Publicar!</a>

<?php $view['slots']->stop(); ?>
