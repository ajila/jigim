<?php
/**
 * Displays content for front page
 * 首页页面内容模板
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'twentyseventeen-panel ' ); ?> >

	<?php if ( has_post_thumbnail() ) :

        //获取附件图像（特色图）的src数组
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'jigim-featured-image' );
		// Calculate aspect ratio计算高宽比: 高h / 宽w * 100%.
		$ratio = $thumbnail[2] / $thumbnail[1] * 100;
		?>

        <!-- section1.显示特色图作固定背景 -->
		<div class="panel-image" style="background-image: url(<?php echo esc_url( $thumbnail[0] ); ?>);">
            <!-- 用此作占位。在非宽屏时将其设为不可见，则不显示固定背景， -->
			<div class="panel-image-prop" style="padding-top: <?php echo esc_attr( $ratio ); ?>%"></div>
		</div><!-- .panel-image -->

	<?php endif; ?>

    <!-- section2. 显示页面内容 -->
	<div class="panel-content">
		<div class="wrap">
            <!-- 2.1 页面标题 -->
			<header class="entry-header">
				<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
				<?php jigim_edit_link(); ?>
			</header><!-- .entry-header -->

            <!-- 2.2 页面内容 -->
			<div class="entry-content">
				<?php
                /* translators: %s: Name of current post */
                the_content( sprintf(
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                    get_the_title()
                ) );
				?>
			</div><!-- .entry-content -->

		</div><!-- .wrap -->
	</div><!-- .panel-content -->

</article><!-- #post-## -->
