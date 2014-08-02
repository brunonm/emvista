var statusArrecadacao = {
    STATUS_EM_ANDAMENTO      : 1,
    STATUS_SUCESSO           : 2,
    STATUS_INSUCESSO         : 3,
    STATUS_AGUARDANDO_BOLETO : 4,
    STATUS_CANCELADO         : 5
};

// fix sub nav on scroll
var $win = $(window)
, $nav = $('.subnav')
, navTop = $('.subnav').length && $('.subnav').offset().top - 40
, isFixed = 0

processScroll()

// hack sad times - holdover until rewrite for 2.1
$nav.on('click', function () {
    if (!isFixed) setTimeout(function () {
        $win.scrollTop($win.scrollTop() - 47)
    }, 10)
})

$win.on('scroll', processScroll)

function processScroll() {
    var i, scrollTop = $win.scrollTop()

    if(scrollTop < 40){
        var altura = 40 - scrollTop;
        $(".subnav").css('top',altura+'px');
    }else{
        $(".subnav").css('top','0px');
    }
}


$.fn.extend({
    loading : function(){
        $(this).each(function(){
            var count = parseInt($('.loading:last').attr('count'));
            if(!count){
                count = 0;
            }
            count++;
            var offset = $(this).offset();
            if($(this).attr('loadingCount'))
                return this;
            var w = $(this).width();
            var h = $(this).height();
            $(this).attr('loadingCount',count);
            var div = $('<div />').css({top:offset.top, left:offset.left}).width(w)
                            .height(h).addClass('loading').attr('count',count)
            var fieldImage = $('<div />').css({top:offset.top, left:offset.left}).width(w)
                            .height(h).addClass('loading-image').attr('count',count);

            $('body').append(div,fieldImage);
        })
        return this;
    },
    removeLoading : function(){
        $(this).each(function(){
            var count = $(this).attr('loadingCount');
            $('.loading[count='+count+'],.loading-image[count='+count+']').remove();
            $(this).removeAttr('loadingCount');
        });
        return this;
    },
    generateThumbs : function(data){
        if(data.length){
            for(var i in data){
                var thumbProjeto = $.thumbProjeto(data[i])
                var li = $('<li/>').append(thumbProjeto).addClass('span3');
                $(this).append(li);
            }
        }else{
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
$.fn.extend({
    inputError : function(msgError,params){

        if(params){
            if(!$.isArray(params)){
                var defaultValue = params;
                params = new Array();
                params[0] = defaultValue;
            }

            $.each(params, function(i, n) {
                    msgError = msgError.replace(new RegExp("\\{" + i + "\\}", "g"), n);
            });
        }
        this.removeInputError();
        this.parents('.control-group:first').addClass('error');
        var labelError = $('<span/>').addClass('help-inline').html(msgError);
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
$.extend({
    thumbProjeto : function(data){
        var article = $('<article/>').addClass('entry project format-narrow').attr('id','project'+data.id);

        var urProjeto = data.urlProjeto;

        //header
        var header = $('<header/>').addClass('entry-header');
        var aTitle = $('<a/>').attr({href:urProjeto}).html(data.titulo)
        var h3Title = $('<h3/>').addClass('entry-title project-title').append(aTitle);
        var divAuthor = $('<div/>').addClass('entry-meta');
        var spanAuthor = $('<span/>').addClass('by-author').html('por ');
        var spanAuthorName = $('<span/>').addClass('author vcard').html(data.autor);
        spanAuthor.append(spanAuthorName)
        divAuthor.append(spanAuthor);
        header.append(h3Title,divAuthor);
        article.append(header);

        //body
        var divBody = $('<div/>').addClass('entry-content');
        var divThumb = $('<div/>').addClass('project-thumb');
        var aThumb = $('<a/>').attr({href:urProjeto});
        var imgThumb = $('<img/>').attr({src:data.urlImagemThumb});
        var divProjectDescription = $('<div/>').addClass('project-description');
        var pShortDescription = $('<p/>').html(data.descricaoCurta);


        divThumb.append(aThumb.append(imgThumb));
        divProjectDescription.append(pShortDescription);
        divBody.append(divThumb,divProjectDescription);

        article.append(divBody);

        //footer

        var footer = $('<footer/>').addClass('entry-meta project-meta').html(data.labelTempoRestante);

        var spanPrice = $('<span />').addClass('price project-price').html(' ' + data.valorArrecadadoFormatado)
        var spanCurrencySymbol = $('<span />').addClass('currency-symbol').html('R$');
        
        spanPrice.prepend(spanCurrencySymbol)
        footer.append(spanPrice);
        
        if(data.statusArrecadacao == statusArrecadacao.STATUS_EM_ANDAMENTO){
            var spanProgress = $('<span />').addClass('progress-status project-progress-status');
            var spanProgressBarContainer = $('<span />').addClass('progress-bar-container');
            var spanProgressBar = $('<span />').addClass('progress-bar').width(data.percentual+'%');
            var spanProgressNumber = $('<span/>').addClass('progress-number').html(data.percentual+'%');
            if(parseFloat(data.percentual) > 91){
                spanProgressNumber.addClass('alternate-color');
            }
            
            spanProgress.append(spanProgressBarContainer);
            spanProgressBarContainer.append(spanProgressBar);
            spanProgressBar.append(spanProgressNumber);
            footer.append(spanProgress)
        }else if(data.statusArrecadacao == statusArrecadacao.STATUS_SUCESSO){
            var divSuccess = $('<div />').addClass('project-success-bar').html('<i class="icon icon-star icon-white"></i> Projeto financiado');
            footer.append(divSuccess)
        }else if(data.statusArrecadacao == statusArrecadacao.STATUS_INSUCESSO){
            var divFail = $('<div />').addClass('project-fail-bar').html('Projeto não financiado');
            footer.append(divFail)
        }else if(data.statusArrecadacao == statusArrecadacao.STATUS_AGUARDANDO_BOLETO){
            var divWaitingPayment = $('<div />').addClass('project-waitingPayment-bar').html('Aguardando boletos');
            footer.append(divWaitingPayment)
        }

        
        article.append(footer);

        return article;

    },
    flashMessage : function(message,type){
        if(!type){
            type = 'warning';
        }
        var classe = '';
        switch(type){
            case 'notice' :classe = 'alert-info';break;
            case 'error'  :classe = 'alert-error';break;
            case 'success':classe = 'alert-success';break;
        }
        var div = $("<div/>").addClass('flash-message alert ' + classe).html(message);
        var buttonClose = $('<button/>').addClass('close').attr('data-dismiss','alert').html('×');
        div.append(buttonClose);
        $(".flash-message-container").append(div);
        return div;
    }

});


$(document).ready(function(){
    $('.form-search').submit(function(){
        var pesquisa = $.trim($('.input-search').val().replace(/ /g, '+'));
        var action = $(this).attr('realAction');
        if(pesquisa == ''){
            $(this).attr('action',Routing.generate('projeto_descubra'));
        }else{
            $(this).attr('action',Routing.generate('projeto_descubraComSearch',{search:pesquisa}));
        }
    })
    $('input.input-search').typing({
        delay:400,
        stop:function(){
            var texto = $('.input-search').val();
            if(texto.length < 3){
                return false;
            }
            $('.input-search').addClass('inLoading');
            if($('#quickSearch:not(:visible)').size()){
                $('.quickSearchContent').removeAttr('style').show().animate({
                    height: 350
                },'normal');
            }
            var textoPesquisa = texto.replace(/ /g, '+');
            $('#quickSearch').find('li').remove();
            $.get(Routing.generate('projeto_search', {'search':textoPesquisa}),null,
            function(data){
                $('.input-search').removeClass('inLoading')
                $('#quickSearch').generateThumbs(data);

            },'json');
        }
    })
    $('input.input-search').focus(function(){
        $(this).addClass('input-searchAnimation');
    })
    $('.quickSearchContent .close').click(function(){
        $('.quickSearchContent').animate({
            height: 0
        }, 'fast', function(){
            $(this).removeAttr('style').hide()  ;
        })
        $('.input-search').val('');
    })
    if($.validationEngine){
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
    }
})


var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36977741-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script');ga.type = 'text/javascript';ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga, s);
})();



(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s);js.id = id;
js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=165519970207494";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

