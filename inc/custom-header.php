<?php
/**
 * Custom header implementation
 * 自定义header实现
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 */

if( ! function_exists('jigim_custom_header_setup') ):
/**
 * Set up the WordPress core custom header feature.
 * 注册自定义header特性主题支持
 * @uses jigim_header_style()
 */
function jigim_custom_header_setup() {

	/**
	 * Filter Jig_im custom-header support arguments.
	 * 注册自定义header特性主题支持，参数可过滤
	 * @since Jig_im 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-image     		Default image of the header.
	 *     @type string $default_text_color     Default color of the header text.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 954.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 1300.
	 *     @type string $wp-head-callback       Callback function used to styles the header image and text
	 *                                          displayed on the blog. 为header图片和文字添加样式的回调函数
	 *     @type string $flex-height     		Flex support for height of header.
	 * }
	 */
	add_theme_support( 'custom-header', apply_filters( 'jigim_custom_header_args', array(
		'default-image'      => get_parent_theme_file_uri( '/assets/images/header.jpg' ),
		'width'              => 1280,
		'height'             => 720,
		'flex-widget'        => true,
		'flex-height'        => true,
		'video'              => true,
		'header-text'        => true,
		'uploads'            => true,
		'wp-head-callback'   => 'jigim_header_style',
	) ) );

	register_default_headers( array(
		'default-image' => array(
			'url'           => '%s/assets/images/header.jpg',
			'thumbnail_url' => '%s/assets/images/header.jpg',
			'description'   => __( 'Default Header Image', 'twentyseventeen' ),
		),
		'wheel' => array(
			'url'           => '%s/assets/images/espresso.jpg',
			'thumbnail_url' => '%s/assets/images/espresso.jpg',
			'description'   => __( 'Wheel', 'twentyseventeen' )
		),
	) );
}
endif;
//add_action( 'after_setup_theme', 'jigim_custom_header_setup' );


if ( ! function_exists( 'jigim_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 * 为header图片和文字添加颜色样式的回调函数
 * @see jigim_custom_header_setup().
 */
function jigim_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail.若未在后台设置文字颜色（等于默认值）则返回
	// get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style id="jigim-custom-header-styles" type="text/css">
	<?php
		// Has the text been hidden? 文字色为blank表示标题隐藏
		if ( 'blank' === $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.否则用户已设置文本色
		else :
	?>
		.site-title a,
		.colors-dark .site-title a,
		.colors-custom .site-title a,
		body.has-header-image .site-title a,
		body.has-header-video .site-title a,
		body.has-header-image.colors-dark .site-title a,
		body.has-header-video.colors-dark .site-title a,
		body.has-header-image.colors-custom .site-title a,
		body.has-header-video.colors-custom .site-title a,
		.site-description,
		.colors-dark .site-description,
		.colors-custom .site-description,
		body.has-header-image .site-description,
		body.has-header-video .site-description,
		body.has-header-image.colors-dark .site-description,
		body.has-header-video.colors-dark .site-description,
		body.has-header-image.colors-custom .site-description,
		body.has-header-video.colors-custom .site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // End of jigim_header_style.

if ( ! function_exists( 'jigim_video_controls' ) ) :
/**
 * Customize video play/pause button in the custom header.
 * 修改header video参数设置，添加界面的翻译和图标
 * @param array $settings Video settings.
 * @return array The filtered video settings.
 */
function jigim_video_controls( $settings ) {
	$settings['l10n']['play'] = '<span class="screen-reader-text">' . __( 'Play background video', 'twentyseventeen' ) . '</span><span class="fa fa-play-circle"></span>';
	$settings['l10n']['pause'] = '<span class="screen-reader-text">' . __( 'Pause background video', 'twentyseventeen' ) . '</span><span class="fa fa-pause-circle></span>"';
	return $settings;
}
endif;
add_filter( 'header_video_settings', 'jigim_video_controls' );
