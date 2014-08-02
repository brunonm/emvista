$.fn.extend({
    // http://docs.jquery.com/Plugins/Validation/Methods/required
    required: function() {
        var value = $(this).val();
        var element = $(this)[0];
        
        if ( element.nodeName.toLowerCase() === "select" ) {
            // could be an array for select-multiple or a string, both are fine this way
            var val = $(element).val();
            return val && val.length > 0;
        }
        if ( this.is(':radio') || this.is(':checkbox') ) {
            return $(this).getLength() > 0;
        }
        return $.trim(value).length > 0;
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/minlength
    minlength: function(param) {
        var value = $(this).val();
        var length = $.isArray( value ) ? value.length : $(this).getLength();
        return length >= param;
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/maxlength
    maxlength:  function(param) {
        var value = $(this).val();
        var length = $.isArray( value ) ? value.length : $(this).getLength();
        return length <= param;
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/rangelength
    rangelength: function(param) {
        var value = $(this).val();
        var length = $.isArray( value ) ? value.length : $(this).getLength();
        return ( length >= param[0] && length <= param[1] );
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/min
    min: function(param) {
        var value = $(this).val();
        return value >= param;
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/max
    max: function(param) {
        var value = $(this).val();
        return value <= param;
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/range
    range: function(param) {
        var value = $(this).val();
        return ( value >= param[0] && value <= param[1] );
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/email
    email: function() {
        var value = $(this).val();
        // contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
        return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/url
    url: function() {
        var value = $(this).val();
        // contributed by Scott Gonzalez: http://projects.scottsplayground.com/iri/
        return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value);
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/date
    date: function() {
        var value = $(this).val();
        return !/Invalid|NaN/.test(new Date(value));
    },
    // http://docs.jquery.com/Plugins/Validation/Methods/date
    dateBR: function() {
        var value = $.trim($(this).val());
        return /^\d\d?\/\d\d?\/\d\d\d?\d?$/.test(value);
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/dateISO
    dateISO: function() {
        var value = $(this).val();
        return /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/.test(value);
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/number
    number: function() {
        var value = $(this).val();
        return /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(value);
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/digits
    digits: function() {
        var value = $(this).val();
        return  /^\d+$/.test(value);
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/creditcard
    // based on http://en.wikipedia.org/wiki/Luhn
    creditcard: function() {
        var value = $(this).val();
        // accept only spaces, digits and dashes
        if (/[^0-9 \-]+/.test(value)) {
            return false;
        }
        var nCheck = 0,
        nDigit = 0,
        bEven = false;

        value = value.replace(/\D/g, "");

        for (var n = value.length - 1; n >= 0; n--) {
            var cDigit = value.charAt(n);
            nDigit = parseInt(cDigit, 10);
            if (bEven) {
                if ((nDigit *= 2) > 9) {
                    nDigit -= 9;
                }
            }
            nCheck += nDigit;
            bEven = !bEven;
        }

        return (nCheck % 10) === 0;
    },

    // http://docs.jquery.com/Plugins/Validation/Methods/equalTo
    equalTo: function(param) {
        //refazer esta função
        var value = $(this).val();
        var element = $(this)[0];
        // bind to the blur event of the target in order to revalidate whenever the target field is updated
        // TODO find a way to bind the event just once, avoiding the unbind-rebind overhead
        var target = $(param);
        if (this.settings.onfocusout) {
            target.unbind(".validate-equalTo").bind("blur.validate-equalTo", function() {
                $(element).valid();
            });
        }
        return value === target.val();
    },
    cnpj: function() {
        var cnpj = $(this).val();
        
        cnpj = jQuery.trim(cnpj);

                // DEIXA APENAS OS NÚMEROS
        cnpj = cnpj.replace('/','');
        cnpj = cnpj.replace('.','');
        cnpj = cnpj.replace('.','');
        cnpj = cnpj.replace('-','');

        var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
        digitos_iguais = 1;

        if (cnpj.length < 14 && cnpj.length < 15){
            return false;
        }
        for (i = 0; i < cnpj.length - 1; i++){
            if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
                digitos_iguais = 0;
                break;
            }
        }

        if (!digitos_iguais){
            tamanho = cnpj.length - 2
            numeros = cnpj.substring(0,tamanho);
            digitos = cnpj.substring(tamanho);
            soma = 0;
            pos = tamanho - 7;

            for (i = tamanho; i >= 1; i--){
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2){
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(0)){
                return false;
            }
            tamanho = tamanho + 1;
            numeros = cnpj.substring(0,tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (i = tamanho; i >= 1; i--){
                soma += numeros.charAt(tamanho - i) * pos--;
                if (pos < 2){
                    pos = 9;
                }
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != digitos.charAt(1)){
                return false;
            }
            return true;
        }else{
            return false;
        }
    },
    cpf: function(){
        var value = $(this).val();
        value = jQuery.trim(value);

        value = value.replace('.','');
        value = value.replace('.','');
        cpf = value.replace('-','');
        while(cpf.length < 11) cpf = "0"+ cpf;
        var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
        var a = [];
        var b = new Number;
        var c = 11;
        for (i=0; i<11; i++){
                a[i] = cpf.charAt(i);
                if (i < 9) b += (a[i] * --c);
        }
        if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
        b = 0;
        c = 11;
        for (y=0; y<10; y++) b += (a[y] * c--);
        if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
        if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
        return true;
    },
    
    getLength: function() {
        var value = $(this).val();
        var element = $(this)[0];
        switch( element.nodeName.toLowerCase() ) {
            case 'select':
                return $("option:selected", element).length;
            case 'input':
                if( this.is(':radio') || this.is(':checkbox') ) {
                    return this.is(':checked').length;
                }
        }
        return value.length;
    },
    evValidation: function(params){
        var defaults = {
            events : {
                text : 'keyup keydown blur keypress',
                select : 'change click blur keyup keydown keypress',
                checkbox : 'change click',
                radio : 'change click',
                textArea : 'keyup keydown blur keypress'
            },
            listenerEvents : {
                text : true,
                select : true,
                checkbox : true,
                radio : true,
                textArea: true
            }
        }
        params = $.extend(params,defaults);
        if($(this)[0].nodeName.toLowerCase() != 'form')
            throw new Error("Tipo esperado -> form")
        $(this).attr('ezValidationForm', true);
        for(var element in params.rules){
            $(element).removeAttr('evValidation');
            var type = $(element)[0].nodeName.toLowerCase() == 'select'?'select':$(element).attr('type');
            if(params.listenerEvents[type])
                $(element).bind(params.events[type], function(){
                    $(this).check();
                })
            for(var rule in params.rules[element]){
                var valueRule = params.rules[element][rule];
                var validations = $(element).attr('evValidation') || '';
                $(element).attr('evValidation', validations + ' ' + rule);
                $(element).attr(rule,valueRule);
            }
        }
        $(this).submit(function(){
            $(this).check();
            if($(this).find('.error').size()){
                return false;
            }
        })
        
        
        
    },
    check : function(){
        var form = this;
        var error = false;
        var valueRule = '';
        var selector = form;
        
        if(form[0].nodeName.toLowerCase() == 'form')
            selector = $(form).find('[evValidation]');
        
        selector.each(function(){
            var element = $(this);
            $(element).removeInputError();
            var rules = element.attr('evValidation').split(' ');
            for(var i in rules){
                var rule = $.trim(rules[i]);
                if($.trim(rule).length == 0)
                    continue;
                error = false;
                valueRule = $(element).attr(rule);
                switch(rule){

                    case 'required':
                        if(!$(element).required())
                            error = true;
                    break;

                    case 'minlength':
                        if(!$(element).minlength(valueRule))
                            error = true;
                    break;

                    case 'maxlength':
                        if(!$(element).maxlength(valueRule))
                            error = true;
                    break;

                    case 'rangelength':
                        if(!$(element).rangelength(valueRule))
                            error = true;
                    break;

                    case 'min':
                        if(!$(element).min(valueRule))
                            error = true;
                    break;

                    case 'max':
                        if(!$(element).max(valueRule))
                            error = true;
                    break;

                    case 'range':
                        if(!$(element).range(valueRule))
                            error = true;
                    break;

                    case 'email':
                        if(!$(element).email())
                            error = true;
                    break;

                    case 'url':
                        if(!$(element).url())
                            error = true;
                    break;

                    case 'date':
                        if(!$(element).date(valueRule))
                            error = true;

                    case 'dateBR':
                        if(!$(element).date(valueRule))
                            error = true;
                    break;

                    case 'dateISO':
                        if(!$(element).dateISO(valueRule))
                            error = true;
                    break;

                    case 'number':
                        if(!$(element).number())
                            error = true;
                    break;

                    case 'digits':
                        if(!$(element).digits())
                            error = true;
                    break;

                    case 'creditcard':
                        if(!$(element).creditcard())
                            error = true;
                    break;

                    case 'equalTo':
                        if(!$(element).creditcard(valueRule))
                            error = true;
                    break;

                }
                if(error === true){
                    $(element).inputError($.evErrorMessage[rule],valueRule);
                }
            }
        })

    }
});
$.extend({
    evErrorMessage : {
        required: "Este campo &eacute; requerido.",
	remote: "Por favor, corrija este campo.",
	email: "Por favor, forne&ccedil;a um endere&ccedil;o eletr&ocirc;nico v&aacute;lido.",
	url: "Por favor, forne&ccedil;a uma URL v&aacute;lida.",
	date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
	dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
	dateBR: "Por favor, forne&ccedil;a uma data v&aacute;lida (dd/mm/aaaa).",
	number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
	digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
	creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
	equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
	accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
	maxlength: "Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres.",
	minlength: "Por favor, forne&ccedil;a ao menos {0} caracteres.",
	rangelength: "Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento.",
	range: "Por favor, forne&ccedil;a um valor entre {0} e {1}.",
	max: "Por favor, forne&ccedil;a um valor menor ou igual a {0}.",
	min: "Por favor, forne&ccedil;a um valor maior ou igual a {0}.",
        cpf: "Informe um CPF válido.",
        cnpj: "Informe um CNPJ válido."
    }
})