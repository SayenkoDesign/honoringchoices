<?php

function my_acf_init() {
	
	acf_update_setting('google_api_key', GOOGLE_API_KEY );
}

add_action('acf/init', 'my_acf_init');

/**
*  Creates ACF Options Page(s)
*/

if( function_exists('acf_add_options_sub_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title' 	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability' 	=> 'edit_posts',
 		'redirect' 	=> true
	));
    /*
    acf_add_options_sub_page(array(
		'page_title' 	=> 'General',
		'menu_title' 	=> 'General',
        'menu_slug' 	=> 'theme-settings-general',
        'parent' 		=> 'theme-settings',
		'capability' => 'edit_posts',
 		'redirect' 	=> false,
        'autoload' => true,
	));
    */
    
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer CTA',
		'menu_title' 	=> 'Footer CTA',
        'menu_slug' 	=> 'theme-settings-footer-cta',
        'parent' 		=> 'theme-settings',
		'capability' => 'edit_posts',
 		'redirect' 	=> false,
        'autoload' => true,
	));
    
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Social Profiles',
		'menu_title' 	=> 'Social Profiles',
        'menu_slug' 	=> 'theme-settings-social',
        'parent' 		=> 'theme-settings',
		'capability' => 'edit_posts',
 		'redirect' 	=> false,
        'autoload' => true,
	));
    
    
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Locations Settings',
		'menu_title' 	=> 'Locations Settings',
		'parent'     => 'edit.php?post_type=location',
		'capability' => 'edit_posts'
	));

}


function _s_get_acf_options() {
    
    $all_options = wp_load_alloptions();
    $acf_options  = array();
     
    foreach ( $all_options as $name => $value ) {
        if ( substr( $name, 0, 8 ) === "options_" ) {
            $name = str_replace( 'options_', '', $name );
            $acf_options[ $name ] = $value;
        }
    }
        
    return $acf_options;
   
}


function _s_get_acf_option( $name = '' ) {
    
    $acf_options = _s_get_acf_options();
    
    if( isset( $acf_options[$name] ) && !empty( $acf_options[$name] ) ) {
        return $acf_options[$name];
    }
    
    return false;
}


function _s_get_acf_image( $attachment_id, $size = 'large', $background = FALSE, $class = array() ) {

	if( ! absint( $attachment_id ) )
		return FALSE;

	if( wp_is_mobile() ) {
 		$size = 'large';
	}

	if( $background ) {
		$background = wp_get_attachment_image_src( $attachment_id, $size );
		return $background[0];
	}

	return wp_get_attachment_image( $attachment_id, $size, '', $class );

}


function _s_get_acf_oembed( $iframe ) {


	// use preg_match to find iframe src
	preg_match('/src="(.+?)"/', $iframe, $matches);
	$src = $matches[1];


	// add extra params to iframe src
	$params = array(
		'controls'    => 1,
		'hd'        => 1,
		'autohide'    => 1,
		'rel' => 0
	);

	$new_src = add_query_arg($params, $src);

	$iframe = str_replace($src, $new_src, $iframe);


	// add extra attributes to iframe html
	$attributes = 'frameborder="0"';

	$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

	$iframe = sprintf( '<div class="embed-container">%s</div>', $iframe );


	// echo $iframe
	return $iframe;
}



// filter for a specific field based on it's name
add_filter('acf/fields/relationship/query/name=related_posts', 'my_relationship_query', 10, 3);
function my_relationship_query( $args, $field, $post_id ) {
	
    // exclude current post from being selected
    $args['exclude'] = $post_id;
	
	
	// return
    return $args;
    
}



function alter_specific_user_field( $result, $user, $field, $post_id ) {

    $result = $user->user_email;

    if( $user->first_name ) {
        
        $result .= ' (' .  $user->first_name;
        
        if( $user->last_name ) {
            
            $result .= ' ' . $user->last_name;
            
        }
        
        $result .= ')';
    }

    return $result;
}
// add_filter("acf/fields/user/result", 'alter_specific_user_field', 10, 4);