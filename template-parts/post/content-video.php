<?php
/**
 * Template part for displaying video posts
 * post-format为video的content模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if( !is_single()) { //非单篇文章(文章列表)

		//获取文章内容中的视频
		$content = apply_filters( 'the_content', get_the_content() );
		$video   = false;
		// Only get video from the content if a playlist isn't present.
		// 文章内容中不包含播放列表，则从内容中查找视频标签
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
		}

		if ( ! empty( $video ) ) {  //若有视频，则显示第一个视频标签
			echo '<div class="entry-video">';
			    echo $video[0];
			echo '</div>';
		}
		else if ( '' !== get_the_post_thumbnail() ) {   //若无视频，有缩略图则显示缩略图
			echo '<div class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
			    //the_post_thumbnail( 'jigim-thumbnail-horizontal' );
			    jigim_echo_responsive_thumbnail( $post, 'post-list' );
			echo '</a></div><!-- .post-thumbnail -->';
		}
		else {  //也无缩略图，则显示文章中第一张图片
			$img = jigim_get_post_first_img( get_the_content() );
			echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
			    //echo '<img src = "'. $img . '" alt="post image attachment">';
			    echo '<img data-src = "'. $img . '" class="lazyload" alt="post image attachment">';
			echo '</a> </div><!-- .post-image-attachment -->';
        }

		//文章meta信息和标题
		echo '<div class="post-outline">';
		jigim_entry_header();
	}
	?>


	<?php //if ( is_single() || ( empty($video) &&  !get_the_post_thumbnail()) ) :
        //若是单篇文章，或文章列表时既无视频也无缩略图，则显示文章内容 ?>
	<?php if ( is_single() ) : //若是单篇文章，则显示文章内容 ?>
	    <div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
				get_the_title()
			) );

            //显示分页链接
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
		?>
    	</div><!-- .entry-content -->
	<?php endif; ?>


	<?php
	jigim_entry_footer();

	if( !is_single()) {
		echo '</div><!-- .post-outline -->';
	}
	?>

</article><!-- #post-## -->
