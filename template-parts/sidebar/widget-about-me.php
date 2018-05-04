<?php
/**
 * “关于我”模块
 * @Author: jig
 * @Date: 2018/4/23 0023
 * @Time: 下午 5:16
 * @package WordPress
 * @subpackage jigim
 * @since 1.0
 */
?>
<section id="about-2" class="widget widget_about_me">
	<h2 class="widget-title"><?php _e('about me', 'twentyseventeen');?></h2>

	<?php //社交网络链接
	if ( has_nav_menu( 'social' ) ) : ?>
	<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Sidebar Social Links Menu', 'twentyseventeen' ); ?>">
		<span class="sr-only"><?php _e( 'follow me:', 'twentyseventeen' ); ?></span>
		<?php
		wp_nav_menu( array(
			'theme_location' => 'social',
			'menu_class'     => 'social-links-menu',
			'depth'          => 1,
		) );
		?>
	</nav><!-- .social-navigation -->
    <?php endif; ?>

	<div class="about-me-img">
		<img src="<?php echo get_stylesheet_directory_uri().'/assets/images/about_me.jpg' ?>" alt="about me image">
	</div>
</section>