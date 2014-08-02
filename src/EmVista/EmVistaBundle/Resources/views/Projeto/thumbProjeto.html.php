<?php
if(!isset($link)){
    $link = 'javascript:void(0);';
}
?>
<div class="row-fluid">
    <a href="<?php echo $link?>" class="span3">
        <img src="<?php echo $projeto->getImagemThumb()?$projeto->getImagemThumb()->getWebPath():'/bundles/emvista/images/favicon_envista.png';?>" alt="Thumb">
    </a>
    <div class="span8 offset1">
        <a href="<?php echo $link?>"><?php echo $projeto->getNome()?$projeto->getNome():'Sem Título';?></a>
        <div><?php echo $projeto->getDescricaoCurta()?$projeto->getDescricaoCurta():' - - ';?></div>
        <div>Criado em <?php echo $projeto->getDataCadastro()->format('d/m/Y')?></div>
    </div>
</div>
