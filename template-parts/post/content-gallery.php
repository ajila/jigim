<?php
/**
 * Template part for displaying gallery posts
 * post-format为gallery的content模板
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if( ! is_single() ) :   //若非单篇文章(即文章列表) ?>
        <?php if ( get_post_gallery() ): //有画廊，则以slider的方式，显示画廊图片 ?>
            <?php $ID = get_the_ID(); ?>
		    <div class="entry-gallery">
                <div id="carousel-post-gallery-<?php echo $ID; ?>" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox"> <!-- Wrapper for slides -->
                        <?php
                        $gallery_image_num = 0;
                        $gallery_img = get_post_gallery_images(); //获取画廊的所有图片
                        foreach( $gallery_img as $image ){
                            echo '<div class="item '. ($gallery_image_num ? '': 'active') . '"><img src="'
                                 . $image . '" class="post-gallery-image"></div>';
                            $gallery_image_num++;
                        }
                        ?>
                    </div> <!-- .carousel-inner -->

                    <ol class="carousel-indicators">    <!-- Indicators -->
                        <?php
                        for($i = 0; $i < $gallery_image_num; $i++) {
                            echo '<li data-target="#carousel-post-gallery-'
                            . $ID
                            . '" data-slide-to="'
                            . $i
                            . '" class="'
                            . ($i ? '' : 'active')
                            . '"></li>';
                            }
                        ?>
                    </ol> <!-- .carousel-indicators -->

                    <a class="left carousel-control" href="#carousel-post-gallery-<?php echo $ID ?>" role="button" data-slide="prev">
                        <span class="fa fa-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only"><?php _e( 'Previous', 'twentyseventeen' ); ?></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-post-gallery-<?php echo $ID ?>" role="button" data-slide="next">
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only"><?php _e( 'Next', 'twentyseventeen' ); ?></span>
                    </a>
                </div>  <!-- .carousel -->
            </div>  <!-- .entry-gallery -->

        <?php elseif('' !== get_the_post_thumbnail() ) : //无画廊有缩略图，则显示缩略图 ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
				    <?php the_post_thumbnail( 'jigim-thumbnail-image' ); ?>
                </a>
            </div><!-- .post-thumbnail -->

        <?php else: //也无缩略图，则显示文章中第一张图片 ?>
            <?php $img = jigim_get_post_first_img( get_the_content() ); ?>
            <div class="post-image-attachment"><a href="<?php the_permalink(); ?>">
                <img src = "<?php jigim_get_post_first_img( get_the_content() );?>" alt="post image attachment">
            </a> </div><!-- .post-image-attachment -->
        <?php endif; ?>
    <?php endif; ?>


	<?php if ( is_sticky() && is_home() ) : //当前是主页（文章列表）且是置顶文章，输出图标 ?>
        <span class="fa fa-thumb-tack"></span>
	<?php endif; ?>


	<?php if( !is_single() ): //非单篇文章(文章列表)，显示文章meta信息和标题 ?>
	<header class="entry-header">
    <?php
        //section1: 文章分类
        jigim_entry_category();

        //section2: 文章标题
        jigim_entry_title();
    ?>
	</header><!-- .entry-header -->
	<?php endif; ?>


	<?php if( is_single()): //TODO：面包屑导航 ?>
	<?php endif; ?>


	<?php //if ( is_single() || (!get_post_gallery() &&  !get_the_post_thumbnail()) ):
	    //若是单篇文章，或文章列表时既无画廊也无缩略图，则显示文章内容    ?>
    <?php if ( is_single() ): //若是单篇文章，则显示文章内容 ?>
	    <div class="entry-content">
		    <?php
            /* translators: %s: Name of current post */
            the_content( sprintf(
                __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                get_the_title()
            ) );

            //单文章分页时，显示分页链接
            wp_link_pages( array(
                'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
                'after'       => '</div>',
                'link_before' => '<span class="page-number">',
                'link_after'  => '</span>',
            ) );
		    ?>
    	</div><!-- .entry-content -->


        <footer class="entry-footer">
            <?php jigim_entry_tag();    //输出tag列表 ?>
        </footer>
	<?php else: ?>
        <footer class="entry-footer">
			<?php jigim_posted_on(); //文章列表时，作者日期时间显示在底部 ?>
        </footer>
	<?php endif; ?>

</article><!-- #post-## -->
