define(['jquery'], function( $ ) {
    return function( config, element ) {
        'use strict';

        var boxReadMore = $(element),
            collapseOpen = boxReadMore.attr('data-collapse-open'),
            textReadMore = boxReadMore.attr('data-text-read-more'),
            textCollapse = boxReadMore.attr('data-text-collapse'),
            showEllipsis = boxReadMore.attr('data-show-ellipsis'),
            keepHtml = boxReadMore.attr('data-keep-html'),
            maxLength = Math.abs(boxReadMore.attr('data-max-length'));

        if ( boxReadMore.length ) {

            if ( collapseOpen != 'true' && collapseOpen != 'false' ) collapseOpen = 'true';
            if ( !textReadMore ) textReadMore = 'Read More';
            if ( !textCollapse ) textCollapse = 'Less';
            if ( showEllipsis != 'true' && showEllipsis != 'false' ) showEllipsis = 'true';
            if ( keepHtml != 'true' && keepHtml != 'false' ) keepHtml = 'false';
            if ( !maxLength && maxLength!==0 ) maxLength = '150';

            if ( boxReadMore.text().length > maxLength ) {
                if ( keepHtml=='true' && maxLength ==0 ) {
                    var visibleText = '',
                        ellipsis = '',
                        hiddenText = boxReadMore.html();
                } else {
                    var boxText = boxReadMore.text(),
                        visibleText = boxText.substr(0, maxLength),
                        hiddenText = boxText.substr(maxLength),
                        ellipsis = '';
                }
                if ( collapseOpen == 'true' ) boxReadMore.addClass('is-hide');
                if ( showEllipsis == 'true' ) ellipsis = '<span class="clamp">...</span>';

                boxReadMore.html(visibleText+ellipsis+
                    '<span class="box-read-more__hide">'+hiddenText+'</span>'+
                    '<a href="javascript:void(0);" class="js-read-more link-switch">'+
                    '<span class="label-read-more">'+textReadMore+'</span>'+
                    '<span class="label-collapse">'+textCollapse+'</span>'+
                    '</a>');

                var linkReadMore = $('.js-read-more');

                linkReadMore.on( 'click', function( e ) {
                    e.preventDefault();

                    $(this).closest(boxReadMore).toggleClass('is-hide');

                } );
            }
        }
    }
})