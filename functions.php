<?php
/**
 * Jig_im functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 */

/**
 * 低版本处理
 * Jig_im only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}


if( ! function_exists('jigim_setup') ):
/**
 * 主题功能特性的启用和注册
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function jigim_setup() {
	/* 翻译支持
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen', get_template_directory().'/lang');

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/* 自定义title支持
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/* 文章/页面缩略图支持，添加自定义尺寸
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size(1280,720,true);
    add_image_size('jigim-thumbnail-image', 570, 640, true );   //文章缩略图，用于文章列表
	add_image_size( 'jigim-thumbnail-avatar', 640, 480, true ); //文章缩略图，用于相关文章
	//文章特性图
	add_image_size( 'jigim-featured-image', 1600, 800, true );
	add_image_size( 'jigim-featured-md', 1280, 720, true );
	add_image_size( 'jigim-featured-sm', 768, 960, true );

	// Set the default content width.默认内容宽度
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.注册自定义导航菜单
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/* html5标记支持
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'search-form',
		'gallery',
		'caption',
	) );

	/* 文章格式支持
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'status',
		'quote',
		'link',
        'chat',
		'image',
        'gallery',
		'video',
        'audio',
	) );

	// Add theme support for Custom Logo. 自定义logo支持
	add_theme_support( 'custom-logo', array(
		'width'       => 300,
		'height'      => 300,
		'flex-width'  => true,
		'flex-height'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/* 可视化编辑器样式
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', jigim_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
    // 定义注册站点的初始内容设置
	$starter_content = array(
		'widgets' => array(     //widget的初始设置
			// Place three core-defined widgets in the sidebar area.侧边栏1初始放置的widget
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area. 页脚1初始放置的widget
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area. 页脚2初始放置的widget
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
        // 创建初始的文章
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
        // 创建自定义图像附件作为页面的缩略图
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
        // 静态首页和博客页的初始设置
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
        // 设置各首页章节初始显示的页面
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
        // 各导航菜单的初始设置
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Jig_im array of starter content.
	 *
	 * @since Jig_im 1.0
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'jigim_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
endif;
add_action( 'after_setup_theme', 'jigim_setup' );


if( ! function_exists('jigim_widgets_init') ):
/**
 * 注册放置widget的区域（sidebar）
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jigim_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<header class="widget-header"><span class="btn widget-toggle">'.
                      '<span class="fa fa-chevron-up"></span></span><h2 class="widget-title">',
        'after_title'   => '</h2></header> ',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'twentyseventeen' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'twentyseventeen' ),
        'id'            => 'sidebar-3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
endif;
add_action( 'widgets_init', 'jigim_widgets_init' );


if( ! function_exists('jigim_scripts') ):
/**
 * 脚本和样式加入队列
 * Enqueue scripts and styles.
 */
function jigim_scripts() {
    // Add custom fonts, used in the main stylesheet. 自定义字体
    wp_enqueue_style( 'jigim-fonts', jigim_fonts_url(), array(), null );

    // Theme stylesheet. 默认样式表style.css
    wp_enqueue_style( 'jigim-style', get_stylesheet_uri() );

    // 自定义样式main.css
    wp_enqueue_style( 'jigim-main-style', get_theme_file_uri( '/assets/css/main.css' ), array(),'1.0' );

    //最终效果参考，开发时临时使用，todo：发布时删除
	//wp_enqueue_style( 'jigim-dev-style', get_theme_file_uri( '/assets/css/for_dev.css' ), array(),'1.0' );

    // Load the dark colorscheme.
    if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
        wp_enqueue_style( 'jigim-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'jigim-style' ), '1.0' );
    }

    // Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
    if ( is_customize_preview() ) {
        wp_enqueue_style( 'jigim-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'jigim-style' ), '1.0' );
        wp_style_add_data( 'jigim-ie9', 'conditional', 'IE 9' );
    }

    //flickity for carousel
	//wp_enqueue_style( 'jigim-flickity', get_theme_file_uri( '/assets/css/flickity.css' ), array( 'jigim-style' ), '2.0' );

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style( 'jigim-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'jigim-style' ), '1.0' );
    wp_style_add_data( 'jigim-ie8', 'conditional', 'lt IE 9' );

    // IE10 viewport hack for Surface/desktop Windows 8 bug
    wp_enqueue_style( 'css-ie10-viewport-bug-workaround', get_theme_file_uri( '/assets/css/ie10-viewport-bug-workaround.css' ), array( 'jigim-style' ), '1.0' );
    wp_style_add_data( 'css-ie10-viewport-bug-workaround', 'conditional', 'IE 10' );

    // Load Modernizr
    //wp_enqueue_script('modernizr', get_theme_file_uri('/assets/js/vendor/modernizr-2.8.3.min.js'),array(), '2.8.3');

    // Load HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
    wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/vendor/html5.js' ), array(), '3.7.3' );
    wp_enqueue_script( 'respond', 'http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js', array(), '1.4.2');
    wp_script_add_data( 'html5', 'conditional', '(lt IE 9) & (!IEMobile)' );
    wp_script_add_data( 'respond', 'conditional', '(lt IE 9) & (!IEMobile)' );

	//IE10 viewport hack for Surface/desktop Windows 8 bug
	wp_enqueue_script( 'jig-ie10-viewport-bug-workaround', get_theme_file_uri( '/assets/js/vendor/ie10-viewport-bug-workaround.js' ), array(), '1.0', true );
	wp_script_add_data( 'jig-ie10-viewport-bug-workaround', 'conditional', 'IE 10' );

    /*
    $jigim_l10n = array(
        'quote'          => '<span class="fa fa-quote-right"></span>',
        //twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
    );

    if ( has_nav_menu( 'top' ) ) {
        wp_enqueue_script( 'jigim-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
        $jigim_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
        $jigim_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
        $jigim_l10n['icon']           = '<span class="fa fa-angle-down"></span>';
        //$jigim_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
    }
	wp_enqueue_script( 'jigim-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );
	wp_localize_script( 'jigim-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $jigim_l10n );
	*/

    //wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/vendor/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );
    //wp_enqueue_script( 'jigim-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    //所有插件js
    wp_enqueue_script( 'jigim-plugins', get_theme_file_uri( '/assets/js/plugins.js' ), array( 'jquery' ), '1.0', true );

    //todo :后续uglify后放到plugins.js里
	wp_enqueue_script( 'jigim-picturefill', get_theme_file_uri( '/assets/js/picturefill.js' ), array( 'jigim-plugins' ), '1.0', true );

    //自定义js
    wp_enqueue_script( 'jigim-main-js', get_theme_file_uri( '/assets/js/main.js' ), array( 'jigim-plugins' ), '1.0', true );

}
endif;
add_action( 'wp_enqueue_scripts', 'jigim_scripts' );


if( ! function_exists('jigim_content_width') ):
/**
 * 根据布局设置，设置内容宽度
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * hook 优先级设为最高
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function jigim_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( jigim_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Jig_im content width of the theme.
	 *
	 * @since Jig_im 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'jigim_content_width', $content_width );
}
endif;
add_action( 'template_redirect', 'jigim_content_width', 0 );


if( ! function_exists('jigim_fonts_url') ):
/**
 * 注册自定义字体（返回google web font字体的链接）
 * Register custom fonts.
 */
function jigim_fonts_url() {
	$fonts_url = '';

	/* 中文不支持 Libre Franklin 字体
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		//查询字符串
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ), //url转码
		);
        //在链接中添加查询字符串?key=value
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
    //用于数据库的链接
	return esc_url_raw( $fonts_url );
}
endif;

if( ! function_exists('jigim_resource_hints') ):
/**
 * 对资源（google fonts字体样式文件url）添加预取，提高性能
 * Add preconnect for Google Fonts.
 *
 * @since Jig_im 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function jigim_resource_hints( $urls, $relation_type ) {
    //检查css样式表是否加入queue    （css handle）
	if ( wp_style_is( 'jigim-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
endif;
add_filter( 'wp_resource_hints', 'jigim_resource_hints', 10, 2 );


if( ! function_exists('jigim_excerpt_more') ):
/**
 * 将摘要中默认显示的 […]替换为“继续阅读”链接
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Jig_im 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function jigim_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
            get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
endif;
add_filter( 'excerpt_more', 'jigim_excerpt_more' );


if( ! function_exists('jigim_javascript_detection') ):
/**
 * 添加js脚本到<head>，当支持js时将<html>的no-js类替换为js类
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Jig_im 1.0
 */
function jigim_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
endif;
add_action( 'wp_head', 'jigim_javascript_detection', 0 );


if( ! function_exists('jigim_pingback_header') ):
/**
 * 添加pingback_url到<head>
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function jigim_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
endif;
add_action( 'wp_head', 'jigim_pingback_header' );


if( ! function_exists('jigim_colors_css_wrap') ):
/**
 * 添加自定义color方案的css代码到<head>
 * Display custom color CSS.
 */
function jigim_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}
	//包含并运行一次，已运行则不再运行
	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo jigim_custom_colors_css(); ?>
	</style>
<?php }
endif;
add_action( 'wp_head', 'jigim_colors_css_wrap' );


if( ! function_exists('jigim_content_image_sizes_attr') ):
/**
 * 为内容中的图片添加自定义sizes属性，增强响应式图片功能
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Jig_im 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.属性sizes的值
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order). 数组（宽px，高px）
 * @return string A source size value for use in a content image 'sizes' attribute.属性sizes的值
 */
function jigim_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
	    //有侧边栏、或是文章列表、或是页面
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
		    //非单列页面，且图片宽过767的
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
endif;
add_filter( 'wp_calculate_image_sizes', 'jigim_content_image_sizes_attr', 10, 2 );


if( ! function_exists('jigim_post_thumbnail_sizes_attr') ):
/**
  * 为文章缩略图添加自定义sizes属性，增强响应式图片功能
  * Add custom image sizes attribute to enhance responsive image functionality
  * for post thumbnails.
  *
  * @since Jig_im 1.0
  *
  * @param array $attr       Attributes for the image markup. 图片img标记的属性
  * @param int   $attachment Image attachment ID. 图片的attachment id
  * @param array $size       Registered image size or flat array of height and width dimensions.数组（高px，宽px）
  * @return array The filtered attributes for the image markup. 图片img标记的属性
  */
function jigim_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
    if ( is_archive() || is_search() || is_home() ) {
        //文章列表时，各视口宽度下，缩略图的宽度
        //$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
    } else {
        //其他则全宽显示
        $attr['sizes'] = '100vw';
    }

    return $attr;
}
endif;
add_filter( 'wp_get_attachment_image_attributes', 'jigim_post_thumbnail_sizes_attr', 10, 3 );


if( ! function_exists('jigim_header_image_tag') ):
/**
 * Filter the `sizes` value in the header image markup.
 * 修改header image标记中的sizes值
 * @since Jig_im 1.0
 *
 * @param string $html   The HTML image tag markup being filtered. 要过滤的img标记
 * @param object $header The custom header object returned by 'get_custom_header()'.自定义header对象
 * @param array  $attr   Array of the attributes for the image tag.图片标记的属性数组
 * @return string The filtered header image HTML.
 */
function jigim_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
	    //header image sizes值改为全宽，最大显示1600px
		$html = str_replace( $attr['sizes'], '(max-width: 1600px) 100vw, 1600px', $html );
	}
	return $html;
}
endif;
add_filter( 'get_header_image_tag', 'jigim_header_image_tag', 10, 3 );


if( ! function_exists('jigim_front_page_template') ):
/**
 * Use front-page.php when Front page displays is set to a static page.
 * 过滤front-page.php的使用情况：
 * 首页显示设置为静态页时，才使用front-page.php模板
 * 首页显示设置为文章页时，不使用
 * @since Jig_im 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function jigim_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
endif;
add_filter( 'frontpage_template',  'jigim_front_page_template' );


if( ! function_exists('jigim_widget_tag_cloud_args') ):
/**
 * 修改标签云widget参数，以同样的字号显示所有标签
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Jig_im 1.4
 *
 * @param array $args Arguments for tag cloud widget. 标签云widget参数
 * @return array The filtered arguments for tag cloud widget.
 */
function jigim_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
endif;
add_filter( 'widget_tag_cloud_args', 'jigim_widget_tag_cloud_args' );

/* 去除head加载<link rel='dns-prefetch' href='//s.w.org'> */
/*  或
function remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }
    return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
*/
remove_filter('wp_head', 'wp_resource_hints', 2);

/**
 * Implement the Custom Header feature. 自定义header
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme. 自定义模板标签
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
//require get_parent_theme_file_path( '/inc/icon-functions.php' );
