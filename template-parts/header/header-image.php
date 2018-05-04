<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>
<div class="custom-header">

	<?php //section1.显示自定义header（图片）的标记
    if( has_custom_header() ) :?>
    <div class="custom-header-media">
		<?php the_custom_header_markup(); ?>
	</div>
    <?php endif; ?>

	<?php //section2.显示自定义logo图片、标题副标题 ?>
	<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

</div><!-- .custom-header -->
