<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('body') ?>

<div class="row">
    <div class="span2">
        <div class="row">
            <div class="span2 userImageProfile">
                <a href="#" >
                    <img src="<?php echo $usuario->getImageProfileWebPath()?>" alt="<?php echo $usuario->getNome()?>">

                </a>
                <a href="#modalUploadImagem" class="alterarImagem" data-toggle="modal">
                    Alterar Imagem
                </a>
            </div>
        </div>
        <div class="row">
            <div class="span2">
                <ul class="nav nav-pills nav-stacked">
                    <li class="<?php echo ($active == 'dadosPessoais')?'active':'';?>">
                        <a href="<?php echo $view['router']->generate('usuario_dados-pessoais') ?>">Dados Pessoais</a>
                    </li>
                    <li  class="<?php echo ($active == 'meusProjetos')?'active':'';?>">
                        <a href="<?php echo $view['router']->generate('usuario_meus-projetos') ?>">Meus Projetos</a>
                    </li>
                    <li  class="<?php echo ($active == 'contribuicoes')?'active':'';?>"">
                        <a href="<?php echo $view['router']->generate('usuario_contribuicoes') ?>">Contribuições</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="span10">
        <?php $view['slots']->output('usuario-body', 'Selecione uma opção ao lado.'); ?>
    </div>

    <div class="modal hide fade" id="modalUploadImagem">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Selecione a foto do seu perfil</h3>
        </div>
        <div class="modal-body">


            <form action="<?php echo $view['router']->generate('usuario_salvar-imagem-temporaria-profile') ?>"
                  data-url="<?php echo $view['router']->generate('usuario_salvar-imagem-temporaria-profile') ?>" class="uploadImageField" >

                 <div class="uploadImagemOver" style="display: none">
                    <h4>Pode largar aqui! ;)</h4>
                </div>
                <div class="uploadImagemNoImage" style="display: none">
                    <h4>Este tipo de arquivo não é suportado</h4>
                    <small>Tente arquivos PNG, JPG, JPEG ou BMP de até 2MB</small>
                </div>
                <div class="uploadImagemInstructions">
                    <h4>
                        Arraste sua foto para aqui
                    </h4>
                    <div>
                        <small>
                            ou então
                        </small>
                    </div>
                    <span class="btn btn-primary fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Selecione do seu computador</span>
                        <input type="file" name="image" multiple="">
                    </span>
                </div>
            </form>
            <div class="uploadedImagemField">
                <form id="cropForm" style="display: none">
                </form>
            </div>
        </div>
        <div class="modal-footer" style="display:none">

            <a href="#" class="btn" id="utilizeOutraFoto">Utilizar outra foto</a>
            <a href="#" class="btn btn-primary" id="salvarImagem">Salvar Imagem</a>
        </div>
    </div>
</div>
<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js'); ?>

<?php
    foreach($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/jcrop/jquery.Jcrop.min.js',
              '@EmVistaBundle/Resources/public/js/jqueryfileupload/jquery.ui.widget.js',
              '@EmVistaBundle/Resources/public/js/jqueryfileupload/jquery.iframe-transport.js',
              '@EmVistaBundle/Resources/public/js/jqueryfileupload/jquery.fileupload.js',
              '@EmVistaBundle/Resources/public/js/emvista/usuario/base.js',
            )
            ) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->output('usuarioJs'); ?>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('css') ?>

        <?php foreach($view['assetic']->stylesheets(
                array('@EmVistaBundle/Resources/public/css/emvista/usuario/base.css',
                '@EmVistaBundle/Resources/public/css/jquery.Jcrop.min.css')) as $url): ?>
            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

<?php $view['slots']->stop(); ?>