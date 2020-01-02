define(['jquery'], function( $ ) {
    return function( config, element ) {
        'use strict';

        var button = $(element),
            sidebar = $('.sidebars-wrapper.sliding');

        if ( !button.parents('.bottom-toolbar').length ) {
            var overlay = button.next();
            sidebar.prepend('<button class="close"><i class="meigee-icon-nav-close"></i><span>Close</span></button>');

            /* Show Sidebar on toggler click */
            button.off().on('click', function () {
                /* Add body overflow:hidden for proper scrolling on mobile devices */
                if ( window.matchMedia("(max-width: 767px)").matches ) {
                    if (sidebar.hasClass('open')) {
                        overlay.removeClass('visible');
                        sidebar.removeClass('open');
                        $('body').css('overflow', 'auto');
                    } else {
                        overlay.addClass('visible');
                        sidebar.addClass('open');
                        $('body').css('overflow', 'hidden');
                    }
                } else {
                    if (sidebar.hasClass('open')) {
                        overlay.removeClass('visible');
                        sidebar.removeClass('open');
                    } else {
                        overlay.addClass('visible');
                        sidebar.addClass('open');
                    }
                }
            });
            /* Close Sidebar on overlay click */
            overlay.off().on('click', function () {
                /* Add body overflow:hidden for proper scrolling on mobile devices */
                if ( window.matchMedia("(max-width: 767px)").matches ) {
                    $(this).removeClass('visible');
                    sidebar.removeClass('open');
                    $('body').css('overflow', 'auto');
                } else {
                    $(this).removeClass('visible');
                    sidebar.removeClass('open');
                }
            });
            /* Close Sidebar on "close" button click */
            sidebar.find('.close').off().on('click', function () {
                /* Add body overflow:hidden for proper scrolling on mobile devices */
                if ( window.matchMedia("(max-width: 767px)").matches ) {
                    overlay.removeClass('visible');
                    sidebar.removeClass('open');
                    $('body').css('overflow', 'auto');
                } else {
                    overlay.removeClass('visible');
                    sidebar.removeClass('open');
                }
            });
        }
    }
})