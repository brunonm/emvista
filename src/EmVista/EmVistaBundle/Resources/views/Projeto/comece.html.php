<?php $view->extend('EmVistaBundle::base.html.php'); ?>
<?php $view['slots']->start('js') ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('#aceitarTermoUso').change(function(){
            if($(this).is(':checked')){
                $(this).parents('.btn:first').addClass('disabled');
                $('.btn-sucesso').removeClass('disabled');
            }else{
                $(this).parents('.btn:first').removeClass('disabled')
                $('.btn-sucesso').addClass('disabled');
            }
        })
        $('.btn-sucesso').click(function(){
            if($(this).hasClass('disabled')){
                return false;
            }
            $('form#form').submit();
            return true;
        })
    })
</script>

<?php $view['slots']->stop() ?>
<?php $view['slots']->start('body') ?>

<link rel="stylesheet" href="/bundles/emvista/css/rte.css" />
<style >
    [class^="icon-"], [class*=" icon-"]{
        background-image: url("/bundles/emvista/css/bootstrap/img/glyphicons-halflings.png")
    }
    .icon-white{
        background-image: url("/bundles/emvista/css/bootstrap/img/glyphicons-halflings-white.png")
    }
    .form-horizontal .control-label{
        width: 100px;
    }
    .form-horizontal .controls{
        margin-left: 120px;
    }
    .contentRecompensa{
        display: block;
        margin-bottom: 18px;
        margin-top:18px;
        border-bottom: 1px solid #eee;
        -webkit-margin-top-collapse: separate;

    }
    .navigation-rte li{
        display: inline;
        text-decoration: none;
        content: '|';
        padding: 0 5px;
    }
    .navigation-rte > li > a{
        display: inline;
    }

</style>
<section id="featureds" class="project-listing">
    <div class="row">
        <div class="span6 col">
            <h1>Registro de Projeto</h1>
        </div>
        <div class="span6 col">
            <span>
                <a href="#" class="pull-right disabled" style="padding: 4px 10px 4px">
                    <i class="icon-trash "></i>
                    Deletar Projeto
                </a>
            </span>
            <span>
                <a href="#" class="pull-right btn btn-success btn-save disabled">
                    <i class="icon-heart icon-white"></i>
                    Salvar
                </a>
            </span>
        </div>
    </div>
    <div class="row">
        <div id="menu" class="span3 col">
            <div class="well" style="padding: 6px 0">
                <ul class="nav nav-list">
                    <li class="nav-header">
                        Projeto
                    </li>
                    <li >
                        <a href="#">
                            Termo de uso
                        </a>
                    </li>
                    <li >
                        <a class="">
                            Dados Básicos
                        </a>
                    </li>
                    <li >
                        <a href="#">
                            Descrição
                        </a>
                    </li>
                    <li>
                        <a>
                            Recompensas
                        </a>
                    </li>

                    <li class="nav-header">
                        Você
                    </li>
                    <li>
                        <a>
                            Mais sobre você
                        </a>
                    </li>
                    <li>
                        <a>
                            Revisão
                        </a>
                    </li>
                </ul>

            </div>
        </div>
        <form id="form" class="span9 col form-horizontal" method="post" action="<?php echo $view['router']->generate('_projeto_registrar') ?>">
            <div class="carousel-inner">
                <div class="active item">
                    <fieldset>
                        <legend>Termo de uso</legend>
                        <div class="control-list">
                            <?php echo nl2br($termoUso->getTermoUso());?>
                            <input type="hidden" name="projeto[termoUso]" id="projeto_termoUso" value="<?php echo $termoUso->getId()?>">
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="span7 offset4">
            <label href="#" class="btn btn-large btn-checkbox">
                <div class="checkbox" style="font-size: 13px;font-weight: normal;line-height: 18px">
                    <input type="checkbox" id="aceitarTermoUso" name="aceitarTermoUso" value="1">
                    Aceito o termo de uso
                </div>
            </label>
            <a href="#" class="btn btn-large btn-primary btn-sucesso disabled">
                Aceitar
            </a>
        </div>
    </div>
</section>

<?php $view['slots']->stop(); ?>