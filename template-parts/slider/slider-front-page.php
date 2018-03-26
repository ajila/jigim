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
<div id="carousel-front-page" class="carousel slide" data-ride="carousel">

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
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
	        $loop_cnt = 0;
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                echo '<div class="item ' . ( $loop_cnt ? '' : 'active' ) . '">';

	            if(has_post_thumbnail( $post )) {
		            echo get_the_post_thumbnail( $post, 'jigim-featured-image' );
	            }
        ?>
                    <div class="carousel-caption">
                        <p class="slide-category"><?php the_category(' | ');?></p>
                        <h2 class="slide-title"><?php the_title();?></h2>
                        <div class="slide-meta">
                            <span class="slide-avatar">
                                <a href="<?php echo esc_url(get_author_posts_url( $post->post_author ));?>">
                                    <?php echo get_avatar($post->post_author,64,'','');?>
                                </a>
                                <span class="badge"><?php the_author_posts(); ?></span>
                            </span>
                            <span class="slide-author">由<?php the_author();?></span>
                            <span class="slide-date">发表于<?php the_time('Y年n月j日');?></span>
                        </div>
                        <div class="slide-excerpt"><?php the_excerpt();?></div>
                        <a type="button" class="btn btn-primary" href="<?php the_permalink();  ?>">more</a>
                    </div> <!-- .carousel-caption-->
        <?php
                echo '</div> <!-- .item -->';
                $loop_cnt++;
            endwhile;
            wp_reset_postdata();
        endif; ?>
    </div> <!-- div.carousel-inner -->

    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php for($i = 0; $i<$loop_cnt; $i++) {
            if(0 === $i){
	            echo '<li data-target="#carousel-front-page" data-slide-to="'.$i.'" class="active"></li>' ;
            }
            else{
	            echo '<li data-target="#carousel-front-page" data-slide-to="'.$i.'" ></li>' ;
            }
        }?>
    </ol>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-front-page" role="button" data-slide="prev">
        <span class="fa fa-arrow-left" aria-hidden="true"></span>
        <span class="sr-only"><?php _e( 'Previous', 'twentyseventeen' ); ?></span>
    </a>
    <a class="right carousel-control" href="#carousel-front-page" role="button" data-slide="next">
        <span class="fa fa-arrow-right" aria-hidden="true"></span>
        <span class="sr-only"><?php _e( 'Next', 'twentyseventeen' ); ?></span>
    </a>

</div> <!-- div.carousel -->