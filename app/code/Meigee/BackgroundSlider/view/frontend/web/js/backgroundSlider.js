define(['jquery', 'Backstretch', 'domReady!'], function($) {
    return function(config) {
        'use strict';

        function bgSlider() {
            if (window.matchMedia('(min-width:' + config.containerWidth + 'px)').matches) {
                $.backstretch(config.slides.split(','), {
                    duration: config.duration * 1000,
                    fade: config.fade * 1000
                });
            } else {
                var bgSlider = $('.backstretch');

                if (bgSlider.length) bgSlider.remove();
            }
        }

        bgSlider();

        $(window).on('resize', function() {
            bgSlider();
        });
    }
});