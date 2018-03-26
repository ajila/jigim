<?php
/**
 * SVG icons related functions and filters
 * SVG图标相关函数和filters
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

if ( ! function_exists( 'twentyseventeen_include_svg_icons' ) ) :
/** 包含svg定义到footer
 * Add SVG definitions to the footer.
 */
function twentyseventeen_include_svg_icons() {
	// Define SVG sprite file.
	$svg_icons = get_parent_theme_file_path( '/assets/images/svg-icons.svg' );

	// If it exists, include it.
	if ( file_exists( $svg_icons ) ) {
		require_once( $svg_icons );
	}
}
endif;
//add_action( 'wp_footer', 'twentyseventeen_include_svg_icons', 9999 );

if ( ! function_exists( 'twentyseventeen_get_svg' ) ) :
/**
 * Return SVG markup.
 * 返回svg标记
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function twentyseventeen_get_svg( $args = array() ) {
	// Make sure $args are an array.
	if ( empty( $args ) ) {
		return __( 'Please define default parameters in the form of an array.', 'twentyseventeen' );
	}

	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return __( 'Please define an SVG icon filename.', 'twentyseventeen' );
	}

	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'fallback'    => false,
	);

	// Parse args.
	$args = wp_parse_args( $args, $defaults );

	// Set aria hidden.
	$aria_hidden = ' aria-hidden="true"';

	// Set ARIA.
	$aria_labelledby = '';

	/*
	 * Twenty Seventeen doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
	 *
	 * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
	 *
	 * Example 1 with title: <?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
	 *
	 * Example 2 with title and description: <?php echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
	 *
	 * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
	 */
	if ( $args['title'] ) {
		$aria_hidden     = '';
		$unique_id       = uniqid();
		$aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';

		if ( $args['desc'] ) {
			$aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
		}
	}

	// Begin SVG markup.
	$svg = '<svg class="icon icon-' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';

	// Display the title.
	if ( $args['title'] ) {
		$svg .= '<title id="title-' . $unique_id . '">' . esc_html( $args['title'] ) . '</title>';

		// Display the desc only if the title is already set.
		if ( $args['desc'] ) {
			$svg .= '<desc id="desc-' . $unique_id . '">' . esc_html( $args['desc'] ) . '</desc>';
		}
	}

	/*
	 * Display the icon.
	 *
	 * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
	 *
	 * See https://core.trac.wordpress.org/ticket/38387.
	 */
	$svg .= ' <use href="#icon-' . esc_html( $args['icon'] ) . '" xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use> ';

	// Add some markup to use as a fallback for browsers that do not support SVGs.
	if ( $args['fallback'] ) {
		$svg .= '<span class="svg-fallback icon-' . esc_attr( $args['icon'] ) . '"></span>';
	}

	$svg .= '</svg>';

	return $svg;
}
endif;

if ( ! function_exists( 'twentyseventeen_nav_menu_social_icons' ) ) :
/**
 * Display SVG icons in social links menu.
 * 在social链接菜单项中添加svg图标
 * @param  string  $item_output The menu item output. 每个菜单项li输出的html
 * @param  WP_Post $item        Menu item object.     每个菜单项li对象
 * @param  int     $depth       Depth of the menu.    菜单深度
 * @param  array   $args        wp_nav_menu() arguments. 函数wp_nav_menu的参数对象
 * @return string  $item_output The menu item output with social icon.
 */
function twentyseventeen_nav_menu_social_icons( $item_output, $item, $depth, $args ) {
	// Get supported social icons.
	$social_icons = twentyseventeen_social_links_icons();

	// Change SVG icon inside social links menu if there is supported URL.
	if ( 'social' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$item_output = str_replace( $args->link_after, '</span>' . twentyseventeen_get_svg( array( 'icon' => esc_attr( $value ) ) ), $item_output );
			}
		}
	}

	return $item_output;
}
endif;
//add_filter( 'walker_nav_menu_start_el', 'twentyseventeen_nav_menu_social_icons', 10, 4 );


if ( ! function_exists( 'twentyseventeen_dropdown_icon_to_menu_link' ) ) :
/**
 * Add dropdown icon if menu item has children.
 * 为有子菜单的菜单项添加图标
 * @param  string  $title The menu item's title. 菜单项li内a内的title
 * @param  WP_Post $item  The current menu item.当前菜单项li对象
 * @param  array   $args  An array of wp_nav_menu() arguments.函数wp_nav_menu的参数对象
 * @param  int     $depth Depth of menu item. Used for padding.菜单深度
 * @return string  $title The menu item's title with dropdown icon.
 */
function twentyseventeen_dropdown_icon_to_menu_link( $title, $item, $args, $depth ) {
	if ( 'top' === $args->theme_location ) {
		foreach ( $item->classes as $value ) {
			if ( 'menu-item-has-children' === $value || 'page_item_has_children' === $value ) {
				$title = $title . twentyseventeen_get_svg( array( 'icon' => 'angle-down' ) );
			}
		}
	}

	return $title;
}
endif;
//add_filter( 'nav_menu_item_title', 'twentyseventeen_dropdown_icon_to_menu_link', 10, 4 );


if ( ! function_exists( 'twentyseventeen_social_links_icons' ) ) :
/**
 * Returns an array of supported social links (URL and icon name).
 * 支持的social链接列表（链接、图标名）
 * @return array $social_links_icons
 */
function twentyseventeen_social_links_icons() {
	// Supported social links icons.
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'docker.com'      => 'dockerhub',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'envelope-o',
		'medium.com'      => 'medium',
		'pinterest.com'   => 'pinterest-p',
		'pscp.tv'         => 'periscope',
		'getpocket.com'   => 'get-pocket',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);

	/**
	 * Filter Twenty Seventeen social links icons.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param array $social_links_icons Array of social links icons.
	 */
	return apply_filters( 'twentyseventeen_social_links_icons', $social_links_icons );
}
endif;