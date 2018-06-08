<?php
/**
 * Additional features to allow styling of the templates
 * 其他自定义函数
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 */

if ( ! function_exists( 'jigim_body_classes' ) ) :
/**
 * Adds custom classes to the array of body classes.
 * 添加自定义class到body_class
 * @param array $classes Classes for the body element.
 * @return array
 */
function jigim_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author. 多个作者
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages. 非单篇文章页
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options. 预览窗口
	if ( is_customize_preview() ) {
		$classes[] = 'twentyseventeen-customizer';
	}

	// Add class on front page.是静态首页
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
add_filter( 'body_class', 'jigim_body_classes' );

if ( ! function_exists( 'jigim_panel_count' ) ) :
/**
 * Count our number of active panels.
 * 计算要在首页显示的激活panel（主页章节）的个数
 * Primarily used to see if we have any panels active, duh.
 */
function jigim_panel_count() {

	$panel_count = 0;

	/**
	 * Filter number of front page sections.
	 * 过滤首页章节的个数（默认是4个）
	 * @since Jig_im 1.0
	 *
	 * @param int $num_sections Number of front page sections.
	 */
	$num_sections = apply_filters( 'jigim_front_page_sections', 4 );

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

if ( ! function_exists( 'jigim_is_frontpage' ) ) :
/**
 * 检查是首页不是主页（静态首页）
 * Checks to see if we're on the homepage or not.
 */
function jigim_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}
endif;


if ( ! function_exists( 'jigim_nav_menu_item_class' ) ) :
/**
 * 为有子菜单的菜单项添加类
 * （效果等同于navigation.js）
 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element. li的类
 * @param WP_Post  $item    The current menu item. 当前菜单项
 * @param stdClass $args    An object of wp_nav_menu() arguments.函数wp_nav_menu的参数对象
 * @param int      $depth   Depth of menu item. Used for padding.菜单深度
 *
 * @return array  $classes The CSS classes that are applied to the menu item's `<li>` element. li的类
 */
function jigim_nav_menu_item_class($classes, $item, $args, $depth) {
	if ( 'top' === $args->theme_location ) {
		//处理有子菜单的li
		foreach ( $item->classes as $value ) {
			if( 'menu-item-has-children' === $value || 'page_item_has_children' === $value){
				$classes[] = 'dropdown';
			}
		}
	}
	return $classes;
}
endif;
add_filter( 'nav_menu_css_class', 'jigim_nav_menu_item_class',10, 4 );


if ( ! function_exists( 'jigim_nav_menu_link_attr' ) ) :
/**
 * 为有子菜单的菜单项li内的a添加属性
 * （效果等同于navigation.js）
 * @param array $atts  The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
 *                      菜单项li内的a的属性
 * @param WP_Post  $item    The current menu item. 当前菜单项
 * @param stdClass $args    An object of wp_nav_menu() arguments.函数wp_nav_menu的参数对象
 * @param int      $depth   Depth of menu item. Used for padding.菜单深度
 *
 * @return array  $atts The HTML attributes applied to the menu item's `<a>` element.
 */
function jigim_nav_menu_link_attr($atts, $item, $args, $depth) {
	if ( 'top' === $args->theme_location ) {
		//处理有子菜单的li
		foreach ( $item->classes as $value ) {
			if( 'menu-item-has-children' === $value || 'page_item_has_children' === $value){
				$atts['data-toggle'] = 'dropdown';
				$atts['role'] = 'button';
				$atts['aria-haspopup'] = 'true';
				$atts['aria-expanded'] = 'false';
				$atts['class'] = 'dropdown-toggle';
			}
		}
	}
	return $atts;
}
endif;
add_filter( 'nav_menu_link_attributes', 'jigim_nav_menu_link_attr',10, 4 );


if ( ! function_exists( 'jigim_nav_menu_link_dropdown_icon' ) ) :
/**
 * Add dropdown icon if menu item has children.
 * 为有子菜单的菜单项添加下箭头图标
 * （效果等同于navigation.js）
 * @param  string  $title The menu item's title. 菜单项li内a内的title
 * @param  WP_Post $item  The current menu item.当前菜单项li对象
 * @param  array   $args  An array of wp_nav_menu() arguments.函数wp_nav_menu的参数对象
 * @param  int     $depth Depth of menu item. Used for padding.菜单深度
 * @return string  $title The menu item's title with dropdown icon.
 */
function jigim_nav_menu_link_dropdown_icon( $title, $item, $args, $depth ) {
	if ( 'top' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title = $title . '<span class="caret"></span>';
			}
		}
	}
	return $title;
}
endif;
add_filter( 'nav_menu_item_title', 'jigim_nav_menu_link_dropdown_icon', 10, 4 );


if ( ! function_exists( 'jigim_nav_menu_submenu_class' ) ) :
/**
 * 为子菜单ul添加类
 * （效果等同navigation.js）
 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
 * @param int      $depth   Depth of menu item. Used for padding.
 *
 * @return array    $classes The CSS classes that are applied to the menu `<ul>` element.
 */
function jigim_nav_menu_submenu_class( $classes, $args, $depth) {
	if ( 'top' === $args->theme_location ) {
		foreach ($classes as $ul_class) {
			if ('sub-menu' === $ul_class) {
				$classes[] = 'dropdown-menu';
			}
		}
	}
	return $classes;
}
endif;
add_filter( 'nav_menu_submenu_css_class', 'jigim_nav_menu_submenu_class', 10, 3 );


if ( ! function_exists( 'jigim_get_post_first_img' ) ) :
/**
 * 返回文章中第一张图片，文章无图片则返回默认图片
 * @param  string  $post_content   文章内容
 * @return string  $first_img      图片url
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
		$first_img = get_stylesheet_directory_uri() . '/assets/images/thumb_default.jpg';
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
	if ( is_single() || is_page() ) {
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
add_action('get_header', 'jigim_set_post_views'); //每次访问页面，则更新meta
endif;

if ( ! function_exists( 'jigim_get_post_views' ) ) :
/**
 * 获取文章阅读次数
 * @param  integer  $post_id   文章id
 * @return string   $count     文章阅读次数
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


if ( ! function_exists( 'jigim_category_feature_color' ) ) :
/**
 * 获取分类特征颜色
 * @param  string  $cat_slug   分类的slug
 * @return string   $feature_color     分类特征色
 */
function jigim_category_feature_color ($cat_slug) {
	//根据实际情况初始化这里的键值，后续可由后台设置
	$cat_colors = array(
		"other"         =>  "#8ab5d8",
		"featured"      =>  "#da6a2a",
		"post-formats"  =>  "#53591b",
		"sticky"        =>  "#f2c572",
		"default"       =>  "#bfa72b",
	);

	if( array_key_exists($cat_slug, $cat_colors) ) {
		return $cat_colors[$cat_slug];
	} else {
		return $cat_colors["default"];
	}
}
endif;
