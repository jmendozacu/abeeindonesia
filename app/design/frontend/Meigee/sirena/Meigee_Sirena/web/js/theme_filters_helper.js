define(['jquery'], function( $ ) {
    return function( config, element ) {
        'use strict';

        $( document ).ready( function() {
            moveCurrentFilters();

            if ( $('.block.filter').length ) {
                $('.filter-options-title').off().on( 'click', function( e ) {
                    e.preventDefault();
                    $(this).closest('.filter-options-item').toggleClass('active');
                } );
            }

        } );

        $( window ).on( 'resize', function() {
            moveCurrentFilters();
        } );

        function moveCurrentFilters() {
            var bodyNode = $('body'),
                filterBlock = $('#layered-filter-block'),
                filterBlockFilterCurrent = filterBlock.find('.block-content .filter-current'),
                filterBlockActions = filterBlock.find('.block-content .filter-actions'),
                filterBlockCurrent = $('#layered-filter-block-current'),
                toolbar = $('.toolbar.toolbar-products');

            if ( ( filterBlockFilterCurrent.length || filterBlockCurrent.length ) && !bodyNode.hasClass('page-layout-1column') ) {

                if ( !filterBlockCurrent.length && toolbar.length ) {
                    $('<div id="layered-filter-block-current" />').insertAfter( toolbar.first() );
                    filterBlockCurrent = $('#layered-filter-block-current');
                }

                if ( window.matchMedia('(min-width: 768px)').matches ) {

                    if ( filterBlockFilterCurrent.length ) filterBlockFilterCurrent.appendTo(filterBlockCurrent);
                    if ( filterBlockActions.length ) filterBlockActions.appendTo(filterBlockCurrent);
                    !$('#layered-filter-block #narrow-by-list').length ? filterBlock.addClass('empty') : filterBlock.removeClass('empty');

                } else {

                    if ( filterBlockCurrent.length ) {
                        $('#layered-filter-block-current .filter-actions').appendTo('#layered-filter-block .block-content');
                        $('#layered-filter-block-current .filter-current').prependTo('#layered-filter-block .block-content');
                        filterBlockCurrent.remove();
                    }

                    filterBlock.removeClass('empty');

                }

            } else if ( bodyNode.hasClass('page-layout-1column') && filterBlockFilterCurrent.length ) {

                if ( window.matchMedia('(min-width: 768px)').matches ) {
                    $('#layered-filter-block .filter-actions').appendTo('#layered-filter-block .filter-current');
                } else {
                    $('#layered-filter-block .filter-current .filter-actions').appendTo('#layered-filter-block .block-content');
                }

            } else {

                filterBlock.removeClass('empty');

            }

        }
    }
})