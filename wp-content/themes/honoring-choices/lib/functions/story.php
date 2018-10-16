<?php

// If we have a custom url, we skip the single story page
add_action( 'template_redirect', function() {
    global $post;
    if ( is_singular( 'story' ) ) {
		$custom_link_url = get_field( 'custom_link_url' );
        if( ! empty( $custom_link_url ) ) {
            wp_redirect( $custom_link_url );
            die;
        }
	}
});