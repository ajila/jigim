<?php
/**
 * The template for displaying all single posts
 * 显示单篇文章的模板
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<?php if ( have_posts() ) : the_post();	?>

	<?php //主内容区 ?>
    <div id="primary" class="content-area">

		<?php //TODO：面包屑导航 ?>
        <header class="page-header">
            <h2 class="page-title">面包屑导航</h2>
        </header>

        <main id="main" class="site-main" role="main">
			<?php

			//1. 用指定文章格式的内容模板，显示文章内容
			get_template_part( 'template-parts/post/content', get_post_format() );

			//todo:作者模块

			//2. 显示同一分类下的相关文章
			get_template_part( 'template-parts/slider/slider', 'related-post' );

			//3. 显示评论和发表评论区
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			//4. 上/下一篇文章导航
			the_post_navigation( array(
				'prev_text' => '<span class="screen-reader-text">'
				               . __( 'Previous Post', 'twentyseventeen' )
				               . '</span><span aria-hidden="true" class="nav-subtitle">'
                               //. '<span class="nav-title-icon-wrapper">'
				               . '<span class="fa fa-chevron-left icon"></span><span class="nav-subtitle-text">'
				               . __( 'Previous', 'twentyseventeen' )
				               . '</span></span> <span class="nav-title">%title</span>',

				'next_text' => '<span class="screen-reader-text">'
				               . __( 'Next Post', 'twentyseventeen' )
				               . '</span><span aria-hidden="true" class="nav-subtitle"><span class="nav-subtitle-text">'
				               . __( 'Next', 'twentyseventeen' )
				               //. '<span class="nav-title-icon-wrapper">'
				               . '</span><span class="fa fa-chevron-right icon"></span>'
				               . '</span> <span class="nav-title">%title</span>'
			) );
			?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php else : ?>

	<?php //section2: 内容 ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
			<?php get_template_part( 'template-parts/post/content', 'none' ); ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php endif; //if(have_posts()) ?>


<?php //section3: 侧边栏
get_sidebar(); ?>


<?php get_footer();