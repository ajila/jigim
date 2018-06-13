<?php
/**
 * Template part for displaying page content in page.php
 * 页面内容模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <!-- 1. 页面标题 -->
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php jigim_edit_link(); ?>
	</header><!-- .entry-header -->

    <!-- 2. 页面内容 -->
	<div class="entry-content">
		<?php
			the_content();
            //页面内部分页时，显示分页数字链接
			wp_link_pages( array(
				'before' => '<div class="page-links pagination">' . __( 'Pages:', 'twentyseventeen' ),
				'after'  => '</div>',
				//'link_before' => '<span class="page-numbers">',
				//'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
