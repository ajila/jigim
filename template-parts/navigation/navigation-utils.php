<?php
/**
 * Displays top navigation utils
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>


<div class="nav-utils">

	<?php //todo:用户登录 ?>
    <div class="nav-login">
        <a href="/wp-login.php" target="_blank">
            <span class="sr-only"><?php _e('user login button', 'twentyseventeen'); ?></span>
            <span class="fa fa-user"></span>
        </a>
    </div>

    <?php //搜索框、搜索按钮 ?>
    <div class="nav-search">
        <input type="text" class="nav-search-input" name="nav-search" placeholder="<?php _e('Search...', 'twentyseventeen'); ?>">

        <a type="button" href="#" class="nav-search-btn">
            <span class="sr-only"><?php _e('navigation search button', 'twentyseventeen'); ?></span>
            <span class="fa fa-search"></span>
        </a>
    </div>  <!-- /.nav-search -->


    <?php //是首页则显示跳到内容的链接
    if ( ( jigim_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
    <a href="#content" class="menu-scroll-down">
        <?php //echo twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); ?>
        <span class="fa fa-angle-double-down"></span>
        <span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span>
    </a>
    <?php endif; ?>
</div><!-- .nav-utils -->

