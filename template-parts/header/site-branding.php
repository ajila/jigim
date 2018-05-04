<?php
/**
 * Displays header site branding
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-branding">

    <?php
    //1.显示自定义logo图片
    if ( function_exists( 'the_custom_logo' ) ) {
        the_custom_logo();
    }

    //2.显示标题和副标题 ?>
    <div class="site-branding-text">
        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

        <?php
        $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ) :
        ?>
            <p class="site-description"><?php echo $description; ?></p>
        <?php endif; ?>
    </div><!-- .site-branding-text -->

    <?php //是静态首页，或博文首页且无导航菜单，则显示跳到内容的链接
    if ( ( jigim_is_frontpage() || ( is_home() && is_front_page() ) ) && ! has_nav_menu( 'top' ) ) : ?>
    <a href="#content" class="menu-scroll-down">
        <span class="fa fa-arrow-right"></span>
        <span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span>
    </a>
    <?php endif; ?>

</div><!-- .site-branding -->
