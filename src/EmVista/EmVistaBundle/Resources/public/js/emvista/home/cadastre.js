$(document).ready(function(){
    $("#form-submissao").validationEngine().showMyValidationEngineMessages();

    $('#form-submissao').submit(function(){

        if(!$(this).validationEngine('validate')){
            return false;
        }

        $.flashMessage('Pré-cadastro realizado com sucesso.', 'success');
        $('#modalCadastre').modal('hide');

        $.post(this.action,
            $(this).serialize(),
            function(data){
                if(!data.status){
                    $('.close:first').click();
                    $.flashMessage(data.message, 'warning');
                }
            },
            'json'
        );

        return false;
    });
});
