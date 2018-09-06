<?php
/*
Functions we may use:

learndash_get_users_group_ids( $user_id ); // we can use this to restrict the Resources page

learndash_set_users_group_ids( $user_id, $user_groups ); // set uer groups on save of gform registration
*/

add_filter( 'login_url', 'ur_login_page' );
function ur_login_page() {
    wp_redirect ( home_url( '/custom-login-page/' ) );  
}