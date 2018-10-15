<?php
function no_proflie_admin_pages_redirect() {
  global $pagenow;
  if( ! current_user_can('manage_options') ) {
      $admin_redirects = array(
                'profile.php'
            );
      if( in_array( $pagenow, $admin_redirects ) ){
        wp_redirect ( get_permalink( 591 ) );
        exit;
      }
  }
}
add_action('admin_init', 'no_proflie_admin_pages_redirect');
    

add_filter( 'user_contactmethods', 'hr_custom_contact_info' );
/**
 * Removes legacy contact fields and adds support for LinkedIn.
 *
 * @param array $fields  Array of default contact fields.
 * @return array $fields Amended array of contact fields.
 */
function hr_custom_contact_info( $fields ) {
     
    $fields = array_splice($fields, 0, 0) + ['organization'=>'Organization'] + $fields;

    // Return the amended contact fields.
    return $fields;
     
}


/*
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">

    <th><label for="organization"><?php _e("Organization"); ?></label></th>
        <td>
            <input type="text" name="organization" id="organization" value="<?php echo esc_attr( get_the_author_meta( 'organization', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your organization."); ?></span>
        </td>
    </tr>
    </table>
<?php }


add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'organization', $_POST['organization'] );
}

*/