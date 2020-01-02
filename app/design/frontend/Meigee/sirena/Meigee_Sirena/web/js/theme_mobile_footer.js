define(['jquery','domReady!'], function( $ ) {
    return function( config, element ) {
        'use strict';

        function initMobileFooter() {
            $('.accordion-list').each(function () {
                $(this).find('.accordion-title').each(function () {
                    if ($(this).find('.icon-more').length == 0) {
                        $(this).prepend('<span class="icon-more"><i class="icon-plus meigee-icon-plus"></i><i class="icon-minus meigee-icon-minus"></i></span>');
                    } else {
                        $(this).find('.icon-more').css('display', 'block');
                    }
                });
                $(this).find('.accordion-title').off().on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    if ($this.parent().hasClass('open')) {
                        $this.parent().removeClass('open');
                        $this.next().slideUp(350);
                    } else {
                        $this.closest('.accordion-list').find('.accordion-item.open .accordion-content').slideUp(350);
                        $this.closest('.accordion-list').find('.accordion-item.open').removeClass('open');
                        $this.parent().addClass('open');
                        $this.next().slideDown(350);
                    }
                });
            });
        }

        function destroyMobileFooter() {
            $('.accordion-list').each(function () {
                $(this).find('.accordion-title').each(function () {
                    $(this).find('.icon-more').css('display', 'none');
                });
                $(this).find('.accordion-item.open .accordion-content').removeClass('open');
                $(this).find('.accordion-item .accordion-content').each(function () {
                    $(this).css('display', '');
                });
            });
        }

        $(window).bind("resize", function () {
            if (($(this).width() < 992)) {
                initMobileFooter();
            } else {
                destroyMobileFooter();
            }
        }).trigger('resize');

    }
})