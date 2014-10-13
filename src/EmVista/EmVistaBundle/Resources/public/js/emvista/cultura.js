(function(jQuery){

    /* ---------------------------------------------- /*
     * Preloader
     /* ---------------------------------------------- */

    jQuery(window).load(function() {
        jQuery('#status').fadeOut();
        jQuery('#preloader').delay(350).fadeOut('slow');
    });

    jQuery(document).ready(function() {

        jQuery('body').scrollspy({
            target: '.navbar-custom',
            offset: 50
        })

        jQuery('a[href*=#]').bind("click", function(e){
            var anchor = jQuery(this);
            if (jQuery(anchor.attr('href')).offset()) {
                jQuery('html, body').stop().animate({
                    scrollTop: jQuery(anchor.attr('href')).offset().top
                }, 1000);
                e.preventDefault();
            }
        });

        /* ---------------------------------------------- /*
         * Background image
         /* ---------------------------------------------- */

        if (window.location.pathname == Routing.generate('home_index')) {
            jQuery('#intro').backstretch([Routing.getBaseUrl() + '/bundles/emvista/images/background.png']);
        }

        /* ---------------------------------------------- /*
         * Navbar
         /* ---------------------------------------------- */

        var navbar = jQuery('.navbar');

        if (window.location.pathname == Routing.generate('home_index')) {
            navbar.removeClass('navbar-color');
            jQuery('#content').css('padding-top', 0);
            var navHeight = navbar.height();
            jQuery(window).scroll(function() {
                if(jQuery(this).scrollTop() >= navHeight) {
                    navbar.addClass('navbar-color');
                }
                else {
                    navbar.removeClass('navbar-color');
                }
            });
        }
        if(jQuery(window).width() <= 767) {
            navbar.addClass('custom-collapse');
        }

        jQuery(window).resize(function() {
            if(jQuery(this).width() <= 767) {
                navbar.addClass('custom-collapse');
            }
            else {
                navbar.removeClass('custom-collapse');
            }
        });
        
        $(document).on('keyup', '.money', function(){
            $(this).attr('maxlength', 11).maskMoney({thousands:'', decimal:'.'});
        });
    });


})(jQuery);


jQuery.fn.extend({
    loading : function(){
        jQuery(this).each(function(){
            var count = parseInt(jQuery('.loading:last').attr('count'));
            if(!count){
                count = 0;
            }
            count++;
            var offset = jQuery(this).offset();
            if(jQuery(this).attr('loadingCount'))
                return this;
            var w = jQuery(this).width();
            var h = jQuery(this).height();
            jQuery(this).attr('loadingCount',count);
            var div = jQuery('<div />').css({top:offset.top, left:offset.left}).width(w)
                .height(h).addClass('loading').attr('count',count)
            var fieldImage = jQuery('<div />').css({top:offset.top, left:offset.left}).width(w)
                .height(h).addClass('loading-image').attr('count',count);

            jQuery('body').append(div,fieldImage);
        })
        return this;
    },
    removeLoading : function(){
        jQuery(this).each(function(){
            var count = jQuery(this).attr('loadingCount');
            jQuery('.loading[count='+count+'],.loading-image[count='+count+']').remove();
            jQuery(this).removeAttr('loadingCount');
        });
        return this;
    },
    generateThumbs : function(data){
        if(data.length){
            for(var i in data){
                var thumbProjeto = jQuery.thumbProjeto(data[i])
                var li = jQuery('<li/>').append(thumbProjeto).addClass('span3');
                jQuery(this).append(li);
            }
        }else{
            var h4 = jQuery('<h4>Nenhum projeto encontrado</h4>').addClass('noProjectFound');
            var li = jQuery('<li/>').addClass('span12').append(h4);
            var content = li;
            console.log(jQuery(this).get(0).tagName);
            if(jQuery(this).get(0).tagName.toLowerCase() != 'ul'){
                content = jQuery('<ul/>').addClass('unstyled');
                content.append(li);
                li.removeClass('span12').addClass('span9');
            }
            jQuery(this).append(content);
        }
        return this;
    }
})
jQuery.fn.extend({
    inputError : function(msgError,params){

        if(params){
            if(!jQuery.isArray(params)){
                var defaultValue = params;
                params = new Array();
                params[0] = defaultValue;
            }

            jQuery.each(params, function(i, n) {
                msgError = msgError.replace(new RegExp("\\{" + i + "\\}", "g"), n);
            });
        }
        this.removeInputError();
        this.parents('.control-group:first').addClass('error');
        var labelError = jQuery('<span/>').addClass('help-inline').html(msgError);
        if(!this.parent().hasClass('input-append'))
            labelError.insertAfter(this);
        else
            this.parent().append(labelError);
    },
    removeInputError : function(){
        this.parents('.control-group:first').removeClass('error');
        this.parents('.control-group:first').find('span.help-inline').remove();
    }
});




$.fn.extend({
    generateThumbs : function(data, config){

        if(data.length){
            for(var i in data){
                var thumbProjeto = $.thumbProjeto(data[i], config)
                var li = $('<li/>').append(thumbProjeto).addClass('span3');
                $(this).append(li);
            }
        } else {
            var h4 = $('<h4>Nenhum projeto encontrado</h4>').addClass('noProjectFound');
            var li = $('<li/>').addClass('span12').append(h4);
            var content = li;
            console.log($(this).get(0).tagName);
            if($(this).get(0).tagName.toLowerCase() != 'ul'){
                content = $('<ul/>').addClass('unstyled');
                content.append(li);
                li.removeClass('span12').addClass('span9');
            }
            $(this).append(content);
        }
        return this;
    }
})

$.extend({
    thumbProjeto: function(data, config) {

        console.log(data);
        var defaultConfig = {
            smSize: 4,
            lgSize: 3,
            xsSize: 12
        };


        config = $.extend(defaultConfig, config);
        var thumb = '' +
        '<div class="col-sm-' + config.smSize + ' col-lg-' + config.lgSize + ' col-xs-' + config.xsSize + ' project-container" project-id="' + data.id + '"> ' +
            '<div class="project-image-content">' +
                '<div class="mask">' +
                    '<div class="content-btn-apoiar">' +
                        '<a href="' + data.urlProjeto + '" class="btn-special-apoiar col-md-12 btn my-btn" >APOIAR</a>' +
                    '</div>' +
                '</div>' +
                '<img class="avatar" src="' + data.urlImagemThumb + '" alt="Projeto">' +
            '</div>' +
            '<div class="project-content">' +
                '<h5>' + data.titulo + '</h5>' +
                '<legend>por ' + data.autor + '</legend>' +
                data.descricaoCurta +
            '</div>' +
            '<div class="project-group">' +
                '<div class="col-sm-4 project-funded">' +
                    '<div class="value">' + data.percentual + '%</div>' +
                    '<div class="label">Meta</div>' +
                '</div>' +
                '<div class="col-sm-4 project-pleged">' +
                    '<div class="value">R$</span> ' + data.valorArrecadadoFormatado + '</div>' +
                '<div class="label">valor</div>' +
            '</div>' +
            '<div class="col-sm-4 project-togo">';

            if (data.tempo) {
                thumb += '' +
                '<div class="value"> <span class="time-left-days">' + data.tempo.numero + '</span> ' + data.tempo.tempo + '</div>' +
                '<div class="label">' + data.tempo.faltam + '</div>'
            } else {
                thumb += '' +
                '<div class="label"> -- </div>';
            }
        thumb += '' +
            '</div>' +
        '</div>'+
        '</div>';
        return $(thumb);

    }
});


$(document).ready(function(){
    if ($.validationEngine){
        $.validationEngine.defaults.showPrompts = false;
        $.validationEngine.defaults.showOneMessage = true;
        $.validationEngine.defaults.validationEventTrigger = "submit";
        $.fn.extend({
            showMyValidationEngineMessages : function(){
                $(this).bind("jqv.field.result",
                    function(event, field, errorFound, prompText) {
                        var parent = $(field).parents('.control-group');
                        if(parent.size() == 0){
                            parent = $(field).parent();
                        }
                        if(errorFound){
                            parent.addClass('error');
                            prompText = prompText.replace(/\*/g,'').split('<br/>')[0];
                            $('.flash-message.alert[typeField="validationEngine"] button').click();
                            $.flashMessage(prompText,'error').attr('typeField','validationEngine');
                        }else{
                            parent.removeClass('error');
                            $('.flash-message.alert[typeField="validationEngine"] button').click();
                        }
                    }
                )
                return this;
            }
        })
    };
});
