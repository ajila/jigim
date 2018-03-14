<?php
/**
 * Template part for displaying image posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php   //当前是博客主页且是置顶文章，输出图标
		if ( is_sticky() && is_home() ) {
			echo twentyseventeen_get_svg( array( 'icon' => 'thumb-tack' ) );
		}
	?>

	<?php   //文章meta信息和标题 ?>
	<header class="entry-header">
		<?php                                    //section1: meta
			if ( 'post' === get_post_type() ) { //文章post type为post
				echo '<div class="entry-meta">';
					if ( is_single() ) {        //单篇文章时，打印日期时间作者
						twentyseventeen_posted_on();
					} else {                    //文章列表时，打印日期时间和编辑链接
						echo twentyseventeen_time_link();
						twentyseventeen_edit_link();
					}
				echo '</div><!-- .entry-meta -->';
			};
		                                        //section2: title
			if ( is_single() ) {
				the_title( '<h1 class="entry-title">', '</h1>' );
			} elseif ( is_front_page() && is_home() ) {
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			} else {
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			}
		?>
	</header><!-- .entry-header -->

	<?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) :
        //若不是单篇文章(文章列表)，且有缩略图，则显示缩略图 ?>
		<div class="post-thumbnail">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
			</a>
		</div><!-- .post-thumbnail -->
	<?php endif; ?>

	<div class="entry-content">

		<?php if ( is_single() || '' === get_the_post_thumbnail() ) {
			//若是单篇文章，或文章列表时没有缩略图，则显示文章内容
			// Only show content if is a single post, or if there's no featured image.
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
				get_the_title()
			) );
			//单文章分页时，显示分页链接
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
				'after'       => '</div>',
				'link_before' => '<span class="page-number">',
				'link_after'  => '</span>',
			) );
		};
		?>

	</div><!-- .entry-content -->

	<?php   //输出分类、tag列表和编辑链接
	if ( is_single() ) {
		twentyseventeen_entry_footer();
	}
	?>

</article><!-- #post-## -->
