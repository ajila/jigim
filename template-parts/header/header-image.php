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
	<?php //section1.打印自定义header标记（图片） ?>
    <div class="custom-header-media">
		<?php the_custom_header_markup(); ?>
	</div>

	<?php //section2.打印自定义logo图片和标题 ?>
	<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>

</div><!-- .custom-header -->
