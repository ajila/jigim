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
    <!--[if lt IE 8]>
    <div class="browserupgrade">
        <h4>You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" style="text-decoration:underline">upgrade your browser</a> to improve your experience.</h4>
        <h4>你使用的浏览器版本<strong>已经过时</strong>. 为了获得更好的体验，请<a href="http://browsehappy.com/" style="text-decoration:underline">升级你的浏览器</a>.</h4>
    </div>
    <![endif]-->

	<a class="screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
        <div class="banner-bar container-fluid">
            <?php //section1.header图片和logo，标题副标题
            get_template_part( 'template-parts/header/header', 'image' );

            //section2.导航工具（搜索框、用户登录/信息块等）
            get_template_part( 'template-parts/navigation/navigation', 'utils' );
            ?>
        </div>

		<?php //section3.导航菜单
        if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
                <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
			</div><!-- .navigation-top -->
		<?php endif; ?>

	</header><!-- #masthead -->


    <div class="content-wrap">
	<?php   //首页显示 幻灯片轮播
    if( is_front_page() && is_home() ) :
		get_template_part('template-parts/slider/slider','front-page');

    else: //其他页显示 特色图页头区 ?>

	    <div class="featured-header">
    <?php   //section4.
	/* 非静态首页的页面：有特色图则显示，无则显示默认图
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if ( is_page() && ! jigim_is_frontpage() ):
		echo '<div class="featured-image-header">';
        if( has_post_thumbnail( get_queried_object_id() ))  :
            //echo get_the_post_thumbnail( get_queried_object_id(), 'jigim-featured-image' );
	        jigim_echo_responsive_thumbnail( get_queried_object(), 'page-feature-image');
        else:
            //echo '<img src="' .get_stylesheet_directory_uri() . '/assets/images/feature_default.jpg' .'" alt="feature image">';
	        jigim_echo_responsive_thumbnail( null, 'default');
        endif;
		echo '</div>';

    elseif ( is_single() ):
        //single文章内容页：特色图、标题、分类日期作者等信息
        if ( have_posts() ) :
            the_post();
            //section1: 特色图、分类、标题、作者、日期等信息
            jigim_single_meta_header( $post );
	        rewind_posts(); //后面主内容区也对同一个query对象执行the_post()，因此在两次执行之间加上rewind_posts()
        endif;

	elseif ( is_archive() ):
		//archive页：特色图、标题、文章数、简介等信息
		jigim_archive_meta_header();

    elseif ( is_search() ):
        //搜索结果页：显示图片
	    jigim_search_meta_header();

    elseif ( is_404() ):
        //404页：显示图片
	    echo '<div class="featured-image-header">';
	    jigim_echo_responsive_thumbnail( null, '404-feature-image');
	    echo '</div>';
    endif;
	?>
    </div> <!-- .featured-header -->

    <?php endif; ?>


	<div class="site-content-contain">
		<div id="content" class="site-content">
