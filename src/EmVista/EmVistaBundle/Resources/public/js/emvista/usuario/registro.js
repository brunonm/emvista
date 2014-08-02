$(document).ready(function(){
    $('.signUpOrLogIn .agrupador input').focus(function(){
        $('.focado').removeClass('focado');
        $(this).parents('.agrupador').addClass('focado');
    })
    $('.agrupador.focado input:first').focus();
    $('form').validationEngine().showMyValidationEngineMessages();
});
