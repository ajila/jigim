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

	// Add class if sidebar is used.有侧边栏的非页面(文章页)
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
/** 检查是首页不是主页（静态首页）
 * Checks to see if we're on the homepage or not.
 */
function twentyseventeen_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}
endif;

if ( ! function_exists( 'twentyseventeen_navigation_menu_item_handle' ) ) :
/**
 * 将wp生成的菜单项li，按bootstrap导航菜单的标记结构修改
 * @param  string  $item_output The menu item output. 每个菜单项li输出的html
 * @param  WP_Post $item        Menu item object.     每个菜单项li对象
 * @param  int     $depth       Depth of the menu.    菜单深度
 * @param  array   $args        wp_nav_menu() arguments. 函数wp_nav_menu的参数对象
 * @return string  $item_output The menu item output with social icon.
 */
function twentyseventeen_nav_menu_item_handle($item_output, $item, $depth, $args) {
	if ( 'top' === $args->theme_location ) {
		//处理有子菜单的li
		foreach ( $item->classes as $value ) {
			if( 'menu-item-has-children' === $value || 'page_item_has_children' === $value){
				//Array_push($item->classes ,'dropdown');
				echo 'this is '.$item_output;
				$item_output = str_replace( 'menu-item-has-children', 'dropdown',$item_output);
			}
		}
	}
	return $item_output;
}
endif;
//add_filter( 'walker_nav_menu_start_el', 'twentyseventeen_nav_menu_item_handle',10, 4 );


if ( ! function_exists( 'jigim_get_post_first_img' ) ) :
/**
 * 返回文章中第一张图片，文章无图片则返回默认图片
 * @param  string  $$post_content   文章内容
 * @return string  $first_img       文章中第一张图片，文章无图片则返回默认图片
 */
function jigim_get_post_first_img( $post_content ){

	$first_img = '';
	$matches = '';
	ob_start();
	//ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);

	//获取文章中第一张图片的路径
	$first_img = $matches [1] [0];
	//如果文章无图片，获取自定义图片
	if( empty( $first_img ) ){
		$first_img = get_stylesheet_directory_uri() . '/assets/images/default_thumb.jpg';
	}
	ob_end_clean();
	return $first_img;
}
endif;


if ( ! function_exists( 'jigim_set_post_views' ) ) :
/**
 * 为文章添加统计阅读次数的meta
 */
function jigim_set_post_views () {
	global $post;
	if (is_single() || is_page()) {
		$post_id   = $post->ID;
		$count_key = 'views';
		$count     = get_post_meta( $post_id, $count_key, true );

		if ( $count == '' ) {
			delete_post_meta( $post_id, $count_key );
			add_post_meta( $post_id, $count_key, '0' );
		} else {
			update_post_meta( $post_id, $count_key, $count + 1 );
		}
	}
}
add_action('get_header', 'jigim_set_post_views');
endif;

if ( ! function_exists( 'jigim_get_post_views' ) ) :
/**
 * 获取文章阅读次数
 * @param  string  $post_id   文章id
 * @return string  $count       文章阅读次数
 */
function jigim_get_post_views ($post_id) {
	$count_key = 'views';
	$count = get_post_meta($post_id, $count_key, true);
	if ($count == '') {
		delete_post_meta($post_id, $count_key);
		add_post_meta($post_id, $count_key, '0');
		$count = '0';
	}
	return number_format_i18n($count);
}
endif;