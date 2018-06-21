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

        <?php
        //section1.放widget的sidebar区
        get_template_part( 'template-parts/footer/footer', 'widgets' );


		//section2.站点信息区
		get_template_part( 'template-parts/footer/site', 'info' );
		?>

</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); //往body的最后添加内容 ?>

</body>
</html>
