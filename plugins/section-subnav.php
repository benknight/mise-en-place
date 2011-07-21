<?php
/**
 * Display subnav based on wp-generated css hooks
 *
 * TODO: make this a widget
 *
 */
function section_subnav() {

	// check for a preselected menu item
	global $subnav_selected_item;
	$selected_class = $subnav_selected_item ? "menu-item-$subnav_selected_item" : false;
	
	$nav_menus = get_registered_nav_menus();
				
	foreach ( array_keys( $nav_menus ) as $nav_menu ) {
	
		$nav = wp_nav_menu( array( 'theme_location' => $nav_menu, 'echo' => false ) );
		
		$xml = simplexml_load_string( $nav );
		
		if ( ! empty( $xml->ul ) ) : foreach ( $xml->ul[0]->li as $menu_item ) :
		
			$menu_item_class = (string) $menu_item['class'];
			if ( ( strstr( $menu_item_class, 'current-menu-ancestor' )
				|| strstr( $menu_item_class, 'current-menu-item' )
				|| strstr( $menu_item_class, 'current-menu-parent' ) 
				|| strstr( $menu_item_class, $selected_class ) )
				&& ! empty( $menu_item->ul ) 
				&& strstr( (string) $menu_item->ul[0]['class'], 'sub-menu' ) ) {
					echo '<nav class="subnav">';
					echo '<h1>' . $menu_item->a->asXML() . '</h1>';
					echo $menu_item->ul->asXML();
					echo '</nav>';
					return;
			}
		
		endforeach; endif;
	}
}