<?php
/**
 * The template for displaying search results pages
 *  搜索结果页面模板
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
    <!-- section1: 标题 -->
	<header class="page-header">
		<?php if ( have_posts() ) : ?>
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyseventeen' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php else : ?>
			<h1 class="page-title"><?php _e( 'Nothing Found', 'twentyseventeen' ); ?></h1>
		<?php endif; ?>
	</header><!-- .page-header -->

    <!-- section2: 内容 -->
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php //若搜索有结果，则显示搜索到的文章
		if ( have_posts() ) :

			/* 主循环 */
			while ( have_posts() ) : the_post();

				/** 显示摘要
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/post/content', 'excerpt' );

			endwhile; // End of the loop.

			/* 文章分页导航 */
			the_posts_pagination( array(
				'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
			) );

		else : //搜索无结果，则显示提示消息和搜索框 ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
			<?php
				get_search_form();

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

    <!-- section3: 侧边栏 -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
