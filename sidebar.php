<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary"
       aria-label="<?php esc_attr_e( 'Blog Sidebar', 'twentyseventeen' ); ?>">

    <?php //侧边栏作弹出菜单时，标题和按钮 ?>
    <div class="sidenav-header">
        <button type="button" id="sidenav-close-btn" class="navbar-toggle sidenav-close">
            <span class="sr-only">close side navigation</span>
            <span class="icon-bar bar1"></span>
            <span class="icon-bar bar2"></span>
            <span class="icon-bar bar3"></span>
        </button>
        <h1 class="sidenav-title">菜单</h1>
    </div>

	<?php
    //关于我模块
	get_template_part( 'template-parts/sidebar/widget', 'about-me' );

	//todo:推荐阅读或专题模块

    //后台设置的widget
    dynamic_sidebar( 'sidebar-1' );
    ?>
</aside><!-- #secondary -->
