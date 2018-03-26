<?php
/**
 * Template part for displaying image posts
 * post-format为image的content模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if( !is_single()) : //非单篇文章(文章列表)

        if ( '' !== get_the_post_thumbnail() ) { //有缩略图，则显示缩略图
            echo '<div class="post-thumbnail"><a href="' . esc_url(get_permalink()) . '">';
                 the_post_thumbnail( 'jigim-thumbnail-image' );
            echo '</a></div><!-- .post-thumbnail -->';
        }
        else{   //无缩略图，则显示第一张图片附件
            /*
            //查询文章的图片附件
            $args = array(
                'post_parent'    => get_the_ID(),
                'numberposts' => 1,    //查询图片数
                'post_type'      => 'attachment',
                'post_mime_type' => 'image'
            );
            $attachments = get_posts( $args );

            if( $attachments ) {
                echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
                    echo wp_get_attachment_image( $attachments[0]->ID, 'jigim-thumbnail-image' );
                echo '</a> </div><!-- .post-image-attachment -->';
            }
	        */
			$img = jigim_get_post_first_img( get_the_content() );
			echo '<div class="post-image-attachment"><a href="' . esc_url(get_permalink()) . '">';
			    echo '<img src = "'. $img . '" alt="post image attachment">';
			echo '</a> </div><!-- .post-image-attachment -->';
	    }
    endif; ?>


	<?php if ( is_sticky() && is_home() ) : //当前是主页（文章列表）且是置顶文章，输出图标 ?>
        <span class="fa fa-thumb-tack"></span>
	<?php endif; ?>

	<?php   //文章meta信息和标题 ?>
	<header class="entry-header">
    <?php
        //section1: 文章分类
        jigim_entry_category();

        //section2: 文章标题
        jigim_entry_title();

        //section3: meta（作者、日期）,文章post type为post且单篇文章时
        if ( 'post' === get_post_type() && is_single() ) {
            echo '<div class="entry-meta">';
                jigim_posted_on();    //打印作者头像日期时间
                jigim_edit_link();    //打印编辑链接
            echo '</div><!-- .entry-meta -->';
        }
    ?>
	</header><!-- .entry-header -->

	<?php if ( is_single() ) : //若是单篇文章，则显示文章内容 ?>
	    <div class="entry-content">
        <?php
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
			<?php jigim_posted_on(); ?>
        </footer>
	<?php endif; ?>

</article><!-- #post-## -->