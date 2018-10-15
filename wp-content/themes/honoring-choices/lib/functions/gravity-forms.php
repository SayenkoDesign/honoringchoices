<?php

// Turn on label visibility
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// On submit scroll back down to form
//add_filter( 'gform_confirmation_anchor', '__return_true' );

// Remove scroll to a specific form #5
//add_filter( 'gform_confirmation_anchor_5', '__return_false' );



/**
 * Gravity Forms Custom Activation Template
 * http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
 */
function hc_gf_maybe_activate_user() {

    $template_path = STYLESHEETPATH . '/gf-activate-template/activate.php';
    $is_activate_page = isset( $_GET['page'] ) && $_GET['page'] == 'gf_activation';
    
    if( ! file_exists( $template_path ) || ! $is_activate_page  )
        return;
    
    require_once( $template_path );
    
    exit();
}

add_action('wp', 'hc_gf_maybe_activate_user', 9);


/**
 * LearnDash set group upon Gravity Forms user activation
 *
 * @since 	1.0
 */
function after_user_activate( $user_id, $user_data, $signup_meta ) {
    $group_id = !empty($_GET['group_id']) ? $_GET['group_id'] : $_POST['group_id'];
    
    if( absint( $group_id ) == $group_id ) {
        ld_update_group_access( $user_id, $group_id );
    }
}

add_action( 'gform_activate_user', 'after_user_activate', 10, 3 );


/**
 * Create links to custom groups activation links for registration Admin email notification. 
 *
 * @since 	1.0
 */
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
            $group_name = get_the_title( $id );
            $links .= '<br />' . sprintf( '<a href="%s">%s</a><br />', $url, $group_name );
        }
            
        $text = str_replace( $activation_url_merge_tag, $links, $text );
    }
    
    
    
    return $text;
}
    
add_filter( 'gform_replace_merge_tags', 'replace_merge_tags', 20, 7 );



