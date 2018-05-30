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
    }


    //文章meta信息和标题
    echo '<div class="post-outline">';
    jigim_entry_header();
    ?>


	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->


    <footer class="entry-footer">
		<?php jigim_entry_tag();    //输出tag列表

        //meta（作者、日期）
        if ( 'post' === get_post_type() ) {     //文章post type为post
        echo '<div class="entry-meta">';
            jigim_posted_on();    //打印作者头像日期时间
            //echo '<span class="entry-views">阅读次数 '.jigim_get_post_views(get_the_ID()).'</span>';
            jigim_edit_link();  //打印编辑链接
            echo '</div><!-- .entry-meta -->';
        }                                       //文章post type为page
        elseif ( 'page' === get_post_type() && get_edit_post_link() ) {
        echo '<div class="entry-meta">';
            jigim_edit_link(); //只打印编辑链接
            echo '</div>';
        }
		?>
    </footer>

    <?php echo '</div><!-- .post-outline -->'; ?>

</article><!-- #post-## -->
