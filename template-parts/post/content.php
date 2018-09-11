<?php
/**
 * Template part for displaying posts
 *  没有定义指定post-format模板文件时，默认的content模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if( !is_single() ) : //非单篇文章(文章列表)

        //文章缩略图
		if ( has_post_thumbnail() ) { //有缩略图，则显示缩略图
			echo '<div class="post-thumbnail"><a href="' . esc_url(get_permalink()) . '">';
			    //the_post_thumbnail( 'jigim-thumbnail-horizontal' );
			    jigim_echo_responsive_thumbnail( $post, 'post-list' );
			echo '</a></div><!-- .post-thumbnail -->';
		}
		else{   //无缩略图，则显示第一张图片附件
            /*
			//查询文章的图片附件
			$args = array(
				'post_parent'    => get_the_ID(),
				'numberposts' => 1,    //查询图片数
				'post_type'      => 'attachment',
				'post_mime_type' => 'image'
			);
			$attachments = get_posts( $args );

			if( $attachments ) {
				echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
				    echo wp_get_attachment_image( $attachments[0]->ID, 'jigim-thumbnail-horizontal' );
				echo '</a> </div><!-- .post-image-attachment -->';
			}
            */
			$img = jigim_get_post_first_img( get_the_content() );
			echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
			    //echo '<img src = "'. $img . '" alt="post image attachment">';
			    echo '<i class="fa fa-spinner fa-spin loading" ></i><img data-src = "'
                     . $img . '" class="lazyload" alt="post image attachment">';
			echo '</a> </div><!-- .post-image-attachment -->';
		}

		//文章meta信息和标题
		echo '<div class="post-outline">';
		jigim_entry_header();

	endif; ?>


    <?php if( is_single() && has_excerpt() ): //单篇文章显示摘要段落?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>
    <?php endif; ?>


	<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
			get_the_title()
		) );

		if( is_single() ) {
			//文章内部分页时，显示分页数字链接
			wp_link_pages( array(
				'before'      => '<div class="page-links pagination">' . __( 'Pages:', 'twentyseventeen' ),
				'after'       => '</div>',
				//'link_before' => '<span class="page-numbers">',
				//'link_after'  => '</span>',
			) );
		}
		?>
	</div><!-- .entry-content -->


    <?php
    jigim_entry_footer();

    if( !is_single()) {
	    echo '</div><!-- .post-outline -->';
    }
    ?>

</article><!-- #post-## -->
