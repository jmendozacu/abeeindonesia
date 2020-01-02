define(['jquery', 'Magento_Ui/js/modal/modal'], function( $, modal ) {
    return function( config, element ) {
        'use strict';

        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            buttons: false,
            closed: function(){
                $(element).html('');
            }
        };
        var meigeeCustomPopup = modal(options, $(element));

        $('*[data-toggle="modal"]').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            var content = $(document).find(target).children().clone();
            $(element).html(content);
            $(element).modal('openModal');
        });

        $('*[data-toggle="lightbox"]').on('click', function(e) {
            e.preventDefault();
            var img_target = $('<img />', {
                class: 'img-responsive',
                src: $(this).attr('href'),
                alt: $(this).data('footer')
            });
            $(element).html(img_target);
            $(element).modal('openModal');
        });

    }
})