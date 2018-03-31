<?php
/**
 * Template part for displaying pages on front page
 * 首页章节内容模板
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

global $twentyseventeencounter;

?>

<article id="panel<?php echo $twentyseventeencounter; ?>" <?php post_class( 'twentyseventeen-panel ' ); ?> >

	<?php if ( has_post_thumbnail() ) :

		//获取附件图像（特性图）的src数组
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'jigim-featured-image' );
		// Calculate aspect ratio计算高宽比: 高h / 宽w * 100%
		$ratio = $thumbnail[2] / $thumbnail[1] * 100;
		?>

        <!-- section1.显示特性图作固定背景 -->
		<div class="panel-image" style="background-image: url(<?php echo esc_url( $thumbnail[0] ); ?>);">
            <!-- 用此作占位。在非宽屏时将其设为不可见，则不显示固定背景， -->
			<div class="panel-image-prop" style="padding-top: <?php echo esc_attr( $ratio ); ?>%"></div>
		</div><!-- .panel-image -->

	<?php endif; ?>

    <!-- section2. 显示页面内容 -->
	<div class="panel-content">
		<div class="wrap">
            <!-- 2.1 页面标题 -->
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
				<?php jigim_edit_link(); ?>
			</header><!-- .entry-header -->

            <!-- 2.2 页面内容 -->
			<div class="entry-content">
				<?php
                /* translators: %s: Name of current post */
                the_content( sprintf(
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                    get_the_title()
                ) );
				?>
			</div><!-- .entry-content -->

			<?php //2.3 若此章节是博客文章列表页，则显示最近3篇文章
			// Show recent blog posts if is blog posts page (Note that get_option returns a string, so we're casting the result as an int).
            // 当前页面id等于作博客页的页面id
			if ( get_the_ID() === (int) get_option( 'page_for_posts' )  ) : ?>

				<?php // Show four most recent posts.
				$recent_posts = new WP_Query( array(
					'posts_per_page'      => 3,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				) );
				?>

		 		<?php if ( $recent_posts->have_posts() ) : ?>
					<div class="recent-posts">
						<?php   //显示每篇文章摘要
						while ( $recent_posts->have_posts() ) : $recent_posts->the_post();
							get_template_part( 'template-parts/post/content', 'excerpt' );
						endwhile;
						wp_reset_postdata();
						?>
					</div><!-- .recent-posts -->
				<?php endif; ?>
			<?php endif; ?>

		</div><!-- .wrap -->
	</div><!-- .panel-content -->

</article><!-- #post-## -->
