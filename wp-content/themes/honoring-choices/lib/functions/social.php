<?php
global $social_profiles;

 
/**
 * Echo social icons.
 */
function _s_get_social_icons( $profiles = array(), $post_id = 'options' ) { 

	if( !is_array( $profiles ) || empty( array_filter( $profiles ) ) ) {
		
        // defaults
        $profiles = array( 
              'linkedin' => get_field( 'linkedin', $post_id ),
              'facebook' => get_field( 'facebook', $post_id ),
              'youtube' => get_field( 'youtube', $post_id ),
              'instagram' => get_field( 'instagram', $post_id ),
              'pinterest' => get_field( 'pinterest', $post_id ),
              'twitter' => get_field( 'twitter', $post_id ),
              'bush' => get_field( 'bush', $post_id ),
         );
  	}
    
    $profiles = array_filter( $profiles );
    
    if( empty( $profiles ) ) {
        return false;
    }
 	
	$out = '';
	
	foreach( $profiles as $type => $url ) {
		
        $icon = get_svg( $type );
        
        if( !empty( $icon ) ) {
			$out .= sprintf( '<li class="social-icon"><a href="%s" title="%s">%s</a></li>', $url, ucwords( $type ), $icon );
		}
	}
	
	return sprintf( '<ul class="social-icons">%s</ul>', $out );

 }
 
 
 function _s_do_social_icons( $profiles = array() ) { 
	if( !empty( $profiles ) ) {
		echo _s_get_social_icons( $profiles );
	}
	
 }
 
 add_shortcode( 'social-icons', '_s_get_social_icons' );
 
 
 
 function get_icon( $type ) {
     
     $icons = array( 
     
        'facebook' => '<i class="fa fa-facebook-square" aria-hidden="true"></i>',
        
        'twitter' => '<i class="fa fa-twitter-square" aria-hidden="true"></i>',
        
        'instagram' => '<i class="fa fa-instagram" aria-hidden="true"></i>'
     
     );
     
     if( isset( $icons[ $type ] ) )
        return $icons[ $type ];
 }