<?php


function title_format($content) {
return '%s';
}
add_filter('private_title_format', 'title_format');
add_filter('protected_title_format', 'title_format');

/* =============================================================================
   Helper functions for blog permalink/ blog title
   ========================================================================== */
   
/**
 * Display the post content. Optionally allows post ID to be passed
 * @uses the_content()
 *
 * @param int $id Optional. Post ID.
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 */
function kr_get_content_by_id( $post_id=0, $more_link_text = null, $stripteaser = false ){
    global $post;
    $post = &get_post($post_id);
    setup_postdata( $post, $more_link_text, $stripteaser );
    $content = apply_filters('the_content', $post->post_content );
    wp_reset_postdata();
	return $content;
}

function kr_the_content_by_id( $post_id=0, $more_link_text = null, $stripteaser = false ){
    global $post;
    $post = &get_post($post_id);
    setup_postdata( $post, $more_link_text, $stripteaser );
    the_content();
    wp_reset_postdata();
}

function get_blog_permalink()
{
	$posts_page_id = get_option( 'page_for_posts');
	return home_url() . '/' . get_page_uri( $posts_page_id  );
}

function get_blog_title()
{
	$posts_page_id = get_option( 'page_for_posts');
	
	$posts_page = get_page( $posts_page_id);
	
	$posts_page_title = $posts_page->post_title;
	
	if( function_exists('wptitle2_get_the_title') )
	{
		$posts_page_title = wptitle2_get_the_title( $posts_page->ID );	
	}
	
	return $posts_page_title;
 		
}

/**
 * Get current page depth
 *
 * @return integer
 */
function get_current_page_depth(){
	global $wp_query;
	
	$object = $wp_query->get_queried_object();
	$parent_id  = $object->post_parent;
	$depth = 0;
	while($parent_id > 0){
		$page = get_page($parent_id);
		$parent_id = $page->post_parent;
		$depth++;
	}
 
 	return $depth;
}


function get_top_parent_id(){
    
    global $post;
    
    if ($post->post_parent)   {
        $ancestors=get_post_ancestors($post->ID);
    $root=count($ancestors)-1;
    $parent = $ancestors[$root];
    } else {
        $parent = $post->ID;
    }
    return $parent;
}

function is_child($pid) {
// $pid = The ID of the ancestor page
global $post; // load details about this page
$anc = get_post_ancestors( $post->ID );
foreach($anc as $ancestor) {
if(is_page() && $ancestor == $pid) {
return true;
}
}
return false; // we're elsewhere
};


function kr_get_post_type() {
	
	global $wp_query, $wpdb;

	if ( is_single() ) {
		$post_id = $wp_query->get_queried_object_id();
		$post = $wp_query->get_queried_object();
		if ( isset( $post->post_type ) ) {
			$post_type = $post->post_type;
		}
	} elseif ( is_archive() ) {
		if ( is_post_type_archive() ) {
			$post_type = get_query_var( 'post_type' );
			if ( is_array( $post_type ) )
				$post_type = reset( $post_type );
		} elseif ( is_category() ) {
			$cat = $wp_query->get_queried_object();
			$post_type = 'category';
			if ( isset( $cat->term_id ) ) {
				$post_type = 'category-' . $cat->term_id;
			}
		} elseif ( is_tag() ) {
			$tags = $wp_query->get_queried_object();
			$post_type = 'tag';
			if ( isset( $tags->term_id ) ) {
				$post_type = 'tag-' . $tags->term_id;
			}
		} elseif ( is_tax() ) {
			$term = $wp_query->get_queried_object();
			$post_type = $term->taxonomy;
			/*
			if ( isset( $term->term_id ) ) {
				$post_type = $term->taxonomy . '-' . $term->term_id;
			}
			*/
		}
	} elseif ( is_page() ) {
		$post_type = 'page';
	} else {
		// Ensure that we always coerce class to being an array.
		$post_type = 'post';
	}

	return $post_type;
}
