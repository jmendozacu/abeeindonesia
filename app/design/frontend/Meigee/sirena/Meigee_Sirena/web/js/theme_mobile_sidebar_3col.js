define(['jquery','domReady!'], function( $ ) {
    return function() {
        'use strict';

        if (window.matchMedia("(max-width: 768px)").matches) {
            if ($(".sidebar").length > 0) {
                $(".sidebar").wrapAll("<div class='sidebars-wrapper' />");
            }
            var top_position = $('.page-header').outerHeight();
            var sidebar = $(".sidebars-wrapper");
            sidebar.css({
                "top": top_position + "px",
                "height": "calc(~'100vh - " + top_position + "px')",
            }).wrapInner('<div class="inner-wrapper"></div>').prepend('<span class="mobile-sidebar-toggler" />');
            var sticky_top = sidebar.offset().top;
            $('.mobile-sidebar-toggler').on('click', function () {
                sidebar.toggleClass('open');
            });
            $(window).scroll(function () {
                var scroll_top = $(window).scrollTop();
                if (scroll_top > sticky_top) {
                    if ($(".page-header").hasClass("sticky-header")) {
                        sidebar.css({
                            "top": top_position + "px",
                            "height": "calc(~'100vh - " + top_position + "px')",
                        });
                    } else {
                        sidebar.css({
                            "top": "0",
                            "height": "100vh",
                        });
                    }
                } else {
                    sidebar.css({
                        "top": top_position + "px",
                        "height": "calc(~'100vh - " + top_position + "px')",
                    });
                }
            });
            $(document).on('click', function (e) {
                if (!sidebar.is(e.target) && sidebar.has(e.target).length == 0) sidebar.removeClass('open');
            });
        }

    }
})