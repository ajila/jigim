<?php
/**
 * Additional features to allow styling of the templates
 * 其他自定义函数
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

if ( ! function_exists( 'twentyseventeen_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 * 添加自定义class到body_class
 * @param array $classes Classes for the body element.
 * @return array
 */
function twentyseventeen_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'twentyseventeen-customizer';
	}

	// Add class on front page.首页是静态页
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'twentyseventeen-front-page';
	}

	// Add a class if there is a custom header.有header image的
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add class if sidebar is used.有侧边栏的
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}

	// Add class for one or two column page layouts.
	if ( is_page() || is_archive() ) {
		if ( 'one-column' === get_theme_mod( 'page_layout' ) ) {
			$classes[] = 'page-one-column';
		} else {
			$classes[] = 'page-two-column';
		}
	}

	// Add class if the site title and tagline is hidden.站点标题副标题隐藏的
	if ( 'blank' === get_header_textcolor() ) {
		$classes[] = 'title-tagline-hidden';
	}

	// Get the colorscheme or the default if there isn't one.
	$colors = twentyseventeen_sanitize_colorscheme( get_theme_mod( 'colorscheme', 'light' ) );
	$classes[] = 'colors-' . $colors;

	return $classes;
}
endif;
add_filter( 'body_class', 'twentyseventeen_body_classes' );

if ( ! function_exists( 'twentyseventeen_panel_count' ) ) :
/**
 * Count our number of active panels.
 * 计算要在首页显示的激活panel（主页章节）的个数
 * Primarily used to see if we have any panels active, duh.
 */
function twentyseventeen_panel_count() {

	$panel_count = 0;

	/**
	 * Filter number of front page sections in Twenty Seventeen.
	 * 过滤首页章节的个数（默认是4个）
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $num_sections Number of front page sections.
	 */
	$num_sections = apply_filters( 'twentyseventeen_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	// 计算激活的panel（customizer中已赋值的panel_n）的个数
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		if ( get_theme_mod( 'panel_' . $i ) ) {
			$panel_count++;
		}
	}

	return $panel_count;
}
endif;

if ( ! function_exists( 'twentyseventeen_is_frontpage' ) ) :
/** 检查是首页不是主页
 * Checks to see if we're on the homepage or not.
 */
function twentyseventeen_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}
endif;
