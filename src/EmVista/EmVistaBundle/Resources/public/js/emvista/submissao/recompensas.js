var recompensas = {
    init: function(){
        this.events();
    },

    events: function(){
        $('#btn-adicionar-recompensa').click(recompensas.handleButtonAdicionarRecompensa);
        $(document).on('click', '.btn-excluir-recompensa', recompensas.handleButtonExcluirRecompensa);
        $(document).on('change', '.checkbox-limite', recompensas.handleExibirLimite);
        $('form').validationEngine().showMyValidationEngineMessages();
    },

    handleButtonAdicionarRecompensa: function(){
        var conteudo = $(".container-recompensas div.recompensa:last").clone();
        var count = parseInt(conteudo.attr("count"));
        conteudo.attr("count", count + 1);

        if(count == 0){
            var btnExcluir = $('<a>').attr('href', 'javascript:;')
                                     .addClass('btn btn-danger btn-excluir-recompensa')
                                     .html('<i class="fa fa-trash icon-white"></i> Excluir recompensa');

            conteudo.append(
                $('<div>').addClass('form-group').append(
                    $('<div>').addClass('col-sm-9 col-sm-offset-2').append(btnExcluir)
                )
            );
        }

        conteudo.find("input").each(function(){
            if($(this).attr('name') != undefined){
                $(this).attr("name", $(this).attr("name").replace("[" + count + "]", "[" + (count + 1) + "]"));
            }
        });

        conteudo.find(':text').val('');
        conteudo.find('.recompensaId').val('');
        conteudo.find('input').attr('readonly', false);
        conteudo.find('.form-group.oculto').removeClass('oculto');

        $(".container-recompensas").append(conteudo);
        conteudo.find('.checkbox-limite').change();
        $('.money').attr('maxlength', 11).maskMoney({thousands:'.', decimal:','});
    },

    handleButtonExcluirRecompensa: function(){
        if(confirm('Deseja realmente remover essa recompensa?')){
            $(this).parents('div.recompensa').remove();
        }
    },

    handleExibirLimite: function(){
        var divLimite = $(this).parents('div.recompensa').children('.div-limite-recompensa');

        if($(this).is(':checked')){
            divLimite.addClass('oculto');
            divLimite.find('input').each(function(){
                $(this).val('');
            });
        }else{
            divLimite.removeClass('oculto');
        }
    }
}

$(document).ready(function(){
    recompensas.init();
});