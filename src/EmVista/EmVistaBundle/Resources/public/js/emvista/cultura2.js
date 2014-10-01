(function($){

    /* ---------------------------------------------- /*
     * Preloader
     /* ---------------------------------------------- */

    $(window).load(function() {
        $('#status').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
    });

    $(document).ready(function() {

        $('body').scrollspy({
            target: '.navbar-custom',
            offset: 50
        })

        $('a[href*=#]').bind("click", function(e){
            var anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top
            }, 1000);
            e.preventDefault();
        });


        /* ---------------------------------------------- /*
         * Navbar
         /* ---------------------------------------------- */

        var navbar = $('.navbar');
        navbar.addClass('navbar-color');
        var navHeight = navbar.height();


        if($(window).width() <= 767) {
            navbar.addClass('custom-collapse');
        }

        $(window).resize(function() {
            if($(this).width() <= 767) {
                navbar.addClass('custom-collapse');
            }
            else {
                navbar.removeClass('custom-collapse');
            }
        });

    });

})(jQuery);
