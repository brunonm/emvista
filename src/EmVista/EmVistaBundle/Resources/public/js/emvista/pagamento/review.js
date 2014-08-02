var review = {
    init: function(){
        review.events();
    },

    events: function(){
        $('#button-confirmar').click(review.handleButtonConfirmar)
        $('#button-cancelar').click(review.handleButtonCancelar);
    },

    handleButtonConfirmar: function(){
        $('#content').loading();
        $('#form-confirm').submit();
    },

    handleButtonCancelar: function(){
        if(confirm('Tem certeza que deseja cancelar?')){
            $('#action').val('cancel');
            $('#content').loading();
            $('#form-confirm').submit();
        }
    }
}

$(document).ready(function(){
    review.init();
});