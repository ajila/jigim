<?php
/**
 * The front page template file
 * 静态页做首页时的首页模板
 * If the user has selected a static page for their homepage, this is what will
 * appear.

 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<!-- 内容 -->
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php // 1.显示设为首页的静态页面内容.
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/page/content', 'front-page' );
			endwhile;
		else : // I'm not sure it's possible to have no posts when this page is shown, but WTH.
			get_template_part( 'template-parts/post/content', 'none' );
		endif; ?>

		<?php // 2.显示customize中设置的首页章节
		// Get each of our panels and show the post data.
		if ( 0 !== jigim_panel_count() || is_customize_preview() ) : // If we have pages to show.

			/**
			 * Filter number of front page sections.
			 * 首页章节个数
			 * @since Twenty Seventeen 1.0
			 *
			 * @param int $num_sections Number of front page sections.
			 */
			$num_sections = apply_filters( 'jigim_front_page_sections', 4 );
			global $twentyseventeencounter;

			// Create a setting and control for each of the sections available in the theme.
			for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
				$twentyseventeencounter = $i;
				jigim_front_page_section( null, $i );
			}

	    endif; // The if ( 0 !== jigim_panel_count() ) ends here. ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
