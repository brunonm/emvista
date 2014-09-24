var imagens = {

    cropParams: null,

    x: null,

    y: null,

    w: null,

    h: null,

    jcropApi: null,

    init: function(){
        imagens.getCropParams();
        imagens.events();
        imagens.handleEdit();
    },

    handleEdit: function(){
        if($('#projetoImagemId').val() > 0){
            imagens.finishCrop();
        }
    },

    events: function(){
        $('#fileupload').fileupload({
            dataType: 'json',
            formData: {
                submissaoId: $('#submissaoId').val()
            },
            done: function(e, data) {
                
                $('#upload-controls').removeLoading();
                alert(data.result.message);
                if (data.result.status) {
                    var img = $('<img>').attr({src: data.result.result.webPath, id: 'img-upload'});
                    $('#projetoImagemId').val(data.result.result.projetoImagemId);
                    $('#preview').html(img);
                    $('#preview').show();
                    $('#tipoProjetoImagemId').val(1);
                    imagens.startCrop();
                }
            },
            send: function(){
                $('#upload-controls').loading();
            }
        });

        $('#button-next-crop').click(imagens.handleButtonNextCrop);
        $('#button-new-upload').click(imagens.handleButtonNewUpload);
    },

    startCrop: function(){
        $('#upload-controls').hide();
        $('#navigate-buttons').hide();
        $('#crop-controls').show();
        $('#button-next-crop').show();
        $('#button-new-upload').show();
        imagens.messagesThumb();
        imagens.crop();
    },

    getCropParams: function(){
        $.post('/submissao/getCropParams', {}, function(data){
            imagens.cropParams = data;
        }, 'json');
    },

    crop: function(){
        var tipo = $('#tipoProjetoImagemId').val();
        $('#img-upload').Jcrop({
            onSelect:    imagens.handleCropEventSelect,
            onRelease:   imagens.handleCropEventRelease,
            aspectRatio: imagens.cropParams[tipo].aspectRatio,
            minSize:    [imagens.cropParams[tipo].largura, imagens.cropParams[tipo].altura],
            maxSize:    [0, 0]
        }, function(){
            imagens.jcropApi = this;
        });
    },

    handleCropEventSelect: function(coords){
        $('#button-next-crop').attr('disabled', false);
        imagens.x = coords.x;
        imagens.y = coords.y;
        imagens.w = coords.w;
        imagens.h = coords.h;
    },

    handleCropEventRelease: function(coords){
        $('#button-next-crop').attr('disabled', true);
    },

    messagesThumb: function(){
        $('#crop-controls p:first').html('<strong>Recorte de miniatura</strong>');
        $('#crop-controls p:last').html('Selecione a área da imagem que deseja utilizar para as miniaturas do site.');
    },

    messagesFinal: function(){
        $('#crop-controls p:first').html('<strong>Imagens concluídas!</strong>');
        $('#crop-controls p:last').html('Pressione o botão "Avançar" para continuar o cadastro ou em "Novo upload" para cancelar e enviar nova imagem.');

    },

    handleButtonNextCrop: function(){
        var submissaoId = $('#submissaoId').val();
        var params = {
            projetoImagemId: $('#projetoImagemId').val(),
            tipoProjetoImagemId: $('#tipoProjetoImagemId').val(),
            x: imagens.x,
            y: imagens.y,
            w: imagens.w,
            h: imagens.h
        }
        $.post('/submissao/' + submissaoId + '/salvar-crop', params, function(data){
            if(data.status){
                $('#button-next-crop').attr('disabled', true);
                imagens.finishCrop();
                return;
            }else{
                alert(status.message);
            }
        }, 'json');
    },

    handleButtonNewUpload: function(){
        $('#button-avancar').attr('disabled', true);
        $('#crop-controls').hide();
        $('#button-next-crop').hide();
        $('#button-new-upload').hide();
        $('#upload-controls').show();
        $('#preview').hide();
    },

    finishCrop: function(){
        $('#crop-controls').show();
        $('#upload-controls').hide();
        imagens.messagesFinal();
        $('#button-next-crop').hide();
        $('#button-new-upload').show();
        $('#navigate-buttons').show();
        $('#button-avancar').attr('disabled', false);
        if(imagens.jcropApi != null){
            imagens.jcropApi.release();
        }
    }
}

$(document).ready(function(){
    imagens.init();
});