/*!
# Picturefill
A Responsive Images approach that you can use today that mimics the [proposed picture element]
(http://www.w3.org/TR/2013/WD-html-picture-element-20130226/) using `span`s, for safety sake.
使用响应式功能：为容器span添加.picture-fill
使用jquery.lazyload延迟加载功能：为容器span添加属性data-lazy-load
* Author: Scott Jehl (c) 2012
* Modified by jig for lazyload
* License: MIT/GPLv2
*/


function f_masonry(){
	//console.log("masonry layout cnt");
    var jq = jQuery.noConflict();
    /*
    jq('.masonry-layout').masonry({
		itemSelector: 'article',//'.post',
		columnWidth: '.masonry-layout-column-width',
		percentPosition: true
	});*/
    jq('.masonry-layout').masonry('layout');
}



(function( w ){

	// Enable strict mode
	"use strict";


	w.picturefill = function() {

		//var ps = w.document.getElementsByTagName( "span" );
		var ps = w.document.getElementsByClassName( "picture-fill" );	//modified by jig
		
		// Loop the pictures
		for( var i = 0, il = ps.length; i < il; i++ ){
			//if( ps[ i ].getAttribute( "data-picture" ) !== null ){	//modified by jig

				//var sources = ps[ i ].getElementsByTagName( "span" ),	//modified by jig
            	var sources = ps[ i ].getElementsByTagName( "div" ),
					matches = [];

				// See if which sources match
				for( var j = 0, jl = sources.length; j < jl; j++ ){
					var media = sources[ j ].getAttribute( "data-media" );
					// if there's no media specified, OR w.matchMedia is supported 
					if( !media || ( w.matchMedia && w.matchMedia( media ).matches ) ){
						matches.push( sources[ j ] );
					}
				}

			// Find any existing img element in the picture element
			var picImg = ps[ i ].getElementsByTagName( "img" )[ 0 ];

			if( matches.length ){
				var matchedEl = matches.pop();
				if( !picImg || picImg.parentNode.nodeName === "NOSCRIPT" ){
					picImg = w.document.createElement( "img" );
					picImg.alt = ps[ i ].getAttribute( "data-alt" );
					picImg.className = "responsive-img";	//added by jig
				}
				else if( matchedEl === picImg.parentNode ){
					// Skip further actions if the correct image is already in place
					continue;
				}				

				if( ps[ i ].getAttribute( "data-lazy-load" ) === null ) {	//added by jig
					picImg.src =  matchedEl.getAttribute( "data-src" );	
				}
				//added by jig
				else{	//元素含有data-lazy-load属性,则按jQuery.lazyload的格式处理元素

                    //为img添加class
                    picImg.className = "responsive-img lazyload";

                    //将img的src属性改为data-src
					var picSrc = matchedEl.getAttribute( "data-src" );
					picImg.removeAttribute("src");
					picImg.setAttribute("data-src",picSrc);

                }

                //绑定图片加载完成事件，隐藏加载图标。	added by ljj
				picImg.addEventListener("load", function (e) {
                    e.target.parentNode.parentNode.parentNode.getElementsByTagName("i")[0].style.display = "none";
                }, false);

				matchedEl.appendChild( picImg );
				picImg.removeAttribute("width");
				picImg.removeAttribute("height");
				
			}
			else if( picImg ){
				picImg.parentNode.removeChild( picImg );
			}
		//}	//modified by jig
		}

        //lazyload();					//for lazyload 2.x
        var jq = jQuery.noConflict();	//注意：WordPress中调用jquery方法需此
        jq("img.lazyload").lazyload({
            effect: "fadeIn",
            failurelimit: 40,
            data_attribute: "src",	//1.x默认data-original，兼容1.x和2.x版本
            placeholder: null,
            load: f_masonry
        });

	};

	// Run on resize and domready (w.load as a fallback)
	if( w.addEventListener ){
		w.addEventListener( "resize", w.picturefill, false );
		w.addEventListener( "DOMContentLoaded", function(){
			w.picturefill();
			// Run once only
			w.removeEventListener( "load", w.picturefill, false );
		}, false );
		w.addEventListener( "load", w.picturefill, false );
	}
	else if( w.attachEvent ){
		w.attachEvent( "onload", w.picturefill );
	}

}( this ));