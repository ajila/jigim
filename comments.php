<?php
/**
 * The template for displaying comments
 * 显示当前评论和发表评论表单
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

/* 需要密码且输入错误，则返回
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php   //若有评论则显示所有评论
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

        <?php //1.评论标题和评论数 ?>
		<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'twentyseventeen' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx('%1$s Reply to &ldquo;%2$s&rdquo;','%1$s Replies to &ldquo;%2$s&rdquo;',$comments_number,'comments title','twentyseventeen'),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}
			?>
		</h2>

        <?php //2.列出所有评论 ?>
		<ol class="comment-list">
			<?php
            wp_list_comments( array(
                'avatar_size' => 100,
                'style'       => 'ul',
                'short_ping'  => true,
                'reply_text'  => '<span class="fa fa-reply"></span>' . __( 'Reply', 'twentyseventeen' ),
            ) );
			?>
		</ol>

		<?php //3.评论分页链接 ?>
		<?php the_comments_pagination( array(
			'prev_text' => '<span class="fa fa-chevron-left"></span><span class="screen-reader-text">' . __( 'Previous', 'twentyseventeen' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'twentyseventeen' ) . '</span><span class="fa fa-chevron-right"></span>' ,
		) );
	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
    // 若当前文章支持评论，且有评论，且评论关闭，则显示提示消息
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'twentyseventeen' ); ?></p>
	<?php
	endif;

    //4.发表评论表单
	comment_form();
	?>

</div><!-- #comments -->
