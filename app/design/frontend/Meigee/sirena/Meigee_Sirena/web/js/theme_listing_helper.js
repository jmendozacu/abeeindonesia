define(['jquery','Meigee_Sirena/js/theme_more_views_sliders','domReady!'], function( $, moreViewsSliders ) {
    return function() {
        'use strict';

        var hoverImage = function(){
            $('img.product-image-photo').each(function(){
                if($(this).data('hoverImage') && ($(this).data('hoverImage').indexOf('placeholder') == -1)){
                    var hover_img = $('<img />');
                    hover_img.addClass('hover-image');
                    hover_img.attr('src', $(this).data('hoverImage'));
                    hover_img.appendTo($(this).parent());
                    $(this).parents('.image-wrapper').addClass('hover-image');
                }
            });
        };

        $('.product-item-info.with-carousel').each(function(){
            var slider = $(this).find('.swiper-container');
            moreViewsSliders.moreViewsProductSliders(slider);
        });

        hoverImage();

    }
})