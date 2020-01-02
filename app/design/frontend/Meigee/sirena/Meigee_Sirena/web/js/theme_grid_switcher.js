define(['jquery','Meigee_Sirena/js/theme_more_views_sliders','mage/cookies','domReady!'], function( $, moreViewsSliders ) {
    return function( config, element ) {
        'use strict';

        var productList = $('.products.wrapper.products-grid'),
            classesProductList = ["columns-1", "columns-2", "columns-3", "columns-4", "columns-5", "columns-6", "columns-7", "columns-8"],
            switchItem = $(element).find('.item'),
            cookieColumns = '';

        if ( window.matchMedia('(min-width: 801px)').matches ) switchItem = switchItem.not( $('.mobile') );

        function changeSwitcher() {
            switchItem.on( 'click', function() {
                var switchCurrentData = $(this).data('grid-switcher');

                if ( !$(this).hasClass('current') ) {
                    switchItem.removeClass('current');
                    $(this).addClass('current');
                    removeCookie();
                    setCookie( switchCurrentData );
                    listingGridSwitch( switchCurrentData );
                }
                moreViewsSliders.reinitMoreViewsProductSliders();
            });
        }

        function loadSwitcherCurrent() {
            var cookieColumns = getCookie(),
                currentSwitch = $('.modes').find('[data-grid-switcher="'+cookieColumns+'"]');

            switchItem.removeClass('current');

            if ( window.matchMedia('(min-width: 1008px)').matches ) {
                if ( !currentSwitch.length || currentSwitch.is( $('.mobile') ) ) {

                    switchItem.first().addClass('current');
                    cookieColumns = $('.modes .item.current').not( $('.mobile') ).data('grid-switcher');
                }
            } else if ( window.matchMedia('(min-width: 768px)').matches ) {
                if ( !cookieColumns || cookieColumns === 'undefined' || cookieColumns !== 'columns-4' ) cookieColumns = 'columns-4';
            } else {
                if ( !cookieColumns || cookieColumns === 'undefined' || ( cookieColumns !== 'columns-1' && cookieColumns !== 'columns-2' ) ) cookieColumns = 'columns-2';
            }

            currentSwitch.addClass('current');
            removeCookie();
            setCookie( cookieColumns );
            listingGridSwitch( cookieColumns );
            moreViewsSliders.reinitMoreViewsProductSliders();
        }

        function getCookie() {
            return $.mage.cookies.get('sirenaListingGridSwitcher');
        }

        function removeCookie() {
            $.mage.cookies.clear('sirenaListingGridSwitcher');
        }

        function setCookie( columns ) {
            $.mage.cookies.set('sirenaListingGridSwitcher', columns, {
                expires: null,
                domain: window.location.host,
                path: '/'
            });
        }

        function listingGridSwitch( switchCurrentData ) {
            cookieColumns = getCookie();
            $.each( classesProductList, function( index, columns ) {
                productList.removeClass(columns);
            } );
            !cookieColumns ? productList.addClass(switchCurrentData) : productList.addClass(cookieColumns);
        }

        loadSwitcherCurrent();
        changeSwitcher();

    }
})