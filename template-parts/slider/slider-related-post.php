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
?>

        <div class="related-post-panel" >

            <header class="related-post-header content-module-header">
                <h3>相关阅读</h3>
            </header>
            <ul class="related-post-list related-post-carousel">

            <?php
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                echo '<li id="related-post-'.get_the_ID().'" class="related-post-item carousel-cell">';

                    if( has_post_thumbnail( $post ) ) {
                        //显示缩略图
                        echo '<div class="post-thumbnail"><a href="' . esc_url(get_permalink()) . '">';
	                    jigim_echo_responsive_thumbnail($post, 'slider-related-post' );
                        echo '</a></div>';//.post-thumbnail
                    }
                    else{   //无缩略图，则显示第一张图片附件（无附件显示默认图片）
                        $img = jigim_get_post_first_img( get_the_content() );
                        echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">'
                            . '<i class="fa fa-spinner fa-spin loading" ></i><img data-flickity-lazyload = "'
                             . $img . '" class="carousel-cell-image" alt="post image attachment">'
                            . '</a> </div>';
                    }
                    echo '<div class="entry-content">';
                        echo '<h4 class="entry-title"><a href="' .esc_url(get_permalink()) .'">'.get_the_title().'</a></h4>';
                        echo '<div class="entry-summary">'.get_the_excerpt().'</div>';
	                    echo '<div class="posted-on">'.get_the_time('Y年n月j日').'</div>';
    	            echo '</div>';//.entry-content
	            echo '</li>';//.related-post-item
            endwhile;
            wp_reset_postdata();
            ?>

            </ul><!-- .related-post-list -->
        </div>

<?php
        endif;  //if( $the_query->have_posts() )
    endif;  //if( $cat_array )
?>
