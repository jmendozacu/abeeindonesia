define(['jquery'], function($) {
    return function( config, element ) {
        'use strict';

        var qty_el = $(element);
        var qty_value = qty_el.val();
        var qty_btn = qty_el.parent().find('.qty-button');

        qty_btn.on('click', function() {
            if ($(this).hasClass('quantity-decrease')) {
                qty_value = qty_el.val();
                if( !isNaN( qty_value ) && qty_value > 0 ){
                    qty_el.get(0).value--;
                }
            } else if ($(this).hasClass('quantity-increase')) {
                qty_value = qty_el.val();
                if( !isNaN( qty_value ) ){
                    qty_el.get(0).value++;
                }
            }
        });

    }
})