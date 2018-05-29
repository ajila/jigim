<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>

<nav role="navigation" id="site-navigation" class="navbar navbar-default"
     aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">
    <div class="container-fluid">

        <?php //品牌标志和折叠开关 Brand and toggle get grouped for better mobile display ?>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" id="sidenav-open-btn"
                    data-target="#navbar-collapse-top" aria-expanded="false">
                <span class="sr-only"><?php _e('Toggle navigation', 'twentyseventeen'); ?></span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
            <a href="<?php bloginfo('url'); ?>" class="navbar-brand" rel="home" itemprop="url">
                <img width="250" src="<?php echo get_stylesheet_directory_uri().'/assets/images/logo_full.png'?>" alt="logo" itemprop="url">
            </a>
        </div>  <!-- /.navbar-header -->

        <?php //由于要右浮动到最右，所以在折叠菜单前定义 ?>
        <ul class="navbar-form navbar-right">
            <li class="nav-login">
                <a href="/wp-login.php" target="_blank">
                    <span class="sr-only"><?php _e('user login button', 'twentyseventeen'); ?></span>
                    <span class="fa fa-user fa-lg"></span>
                </a>
            </li>
            <li class="nav-search">
			    <?php get_search_form(); ?>
            </li>
        </ul>

	    <?php //显示菜单
        wp_nav_menu( array(
		    'theme_location'    => 'top',
		    'container_class'   => 'navbar-collapse collapse navbar-right',
		    'container_id'      => 'navbar-collapse-top',
            'menu_class'        => 'nav navbar-nav',
		    //'depth'             => 2
	    ) ); ?>


    </div> <!-- .container-fluid -->
</nav><!-- #site-navigation -->
