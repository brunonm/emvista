$(window).scroll(function()
{
    if($(window).scrollTop()  >= $(document).height() - $(window).height() - $('#footer').height() - 100)
    {
        $('div#loadMoreAjaxLoader').show();
        $.ajax({
            url: Routing.generate('ge'),
            data: {
                quantidadeProjetos: 8,
                ultimoProjeto: $('.project-container:last').attr('project-id')
            },
            success: function(html)
            {
                if(html)
                {
                    $("#postswrapper").append(html);
                    $('div#loadmoreajaxloader').hide();
                }else
                {
                    $('div#loadmoreajaxloader').html('<center>No more posts to show.</center>');
                }
            }
        });
    }
});