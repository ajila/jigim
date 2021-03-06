/* main */
(function( $ ) {

    $( document ).ready(function() {

        //** flickity initialize
        $('.main-carousel').flickity({
            // options
            cellAlign: 'center',
            contain: true,
            wrapAround: true,
            //autoPlay: 8000,
            dragThreshold: 1,
            //selectedAttraction: 0.9,
            //friction: 0.9,
            setGallerySize: false   //用CSS设置幻灯片的大小，而不是使用单元格的大小
        });
        $('.related-post-carousel').flickity({
            // options
            cellAlign: 'left',
            contain: true,
            wrapAround: false,
            //dragThreshold: 10,
            groupCells: 2,
            adaptiveHeight: true,
            lazyLoad: true
        });
        $('.gallery-carousel').flickity({
            // options
            cellAlign: 'center',
            contain: true,
            wrapAround: true,
            dragThreshold: 1,
            setGallerySize: false,   //用CSS设置幻灯片的大小，而不是使用单元格的大小
            lazyLoad: true
        });


        //** blazy initialize
        /*
        var bLazy = new Blazy({
            breakpoints: [{
                width: 768 // Max-width
                , src: 'data-src-small'
            },{
                width: 1200 // Max-width
                , src: 'data-src-middle'
            }]
            , container: '#carousel-front-page'
            , success: function(element){
                setTimeout(function(){
                    // We want to remove the loader gif now.
                    // First we find the parent container
                    // then we remove the "loading" class which holds the loader image
                    var parent = element.parentNode;
                    parent.className = parent.className.replace(/\bloading\b/,'');
                }, 200);
            }
        });
        */


        //** jQuery.lazyload initialize
        //避免重复初始化，放到picturefill.js中，当图片标签准备好后调用
        //lazyload();   //2.x版本用工厂模式
        /*
        $("img.lazyload").lazyload({      //1.9版本的初始化
            effect:"fadeIn",
            failurelimit:40,
            data_attribute: "src",  //1.x默认data-original，兼容1.x和2.x版本
            placeholder: null,
            load:f_masonry
        });
        */


        //** Infinite Scroll Initialize
        /*
        $('#main').infiniteScroll({
            //path: '.next',
            path: '/page/{{#}}',//下一页链接的选择器，或路径
            append: '.post',    //从加载的下一页中，选择添加入容器的元素
            checkLastPage: '.next',
            history: false,
            debug: true
        });
        */


        //** Masonry Initialize
        $('.masonry-layout').masonry({
            itemSelector: 'article',//'.post',
            columnWidth: '.masonry-layout-column-width',
            percentPosition: true
        });
/*
        $grid.imagesLoaded().progress( function() {
            $grid.masonry('layout');
        });
*/
        /*
        var $cnt = 0;
        $('.masonry-layout').imagesLoaded().progress( function( instance, image ) {
           // $grid.masonry('layout');
            $cnt+=1;
            var result = image.isLoaded ? 'loaded' : 'broken';
            if ('loaded' === result) {
                console.log('image is ' + result + ' for ' + image.img.src);
            }else {
                console.log('image is ' + result + ' for ' + image.img.getAttribute("data-src"));
            }
            console.log("imagesload cnt: %d", $cnt);
        });
        */



        //侧边弹出菜单的打开/关闭动画及按钮动画
        $('.navbar-header .navbar-toggle').bind("click", function(){
          side_nav_open(this);
        });
        $('.sidenav-header .navbar-toggle').bind("click", function(){
          side_nav_close(this);
        });

        /*  todo:用jquery的方法
        $('.widget .widget-header').bind("click", function(){
          //widget_toggle_btn(this.children(".widget-toggle"));
          this.next().slideToggle();
        } );
        */

        //侧边栏中widget的收缩/展开动画
        $('.widget_categories .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_categories .widget-toggle'));
            $('.widget_categories ul').slideToggle();
        } );

        $('.widget_tag_cloud .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_tag_cloud .widget-toggle'));
            $('.widget_tag_cloud .tagcloud').slideToggle();
        } );

        $('.widget_archive .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_archive .widget-toggle'));
            $('.widget_archive ul').slideToggle();
        } );


        $('.widget_meta .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_meta .widget-toggle'));
            $('.widget_meta ul').slideToggle();
        } );

        $('.widget_about_me .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_about_me .widget-toggle'));
            $('.widget_about_me .about-me-img').slideToggle();
        } );

        $('.widget_search .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_search .widget-toggle'));
            $('.widget_search .search-form').slideToggle();
        } );

        $('.widget_recent_entries .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_recent_entries .widget-toggle'));
            $('.widget_recent_entries ul').slideToggle();
        } );

        $('.widget_recent_comments .widget-header').bind("click", function(){
            widget_toggle_btn($('.widget_recent_comments .widget-toggle'));
            $('.widget_recent_comments ul').slideToggle();
        } );


        img_loaded_icon_setup();

        search_modal_init();

    });

})( jQuery );


/* 图片加载完成隐藏loading图标 */
function img_loaded_icon_setup() {
    var i, len, imgContainers, img;
    //文章列表特性图、首页slider等响应式图片的操作，在picturefill.js中

    //文章列表默认缩略图
    imgContainers = document.getElementsByClassName("post-image-attachment");
    for (i = 0 ,len = imgContainers.length; i<len; i++) {
        img = imgContainers[i].getElementsByTagName("img")[0];
        img.addEventListener("load", function(e){
            e.target.parentNode.getElementsByTagName("i")[0].style.display = "none";
        },false);
    }

    //文章列表video文章
    imgContainers = document.getElementsByClassName("entry-video");
    for (i = 0 ,len = imgContainers.length; i<len; i++) {
        img = imgContainers[i].getElementsByTagName("iframe")[0];
        img.addEventListener("load", function(e){
            e.target.parentNode.getElementsByTagName("i")[0].style.display = "none";
        },false);
    }

    //文章列表gallery文章
    imgContainers = document.querySelectorAll(".entry-gallery .carousel-cell");
    for (i = 0 ,len = imgContainers.length; i<len; i++) {
        img = imgContainers[i].getElementsByTagName("img")[0];
        img.addEventListener("load", function(e){
            e.target.parentNode.getElementsByTagName("i")[0].style.display = "none";
        },false);
    }

    //相关文章slider
    imgContainers = document.getElementsByClassName("related-post-item");
    for (i = 0 ,len = imgContainers.length; i<len; i++) {
        img = imgContainers[i].getElementsByClassName("carousel-cell-image")[0];
        img.addEventListener("load", function(e){
            e.target.parentNode.getElementsByTagName("i")[0].style.display = "none";
        },false);
    }
}

/* 搜索框模态对话框动画 */
function search_modal_init() {
    // Get the modal
    var modal = document.getElementById("searchModal");

    // Get the button that opens the modal
    var btn = document.getElementById("searchModalBtn");

    // Get the <span> element that closes the modal
    var close = document.getElementById("searchModalClose");

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    close.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

/* 打开和关闭导航条侧边菜单 */
function side_nav_toggle(btn) {

    btn.classList.toggle("change"); //导航条菜单开关的图标动画
    btn.classList.toggle("navbar-toggle-transition");

    document.getElementById("secondary").classList.toggle("sidenav-display");
    //document.getElementById("page").classList.toggle("main-push-right");

}

/* 打开侧边弹出菜单 */
function side_nav_open(btn) {
    //侧边弹出菜单开关按钮的动画
    //document.getElementById("sidenav-open-btn").classList.add("change");
    btn.classList.add("change");
    document.getElementById("sidenav-close-btn").classList.add("change");

    //侧边弹出菜单的动画
    document.getElementById("secondary").classList.add("sidenav-display");
    //document.getElementById("page").classList.add("main-push-right");
}

/* 关闭侧边弹出菜单 */
function side_nav_close(btn) {
    //侧边弹出菜单开关按钮的动画
    document.getElementById("sidenav-open-btn").classList.remove("change");
    //document.getElementById("sidenav-close-btn").classList.remove("change");
    btn.classList.remove("change");

    //侧边弹出菜单的动画
    document.getElementById("secondary").classList.remove("sidenav-display");
    //document.getElementById("page").classList.remove("main-push-right");
}

/* widget展开/折叠按钮动画 */
function widget_toggle_btn(btn) {
    //btn.classList.toggle("widget-toggle-rotate");
    btn.toggleClass("widget-toggle-rotate");
}