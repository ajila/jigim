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


<ul class="nav-utils">

	<?php //用户登录按钮 ?>
    <li class="nav-login">
        <a href="/wp-login.php" target="_blank">
            <span class="sr-only"><?php _e('user login button', 'twentyseventeen'); ?></span>
            <span class="fa fa-user fa-lg"></span>
        </a>
    </li>

    <?php //搜索按钮下拉搜索框 ?>
    <li class="nav-search">
        <a class="nav-search-btn" id="searchModalBtn" role="button">
            <span class="sr-only"><?php _e('navigation search button', 'twentyseventeen'); ?></span>
            <span class="fa fa-search fa-lg"></span>
        </a>

    </li>  <!-- /.nav-search -->


    <?php //是首页则显示跳到内容的链接
    if ( ( jigim_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
    <li>
        <a href="#content" class="menu-scroll-down">
            <span class="fa fa-angle-double-down"></span>
            <span class="screen-reader-text"><?php _e( 'Scroll down to content', 'twentyseventeen' ); ?></span>
        </a>
    </li>
    <?php endif; ?>
</ul><!-- .nav-utils -->

