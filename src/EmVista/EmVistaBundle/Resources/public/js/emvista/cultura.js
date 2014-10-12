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
            jQuery('html, body').stop().animate({
                scrollTop: jQuery(anchor.attr('href')).offset().top
            }, 1000);
            e.preventDefault();
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
})