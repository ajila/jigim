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


<?php //标题 ?>
<header class="page-header">
    <?php if ( have_posts() ) : global $wp_query; ?>
        <div class="featured-image-header">
            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/feature_search.jpg' ?>" alt="feature image">
        </div>
        <h1 class="page-title"><?php printf( __( '%1$s Search Results for: %2$s', 'twentyseventeen' ), $wp_query->found_posts,'<span>' . get_search_query() . '</span>' ); ?></h1>
    <?php else : ?>
        <div class="featured-image-header">
            <img src="<?php echo get_stylesheet_directory_uri().'/assets/images/feature_search-none.jpg' ?>" alt="feature image">
        </div>
        <h1 class="page-title"><?php printf(__( 'Nothing Found: %s', 'twentyseventeen' ),'<span>' .get_search_query() .'</span>' ); ?></h1>
    <?php endif; ?>
</header><!-- .page-header -->


<div class="container">
    <div class="row">

	    <?php //主内容区 ?>
        <div id="primary" class="content-area">

	        <?php //TODO：section1: 面包屑导航 <header> ?>




            <?php //若搜索有结果，则显示搜索到的文章
            if ( have_posts() ) : ?>

                <main id="main" class="site-main" role="main">
                <?php //section2: 文章列表
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
                    'prev_text' => '<span class="fa fa-chevron-left"></span><span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
                    'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span><span class="fa fa-chevron-right"></span>',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
                ) );?>
                </footer>

            <?php else : //搜索无结果，则显示提示消息和搜索框 ?>

                <main id="main" class="site-main" role="main">
                <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyseventeen' ); ?></p>
                <?php get_search_form(); ?>
                </main><!-- #main -->

            <?php endif; ?>

        </div><!-- #primary -->


        <?php //侧边栏 ?>
        <?php get_sidebar(); ?>

    </div><!-- .row -->
</div><!-- .container -->


<?php get_footer();
