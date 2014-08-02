var pagamentos = {
    init: function(){
        pagamentos.events();
    },

    events: function(){
        $('.pagar').click(pagamentos.handleButtonPagar);

    },

    handleButtonPagar: function(){
        var id = this.id;

        $.post(
            '/admin/informar-pagamento',
            {projetoId: this.id.replace('pagar-', '')},
            function(data){
                alert(data.msg);
                $('#' + id).parent().append('Pago');
                $('#' + id).remove();
            },
            'json'
        );
    }
}

$(document).ready(function(){
    pagamentos.init();
});