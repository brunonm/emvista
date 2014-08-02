$(document).ready(function(){
    $.extend({
        activeLi:function(){
            var url = window.location.pathname.split('/');
            $('ul.rightBarDiscovery li[categoria="'+url[3]+'"]').activeLi()
        }
    })
    $.fn.extend({
        activeLi:function(){
            $('.active').removeClass('active');
            $(this).addClass('active');
        }
    })
    $.activeLi();
    $('.rightBarDiscovery a').click(function(){
        var path = $('#normalPath').val();
        var texto = '';
        var url = '';
        
        if($.trim($('#inputSearch').val()) != ''){
            texto = $('#inputSearch').val()+' ';
        }
        if($(this).parent().hasClass('active')){
            $('.active').removeClass('active');
        }else{
            texto += $(this).parent().attr('categoria');
            $(this).parent().activeLi();
        }
        
        if(texto != ''){
            path += '/'+texto;
            url = Routing.generate('projeto_search',{search: texto.replace(' ','+')});
        }else{
            url = Routing.generate('projeto_listarJson');
        }
        window.history.pushState("","", path);
        
        
        $('.project-listing').loading();
        $.get(url,null,
            function(data){ 
                $('.project-listing').removeLoading().html('<div class="span9"></div>').generateThumbs(data);
            },'json');
    })
})