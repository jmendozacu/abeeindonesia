define(['jquery', 'Magento_Ui/js/modal/modal', 'mage/cookies'], function( $, modal ) {
    return function( config, element ) {
        'use strict';

        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            modalClass: 'popup-block-modal',
            buttons: false,
        };
        var popupBlock = $(element);
        var subscribePopup = modal(options, popupBlock);
        var subscribeFlag = $.mage.cookies.get('popupFlag');
        var custom_expire = popupBlock.data('expires');
        var cookieExpires = Math.abs( parseInt( custom_expire ) );
        // Set expires cookie: if 0 = 10 years, else if undefined = 30 days
        cookieExpires = cookieExpires == 0 ? 3650 : typeof cookieExpires == 'undefined' ? 30 : cookieExpires;
        cookieExpires = new Date( new Date().getTime() + cookieExpires * 1000 * 60 * 60 * 24 );

        $(document).ready( function() {
            popupBlock.show();
            popupBlock.find('.action.subscribe').on( 'click', function() {
                if (!popupBlock.find('.mage-error').length && !$('#subscribecheck').attr('aria-invalid')) {

                    $.mage.cookies.set('popupSubscribe', 'true', {
                        expires: new Date( new Date().getTime() + 30 * 1000 * 60 * 60 * 24 ),
                        domain: window.location.host,
                        path: '/'
                    } );

                } else {
                    $.mage.cookies.clear('popupSubscribe');
                }
            } );

            if (!subscribeFlag && !$.mage.cookies.get('popupSubscribe')) {
                popupBlock.modal('openModal');
            } else {
                $.mage.cookies.clear( 'popupFlag' );
                subsSetCookie();
            }

            popupBlock.parents('body').css('overflow', 'visible');

            popupBlock.find('.popup-bottom input').on( 'click', function() {
                $.mage.cookies.clear( 'popupFlag' );
                if ($(this).parent().find('input:checked').length) {
                    subsSetCookie();
                }
            } );

        } );

        function subsSetCookie() {
            $.mage.cookies.set( 'popupFlag', 'true', {
                expires: cookieExpires,
                domain: window.location.host,
                path: '/'
            } );
        }

        var bg_img_src = popupBlock.find('.popup-content-wrapper').data('bgimg'),
            popup_content_color = popupBlock.find('.popup-content-wrapper').data('content-color');

        if (bg_img_src && bg_img_src!='') {
            popupBlock.find('.popup-content-wrapper').css('background-image', 'url('+bg_img_src+')');
        }
        if (popup_content_color && popup_content_color!='') {
            popupBlock.find('.popup-content-wrapper').css('color', popup_content_color);
        }

    }
})