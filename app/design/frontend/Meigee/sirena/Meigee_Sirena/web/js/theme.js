require(['jquery','domReady!'], function ($) {

    /* Special Class for Mobile Devices */
    if (/Mobi|Android/i.test(navigator.userAgent)) {
        $('body').addClass('mobile-device');
    }

    /* Replacing Blog Posts featured imgs src */
    if ($('.post-list-wrapper').length > 0 && window.matchMedia("(min-width: 768px)").matches) {
        $('.post-list-wrapper .post-list li.post-holder:nth-child(3n+1)').each(function(){
            var featured_img = $(this).find('.post-featured-img');
            var big_img_src = featured_img.data('large-img');
            featured_img.attr('src',big_img_src);
        });
    }

    /* Fix for banner links in mobile mega menu */
    $("#mobile-nav .menu-banners a").click(function(e){
        location.href = this.href;
    });

    /* Calc browser scrollbar for proper full width blocks */
    function handleWindow() {
        var body = document.querySelector('body');
        if (window.innerWidth > body.clientWidth + 5) {
            body.classList.add('has-scrollbar');
            body.setAttribute('style', '--scroll-bar: ' + (window.innerWidth - body.clientWidth) + 'px');
        } else {
            body.classList.remove('has-scrollbar');
        }
    }
    if ( window.matchMedia("(min-width: 1300px)").matches ) {
        handleWindow();
    }

});
