<?php
/**
 * Template part for displaying posts with excerpts
 *  非post_format，只用于搜索结果页search，和首页panel显示最新文章时，显示文章摘要
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php
    if ( '' !== get_the_post_thumbnail() ) { //有缩略图，则显示缩略图
	    echo '<div class="post-thumbnail"><a href="' .esc_url(get_permalink()) .'">';
	        //the_post_thumbnail( 'jigim-thumbnail-horizontal' );
	        jigim_echo_responsive_thumbnail( $post, 'post-list' );
	    echo '</a></div><!-- .post-thumbnail -->';
    }
    else{   //无缩略图，则显示第一张图片附件
	    $img = jigim_get_post_first_img( get_the_content() );
	    echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
	        //echo '<img src = "'. $img . '" alt="post image attachment">';
	        echo '<img data-src = "'. $img . '" class="lazyload" alt="post image attachment">';
	    echo '</a> </div><!-- .post-image-attachment -->';
    } ?>



    <div class="post-outline">
    <?php
    if ( 'page' === get_post_type() ) {
        echo '<div class="page-label"><span class="fa fa-file icon"></span>页面</div>';
    }
    jigim_entry_header();
    ?>


	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->


	<?php 	if ( 'post' === get_post_type() ) {     //post type为文章
		jigim_entry_footer();
	}                                               //post type为页面
    elseif ( 'page' === get_post_type() && get_edit_post_link() ) {
		echo '<footer class="entry-footer"><div class="entry-meta">';
		jigim_edit_link(); //只打印编辑链接
		echo '</div></footer>';
	}
	?>

    </div><!-- .post-outline -->

</article><!-- #post-## -->
