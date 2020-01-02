define(['jquery'], function( $ ) {
    return function( config, element ) {
        'use strict';

        if ( window.matchMedia("(min-width: 801px)").matches ) {
            $(document).ready(function () {

                // Populate images from data attributes.
                var scrolled = $(window).scrollTop();
                $(element).each(function (index) {
                    var imageSrc = $(this).data('image-src');
                    var imageHeight = $(this).data('height');
                    $(this).css('background-image', 'url(' + imageSrc + ')');
                    $(this).css('height', imageHeight);

                    // Adjust the background position.
                    var initY = $(this).offset().top;
                    var height = $(this).height();
                    var diff = scrolled - initY;
                    var ratio = Math.round((diff / height) * 100);
                    $(this).css('background-position', 'center ' + parseInt(-(ratio * 1.5)) + 'px');
                });

                // Attach scroll event to window. Calculate the scroll ratio of each element
                // and change the image position with that ratio.
                $(window).scroll(function () {
                    var scrolled = $(window).scrollTop();
                    $(element).each(function (index, element) {
                        var initY = $(this).offset().top;
                        var height = $(this).height();
                        var endY = initY + $(this).height();

                        // Check if the element is in the viewport.
                        var visible = isInViewport(this);
                        if (visible) {
                            var diff = scrolled - initY;
                            var ratio = Math.round((diff / height) * 100);
                            $(this).css('background-position', 'center ' + parseInt(-(ratio * 0.9)) + 'px');
                        }
                    })
                })
            })
        } else {
            $(element).each(function (index) {
                if ( window.matchMedia("(max-width: 767px)").matches ) {
                    var imageSrc = $(this).data('image-src-small');
                } else {
                    imageSrc = $(this).data('image-src');
                }
                var imageHeight = $(this).data('height');
                $(this).css('background-image', 'url(' + imageSrc + ')');
                $(this).css('height', imageHeight);
            });
        }

        // Check if the element is in the viewport.
        function isInViewport(node) {
            var rect = node.getBoundingClientRect();
            return (
                (rect.height > 0 || rect.width > 0) &&
                rect.bottom >= 0 &&
                rect.right >= 0 &&
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.left <= (window.innerWidth || document.documentElement.clientWidth)
            )
        }
    }
})