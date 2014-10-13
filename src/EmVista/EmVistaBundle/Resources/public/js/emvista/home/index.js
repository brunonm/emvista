var loadingMore = true;
$(window).scroll(function()
{
    if($(window).scrollTop()  >= $(document).height() - $(window).height() - $('#footer').height() - 100 && loadingMore)
    {
        loadingMore = false;
        $('div#loadMoreAjaxLoader').show();
        $.ajax({
            url: Routing.generate('projeto_get-more'),
            data: {
                count: 8,
                lastProjectId: $('.project-container:last').attr('project-id')
            },
            method: 'post',
            type: 'json',
            success: function(data)
            {

                if(data) {
                    for (var i in data) {
                        var projeto = data[i];
                        $('#projects .container .row').append($.thumbProjeto(projeto));
                    }
                }
                $('div#loadMoreAjaxLoader').hide();
                if (data.length == 8) {
                    loadingMore = true;
                } else {

                }

            }
        });
    }
});