<?php

// Wrapper incase BBPress isnt installed
function hc_is_bbpress() {
    
    if( ! function_exists( 'is_bbpress' ) ) {
        return false;
    }
    
    return is_bbpress();
    
}

/**
* Redirect buddypress and bbpress pages to registration page
*/
function hc_bbpress_template_redirect()
{
    //if not logged in and on a bp page except registration or activation
    if( ! is_user_logged_in() && hc_is_bbpress() )
    {
        // wp_redirect( home_url( '/register/' ) );
        wp_redirect( site_url() );
        exit();
    }
}
add_action( 'template_redirect', 'hc_bbpress_template_redirect' );

/*
add_filter( 'bbp_get_topic_subscribe_link', function( $retval, $r ) {
    return str_replace( '&nbsp;|&nbsp;', '', $retval );
}, 10, 2 );


add_filter( 'bbp_get_user_subscribe_link', function( $html, $r, $user_id, $topic_id ) {
    return str_replace( '&nbsp;|&nbsp;', '', $html );
}, 10, 4 );
*/



add_filter( 'bbp_get_user_edit_profile_url', function( $url ) {
    
  if( ! current_user_can('manage_options') ) {
        $url = get_permalink( 591 );
  }
  else {
    $url = admin_url( 'profile.php' );   
  }
    
  return $url;
} );

