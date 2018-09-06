<?php

// Turn on label visibility
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// On submit scroll back down to form
//add_filter( 'gform_confirmation_anchor', '__return_true' );

// Remove scroll to a specific form #5
//add_filter( 'gform_confirmation_anchor_5', '__return_false' );



function after_user_activate( $user_id, $user_data, $signup_meta ) {
    //add note to entry
    GFFormsModel::add_note( $signup_meta['lead_id'], $user_id, 'admin', 'The user signup has completed for ' . $user_data['display_name'] . '.');
}

add_action( 'gform_activate_user', 'after_user_activate', 10, 3 );


function replace_merge_tags( $text, $form, $entry, $url_encode, $esc_html, $nl2br, $format ) {

    if ( empty( $entry ) || empty( $form ) ) {
        return $text;
    }
    
    $activation_url_merge_tag = '{activation_urls}';
    if ( strpos( $text, $activation_url_merge_tag ) !== false ) {
        $key = gform_get_meta( $entry['id'], 'activation_key' );
        
        $groups_query_args = array(
			'post_type'		=>	'groups',
            'fields'        => 'ids',
			'nopaging'		=>	true
		);
	
	
		$groups_query = new WP_Query( $groups_query_args );
		
        $ids =  $groups_query->posts;
        
        if( empty( $ids ) ) {
            return $text;
        }
        
        $links = '';
        
        foreach( $ids as $id ) {
            $url = empty( $key ) ? '' : add_query_arg( array( 'page' => 'gf_activation', 'key'  => $key, 'group_id' => $id ), home_url( '/' ) );
            
            $links .= '<br />' . $url;
        }
            
        $text = str_replace( $activation_url_merge_tag, $links, $text );
    }
    
    
    
    return $text;
}
    
add_filter( 'gform_replace_merge_tags', 'replace_merge_tags', 20, 7 );