$(document).ready(function(){
    $('#abasProjeto ul li').click(function(){
        $('.atual').removeClass('atual');
        $(this).addClass('atual');
        $('#abasProjeto').removeClass('abaProjeto abaComentario abaAtualizacoes').addClass('aba' + $(this).attr('id'));
        $('.cont_principal div.contents').hide();
        $('#content' + $(this).attr('id')).show().focus();
        return false;
    });
    if($('#dataFim')[0]){
        var dataFim = new Date($('#dataFim').val());
        $('.tempoParaFimDoProjeto').countdown({until: dataFim,layout:$('.layoutTempoParaFimDoProjeto').html()}); 
    }
})
