define(['jquery'], function($) {
    return function( config, element ) {
        'use strict';

        var qty_el = $('.input-text.qty');

        /* Add additional controls */
        qty_el.each(function(){
            var qty_el_wrapper = $(this).parent();
            qty_el_wrapper.prepend('<div class="quantity-decrease qty-button"><i class="meigee-icon-minus"></i></div>');
            qty_el_wrapper.append('<div class="quantity-increase qty-button"><i class="meigee-icon-plus"></i></div>');
        });

        /* Change qty on click */
        var qty_btn = qty_el.parent().find('.qty-button');
        qty_btn.each(function(){
            $(this).on('click', function() {
                var qty_input = $(this).parent().find('.input-text.qty');
                var qty_value = qty_input.val();
                if ($(this).hasClass('quantity-decrease')) {
                    if( !isNaN( qty_value ) && qty_value > 0 ){
                        qty_input.get(0).value--;
                    }
                } else if ($(this).hasClass('quantity-increase')) {
                    if( !isNaN( qty_value ) ){
                        qty_input.get(0).value++;
                    }
                }
            });
        });

    }
})