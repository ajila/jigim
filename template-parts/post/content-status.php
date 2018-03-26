<?php
/**
 * Template part for displaying status posts
 *  post-format为status的content模板
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


	<?php   //当前是博客主页（即文章列表）且是置顶文章，输出图标
		if ( is_sticky() && is_home() ) {
            echo '<span class="fa fa-thumb-tack"></span>';
		}
	?>

	<?php   //文章meta信息和标题 ?>
	<header class="entry-header">
    <?php
        //section1: 文章分类
        jigim_entry_category();

        //section2: meta（作者、日期）,文章post type为post且单篇文章时
        if ( 'post' === get_post_type() && is_single() ) {
            echo '<div class="entry-meta">';
                jigim_posted_on();    //打印作者头像日期时间
                jigim_edit_link();    //打印编辑链接
            echo '</div><!-- .entry-meta -->';
        }
    ?>
	</header><!-- .entry-header -->


	<div class="entry-content">
		<?php
		/* translators: %s: Name of current post */
		the_content( sprintf(
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
			get_the_title()
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
        <footer class="entry-footer">
            <?php jigim_entry_tag();    //输出tag列表 ?>
        </footer>
    <?php else : ?>
        <footer class="entry-footer">
			<?php jigim_posted_on();  //作者日期显示在底部 ?>
        </footer>
    <?php endif; ?>

</article><!-- #post-## -->
