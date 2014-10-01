<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

    <input type="hidden" name="submissaoId" id="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <fieldset>
        <legend>Imagens</legend>

        <div id="upload-controls">
            <p>Selecione uma imagem ilustrativa do seu projeto. O tamanho máximo permitido é de 2MB e são aceitos os formatos JPG e PNG. </p>

            <input id="fileupload" type="file" name="imagem"
                    data-url="<?php echo $view['router']->generate('submissao_salvar-imagem-original', array('submissaoId' => $submissao->getId())); ?>">
        </div>

        <div id="crop-controls" style="display: none;">
            <p><strong>1° Recorte - Miniatura</strong></p>
            <p>Selecione a área da imagem que deseja utilizar para as miniaturas do site.</p>
        </div>

        <div class="row">
            <input type="hidden" id="projetoImagemId" name="projetoImagemId"
                   value="<?php echo ($imagemOriginal ? $imagemOriginal->getId() : ''); ?>"/>
            <input type="hidden" id="tipoProjetoImagemId" name="tipoProjetoImagemId" value="4"/>
            <div class="col-sm-10" id="preview">
                <?php if($imagemOriginal): ?>
                <img src="<?php echo $imagemOriginal->getWebPath(); ?>"/>
                <?php endif; ?>
            </div>
        </div>

        <div class="control-group" id="crop-buttons">
            <div class="controls">
                <a href="javascript:;" style="display: none;" class="btn btn-inverse"
                   id="button-new-upload"><i class="icon-arrow-up icon-white"></i> Novo upload</a>

                <a href="javascript:;" style="display: none;" class="btn btn-success" disabled
                   id="button-next-crop"><i class="icon-arrow-right icon-white"></i> Próxima imagem</a>
            </div>
        </div>

        <div class="control-group" id="navigate-buttons">
            <div class="controls">
                <a href="<?php echo $view['router']->generate('submissao_video', array('submissaoId' => $submissao->getId())); ?>"
                   class="btn">Voltar</a>
                <a href="<?php echo $view['router']->generate('submissao_mais-sobre-voce', array('submissaoId' => $submissao->getId())); ?>"
                   class="btn" id="button-avancar" disabled>Avançar</a>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('js') ?>

<?php foreach($view['assetic']->javascripts(
        array('@EmVistaBundle/Resources/public/js/emvista/submissao/imagens.js',
              '@EmVistaBundle/Resources/public/js/jcrop/jquery.Jcrop.min.js',
              '@EmVistaBundle/Resources/public/js/jqueryfileupload/jquery.ui.widget.js',
              '@EmVistaBundle/Resources/public/js/jqueryfileupload/jquery.iframe-transport.js',
              '@EmVistaBundle/Resources/public/js/jqueryfileupload/jquery.fileupload.js')) as $url): ?>
    <script type="text/javascript" src="<?php echo $view->escape($url) ?>"></script>
<?php endforeach; ?>

<?php $view['slots']->stop(); ?>

<?php $view['slots']->start('css') ?>

        <?php foreach($view['assetic']->stylesheets(
                array('@EmVistaBundle/Resources/public/css/jquery.Jcrop.min.css')) as $url): ?>
            <link rel="stylesheet" href="<?php echo $view->escape($url) ?>" />
        <?php endforeach; ?>

<?php $view['slots']->stop(); ?>
