<?php
/**
 * gallery文章幻灯片
 * @Author: jig
 * @Date: 2018/5/18 0018
 * @Time: 下午 3:32
 * @package WordPress
 * @subpackage jigim
 * @since 1.0
 */
?>
<div id="carousel-post-gallery-<?php the_ID(); ?>" class="gallery-carousel">

	<?php
	$gallery_img = get_post_gallery_images(); //获取画廊的所有图片

	foreach( $gallery_img as $image ){
	    //获取画廊图片
        //目前只支持固定分辨率768x960，命名后缀-768x960的图片
	    $ext = '.' . pathinfo( $image, PATHINFO_EXTENSION );
	    $basename = basename( $image, $ext) . '-768x960' . $ext;
		$image_show = dirname( $image ) . '/' . $basename;

        /* 在linux下判断指定分辨率图片存在否，不存在则用原始图片
		$loc = str_replace( get_bloginfo('url'), '', $image_show );
		if ( !file_exists($loc) ) {
			$image_show = $image;
		}
        */

        echo '<div class="carousel-cell"><i class="fa fa-spinner fa-spin loading"></i><img data-flickity-lazyload="'
             . $image_show . '" class="carousel-cell-image"></div>';
	}
	?>

</div>
