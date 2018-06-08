<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->

	</div><!-- .site-content-contain -->

</div><!-- .content-wrap -->

    <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="container">
        <div class="row">
			<?php
			//section1.放widget的sidebar区
			get_template_part( 'template-parts/footer/footer', 'widgets' );

			//section2.社交网络链接菜单
			if ( has_nav_menu( 'social' ) ) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
                <span><?php _e( 'contact us:', 'twentyseventeen' ); ?></span>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'social',
					'menu_class'     => 'social-links-menu',
					'depth'          => 1,
				) );
				?>
            </nav><!-- .social-navigation -->
        </div><!-- .row -->
		<?php endif;

		//section3.站点信息区
		get_template_part( 'template-parts/footer/site', 'info' );
		?>
    </div><!-- .wrap -->
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); //往body的最后添加内容 ?>

</body>
</html>
