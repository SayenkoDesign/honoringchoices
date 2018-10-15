<?php

// Add Search icon to primary menu
function primary_navigation( $items, $args ) {
    if( $args->theme_location == 'primary' )  {
       $items .=  sprintf('<li class="menu-item menu-item-search"><span><button class="search-button" data-open="modal-search"><img src="%sicons/search.svg" class="" /><span class="search-text">Search</span></span></button></li>', trailingslashit( THEME_IMG ) );
    }
    return $items;
}

add_filter( 'wp_nav_menu_items','primary_navigation', 10, 2 );



// Contact Modal
function _s_contact_menu_atts( $atts, $item, $args ) {
      $classes = $item->classes;
      
 	  if ( in_array( 'contact-modal', $classes ) ) {
		$atts['data-open'] = 'contact';
	  }
	  return $atts;
}

// add_filter( 'nav_menu_link_attributes', '_s_contact_menu_atts', 10, 3 );


// remove parent class from homepage - used for single page scroll menus
function clear_nav_menu_item_class($classes, $item, $args) {
    
    
	if( is_front_page() && ( $args->theme_location == 'primary' ) ) {
		$classes = array_filter($classes, "remove_parent_classes");
	}
	
	return $classes;
}

//add_filter('nav_menu_css_class', 'clear_nav_menu_item_class', 10, 3);


// Filter menu items as needed and set a custom class etc....
function set_current_menu_class($classes) {
	global $post;
	
	if( is_singular( 'team' ) ) {
		
		$classes = array_filter($classes, "remove_parent_classes");
		
		if ( in_array('menu-item-27', $classes ) )
			$classes[] = 'current-menu-item';
	}
			
	return $classes;
}

//add_filter('nav_menu_css_class', 'set_current_menu_class',1,2); 


// check for current page classes, return false if they exist.
function remove_parent_classes($class){
  return in_array( $class, array( 'current_page_item', 'current_page_parent', 'current_page_ancestor', 'current-menu-item' ) )  ? FALSE : TRUE;
}



function _s_is_page_template_name( $template_name ) {
	
	if( is_page() ) {
		$template_found = str_replace( '.php', '', basename( get_page_template_slug( get_queried_object_id() ) ) );
		return $template_name === $template_found ? true : false;
	}
	
}
