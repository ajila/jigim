<?php
/**
 * Template part for displaying posts with excerpts
 *  非post_format，只用于搜索结果页search，和首页panel显示最新文章时，显示文章摘要
 * Used in Search Results and for Recent Posts in Front Page panels.
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

	<?php   //文章meta信息和标题 ?>
	<header class="entry-header">
		<?php                                   //section1: meta
        if ( 'post' === get_post_type() ) { //文章post type为post
	        echo '<div class="entry-meta">';//打印日期时间和编辑链接
	            echo jigim_time_link();
	            jigim_edit_link();
	        echo '</div>';
        }                                   //文章post type为page
        elseif ( 'page' === get_post_type() && get_edit_post_link() ) {
            echo '<div class="entry-meta">';
	            jigim_edit_link(); //只打印编辑链接
	        echo '</div>';
        }

        if ( is_front_page() && ! is_home() ) {   //section2: title
            //是首页而不是主页（首页中的panel）
			// The excerpt is being displayed within a front page section, so it's a lower hierarchy than h2.
			the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
        } else {
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
        }
        ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

</article><!-- #post-## -->
