<?php $view->extend('EmVistaBundle:Submissao:index.html.php'); ?>
<?php $view['slots']->start('submissao-body') ?>

<form class="form-horizontal" method="post"
      action="<?php echo $view['router']->generate('submissao_salvar-video', array('submissaoId' => $submissao->getId())); ?>">

    <input type="hidden" name="submissaoId" id="submissaoId" value="<?php echo $submissao->getId(); ?>"/>

    <?php $video = $submissao->getProjeto()->getVideo(); ?>

    <fieldset>
        <legend>Video</legend>
        <div class="control-group">
            <label class="control-label" for="siteVideoId">Site do video</label>
            <div class="controls">
                <select type="text" name="siteVideoId" class="input-small">
                    <?php foreach($sitesVideo as $siteVideo): ?>
                        <?php $siteVideoId = ($video ? $video->getSiteVideo()->getId() : null); ?>
                        <?php $selected = ($siteVideo->getId() == $siteVideoId ? 'selected' : ''); ?>
                        <option <?php echo $selected; ?> value="<?php echo $siteVideo->getId(); ?>"><?php echo $siteVideo->getNome(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="url">Endereço</label>
            <div class="controls ">
                <input type="text" name="url" class="input-xxlarge" value="<?php echo ($video ? $video->getWatchUrl() : ''); ?>">

            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <a href="<?php echo $view['router']->generate('submissao_recompensas', array('submissaoId' => $submissao->getId())); ?>"
                   class="btn">Voltar</a>
                <button type="submit" class="btn">Avançar</button>
            </div>
        </div>
    </fieldset>
</form>

<?php $view['slots']->stop(); ?>