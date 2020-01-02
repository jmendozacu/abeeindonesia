define(['jquery','meigeeSwiper','domReady!'], function( $, Swiper ) {
    return function( config ) {
        'use strict';

        var toggleReviews = $('.js-toggle-reviews'),
            defaultTextLink = toggleReviews.text(),
            toggleTextLink = config.toggleText,
            reviewsCount = config.reviewsCount;

        /* Reviews Carousels */
        function reviewsCarousel() {
            if (reviewsCount > 3) {
                var slider = $('.review-list .block-content'),
                    navigation = slider.data("navigation"),
                    pagination = slider.data("pagination"),
                    items = slider.data("items"),
                    isRTL = slider.data("rtl");

                toggleReviews.removeClass('hidden');
                
                if ($('body').hasClass('page-layout-3columns')) {
                    items = 1;
                }

                var sliderConfig = {
                    loop: false,
                    slidesPerView: items,
                    breakpoints: {
                        1024: {
                          slidesPerView: items,
                        },
                        801: {
                          slidesPerView: 2,
                        },
                        767: {
                          slidesPerView: 1,
                        }
                    }
                };
                if (navigation) {
                    sliderConfig['navigation'] = {
                        nextEl: '.review-list .block-content .swiper-button-next',
                        prevEl: '.review-list .block-content .swiper-button-prev'
                    };
                }
                if (pagination) {
                    sliderConfig['pagination'] = {
                        el: '.review-list .block-content .swiper-pagination',
                        clickable: true
                    };
                }

                var reviewsSlider = new Swiper (slider,sliderConfig);            

                /* Read All Reviews Toggler */
                if (toggleReviews.length) {
                    toggleReviews.toggle(function (e) {
                        e.preventDefault();
                        $(this).text(toggleTextLink);
                        slider.find('.swiper-button-prev').addClass('hidden');
                        slider.find('.swiper-button-next').addClass('hidden');
                        slider[0].swiper.destroy();
                        slider.removeClass('swiper-container').find('.customer-reviews-wrapper').removeClass('swiper-wrapper');
                    }, function (e) {
                        e.preventDefault();
                        $(this).text(defaultTextLink);
                        slider.addClass('swiper-container').find('.customer-reviews-wrapper').addClass('swiper-wrapper');
                        slider.find('.swiper-button-prev').removeClass('hidden');
                        slider.find('.swiper-button-next').removeClass('hidden');
                        return new Swiper (slider,sliderConfig);
                    });
                }
            }
        }
        reviewsCarousel();

        /* Proper reviews anchors */
        $('.product-info-main .reviews-actions a').on('click', function(event){
            event.preventDefault();
            var anchor = $(this).attr('href').replace(/^.*?(#|$)/, '');
            $('html, body').animate({
                scrollTop: $( '#' + anchor ).offset().top - 100 }, 500);
        });

    }
})
