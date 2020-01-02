define([
    'jquery'
], function ($) {
    'use strict';

    return function (widgetSlider) {

        $.widget('meigee.widgetSlider', widgetSlider, {
            afterSliderInit: function () {
                this._super();
                this.checkSlidesVisibility();
            },
            checkSlidesVisibility: function () {
                var sliderInstance = $(this.element)[0].swiper,
                    options = this.getOptions(),
                    slidesPerView = parseInt(options.slidesPerView);

                if ($(this.element).hasClass('swiper-container-rtl')) {
                    var visibleSlidesOnInit = sliderInstance.visibleSlides,
                        visibleSlidesQtyOnInit = parseInt(sliderInstance.visibleSlides.length),
                        lastVisibleSlideOnInit = visibleSlidesOnInit.eq(visibleSlidesQtyOnInit - 1);
                    if (slidesPerView !== visibleSlidesQtyOnInit) {
                        $(lastVisibleSlideOnInit).removeClass('swiper-slide-visible');
                    }
                }

                sliderInstance.on('transitionEnd', function () {
                    var visibleSlides = sliderInstance.visibleSlides,
                        visibleSlidesQty = parseInt(sliderInstance.visibleSlides.length),
                        firstVisibleSlide = visibleSlides.eq(0),
                        lastVisibleSlide = visibleSlides.eq(visibleSlidesQty - 1);

                    if (slidesPerView !== visibleSlidesQty) {
                        var itemToHide = null;
                        if (visibleSlides.eq(slidesPerView).length && $(firstVisibleSlide).hasClass('swiper-slide-prev')) {
                            itemToHide = firstVisibleSlide;
                        }
                        if (visibleSlides.eq(slidesPerView).length && !$(firstVisibleSlide).hasClass('swiper-slide-prev')) {
                            itemToHide = lastVisibleSlide;
                        }
                        if (visibleSlides.eq(slidesPerView + 1).length) {
                            itemToHide = visibleSlides.eq(slidesPerView + 1)[0];
                        }
                        $(itemToHide).removeClass('swiper-slide-visible');
                    }
                });

            }
        });

        return $.meigee.widgetSlider;
    }
});