$(document).ready(function(){
    $('ul.my-tabs li').click(function(){
        var element = $(this).find('a').attr('data-target');
        $('.my-tab-content').hide();
        $(element).show();

        $('ul.my-tabs li.invert').removeClass('invert');
        $(this).addClass('invert');
    });
    $('.my-tab-content').hide();
    $('.my-tab-content:first').show();

    if($('#dataFim')[0]){
        var dataFim = new Date($('#dataFim').val());
        $('.tempoParaFimDoProjeto').countdown({until: dataFim,layout:$('.layoutTempoParaFimDoProjeto').html()}); 
    }
})
