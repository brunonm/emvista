var maisSobreVoce = {

    init: function(){
        maisSobreVoce.events();
        maisSobreVoce.masks();
    },

    events: function(){
        $('#radio-tipo-pessoa-fisica').change(maisSobreVoce.handleCheckboxTipoPessoa);
        $('#radio-tipo-pessoa-juridica').change(maisSobreVoce.handleCheckboxTipoPessoa);
    },

    masks: function(){
        $('#documento').mask('999.999.999-99');
    },

    handleCheckboxTipoPessoa: function(){
        if(this.value == 'f'){
            maisSobreVoce.showPessoaFisica();
        }else{
            maisSobreVoce.showPessoaJuridica();
        }
    },

    showPessoaFisica: function(){
        $('#documento').unmask();
        $('#documento').val('');
        $('#documento').mask('999.999.999-99');
        $('#nome').parents('.form-group').children('label').html('Nome');
        $('#documento').parents('.form-group').children('label').html('CPF');
    },

    showPessoaJuridica: function(){
        $('#documento').unmask();
        $('#documento').val('');
        $('#documento').mask('99.999.999/9999-99');
        $('#nome').parents('.form-group').children('label').html('Razão social');
        $('#documento').parents('.form-group').children('label').html('CNPJ');
    }
}

$(document).ready(function(){
    maisSobreVoce.init();
});