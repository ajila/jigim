
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

(function( $ ) {

	function initMainNavigation( container ) {

		// 为有子菜单的菜单项添加类.
		container.find( '.menu-item-has-children, .page_item_has_children' )
            .addClass( 'dropdown' );

		//为菜单项li的a添加类和属性
        container.find( '.menu-item-has-children > a, .page_item_has_children > a' )
            .addClass( 'dropdown-toggle' )
			.attr('data-toggle', 'dropdown')
			.attr('role', 'button')
			.attr('aria-haspopup', 'true')
			.attr('aria-expanded', 'false')
            .append( $( '<span />', { 'class': 'caret'}) );

        //为子菜单ul添加类
        container.find( '.menu-item-has-children > ul, .page_item_has_children > ul' )
			.addClass( 'dropdown-menu');


	}

	initMainNavigation( $( '#navbar-collapse-top' ) );

})( jQuery );
