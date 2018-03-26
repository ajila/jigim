<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<nav role="navigation" id="site-navigation" class="navbar navbar-default"
     aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">
    <div class="container-fluid">

        <?php //品牌标志和折叠开关 Brand and toggle get grouped for better mobile display ?>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse-top" aria-expanded="false">
                <span class="sr-only"><?php _e('Toggle navigation', 'twentyseventeen'); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>  <!-- /.navbar-header -->

        <?php //显示菜单 ?>
	    <?php wp_nav_menu( array(
		    'theme_location'    => 'top',
		    'container_class'   => 'navbar-collapse collapse',
		    'container_id'      => 'navbar-collapse-top',
            'menu_class'        => 'nav navbar-nav',
		    'depth'             => 2
	    ) ); ?>

        <?php //是首页则显示跳到内容的链接 ?>
	    <?php if ( ( twentyseventeen_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
		<a href="#content" class="menu-scroll-down">
            <?php //echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?>
            <span class="fa fa-angle-double-down"></span>
            <span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span>
        </a>
	    <?php endif; ?>
    </div>
</nav><!-- #site-navigation -->
