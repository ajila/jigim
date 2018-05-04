<?php
/**
 * Template part for displaying audio posts
 * post-format为audio的content模板
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

		//获取文章内容中的音频
		$content = apply_filters( 'the_content', get_the_content() );
		$audio   = false;
		// Only get video from the content if a playlist isn't present.
		// 文章内容中不包含播放列表，则从内容中查找音频标签
		if ( false === strpos( $content, 'wp-playlist-script' ) ) {
			$audio = get_media_embedded_in_content( $content, array( 'audio' ) );
		}

		if ( ! empty( $audio ) ) {  //若有音频，则显示第一个音频标签
			echo '<div class="entry-audio">';
			    echo $audio[0];
			echo '</div>';
		}
		else if ( '' !== get_the_post_thumbnail() ) {   //若无音频，有缩略图则显示缩略图
			echo '<div class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '">';
			    the_post_thumbnail( 'jigim-thumbnail-image' );
			echo '</a></div><!-- .post-thumbnail -->';
		}
		else {  //也无缩略图，则显示文章中第一张图片
			$img = jigim_get_post_first_img( get_the_content() );
			echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
			    echo '<img src = "'. $img . '" alt="post image attachment">';
			echo '</a> </div><!-- .post-image-attachment -->';
        }
	}
	?>


	<?php if ( is_sticky() && is_home() ) : //当前是博客主页（文章列表）且是置顶文章，输出图标 ?>
        <span class="fa fa-thumb-tack"></span>
	<?php endif; ?>


	<?php if( !is_single() ): //非单篇文章(文章列表)，显示文章meta信息和标题 ?>
	<header class="entry-header">
		<?php
		//section1: 文章分类
		jigim_entry_category();

		//section2: 文章标题
		jigim_entry_title();
		?>
	</header><!-- .entry-header -->
	<?php endif; ?>


	<?php if( is_single()): //TODO：面包屑导航 ?>
	<?php endif; ?>


	<?php if ( is_single() || ( empty($audio) && !get_the_post_thumbnail() ) ):
		//若是单篇文章，或文章列表时既无音频也无缩略图，则显示文章内容 ?>
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


        <footer class="entry-footer">
            <?php jigim_entry_tag();    //输出tag列表 ?>
        </footer>
	<?php else: //文章列表时，作者日期时间显示在底部 ?>
        <footer class="entry-footer">
			<?php jigim_posted_on();  ?>
        </footer>
	<?php endif; ?>

</article><!-- #post-## -->
