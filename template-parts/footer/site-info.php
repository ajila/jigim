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

    <p class = "site-copyright">
        <span>Copyright © 2018 <a href="<?php echo home_url('/'); ?>">jig.im</a> 版权所有 | </span>
        <span><a target="_blank" rel="nofollow" href="http://www.miitbeian.gov.cn">粤ICP备17137059号-1</a></span>
    </p>
    <p class = "site-credit">
        <span>基于<a href="<?php echo esc_url('http://www.aliyun.com') ?>">阿里云</a> +
            <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'twentyseventeen' ) ); ?>">Wordpress
            </a>构建 |
        </span>
        <span>设计：<a href="<?php echo home_url('/'); ?>">JIG</a></span>
    </p>


</div><!-- .site-info -->
