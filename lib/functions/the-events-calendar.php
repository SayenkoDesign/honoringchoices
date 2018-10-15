<?php

add_filter( 'tribe_get_event_link', function( $link, $post_id, $full_link, $url ) {
    $custom_link_url = get_field( 'custom_link_url', $post_id );
    if( ! empty( $custom_link_url ) ) {
        $link = $custom_link_url;
    }
    return $link;
}, 10, 4);


// If we have a custom url, we skip the single event page
add_action( 'template_redirect', function() {
    global $post;
    if ( is_singular( 'tribe_events' ) ) {
		$custom_link_url = get_field( 'custom_link_url' );
        if( ! empty( $custom_link_url ) ) {
            wp_redirect( $custom_link_url );
            die;
        }
	}
});
