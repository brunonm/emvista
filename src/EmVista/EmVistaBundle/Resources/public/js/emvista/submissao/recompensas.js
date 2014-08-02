var recompensas = {
    init: function(){
        recompensas.events();
    },

    events: function(){
        $('#btn-adicionar-recompensa').click(recompensas.handleButtonAdicionarRecompensa)
        $('.btn-excluir-recompensa').live('click', recompensas.handleButtonExcluirRecompensa)
        $('.checkbox-limite').live('change', recompensas.handleExibirLimite)
    },

    handleButtonAdicionarRecompensa: function(){
        var conteudo = $(".container-recompensas div.recompensa:last").clone();
        var count = parseInt(conteudo.attr("count"));
        conteudo.attr("count", count + 1);

        if(count == 0){
            var btnExcluir = $('<a>').attr('href', 'javascript:;')
                                     .addClass('btn btn-danger btn-excluir-recompensa')
                                     .html('<i class="icon-trash icon-white"></i> Excluir recompensa');

            conteudo.children('div.control-group:first').children('.controls').append(btnExcluir);
        }

        conteudo.find("input").each(function(){
            if($(this).attr('name') != undefined){
                $(this).attr("name", $(this).attr("name").replace("[" + count + "]", "[" + (count + 1) + "]"));
            }
        });

        conteudo.find(':text').val('');
        conteudo.find('.recompensaId').val('');

        $(".container-recompensas").append(conteudo);
    },

    handleButtonExcluirRecompensa: function(){
        if(confirm('Deseja realmente remover essa recompensa?')){
            $(this).parents('div.recompensa').remove();
        }
    },

    handleExibirLimite: function(){
        var divLimite = $(this).parents('div.recompensa').children('.div-limite-recompensa');

        if(this.checked){
            divLimite.addClass('oculto');
            divLimite.find('input').each(function(){
                $(this).val('');
            })
        }else{
            divLimite.removeClass('oculto');
        }
    }
}

$(document).ready(function(){
    recompensas.init();
});