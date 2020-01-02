define(['jquery'], function( $ ) {
    return function( config, element ) {
        'use strict';

        var button = $(element),
            sidebar = $('.sidebars-wrapper'),
            top_position = $('.page-header').outerHeight();

        button.on('click', function(){
            sidebar.toggleClass('open');
        });

        if ( window.matchMedia("(max-width: 768px)").matches ) {
            if (!$('.hero-img-wrapper').length) {
                sidebar.css({
                    "top" : top_position + "px",
                    "height" : "calc(~'100vh - " + top_position + "px')",
                });
            }
            var sticky_top = sidebar.offset().top;
            /* New position on scroll */
            $(window).scroll(function() {
                var scroll_top = $(window).scrollTop();
                if ( scroll_top > sticky_top ) {
                    if ($(".page-header").hasClass("sticky-header")) {
                        sidebar.css({
                            "top" : top_position + "px",
                            "height" : "calc(~'100vh - " + top_position + "px')",
                        });
                    } else {
                        sidebar.css({
                            "top" : "0",
                            "height" : "100vh",
                        });
                    }
                } else {
                    if (!$('.hero-img-wrapper').length) {
                        sidebar.css({
                            "top": top_position + "px",
                            "height": "calc(~'100vh - " + top_position + "px')",
                        });
                    }
                }
            });
        }

        /* Close sidebar on outside click */
        $( document ).on( 'click', function( e ) {
            if ( !sidebar.is(e.target) && sidebar.has(e.target).length == 0 ) sidebar.removeClass('open');
        } );

        /* Add transition-disabled class on resize */
        $(window).bind("resize", function () {
            if (($(this).width() > 801)) {
                sidebar.addClass('transition-disabled');
            } else {
                sidebar.removeClass('transition-disabled');
            }
        }).trigger('resize');

    }
})