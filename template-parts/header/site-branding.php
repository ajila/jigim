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
    if(0):
    if ( function_exists( 'the_custom_logo' ) ) {
        the_custom_logo();
    }
    endif;

    //需要用300x300的图片以100x100的宽高显示，获得更精细的效果。故注册时宽高为300x300，使用时指定为100x100
    if(0):
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
    if ( has_custom_logo() ) {
	    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home" itemprop="url">';
	    echo '<img width="100" height="100" src="' . esc_url( $logo[0] ) . '" alt="Jig.im" itemprop="logo">';
	    echo '</a>';
    }
    endif;
    ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
        <img width="100" height="100" src="<?php echo get_stylesheet_directory_uri().'/assets/images/logo_sm.png'?>" class="custom-logo" alt="Jig.im" itemprop="logo">
    </a>


    <?php //2.显示标题和副标题 ?>
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
