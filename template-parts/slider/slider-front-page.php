<?php
/**
 * 首页显示幻灯片轮播
 * @Author: jig
 * @Date: 2018/3/17 0017
 * @Time: 下午 4:55
 * @package WordPress
 * @subpackage jigim
 * @since 1.0
 */
?>
<div id="carousel-front-page" class="main-carousel">

    <?php
    $args = array(
        'stickies_only'    => 0,
        'post_status'      => 'publish',
        'post_type'        => 'post',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'posts_per_page'   => 5,
        'offset'           => 0,
        'suppress_filters' => false, // <- for language plugins
        'tag'           => 'recommend',  //显示tag为recommend的文章
    );

    $the_query = new WP_Query($args);
    if($the_query->have_posts()):

        while ( $the_query->have_posts() ) :
            $the_query->the_post();
            echo '<div class="carousel-cell">';

            if( has_post_thumbnail( $post ) ) {
                jigim_echo_responsive_thumbnail( $post, 'slider-front-page' );
            } else {
	            jigim_echo_responsive_thumbnail( $post, 'default' );
            }
    ?>
            <div class="carousel-content">
                <!-- <p class="slide-category"><?php //the_category(' | ');?></p> -->
                <?php jigim_entry_category(); ?>
                <h2 class="slide-title"><?php the_title();?></h2>
                <div class="slide-excerpt"><?php the_excerpt();?></div>
                <div class="slide-meta">
                    <span class="slide-avatar">
                        <a href="<?php echo esc_url(get_author_posts_url( $post->post_author ));?>">
                            <?php echo get_avatar($post->post_author,64,'','');?>
                        </a>
                    </span>
                    <span class="slide-author"> <?php the_author();?></span>
                    <span class="slide-date"> | <?php the_time('Y年n月j日');?></span>
                    <a type="button" class="btn btn-primary pull-right" href="<?php the_permalink();  ?>">more</a>
                </div>
            </div> <!-- .carousel-content-->
    <?php
            echo '</div>';//.carousel-cell

        endwhile;
        wp_reset_postdata();
    endif; ?>

</div> <!-- div.main-carousel -->