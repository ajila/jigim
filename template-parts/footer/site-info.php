<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	<?php
	//显示自定义logo图片
	if ( function_exists( 'the_custom_logo' ) ) {
	    the_custom_logo();
	}
	?>

    <div class="site-declaration">
        <p class = "site-copyright">
            Copyright © 2018 <a href="<?php echo home_url('/'); ?>">jig.im</a> 版权所有  |
            <a target="_blank" rel="nofollow" href="http://www.miitbeian.gov.cn">粤ICP备17137059号-1</a>
        </p>
        <p class = "site-credit">
            基于<a href="<?php echo esc_url('http://www.aliyun.com') ?>">阿里云</a> +
                <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentyseventeen' ) ); ?>">Wordpress
                </a>构建  |
            设计：<a href="<?php echo home_url('/'); ?>">JIG</a>
        </p>
    </div>

	<?php
	//社交网络链接菜单
	if ( has_nav_menu( 'social' ) ) : ?>
        <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
            <span><?php _e( 'contact us:', 'twentyseventeen' ); ?></span>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'social',
				'menu_class'     => 'social-links-menu',
				'depth'          => 1,
			) );
			?>
        </nav><!-- .social-navigation -->
	<?php endif;?>

</div><!-- .site-info -->
