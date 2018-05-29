<?php
/**
 * 相关文章幻灯片
 * @Author: jig
 * @Date: 2018/3/25 0025
 * @Time: 下午 4:33
 * @package WordPress
 * @subpackage jigim
 * @since 1.0
 */
?>
<div class="related-post-panel" >
	<?php
	$cat_array = array();
	$categories = get_the_category();   //获取文章的分类对象数组
	if ( $categories ) {
		foreach ( $categories as $cat) {
			$cat_array[] = $cat->term_id;
		}
	}

	if( $cat_array ) :
        $args = array(
            'stickies_only'    => 0,
            'post_status'      => 'publish',
            'post_type'        => 'post',
            'orderby'          => 'date',
            'order'            => 'DESC',
            'posts_per_page'   => 6,
            'offset'           => 0,
            'suppress_filters' => false, // <- for language plugins
            'category__in'     => $cat_array,  //显示分类属于当前文章的分类之一的文章
	        'post__not_in'     => array(get_the_ID())   //排除当前文章
        );

        $the_query = new WP_Query($args);
        if( $the_query->have_posts() ):

            echo '<header class="related-post-header"> <h4>相关阅读</h4> </header>';
            echo '<ul class="related-post-list related-post-carousel">';

            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                echo '<li id="related-post-'.get_the_ID().'" class="related-post-item carousel-cell">';

                    if( has_post_thumbnail( $post ) ) {
                        echo '<div class="post-thumbnail"><a href="' . esc_url(get_permalink()) . '">';
	                    jigim_echo_responsive_thumbnail($post, 'slider-related-post' );
                        echo '</a></div>';//.post-thumbnail
                    }
                    else{   //无缩略图，则显示第一张图片附件
                        $img = jigim_get_post_first_img( get_the_content() );
                        echo '<div class="carousel-cell-image post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
                        echo '<img data-flickity-lazyload = "'. $img . '" alt="post image attachment">';
                        echo '</a> </div>';//.post-image-attachment
                    }
                    echo '<div class="entry-content">';
                        echo '<h5 class="entry-title"><a href="' .esc_url(get_permalink()) .'">'.get_the_title().'</a></h5>';
                        echo '<div class="entry-summary">'.get_the_excerpt().'</div>';
	                    echo '<div class="posted-on">'.get_the_time('Y年n月j日').'</div>';
    	            echo '</div>';//.entry-content
	            echo '</li>';//.related-post-item
            endwhile;
            wp_reset_postdata();

            echo '</ul>';//.related-post-list
        endif;  //if( $the_query->have_posts() )
    endif;  //if( $cat_array )
	?>
</div>