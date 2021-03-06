<?php
/**
 * The template for displaying archive pages
 * 存档页模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<?php if ( have_posts() ) :
    //特色图、标题、文章数、简介等信息
    //jigim_archive_meta_header();
endif; ?>


<?php //主内容区 ?>
<div id="primary" class="content-area">

    <?php //TODO：section1: 面包屑导航 ?>
    <header class="page-header">
        <h2 class="page-title">面包屑导航</h2>
    </header>


    <?php if ( have_posts() ) : ?>

        <main id="main" class="site-main masonry-layout" role="main">
            <div class="masonry-layout-column-width" aria-label="used for masonry layout"></div>
        <?php //section2: 文章列表
        while ( have_posts() ) : the_post();

            /* 用指定文章格式的内容模板，显示每篇文章
             * Include the Post-Format-specific template for the content.
             * If you want to override this in a child theme, then include a file
             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
             */
            get_template_part( 'template-parts/post/content', get_post_format() );

        endwhile; ?>
        </main><!-- #main -->

        <footer class="site-main-pagination">
        <?php //section3：文章分页导航
        the_posts_pagination( array(
            'prev_text' => '<span class="fa fa-chevron-left"></span><span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span><span class="fa fa-chevron-right"></span>' ,
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
        ) ); ?>
        </footer>

    <?php else : ?>

        <main id="main" class="site-main" role="main">
        <?php get_template_part( 'template-parts/post/content', 'none' ); ?>
        </main><!-- #main -->

    <?php endif; ?>

</div><!-- #primary -->


<?php //侧边栏 ?>
<?php get_sidebar(); ?>


<?php get_footer();
