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
         * Background image
         /* ---------------------------------------------- */

        if (window.location.pathname == Routing.generate('home_index')) {
            $('#intro').backstretch([Routing.getBaseUrl() + '/bundles/emvista/images/background.png']);
        }

        /* ---------------------------------------------- /*
         * Navbar
         /* ---------------------------------------------- */

        var navbar = $('.navbar');

        if (window.location.pathname == Routing.generate('home_index')) {
            navbar.removeClass('navbar-color');
            $('#content').css('padding-top', 0);
            var navHeight = navbar.height();
            $(window).scroll(function() {
                if($(this).scrollTop() >= navHeight) {
                    navbar.addClass('navbar-color');
                }
                else {
                    navbar.removeClass('navbar-color');
                }
            });
        }
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
