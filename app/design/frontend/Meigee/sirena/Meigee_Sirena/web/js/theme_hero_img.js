define(['jquery','domReady!'], function( $ ) {
    return function() {
        'use strict';

        var scroll_duration = 500,
            scroll_element = $('.page-header'),
            scroll_btn = $('.scroll-to-content');

        scroll_btn.on('click', function(e){
            e.preventDefault();
            $('body,html').animate({
                    scrollTop: (scroll_element.offset().top),
                }, scroll_duration
            );
        });

    }
})