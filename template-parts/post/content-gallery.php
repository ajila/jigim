<?php
/**
 * Template part for displaying gallery posts
 * post-format为gallery的content模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if( ! is_single() ) :   //若非单篇文章(即文章列表)
         if ( get_post_gallery() ): //有画廊，则以slider的方式，显示画廊图片 ?>
            <?php $ID = get_the_ID(); ?>
		    <div class="entry-gallery">
                <?php get_template_part('template-parts/slider/slider', 'gallery'); ?>
            </div>  <!-- .entry-gallery -->

        <?php elseif( has_post_thumbnail() ) : //无画廊有缩略图，则显示缩略图 ?>
            <div class="post-image-attachment">
                <a href="<?php the_permalink(); ?>">
                    <i class="fa fa-spinner fa-spin loading" ></i>
				    <?php //jigim_echo_responsive_thumbnail( $post, 'post-list' ); ?>
                    <img data-src = "<?php get_the_post_thumbnail_url( $post, 'jigim-thumbnail-vertical'); ?>"
                        class="lazyload" alt="post image attachment">
                </a>
            </div><!-- .post-thumbnail -->

        <?php else: //也无缩略图，则显示文章中第一张图片 ?>
            <div class="post-image-attachment">
                <a href="<?php the_permalink(); ?>">
                    <i class="fa fa-spinner fa-spin loading" ></i>
                    <img data-src = "<?php jigim_get_post_first_img( get_the_content() );?>" class="lazyload" alt="post image attachment">
                </a>
            </div><!-- .post-image-attachment -->
        <?php endif;


        //文章meta信息和标题
        jigim_entry_header();   ?>

    <?php endif; ?>


	<?php //if ( is_single() || (!get_post_gallery() &&  !has_post_thumbnail()) ):
	    //若是单篇文章，或文章列表时既无画廊也无缩略图，则显示文章内容    ?>
    <?php if ( is_single() ): //若是单篇文章，则显示文章内容 ?>
	    <div class="entry-content">
		    <?php
            /* translators: %s: Name of current post */
            the_content( sprintf(
                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                get_the_title()
            ) );

            //单文章分页时，显示分页链接
            wp_link_pages( array(
                'before'      => '<div class="page-links pagination">' . __( 'Pages:', 'twentyseventeen' ),
                'after'       => '</div>',
                //'link_before' => '<span class="page-numbers">',
                //'link_after'  => '</span>',
            ) );
		    ?>
    	</div><!-- .entry-content -->
    <?php endif; ?>


	<?php jigim_entry_footer(); ?>

</article><!-- #post-## -->
