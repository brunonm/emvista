$.fn.extend({
    limitTextArea : function(limit,params){
        if(!limit){
            limit = 120;
        }
        var defaults = {
            element : null,
            onTextChange : function(length,limit,event){
                length = length < 0 ? 0 : length;
                $(params.element).html(length + '/' + limit);
            },
            colors: {
                110:'#F00',
                85:'#FFD100',
                0:'#333'
            },
            changeColors : false
        }

        var params = $.extend(defaults,params);

        $(this).bind('keypress keydown blur keyup past focus',function(event){
            var length = $(this).val().length;
            if(length > limit){
                $(this).val($(this).val().substring(0 , limit));
            }
            params.onTextChange(length, limit, event);
            if(params.changeColors){
                for(var i in params.colors){
                    if(length > i){
                        $(params.element).css('color',params.colors[i]);
                    }
                }
            }
        })
        $(this).bind('keypress');
    }
})