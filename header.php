<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="profile" href="http://gmpg.org/xfn/11"> -->
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="jig">

<?php wp_head(); //hook方便往head添加内容?>
</head>

<body <?php body_class(); //hook方便添加class ?>>

<div id="page" class="site">
	<a class="screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<?php //section1.header图片和logo
		get_template_part( 'template-parts/header/header', 'image' );
		?>

		<?php //section2.导航菜单
        if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>

        <?php   //section3.导航工具（搜索框、用户登录/信息块等）
        get_template_part( 'template-parts/navigation/navigation', 'utils' );
        ?>

	</header><!-- #masthead -->

	<?php
    //section3. 是首页才显示 幻灯片轮播
    if( is_front_page()) :
		get_template_part('template-parts/slider/slider','front-page');
    endif;

	/* section4.单篇文章、非首页的页面，有特性图则显示，无则显示默认图
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if (  is_single() || ( is_page() && ! jigim_is_frontpage() ) ):
        if( has_post_thumbnail( get_queried_object_id() ))  :
            echo '<div class="single-featured-image-header">';
            echo get_the_post_thumbnail( get_queried_object_id(), 'jigim-featured-image' );
            echo '</div><!-- .single-featured-image-header -->';
        else:
            echo '<div class="single-featured-image-header"><img src="'
                .get_stylesheet_directory_uri() . '/assets/images/default_feature.jpg'
                .'" alt="feature image"></div>';
        endif;
	endif;
	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">
