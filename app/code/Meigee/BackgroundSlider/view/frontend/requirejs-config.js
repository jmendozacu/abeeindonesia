var config = {
    map: {
        '*': {
            Backstretch: 'Meigee_BackgroundSlider/js/lib/jquery.backstretch'
        }
    },
    paths: {
        Backstretch: 'Meigee_BackgroundSlider/js/lib/jquery.backstretch'
    },
    shim: {
        Backstretch:{
            deps: ['jquery'],
            exports: 'jQuery.fn.backstretch',
        }
    }
};
