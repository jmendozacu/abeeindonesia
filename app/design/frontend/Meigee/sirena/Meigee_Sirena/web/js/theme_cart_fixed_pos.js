define(['jquery','domReady!'], function( $ ) {
    return function (config, element) {
        'use strict';

        var minicartBtn = $('.minicart-wrapper.fixed-right-pos .showcart');

        $('.minicart-wrapper.fixed-right-pos .block-minicart').prepend('<span class="close-fixed-cart"/>');
        $('.close-fixed-cart').on('click', function () {
            $('.block.block-minicart').dropdownDialog('close');
            $('body').removeClass('fixed-cart-open');
        });
        minicartBtn.on('click', function () {
            if ($(this).hasClass('active')) {
                $('body').addClass('fixed-cart-open');
            }
        });
        $(document).click(function(event) {
            var target = $(event.target);
            if(!target.closest('.minicart-wrapper.fixed-right-pos').length && $('body').hasClass('fixed-cart-open')) {
                $('body').removeClass('fixed-cart-open');
            }
        });

    }
})
