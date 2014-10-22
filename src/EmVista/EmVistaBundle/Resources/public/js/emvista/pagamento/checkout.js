var checkout = {
    init: function(){
        checkout.events();
        checkout.resetForm();
        checkout.disableButtonContinuar();
        checkout.hideRadioButtons();
        checkout.toggleFaq();
        checkout.goCheckout()
    },

    events: function(){
        $('.checkbox-recompensa').change(checkout.handleCheckboxRecompensa);
        $('#input-valor').blur(checkout.handleInputValor);
        $('#button-continuar').click(checkout.handleButtonContinuar);
        $('#naoEraIsso').click(checkout.resetForm())
    },

    resetForm: function(){
        $('.checkbox-recompensa').attr('checked',false).change();
        $('.recompensas .recompensa').show();
        $('#input-valor').val(0);
        $('#naoEraIsso,#confirmeRecompensa').hide();
        $('#makeChoice').show();
    },

    handleInputValor: function(){
        if(jQuery.trim(this.value) == '' || isNaN(this.value)){
            this.value = 0;
        }

        this.value = parseFloat(this.value.replace(",", "."));
        var doacaoValor = this.value;
        if(doacaoValor < checkout.getValorRecompensaChecked()){
            $('.checkbox-recompensa:checked').attr('checked',false);
            $('.checkbox-recompensa').each(function(){
               var valorRecompensa = parseFloat($(this).attr('valor').replace(",", "."));
               if(doacaoValor >= valorRecompensa){
                   $(this).attr('checked',true);
               }
            });
            if($('.checkbox-recompensa:checked').size()){
                $('.checkbox-recompensa:checked').change();
                $('#input-valor').val(doacaoValor);
            }else{
                alert('Valor informado não equivale a o minimo de nenhuma recompensa!')
                
                $('.checkbox-recompensa').change();
            }
        }else{
            $('#container-valor').removeClass('error');
        }

        checkout.handleStatusButtonContinuar();
    },

    handleCheckboxRecompensa: function(){
        $('#input-valor').attr('disabled', false);
        
        checkout.ativaRecompensaChecked();
        var recompensaValor = checkout.getValorRecompensaChecked();
        if(isNaN(recompensaValor)){
            recompensaValor = 0;
        }
        $('#input-valor').val(recompensaValor);

        $('#container-valor').removeClass('error');

        checkout.handleStatusButtonContinuar();
    },
    
    ativaRecompensaChecked: function(){
        
        $('.block_pledge_active').removeClass('block_pledge_active');
        $('#form-checkout input:radio:checked').parents('div.recompensa').find('.block_pledge').addClass('block_pledge_active');
    },

    getValorRecompensaChecked: function(){
        var valor = $('#form-checkout input:radio:checked').attr('valor');
        return parseFloat(valor);
    },
    handleStatusButtonContinuar: function(){
        if($('#input-valor').val() > 0 && !$('#container-valor').hasClass('error')){
           checkout.enableButtonContinuar();
        }else{
            checkout.disableButtonContinuar();
        }
    },

    handleButtonContinuar: function(){
        $('#content').loading();
        $('#form-checkout').submit();
    },
    
    handlerButtonConfirmar: function(){
        $('.recompensas .recompensa').each(function(){
            if($(this).find('.block_pledge_active').size() == 0){
                $(this).hide('fast');
            }
            $('#naoEraIsso').show();
            $('#confirmeRecompensa').show();
            $('#makeChoice').hide();
        })
        
    },

    disableButtonContinuar: function(){
        $('#btn-apoiar').attr('disabled', true);
    },

    enableButtonContinuar: function(){
        $('#btn-apoiar').attr('disabled', false);
    },
    hideRadioButtons : function(){
        $('#form-checkout input:radio').hide();
    },
    toggleFaq : function(){
        $('.faqbox').click(function(){
            $(this).find('.hidden-content').toggle();
        });
    },
    goCheckout : function(){
        $('#form-checkout').submit(function(){
            
            $('#btn-apoiar').hide();
            $('#form-checkout').loading();
            $('#mensagemLoading').show();
        })
    }
}

$(document).ready(function(){
    checkout.init();
});