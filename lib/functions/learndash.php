<?php
/*
Functions we may use:

learndash_get_users_group_ids( $user_id ); // we can use this to restrict the Resources page
// ld_update_group_access( $order->customer_id, $ld_group_id, false );
learndash_set_users_group_ids( $user_id, $user_groups ); // set uer groups on save of gform registration
*/

// add_filter( 'login_url', 'ur_login_page' );
function ur_login_page() {
    wp_redirect ( home_url( '/custom-login-page/' ) );  
}


function hc_is_learndash() {
    
   /* 'sfwd-courses' - Courses
    * 'sfwd-lessons' - Lessons
    * 'sfwd-topic' - Topics
    * 'sfwd-quiz' - Quizzes
    * 'sfwd-certificates' - Certificates
    * 'sfwd-assignment' - Assignments
    */
    
    $learndash_post_types = [ 'sfwd-courses', 'sfwd-lessons', 'sfwd-topic', 'sfwd-quiz', 'sfwd-certificates', 'sfwd-assignment' ];
    
    if( in_array( get_post_type(), $learndash_post_types ) ) {
        return true;
    }
    
    return false;
    
}


// fix shortcode row class

add_filter( 'ld_course_list', function( $output ) {
    $find = 'ld-course-list-items row';
    return str_replace( $find, $find . ' column', $output );
}, 10 );



add_filter( 'ld_course_list_shortcode_attr_defaults', function( $defaults ) {
    
    $defaults['mygroups'] = null;
    return $defaults;
    
}, 10 );

add_filter('learndash_ld_course_list_query_args', function( $filter, $atts ) {
        
    if ( ! is_user_logged_in() || ! $atts['mygroups'] ) {
        return $filter;
    }
    
    $user_id = get_current_user_id();
    $group_ids = learndash_get_users_group_ids( $user_id );
    $group_meta_id = [];
    
    if( empty( $group_ids ) ) {
        return $filter;
    }
    $meta_query = [];
    
    $meta_query[] = [ 'relation' => 'OR' ];
    
    foreach( $group_ids as $group_id) {
        
        $group_meta_key = sprintf( 'learndash_group_enrolled_%d', $group_id ); 
        
        $meta_query[] = array(
					'key' => $group_meta_key,
					'compare' => 'EXISTS'
				);
    }
    
    $filter['meta_query'] = $meta_query;
    
    return $filter;
}, 10, 2);