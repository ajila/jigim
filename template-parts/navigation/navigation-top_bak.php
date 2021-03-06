<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation"
     aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">

    <?php //折叠按钮 ?>
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo twentyseventeen_get_svg( array( 'icon' => 'bars' ) );
		echo twentyseventeen_get_svg( array( 'icon' => 'close' ) );
		_e( 'Menu', 'twentyseventeen' );
		?>
	</button>

    <?php //显示菜单 ?>
	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>

    <?php //是首页则显示跳到内容的链接 ?>
	<?php if ( ( jigim_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
		<a href="#content" class="menu-scroll-down">
            <?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?>
            <span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span>
        </a>
	<?php endif; ?>

</nav><!-- #site-navigation -->
