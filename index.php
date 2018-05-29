<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" style="text-decoration:underline">upgrade your browser</a> to improve your experience.</p>
<p class="browserupgrade">你使用的浏览器版本<strong>已经过时</strong>. 为了获得更好的体验，请<a href="http://browsehappy.com/" style="text-decoration:underline">升级你的浏览器</a>.</p>
<![endif]-->


<!--<div class="container">-->
        <!--<div class="row">-->

            <div id="primary" class="content-area">

	            <?php //section1: 标题 ?>
	            <?php if ( is_home() && ! is_front_page() ) : //是主页但非首页，则显示页面标题?>
                    <header class="page-header">
                        <h1 class="page-title"><?php single_post_title(); ?></h1>
                    </header>
	            <?php else : //主页做首页，则显示字符串 ?>
                    <header class="page-header">
                        <h2 class="page-title"><?php _e( 'Posts', 'twentyseventeen' ); ?></h2>
                    </header>
	            <?php endif; ?>

                <main id="main" class="site-main" role="main">

                    <?php   //section2: 内容
                    if ( have_posts() ) :

                        /* 主循环 */
                        while ( have_posts() ) : the_post();

                            /* 用指定文章格式的内容模板，显示每篇文章
                             * Include the Post-Format-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/post/content', get_post_format() );

                        endwhile;

                        /* 文章分页导航 */
                        the_posts_pagination( array(
                            'prev_text' => '<span class="fa fa-chevron-left"></span><span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span><span class="fa fa-chevron-right"></span>',
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
                        ) );

                    else :

                        get_template_part( 'template-parts/post/content', 'none' );

                    endif;
                    ?>
                </main><!-- #main -->
            </div><!-- #primary -->


            <?php //section3: 侧边栏
            get_sidebar(); ?>
<!-- </div> -->
<!-- </div>-->

<?php get_footer();?>
