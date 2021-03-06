<?php
/**
 * Jig_im back compat functionality
 * 处理主题向后兼容性的函数
 * Prevents Jig_im from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since Jig_im 1.0
 */

/**
 * Prevent switching to Twenty Seventeen on old versions of WordPress.
 * 切换回默认主题，并在admin显示消息
 * Switches to the default theme.
 *
 * @since Jig_im 1.0
 */
function jigim_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'jigim_upgrade_notice' );
}
add_action( 'after_switch_theme', 'jigim_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 * 显示主题切换失败消息
 * Prints an update nag after an unsuccessful attempt to switch to
 * Jig_im on WordPress versions prior to 4.7.
 *
 * @since Jig_im 1.0
 *
 * @global string $wp_version WordPress version.
 */
function jigim_upgrade_notice() {
	$message = sprintf( __( 'Jig_im requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 * 阻止customizer加载
 * @since Jig_im 1.0
 *
 * @global string $wp_version WordPress version.
 */
function jigim_customize() {
	wp_die( sprintf( __( 'Jig_im requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'jigim_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 * 阻止主题预览
 * @since Jig_im 1.0
 *
 * @global string $wp_version WordPress version.
 */
function jigim_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Jig_im requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'twentyseventeen' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'jigim_preview' );
