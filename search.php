<?php
/**
 * The template for displaying search results pages
 *  搜索结果页面模板
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<?php if ( have_posts() ) : ?>
    <?php //主内容区 ?>
    <div id="primary" class="content-area">

        <?php //TODO：section1: 面包屑导航 ?>
        <header class="page-header">
            <h2 class="page-title">面包屑导航</h2>
        </header>


        <main id="main" class="site-main masonry-layout" role="main">
            <div class="masonry-layout-column-width" aria-label="used for masonry layout"></div>
            <?php //section2: 显示搜索到的文章列表
            while ( have_posts() ) : the_post();

                /** 显示摘要
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part( 'template-parts/post/content', 'excerpt' );

            endwhile; ?>
            </main><!-- #main -->


        <footer class="site-main-pagination">
        <?php //section3：文章分页导航
        the_posts_pagination( array(
            'prev_text' => '<span class="fa fa-chevron-left"></span><span class="screen-reader-text">'
                           . __( 'Previous page', 'twentyseventeen' )
                           . '</span>',
            'next_text' => '<span class="screen-reader-text">'
                           . __( 'Next page', 'twentyseventeen' )
                           . '</span><span class="fa fa-chevron-right"></span>',
            'before_page_number' => '<span class="meta-nav screen-reader-text">'
                                    . __( 'Page', 'twentyseventeen' )
                                    . ' </span>',
        ) );?>
        </footer>

    </div><!-- #primary -->


	<?php //侧边栏 ?>
	<?php get_sidebar(); ?>

<?php else: //搜索无结果，则显示提示消息和搜索框 ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <section class="not-found">
                <h1>
                    <?php printf(__( 'Nothing Found: %s', 'twentyseventeen' ),
		                '<span class="search-string">' .get_search_query() .'</span>' ); ?>
                </h1>
                <p><?php
                    _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.','twentyseventeen' ); ?>
                </p>
                <?php get_search_form(); ?>
            </section>
        </main><!-- #main -->
    </div>

<?php endif; ?>


<?php get_footer();
