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

		echo '<div class="carousel-cell"><img data-flickity-lazyload="'
		     . $image . '" class="post-gallery-image carousel-cell-image"></div>';

	}
	?>

</div>
