<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <section class="error-404 not-found">
            <h1>
                <?php _e( 'Oops! That page can&rsquo;t be found.', 'twentyseventeen' ); ?>
            </h1>
            <p><?php
                _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentyseventeen' ); ?>
            </p>
            <?php get_search_form(); ?>
        </section><!-- .error-404 -->
    </main><!-- #main -->
</div><!-- #primary -->


<?php get_footer();
