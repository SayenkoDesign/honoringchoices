<?php


function _s_get_the_post_navigation( $args = array() ) {
    $args = wp_parse_args( $args, array(
        'prev_text'          => '%title',
        'next_text'          => '%title',
        'in_same_term'       => false,
        'excluded_terms'     => '',
        'taxonomy'           => 'category',
        'screen_reader_text' => __( 'Post navigation' ),
    ) );
 
    $navigation = '';
 
    $next = get_previous_post_link(
        '<div class="nav-next">%link</div>',
        $args['next_text'],
        $args['in_same_term'],
        $args['excluded_terms'],
        $args['taxonomy']
    );
 
    $previous = get_next_post_link(
        '<div class="nav-previous">%link</div>',
        $args['prev_text'],
        $args['in_same_term'],
        $args['excluded_terms'],
        $args['taxonomy']
    );
 
    // Only add markup if there's somewhere to navigate to.
    if ( $previous || $next ) {
        $navigation = _navigation_markup( $previous . $next, 'post-navigation', $args['screen_reader_text'] );
    }
 
    return $navigation;
}


add_filter( 'term_link', function ( $termlink, $term, $taxonomy )
{
    // Check if we have the correct term and taxonomy, if not, bail early
    if (   $taxonomy != 'category' )
        return $termlink;

    // If we came to this point, we have the desired term and taxonomy, so lets alter the URL
    // Here should be the code to construct your new URL, you need to work on this
    // $termlink = 'VALUE_OF_NEW_URL'; // This will be the new URL our term to link to its term page
    $slug = $term->slug;
    $page_for_posts = get_permalink( get_option( 'page_for_posts' ) );
    $termlink = add_query_arg( 'fwp_categories', $slug, $page_for_posts ); //?fwp_categories=general;

    return $termlink;
}, 10, 3 );



function _s_blog_pre_get_posts($query) {
						
    if ( $query->is_main_query() && ( $query->is_home() || $query->is_category() || $query->is_tag() ) ) {
                                                                
        // Order By
        $query->set( 'orderby', 'meta_value_num, date' );
        $query->set( 'order', 'ASC' );
        $query->set( 'meta_key', 'event_start_date' );
        
        // Only show future concerts
        $meta_query = array(
            array(
                'key' => 'event_end_date',
                'value' => date_i18n('Ymd'),
                'compare' => '>='
            )
        );
        
        $query->set( 'meta_query', $meta_query );
    
    }
        
    return $query;
}

//add_action( 'pre_get_posts','_s_blog_pre_get_posts' );


function _s_blog_template_redirect( $template ) {
	if ( is_search() ) 
		$template = get_query_template( 'home' );	
	return $template;
}
add_filter( 'template_include', '_s_blog_template_redirect' );	


function _s_add_blog_class( $classes ) {
  
  if ( is_category() || is_author() || is_search() ) {
      $classes[] = 'blog';
  }
   return $classes;
}
add_filter( 'body_class', '_s_add_blog_class' );


/*
// adding custom post types to blog pagination
add_action( 'get_previous_post_where', 'misha_posts_and_page', 20 );
add_action( 'get_next_post_where', 'misha_posts_and_page', 20 );
 
function misha_posts_and_page( $where ){
	// $where looks like WHERE p.post_date < '2017-08-02 09:07:03' AND p.post_type = 'post' AND ( p.post_status = 'publish' OR p.post_status = 'private' )
	// In code $where looks like $wpdb->prepare( "WHERE p.post_date $op %s AND p.post_type = %s $where", $post->post_date, $post->post_type )
	// Parameters $op and another $where can not be passed to this action hook
	// So, I think the best way is to use str_replace()
	return str_replace(
		array( "p.post_type = 'post'", "p.post_type = 'story'", "p.post_type = 'event'" ),
		"(p.post_type = 'post' OR p.post_type = 'story' OR p.post_type = 'event')",
		$where
	);
 
}
*/



function _s_get_post_author( $size = 100, $user_id = false ) {
    global $post;
    
    if( false == $user_id ) {
        $author_id = get_the_author_meta('ID');
    }
    else {
        $author_id = $user_id;
    }
    
    if( empty( $author_id ) ) {
        return false;
    }
    
    $display_name = get_the_author_meta('display_name', $author_id );
    $author_image = '';
    if( $avatar = get_avatar( $author_id, $size ) ) {
         $author_url = get_author_posts_url( $author_id ); 
         //return sprintf( '<div class="post-author"><a href="%s">%s<p>%s</p></a></div>',$author_url, $avatar, $display_name );
         return sprintf( '<div class="post-author">%s<p>%s</p></div>', $avatar, $display_name );
    }
    
    return '';
        
}


function _s_get_the_author_meta( $field, $user_id = false ) {
    
    if ( in_array( $field, array( 'login', 'pass', 'nicename', 'email', 'url', 'registered', 'activation_key', 'status' ) ) )
		return get_the_author_meta( $field, $user_id );
    
    $author_id = ! $user_id ? get_the_author_meta('ID') : $user_id;
    $value = get_field( $field, 'user_'. $author_id );
    
    return !empty( $value ) ? $value : '';
}


function _s_modify_user_contact_methods( $user_contact ) {

	// Add user contact methods
	$user_contact['facebook']   = __( 'Facebook URL' );
	$user_contact['twitter'] = __( 'Twitter URL' );
    $user_contact['instagram'] = __( 'Instagram URL' );
    $user_contact['youtube'] = __( 'YouTube URL' );
    
	return $user_contact;
}
add_filter( 'user_contactmethods', '_s_modify_user_contact_methods' );



// Callback function to remove default bio field from user profile page & re-title the section
// ------------------------------------------------------------------

if( !function_exists( 'remove_plain_bio' ) ){
	function remove_bio_box($buffer){
		$buffer = str_replace('<h2>About Yourself</h2>','',$buffer);
		$buffer = preg_replace('/<tr class=\"user-description-wrap\"[\s\S]*?<\/tr>/','',$buffer,1);
		return $buffer;
	}
	function user_profile_subject_start(){ ob_start('remove_bio_box'); }
	function user_profile_subject_end(){ ob_end_flush(); }
}
add_action('admin_head-profile.php','user_profile_subject_start');
add_action('admin_footer-profile.php','user_profile_subject_end');


function _s_get_post_terms( $post_id ) {
    $taxonomy = 'category';
    $terms = wp_get_post_terms( $post_id, $taxonomy );
    if( !is_wp_error( $terms ) && !empty( $terms ) ) {
        $out = '';
        foreach( $terms as $term ) {
            $term_class = sanitize_title( $term->name );
        $out .= sprintf( '<li><a href="%s" class="term-link %s">%s<span>%s</span></a></li>', get_term_link( $term->slug, $taxonomy ), $term_class, get_svg( $term_class ), $term->name );
        }
        
        return sprintf( '<ul class="post-categories">%s</ul>', $out );
        
    }
    
}


function _s_get_post_term( $post_id ) {
    $taxonomy = 'category';
    $terms = wp_get_post_terms( $post_id, $taxonomy );
    if( !is_wp_error( $terms ) ) {
        $term = array_pop($terms);
        $term_class = sanitize_title( $term->name );
        return sprintf( '<a href="%s" class="term-link %s">%s<span>%s</span></a>', get_term_link( $term->slug, $taxonomy ), $term_class, get_svg( $term_class ), $term->name );
    }
    
}


function comment_form_submit_button($button) {
    $button = sprintf( "<button class='submit button'><span>%s</span></button>", 'Post Comment' ) . //Add your html codes here
    get_comment_id_fields();
    return $button;
}
add_filter('comment_form_submit_button', 'comment_form_submit_button');