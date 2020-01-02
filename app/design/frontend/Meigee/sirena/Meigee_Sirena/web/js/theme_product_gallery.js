define(['jquery', 'mage/gallery/gallery'], function( $, $mageGallery ) {
    return function( config, element ) {
        'use strict';

        $(element).on('gallery:loaded', function () {
            var api = $(element).data('gallery');
            var rtlEnabled = config.rtlEnabled;

            /* RTL support */
            if (rtlEnabled == "rtl-enabled") {
                api.fotorama.setOptions({
                    direction: "rtl"
                });
            }

            /* Large More Views */
            if ($(element).hasClass('more-views-large')) {
                $(this).on('click', '.fotorama__nav__frame', function(e) {
                    api.fotorama.requestFullScreen();
                });
            }

            /* Show more views for List Mode */
            if ($(element).hasClass('collapsed')) {
                var thumbs = $(element).find('.fotorama__nav-wrap');
                $('.product.media .action-collapse').off().on('click', function () {
                    $(this).toggleClass('show');
                    thumbs.toggleClass('is-open');
                });
            }
        });
    }
})