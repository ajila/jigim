/* main */
(function( $ ) {

    //将传送带的间隔时间初始化为 8000 毫秒。
    $( document ).ready(function() {
        $('#carousel-front-page').carousel({
            interval: 8000
        });
    });

})( jQuery );