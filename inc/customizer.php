<?php
/**
 * Twenty Seventeen: Customizer
 * customizer相关函数
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 */

if ( ! function_exists( 'twentyseventeen_customize_register' ) ) :
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function twentyseventeen_customize_register( $wp_customize ) {
	//1.将站点标题、副标题、顶部文本色的transport改为postMessage
	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
	//为站点标题、副标题添加预览partial（selective_refresh类型）
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'twentyseventeen_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'twentyseventeen_customize_partial_blogdescription',
	) );

	/**
	 * 2.Custom colors. 添加自定义配色方案的setting
	 */
	$wp_customize->add_setting( 'colorscheme', array(
		'default'           => 'light',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'twentyseventeen_sanitize_colorscheme',
	) );
	//添加配色方案色相的setting
	$wp_customize->add_setting( 'colorscheme_hue', array(
		'default'           => 250,
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint', // The hue is stored as a positive integer.
	) );
	//添加自定义配色方案的control
	$wp_customize->add_control( 'colorscheme', array(
		'type'    => 'radio',
		'label'    => __( 'Color Scheme', 'twentyseventeen' ),
		'choices'  => array(
			'light'  => __( 'Light', 'twentyseventeen' ),
			'dark'   => __( 'Dark', 'twentyseventeen' ),
			'custom' => __( 'Custom', 'twentyseventeen' ),
		),
		'section'  => 'colors',
		'priority' => 5,
	) );
	//为自定义配色方案色相注册自定义control
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'colorscheme_hue', array(
		'mode' => 'hue',
		'section'  => 'colors',
		'priority' => 6,
	) ) );

	/**
	 * 3.Theme options. 添加主题选项section
	 */
	$wp_customize->add_section( 'theme_options', array(
		'title'    => __( 'Theme Options', 'twentyseventeen' ),
		'priority' => 130, // Before Additional CSS.
	) );
	//添加页面布局setting
	$wp_customize->add_setting( 'page_layout', array(
		'default'           => 'two-column',
		'sanitize_callback' => 'twentyseventeen_sanitize_page_layout',
		'transport'         => 'postMessage',
	) );
	//添加页面布局control
	$wp_customize->add_control( 'page_layout', array(
		'label'       => __( 'Page Layout', 'twentyseventeen' ),
		'section'     => 'theme_options',
		'type'        => 'radio',
		'description' => __( 'When the two-column layout is assigned, the page title is in one column and content is in the other.', 'twentyseventeen' ),
		'choices'     => array(
			'one-column' => __( 'One Column', 'twentyseventeen' ),
			'two-column' => __( 'Two Column', 'twentyseventeen' ),
		),
		'active_callback' => 'twentyseventeen_is_view_with_layout_option',
	) );

	/**
	 * Filter number of front page sections.
	 * 过滤首页章节数
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $num_sections Number of front page sections.
	 */
	$num_sections = apply_filters( 'jigim_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	// 为每个首页章节创建setting和control和partial
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'twentyseventeen' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'twentyseventeen' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'twentyseventeen_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'jigim_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
endif;
add_action( 'customize_register', 'twentyseventeen_customize_register' );

if ( ! function_exists( 'twentyseventeen_sanitize_page_layout' ) ) :
/**
 * Sanitize the page layout options.
 * 过滤page_layout有效值
 * @param string $input Page layout.
 */
function twentyseventeen_sanitize_page_layout( $input ) {
	$valid = array(
		'one-column' => __( 'One Column', 'twentyseventeen' ),
		'two-column' => __( 'Two Column', 'twentyseventeen' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}
endif;

if ( ! function_exists( 'twentyseventeen_sanitize_colorscheme' ) ) :
/**
 * Sanitize the colorscheme.
 * 过滤colorscheme有效值
 * @param string $input Color scheme.
 */
function twentyseventeen_sanitize_colorscheme( $input ) {
	$valid = array( 'light', 'dark', 'custom' );

	if ( in_array( $input, $valid, true ) ) {
		return $input;
	}

	return 'light';
}
endif;

if ( ! function_exists( 'twentyseventeen_customize_partial_blogname' ) ) :
/**
 * Render the site title for the selective refresh partial.
 * 部分刷新类型partial的站点标题的显示回调函数
 * @since Twenty Seventeen 1.0
 * @see twentyseventeen_customize_register()
 *
 * @return void
 */
function twentyseventeen_customize_partial_blogname() {
	bloginfo( 'name' );
}
endif;

if ( ! function_exists( 'twentyseventeen_customize_partial_blogdescription' ) ) :
/**
 * Render the site tagline for the selective refresh partial.
 * 部分刷新类型partial的站点副标题的显示回调函数
 * @since Twenty Seventeen 1.0
 * @see twentyseventeen_customize_register()
 *
 * @return void
 */
function twentyseventeen_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
endif;

if ( ! function_exists( 'twentyseventeen_is_static_front_page' ) ) :
/** 预览的是首页且不是博客主页
 * Return whether we're previewing the front page and it's a static page.
 */
function twentyseventeen_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}
endif;

if ( ! function_exists( 'twentyseventeen_is_view_with_layout_option' ) ) :
/** 是否是支持一列/两列布局的页面
 * Return whether we're on a view that supports a one or two column layout.
 */
function twentyseventeen_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}
endif;

if ( ! function_exists( 'twentyseventeen_customize_preview_js' ) ) :
/** 实时预览的js脚本
 * Bind JS handlers to instantly live-preview changes.
 */
function twentyseventeen_customize_preview_js() {
	wp_enqueue_script( 'twentyseventeen-customize-preview',
		get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview' ), '1.0', true );
}
endif;
add_action( 'customize_preview_init', 'twentyseventeen_customize_preview_js' );


if ( ! function_exists( 'twentyseventeen_panels_js' ) ) :
/** 动态加载control区域的js脚本
 * Load dynamic logic for the customizer controls area.
 */
function twentyseventeen_panels_js() {
	wp_enqueue_script( 'twentyseventeen-customize-controls',
		get_theme_file_uri( '/assets/js/customize-controls.js' ), array(), '1.0', true );
}
endif;
add_action( 'customize_controls_enqueue_scripts', 'twentyseventeen_panels_js' );