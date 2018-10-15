<?php
// Member functions


/**
 * Redirect loggedin users back to homepage if they try to access this page when logged in
 *
 * @since 	1.0
 */


// Logged in pages to ignore
add_action( 'template_redirect', function() {
    global $post;
    if ( is_user_logged_in() && ( 
    
        is_page_template( 'page-templates/login.php' ) || 
        is_page_template( 'page-templates/lost-password.php' ) ||
        is_page_template( 'page-templates/register.php' )
            
           
       ) ) 
    {
        wp_redirect( site_url() );
        die;
	}
    
});

// Logged out pages set to private/learndash && bbpress
add_action( 'template_redirect', function() {
    global $post;
    if ( ! is_user_logged_in() && (
        'private' == get_post_status() ||
        true == hc_is_learndash() ||
        is_page_template( 'page-templates/my-profile.php' )
        
        //( is_page( 591 ) || is_page_template( 'page-templates/edit-profile.php' ) )
       
       ) )
    {         
        wp_redirect( site_url() );
        die;
	}
});


/**
 * Check if login page
 *
 * @since 	1.0
 */
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}


/**
 * Redirect non-admins to the homepage after logging into the site.
 *
 * @since 	1.0
 */
function hc_login_redirect( $redirect_to, $request, $user  ) {
	return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : home_url();
}
add_filter( 'login_redirect', 'hc_login_redirect', 10, 3 );


/**
 * Redirect to the homepage after logging out.
 *
 * @since 	1.0
 */
function hc_redirect_after_logout(){
    wp_redirect( home_url() );
    exit();
}
add_action('wp_logout','auto_redirect_after_logout');


/**
 * Get current user role
 *
 * @since 	1.0
 */
function hc_get_user_role( $user = null ) {
	$user = $user ? new WP_User( $user ) : wp_get_current_user();
	return $user->roles ? array_values( $user->roles )[0] : false;
}

/**
 * Find out if they are a user. We do it this way so that anyone that can read can see content.
 *
 * @since 	1.0
 */
function hc_is_member() {
	return current_user_can( 'read' ) ? true : false;
}

/**
 * Displays signup login message
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function hc_members_login_message() {
    if( ! is_user_logged_in() ) {
        return hc_members_only_message();   
    }  
}

add_shortcode( 'members_login_message', 'hc_members_login_message' );



/**
 * Displays reset password link
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function hc_reset_password_link() {
    return sprintf( '<a href="%s/lost-password/">%s</a>', site_url(), __( 'Forgot your password?' ) );
}

add_shortcode( 'hc_reset_password_link', 'hc_reset_password_link' );


/**
 * Displays reset password form
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function hc_reset_password_shortcode( $attr, $content = null ) {
    
    ob_start( );
    ?>
    <form method="post" action="<?php echo wp_lostpassword_url() ?>" class="wp-user-form">
        <div class="username">
            <label for="user_login" class=""><?php _e('Username or Email'); ?>: </label>
            <input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
        </div>
        <div class="login_fields">
            <?php do_action('login_form', 'resetpass'); ?>
            <input type="submit" name="user-submit" value="<?php _e('Reset my password'); ?>" class="user-submit" tabindex="1002" />
         </div>
    </form>
    <?php
    $output = ob_get_clean( );
    
    return $output;
     
}

add_shortcode( 'hc_lost_password_form', 'hc_reset_password_shortcode' );



/**
 * Display user info
 *
 * @since  0.1.0
 * @access public
 * @param  array   $attr
 * @return string
 */
function hc_user_info( $atts = '' ) {
	
	$a = shortcode_atts( array(
        'value' => 'user_firstname',
    ), $atts );
	
	if( is_user_logged_in() ) {
		// Hello [username]! My Account (link to profile) 
		$user = wp_get_current_user();
		$detail = $a['value'];
		return 	( isset( $user->{$detail} ) ) ? $user->{$detail} : 'User';
	}
	
	return 'User';	
}

add_shortcode( 'hc_user_info', 'hc_user_info' );



/**
 * Display logout link
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function hc_logout_url() {
	return sprintf('<a href="%s">Logout</a>', wp_logout_url( site_url() ) );
}

add_shortcode( 'hc-logout', 'hc_logout_url' );



function hc_show_members_only_message() {
	if( !is_user_logged_in() )
		return hc_members_only_message();	
}

add_shortcode( 'hc_show_members_only_message', 'hc_show_members_only_message' );
