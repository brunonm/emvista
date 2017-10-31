var DadosBasicos = {
    init: function(){
        this.events();
    },
    events: function(){
        $('input[name="preCadastro"]').change(this.handleChangePreCadastro);
    },
    handleChangePreCadastro: function(){
        if ($('input[name="preCadastro"]').is(':checked')) {
            $('input[name="valor"]').val('').prop('disabled', true);
        } else{
          $('input[name="valor"]').prop('disabled', false);
        }
    }
};

$(document).ready(function(){
    DadosBasicos.init();
});