define(['jquery', 'meigeeSwiper'], function( $, Swiper ) {
    'use strict';

    return {
        moreViewsProductSliders: function(element) {
            var slider = $(element);
            var slider_options = {
                loop: false,
                slidesPerView: 1,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            };
            if (slider.data('swiper-dots')) {
                slider_options['pagination'] = {
                    el: '.swiper-pagination',
                    clickable: true
                };
            }

            var moreViewsSlider = new Swiper(slider, slider_options);
            return moreViewsSlider;
        },

        reinitMoreViewsProductSliders: function() {
            $('.product-item-info.with-carousel').each(function() {
                var moreViewsSlider = $(this).find('.swiper-container')[0].swiper;
                if (typeof moreViewsSlider !=='undefined') {
                    moreViewsSlider.update();
                }
            });
        },
    };

});