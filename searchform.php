<?php
/**
 * Template for displaying search forms
 *
 * @package WordPress
 * @subpackage Jig_im
 * @since 1.0
 * @version 1.0
 */

?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); //由于被嵌入其他页面，可能一个页面有多个，故每个用唯一id ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="input-group">

        <label for="<?php echo $unique_id; ?>">
            <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'twentyseventeen' ); ?></span>
        </label>

        <input type="search" id="<?php echo $unique_id; ?>" class="search-field form-control"
               placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'twentyseventeen' ); ?>"
               value="<?php echo get_search_query(); ?>" name="s" />

        <div class="input-group-btn">
            <button type="submit" class="search-submit btn btn-default">
                <span class="fa fa-search fa-lg"></span>
                <span class="screen-reader-text"><?php echo _x( 'Search', 'submit button', 'twentyseventeen' ); ?></span>
            </button>
        </div>

    </div>
</form>
