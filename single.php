<?php
/**
 * The template for displaying all single posts
 * 显示单篇文章的模板
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
    <!-- section1: 内容 -->
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/* 主循环 */
			//while ( have_posts() ) : the_post();
			if ( have_posts() ) : the_post();

				//1. 用指定文章格式的内容模板，显示文章内容
				get_template_part( 'template-parts/post/content', get_post_format() );

				//2. 显示评论和发表评论区
                // If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				//3. 上/下一篇文章导航
				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">'
                                   . __( 'Previous Post', 'twentyseventeen' )
                                   . '</span><span aria-hidden="true" class="nav-subtitle">'
                                   . __( 'Previous', 'twentyseventeen' )
                                   . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">'
                                   . twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) )
                                   . '</span>%title</span>',
					'next_text' => '<span class="screen-reader-text">'
                                   . __( 'Next Post', 'twentyseventeen' )
                                   . '</span><span aria-hidden="true" class="nav-subtitle">'
                                   . __( 'Next', 'twentyseventeen' )
                                   . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">'
                                   . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) )
                                   . '</span></span>',
				) );
			//endwhile; // End of the loop.
			else :
				get_template_part( 'template-parts/post/content', 'none' );
            endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

    <!-- section2: 侧边栏 -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
