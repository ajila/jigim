<?php
/**
 * Custom template tags for this theme
 * 自定义模板标签（已有的代码模块化）
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 */

if ( ! function_exists( 'jigim_posted_on' ) ) :
/**
 * 显示当前文章日期和作者等meta信息的html
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jigim_posted_on() {

	// Get the author name; wrap it in a link. 作者名及其链接
	$ID = get_the_author_meta( 'ID' );
	$byline = sprintf(
		/* translators: %s: post author */
		__( 'by %s', 'twentyseventeen' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $ID ) ) . '">' . get_the_author() . '</a></span>'
	);

	// Finally, let's write all of this to the page.作者信息+文章日期
	echo '<span class="post-avatar"><a href="' . esc_url( get_author_posts_url( $ID ) ) . '">'
	     . get_avatar($ID,64,'','') . '</a></span>'
	     . '<span class="byline"> ' . $byline . '</span>'
	     . '<span class="posted-on">' . jigim_time_link() . '</span>';
}
endif;


if ( ! function_exists( 'jigim_time_link' ) ) :
/**
 * 返回文章（发表/更新）日期
 * Gets a nicely formatted string for the published date.
 */
function jigim_time_link() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	$year = get_the_time('Y');
	$month = get_the_time('n');
	$day = get_the_time('j');
	$time_string_updated = '';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		$time_string_updated = '<time class="entry-date updated" datetime="%1$s">%2$s</time>';
		$modified_year = get_the_modified_time('Y');
		$modified_month = get_the_modified_time('n');
		$modified_day = get_the_modified_time('j');
	}

	//组合时间标签
	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date()
	);
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string_updated = sprintf( $time_string_updated,
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);
	}

	// 包装时间标签。Wrap the time string in a link, and preface it with 'Posted on'.
	if( is_single() && ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) )){
		$time_string = sprintf(
		/* translators: %s: post date */
			__( '<span class="posted-time-text">Posted on %1$s</span><span class="updated-time-text">Updated on %2$s</span> ','twentyseventeen' ),
			'<a href="' . esc_url( get_day_link($year,$month,$day) ) . '" rel="bookmark">' . $time_string . '</a>',
			'<a href="' . esc_url( get_day_link($modified_year,$modified_month,$modified_day) ) . '" rel="bookmark">' . $time_string_updated . '</a>'
		);
	}
	else{
		$time_string = sprintf(
		/* translators: %s: post date */
			__( '<span class="posted-time-text">Posted on %s</span>', 'twentyseventeen' ),
			'<a href="' . esc_url( get_day_link($year,$month,$day) ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	}

	return $time_string;
}
endif;


if ( ! function_exists( 'jigim_entry_title' ) ) :
/**
 * 显示文章标题的html
 * Prints HTML with meta information for the title
 */
function jigim_entry_title(){
	if ( is_single() ) {
		the_title( '<h1 class="entry-title">', '</h1>' );
	} elseif ( is_front_page() && is_home() ) {
		the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
	} else {
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	}
}
endif;


if ( ! function_exists( 'jigim_entry_category' ) ) :
/**
 * 显示文章分类信息的html
 * Prints HTML with meta information for the categories
 */
function jigim_entry_category(){

	if ( 'post' === get_post_type() ) { //文章类型才显示

		$categories = get_the_category();   //获取文章的分类对象数组
		if ( $categories ) {
			echo '<ul class="entry-categories">';
			foreach ( $categories as $cat) {
				echo '<li class="category-' . $cat->slug . '"><a href="' . get_category_link($cat)
				     . '" rel="category tag" style="background-color:'
					. jigim_category_feature_color($cat->slug) .'">' . $cat->name . '</a></li>';
			}
			echo '</ul>';
		}
	}
}
/*
function jigim_entry_category_2(){
	if ( 'post' === get_post_type() ) { //文章类型才显示
		$separate_meta = __( ' | ', 'twentyseventeen' );
		// Get Categories for posts.获取分类列表
		$categories_list = get_the_category_list( $separate_meta );

		if ( $categories_list ) {
			//获取文章的分类对象数组
			$categories = get_the_category();
			$cat_num = 0;

			//用分隔符提取字符串
			$array = explode($separate_meta, $categories_list);
			echo '<ul class="entry-category">';
				foreach ( $array as $cat_item) {
					echo '<li class="category-' . $categories[ $cat_num ]->slug . '">' . $cat_item . '</li>';
					$cat_num ++;
				}
			echo '</ul>';
		}
	}
}
*/
endif;


if ( ! function_exists( 'jigim_entry_tag' ) ) :
/**
 * 显示文章tag信息的html
 * Prints HTML with meta information for the tag
 */
function jigim_entry_tag() {
	if ( 'post' === get_post_type() ) { //文章类型才显示

		$tags = get_the_tags(); //获取文章的tag对象数组
		if ( $tags && ! is_wp_error( $tags ) ) {
			if( is_single() ) {
				echo '<span class="tag-text">'.__('tags:', 'twentyseventeen' ).'</span>';
			}
			echo '<ul class="entry-tags">';
			foreach( $tags as $tag_item){
				echo '<li class="tag-' . $tag_item->slug . '"><a href="' . get_tag_link($tag_item)
				     . '" rel="tag">' . $tag_item->name . '</a></li>';
			}
			echo '</ul>';
		}
	}
}
/*
function jigim_entry_tag_2() {
	if ( 'post' === get_post_type() ) { //文章类型才显示
		$separate_meta = __( ', ', 'twentyseventeen' );
		//获取文章的tag列表
		$tags_list = get_the_tag_list( '', $separate_meta );
		if ( $tags_list && ! is_wp_error( $tags_list ) ) {
			//获取文章的tag对象数组
			$tags = get_the_tags();
			$tags_num = 0;

			//用分隔符提取字符串
			echo '<ul class="entry-tags">';
				$array = explode($separate_meta, $tags_list);
				foreach( $array as $tag_item){
					echo '<li class="tag-' . $tags[$tags_num]->slug . '">' . $tag_item . '</li>';
					$tags_num++;
				}
			echo '</ul>';
		}
	}
}
*/
endif;


if ( ! function_exists( 'jigim_entry_footer' ) ) :
/**
 * 显示分类/tag/编辑链接等meta信息的html
 * Prints HTML with meta information for the categories, tags and comments.
 */
function jigim_entry_footer() {
	/* translators: used between list items, there is a space after the comma */
	$separate_meta = __( ', ', 'twentyseventeen' );

	// Get Categories for posts.获取分类列表
	$categories_list = get_the_category_list( $separate_meta );

	// Get Tags for posts.获取tag列表
	$tags_list = get_the_tag_list( '', $separate_meta );

	// We don't want to output .entry-footer if it will be empty, so make sure its not.
	// 分类列表非空且分类数大于1，或tag列表非空，或有编辑链接
	if ( ( ( jigim_categorized_blog() && $categories_list ) || $tags_list ) || get_edit_post_link() ) {

		echo '<footer class="entry-footer">';

			if ( 'post' === get_post_type() ) { //文章类型才显示分类和tag
				if ( ( $categories_list && jigim_categorized_blog() ) || $tags_list ) {
					echo '<span class="cat-tags-links">';
						// Make sure there's more than one category before displaying.
						if ( $categories_list && jigim_categorized_blog() ) {   //显示文章分类
							echo '<span class="cat-links"><span class="fa fa-folder-open-o"></span> '
							     . '<span class="screen-reader-text">' . __( 'Categories', 'twentyseventeen' ) . '</span>' . $categories_list . '</span>';
						}

						if ( $tags_list && ! is_wp_error( $tags_list ) ) {      //显示文章tag
							echo '<span class="tags-links"><span class="fa fa-hashtag"></span> '
							     . '<span class="screen-reader-text">' . __( 'Tags', 'twentyseventeen' ) . '</span>' . $tags_list . '</span>';
						}

					echo '</span>';
				}
			}

			jigim_edit_link(); //显示（文章/页面）编辑链接
		echo '</footer> <!-- .entry-footer -->';
	}
}
endif;


if ( ! function_exists( 'jigim_edit_link' ) ) :
/**
 * Returns an accessibility-friendly link to edit a post or page.
 * 显示（文章/页面）编辑链接
 * This also gives us a little context about what exactly we're editing
 * (post or page?) so that users understand a bit more where they are in terms
 * of the template hierarchy and their content. Helpful when/if the single-page
 * layout with multiple posts/pages shown gets confusing.
 */
function jigim_edit_link() {
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;


if ( ! function_exists( 'jigim_front_page_section' ) ) :
/**
 * Display a front page section.
 * 显示首页章节
 * @param WP_Customize_Partial $partial Partial associated with a selective refresh request.
 * @param integer              $id Front page section to display.
 */
function jigim_front_page_section( $partial = null, $id = 0 ) {
	if ( is_a( $partial, 'WP_Customize_Partial' ) ) {
		// Find out the id and set it up during a selective refresh.
		global $twentyseventeencounter;
		$id = str_replace( 'panel_', '', $partial->id );
		$twentyseventeencounter = $id;
	}

	global $post; // 在创建post data之前，修改全局对象$post.
	if ( get_theme_mod( 'panel_' . $id ) ) {    //获取panel_n的值（page_id）

		$post = get_post( get_theme_mod( 'panel_' . $id ) );//获取指定首页章节(page_id)的post数据
		setup_postdata( $post );             //用返回的post数据创建全局post对象
		set_query_var( 'panel', $id );  //设置查询变量，传递参数给下面的模板文件调用
		//显示首页章节页面内容
		get_template_part( 'template-parts/page/content', 'front-page-panels' );

		wp_reset_postdata();        //复位全局变量$post

	} elseif ( is_customize_preview() ) {   //panel_n未设置，在预览窗口中显示占位符

		// The output placeholder anchor.
		echo '<article class="panel-placeholder panel twentyseventeen-panel twentyseventeen-panel'
		     . $id . '" id="panel' . $id . '"><span class="twentyseventeen-panel-title">'
		     . sprintf( __( 'Front Page Section %1$s Placeholder', 'twentyseventeen' ), $id )
		     . '</span></article>';

	}
}
endif;


if ( ! function_exists( 'jigim_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category.
 * 计算文章分类数，有超过1个分类则返回true
 * @return bool
 */
function jigim_categorized_blog() {
	$category_count = get_transient( 'jigim_categories' ); //获取瞬态值

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.返回文章的分类对象数组
		$categories = get_categories(  array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.只需知道是否大于1，最大返回2个即可
			'number'     => 2,
		));

		// Count the number of categories that are attached to the posts. 分类数组中的元素个数
		$category_count = count( $categories );

		set_transient( 'jigim_categories', $category_count ); //设置瞬态值，令此部分代码只执行一次
	}

	// Allow viewing case of 0 or 1 categories in post preview.预览窗口无论有多少分类都返回true
	if ( is_preview() ) {
		return true;
	}

	return $category_count > 1;
}
endif;


if ( ! function_exists( 'jigim_category_transient_flusher' ) ) :
/**
 * 编辑完成保存后，清除瞬态值
 * Flush out the transients used in jigim_categorized_blog.
 */
function jigim_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'jigim_categories' );
}
endif;
add_action( 'edit_category', 'jigim_category_transient_flusher' );
add_action( 'save_post',     'jigim_category_transient_flusher' );


if ( ! function_exists( 'jigim_archive_meta_header' ) ) :
/**
* 显示单篇文章页single的
* header部分（特性图、分类、标题、作者、日期等信息）
* Prints HTML with meta information for the single
*/
function jigim_single_meta_header(){
	echo '<header class="meta-header">';

		//1.特性图
		echo '<div class="featured-image-header">';
		if ( '' !== get_the_post_thumbnail() ) { //有特性图，则显示特性图
			the_post_thumbnail( 'jigim-featured-image' );
		}
		else {   //无特性图，则显示默认特性图
			echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/default_feature.jpg" alt="feature image">';
		}
		echo '</div><!-- .featured-image-header -->';

		echo '<div class="meta-container">';
			//2.文章分类
			jigim_entry_category();

			//3: 文章标题
			jigim_entry_title();

			//4: 作者、日期
			echo '<div class="entry-meta">';
				jigim_posted_on();    //打印作者头像日期时间
				echo '<span class="entry-views">阅读次数 '.jigim_get_post_views(get_the_ID()).'</span>';
				jigim_edit_link();  //打印编辑链接
			echo '</div>';  //.entry-meta
		echo '</div>';  //.meta-container

	echo '</header>';   //.meta-header
}
endif;


if ( ! function_exists( 'jigim_archive_meta_header' ) ) :
/**
 * 显示存档页archive（category、tag、date、author等）的
 * header部分（特性图、标题、简介、文章数等信息）
 * Prints HTML with meta information for the archive
 */
function jigim_archive_meta_header(){

	global  $wp_query;
	$arch_obj = get_queried_object();
	$post_num = $wp_query->found_posts; //由全局查询对象获取匹配结果数量

	if ( is_category() ) {

		$label_string = '<span class="fa fa-folder-open-o">'.__('category','twentyseventeen').'</span>';
		$title = single_cat_title( '', false );
		$title_string = sprintf( __( '%1$s Category: %2$s','twentyseventeen' ),
			'<span class="sr-only">','</span>'.$title );
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/feature_category-'.$arch_obj->slug.'.jpg';

	} elseif ( is_tag() ) {

		$label_string = '<span class="fa fa-tag">'.__('tags','twentyseventeen').'</span>';
		$title = single_tag_title( '', false );
		$title_string = sprintf( __( '%1$s Tag: %2$s','twentyseventeen' ),
			'<span class="sr-only">','</span>'.$title );
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/feature_tag-'.$arch_obj->slug.'.jpg';

	} elseif ( is_author() ) {

		$label_string = '<span class="fa fa-user-circle">'.__('author','twentyseventeen').'</span>';
		$title = get_the_author();
		$title_string = sprintf( __( '%1$s Author: %2$s','twentyseventeen' ),
			'<span class="sr-only">','</span><span class="vcard">' .$title . '</span>' );
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/feature_author-'.$title.'.jpg';
		$avatar = get_avatar(get_the_author_meta( 'ID' ),64,'','');
		//$post_num = get_the_author_posts();

	} elseif ( is_year() ) {

		$label_string = '<span class="fa fa-calendar">'.__('year','twentyseventeen').'</span>';
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/feature_year.jpg';
		$title_string = sprintf( __( '%1$s Year: %2$s','twentyseventeen' ),
			'<span class="sr-only">', '</span>'.get_the_date( _x( 'Y', 'yearly archives date format' ) ) );

	} elseif ( is_month() ) {

		$label_string = '<span class="fa fa-calendar">'.__('month','twentyseventeen').'</span>';
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/feature_month.jpg';
		$title_string = sprintf( __( '%1$s Month: %2$s','twentyseventeen' ),
			'<span class="sr-only">', '</span>'.get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );

	} elseif ( is_day() ) {

		$label_string = '<span class="fa fa-calendar">'.__('day','twentyseventeen').'</span>';
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/feature_day.jpg';
		$title_string = sprintf( __( '%1$s Day: %2$s','twentyseventeen' ),
			'<span class="sr-only">', '</span>'.get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );

	} else {

		$label_string = '<span class="fa fa-file-archive-o">'.__('archive','twentyseventeen').'</span>';
		$feature_image = get_stylesheet_directory_uri() . '/assets/images/default_feature.jpg';
		$title_string = __( 'Archives','twentyseventeen' );
		$post_num = 0;

	}

	//$feature_image = '<div class="single-featured-image-header"><img src="'.$feature_image.'" alt="feature image"></div>';
	//$title_string = '<h1 class="page-title">'.$title_string.'</h1>';
	//$post_num_string = '';//'<span class="archive-post-num">'.$post_num.'篇文章</span>';
	//$description_string = '<div class="taxonomy-description">'.get_the_archive_description().'</div>';

	echo '<header class="meta-header">';
		echo '<div class="featured-image-header"><img src="'.$feature_image.'" alt="feature image"></div>';
		echo '<div class="meta-container">';
			echo '<div class="meta-label">'.$label_string.'</div>';
			if( is_author() ){
				echo '<span class="meta-avatar">' .$avatar. '</span>';
			}
			echo '<h1 class="meta-title">'.$title_string.'</h1>';
			echo '<span class="meta-post-num">'.$post_num.'篇文章</span>';
			echo '<div class="meta-taxonomy-description">'.get_the_archive_description().'</div>';
		echo '</div>';  //.meta-container
	echo '</header>';   //.meta-header
}
endif;

if ( ! function_exists( 'jigim_carousel_img_lazyload' ) ) :
/**
 * flickity幻灯片图片支持lazyload
 * 添加class，src属性改为data-flickity-lazyload属性，
 * 并输出html标签
 * @param string       $html img标签html
 * @return string       返回修改后的img标签html
 */
function jigim_carousel_img_lazyload( $html ) {
	if ( ! $html ) {
		return null;
	}

	$html = str_replace( 'src=', 'data-flickity-lazyload=', $html );
	$html = str_replace( 'class="', 'class="carousel-cell-image ', $html );
	return $html;
}
endif;


if ( ! function_exists( 'jigim_echo_responsive_thumbnail' ) ) :
/**
 * 修改首页幻灯片、文章列表缩略图、文章特性图
 * 等图片的srcset、sizes响应式属性，
 * 并输出html标签
 * @param int|WP_Post  $post Post ID or WP_Post object.  Default is global `$post`.
 * @param string       $thumb_pos 输出哪个位置的缩略图
 *
 */
function jigim_echo_responsive_thumbnail( $post, $thumb_pos ){
	if ( ! $post ) {
		return;
	}

	$html = null;
	if('slider-front-page' === $thumb_pos) {
/*
		add_filter( 'wp_calculate_image_sizes', 'jigim_content_image_sizes_attr', 10, 2 );
		$html = get_the_post_thumbnail( $post, 'jigim-featured-image' );
		//flickity幻灯片图片lazyload
		$html = jigim_carousel_img_lazyload($html);
*/

		//使用blazy.js方案，实现响应式+懒加载图片
		/*
		$meta_data = wp_get_attachment_metadata( get_post_thumbnail_id($post), false);
		$img_loc = dirname($meta_data["file"]);
		$img_lg = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-image"]["file"];
		$img_md = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-md"]["file"];
		$img_sm = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-sm"]["file"];
		$html = '<img class="attachment-jigim-featured-image size-jigim-featured-image wp-post-image b-lazy" '
		        //. ' src="' . get_stylesheet_directory_uri() . '/assets/images/default_feature.jpg"'
		        . ' src=data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw== '
				. ' data-src="' . $img_lg
		        . '" data-src-small="' . $img_sm
		        . '" data-src-middle="' . $img_md
		        . '" alt="feature image">';
		*/

		//使用jQuery.lazyload方案实现响应式+懒加载图片
		/*
		$meta_data = wp_get_attachment_metadata( get_post_thumbnail_id($post), false);
		$img_loc = dirname($meta_data["file"]);
		$img_lg = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-image"]["file"];
		$img_md = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-md"]["file"];
		$img_sm = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-sm"]["file"];
		$html = '<img class="attachment-jigim-featured-image size-jigim-featured-image wp-post-image lazyload" '
		        //. ' src="' . get_stylesheet_directory_uri() . '/assets/images/default_feature.jpg"'
		        . ' src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=" '
		        . ' data-src="' . $img_sm
		        . '" data-srcset="' . $img_sm . ' 768w, ' . $img_md . ' 1200w, ' . $img_lg . '" alt="feature image">';
		*/

		//使用picturefill.js实现响应式图片+jQuery.lazyload实现懒加载
		$meta_data = wp_get_attachment_metadata( get_post_thumbnail_id($post), false);
		$img_loc = dirname($meta_data["file"]);
		$img_lg = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-image"]["file"];
		$img_md = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-md"]["file"];
		$img_sm = get_bloginfo('url') . '/wp-content/uploads/' . $img_loc . '/' . $meta_data["sizes"]["jigim-featured-sm"]["file"];
		//$html = '<span class="picture-fill" data-picture data-lazy-load data-alt="carousel feature image">'
		$html = '<span class="picture-fill" data-picture data-alt="carousel feature image">'
		        . '<span data-src="' . $img_sm . '"></span>'
		        . '<span data-src="' . $img_md . '" data-media="(min-width: 769px)"></span>'
		        . '<span data-src="' . $img_lg . '" data-media="(min-width: 1201px)"></span>'
		        //. '<!--[if (lt IE 9) & (!IEMobile)]><span data-src="' . $img_lg . '"></span><![endif]-->' //已通过respond.js支持media query
		        . '<noscript><img src="' . $img_lg . '" alt="carousel feature image"></noscript>'
		        . '</span>';

	} else if ('slider-related-post' === $thumb_pos) {

		//使用flickity方案，懒加载图片
		$html = get_the_post_thumbnail( $post, 'jigim-thumbnail-avatar' );
		$html = jigim_carousel_img_lazyload($html);

	} else if( 'slider-gallery' === $thumb_pos ) {


	}



	echo $html;
}
endif;