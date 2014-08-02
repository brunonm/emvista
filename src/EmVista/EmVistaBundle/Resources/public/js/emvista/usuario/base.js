var coords = {
    x:0,
    y:0,
    w:0,
    h:0,
    escH:0,
    escW:0
};
$(document).ready(function(){
    $('.userImageProfile').hover(function(){
        $(this).find('.alterarImagem').show();
    },function(){
        $(this).find('.alterarImagem').hide();
    })
    $('.alterarImagem').click(function(){
        if($('#cropForm').css('display') == 'none'){
            $('#modalUploadImagem .modal-footer').hide();
        }
    })
    $('#modalUploadImagem').modal({
        show:false
    })
    $('#utilizeOutraFoto').click(function(){
        $.Jcrop('#imgCrop').destroy();
        $('#modalUploadImagem .modal-footer, #cropForm').hide();
        $('.uploadImageField').show();
        
    })
    var dropActiveInterval;
    
    
    $('.uploadImageField').fileupload({
        dataType: 'json',
        dropZone: $('.uploadImageField'),
        autoUpload:true,
        acceptFilesTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        send: function(){
            $('.uploadImageField').loading();
        },
        done: function (e, data) {
            var result = data.result;
            $('.uploadImageField').removeLoading();
            $('#modalUploadImagem .modal-footer').show();
            $('.uploadImageField').hide();
            $('#cropForm').show().html('');
            var img = $('<img alt="Profile" />').attr({src:result.url,id:'imgCrop','w':result.w,'h':result.h,
                                                        'o':result.name}).addClass('imagemProfile');
            $('#cropForm').append(img);
            $(img).load(function() {  
                var ch = $('#imgCrop')[0].clientHeight;
                var cw = $('#imgCrop')[0].clientWidth;
                var w = $('#imgCrop').attr('w');
                var h = $('#imgCrop').attr('h');
                var escH = Math.round(ch/h*100)/100;
                var escW = Math.round(cw/w*100)/100;
                coords.escH = escH;
                coords.escW = escW;
                $(this).Jcrop({
                    aspectRatio: 1,
                    minSize:[140*escW,140*escH],
                    setSelect:[0,0,140,140],
                    onSelect:function(coord){
                        coords.x = coord.x;
                        coords.y = coord.y;
                        coords.w = coord.w;
                        coords.h = coord.h;
                    }
                });
            });  
            
        },
        fail: function(e, data){
            
            $('.uploadImageField').removeLoading();
            $.flashMessage(data.result.message,'erro');

        }
    });
    $('.uploadImageField').bind('dragover', function (e) {
        $(this).addClass('active');
        clearInterval(dropActiveInterval);
        dropActiveInterval = setInterval(function(){
            $('.uploadImageField').removeClass('active');
            clearInterval(dropActiveInterval);
        }, 100);
    });
    $('#salvarImagem').click(function(){
        $('#cropForm').loading();
        $.post(Routing.generate('usuario_recortaImagemProfile'),$.extend(coords,{name: $('#imgCrop').attr('o')}),function(data){
            $('#cropForm').removeLoading();
            $('.userImageProfile a img').attr({src:data.url});
            $('#utilizeOutraFoto').click();
            $('#modalUploadImagem').modal('hide');
        },'json');
    });
});