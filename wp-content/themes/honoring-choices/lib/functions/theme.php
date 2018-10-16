<?php

// Absolute/fixed headers need to remove the margin from wp-adminbar
add_action('get_header', 'my_filter_head');

  function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }


function accent_color_body_class( $classes ) {
  
  if( is_page() ) {
     
     $accent_color = get_field( 'accent_color' );
     
     if( ! empty( $accent_color ) ) {
         $classes[] = sprintf( 'accent-color-%s', strtolower( $accent_color ) );
     }
  }
  
  return $classes;
}
add_filter( 'body_class', 'accent_color_body_class', 99 );



// Add modals to footer
function _s_footer() {
    get_template_part( 'template-parts/modal', 'search' );   
}
add_action( 'wp_footer', '_s_footer' );


/*
 * Modify TinyMCE editor to remove H1.
 */
function tiny_mce_remove_unused_formats($init) {
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;';
	return $init;
}

add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );



// Enable the Styles dropdown menu item
// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter('mce_buttons_2', 'my_mce_buttons_2');


// Add the Button CSS to the Dropdown Menu
// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {

    // Define the style_formats array
    $style_formats = array(
    
    // Each array child is a format with it's own settings
    array(
        'title' => 'Button',
        'selector' => 'a',
        'classes' => 'button blue',
        )
    );
    
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );
    return $init_array;
}

add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

/**
 * Check if a post contains video.  Maybe set a thumbnail, store the video URL as post meta.
 *
 * @author Gary Kovar
 *
 * @since  1.0.5
 *
 * @param int    $post_id ID of the post being saved.
 * @param object $post    Post object.
 */
function wds_check_if_content_contains_video() {
	global $post;
    $post_id = $post->ID;
	$content = isset( $post->post_content ) ? $post->post_content : '';
	$content = substr( $content, 0 );
	// Allow developers to filter the content to allow for searching in postmeta or other places.
	$content = apply_filters( 'wds_featured_images_from_video_filter_content', $content, $post_id );
	// Set the video id.
	$youtube_id          = wds_check_for_youtube( $content );
	$vimeo_id            = wds_check_for_vimeo( $content );
    	
	if ( $content
	     && ( $youtube_id || $vimeo_id )
	) {
		return true;
	} 
    
    return false;
}


/**
 * Check if the content contains a youtube url.
 *
 * Props to @rzen for lending his massive brain smarts to help with the regex.
 *
 * @author Gary Kovar
 *
 * @param $content
 *
 * @return string The value of the youtube id.
 *
 */
function wds_check_for_youtube( $content ) {
	if ( preg_match( '#\/\/(www\.)?(youtu|youtube|youtube-nocookie)\.(com|be)\/(watch|embed)?\/?(\?v=)?([a-zA-Z0-9\-\_]+)#', $content, $youtube_matches ) ) {
		return $youtube_matches[6];
	}
	return false;
}
/**
 * Check if the content contains a vimeo url.
 *
 * Props to @rzen for lending his massive brain smarts to help with the regex.
 *
 * @author Gary Kovar
 *
 * @param $content
 *
 * @return string The value of the vimeo id.
 *
 */
function wds_check_for_vimeo( $content ) {
	if ( preg_match( '#\/\/(.+\.)?(vimeo\.com)\/(\d*)#', $content, $vimeo_matches ) ) {
		return $vimeo_matches[3];
	}
	return false;
}


function the_title_trim($title) {

	$title = attribute_escape($title);

	$findthese = array(
		'#Protected:#',
		'#Private:#'
	);

	$replacewith = array(
		'', // What to replace "Protected:" with
		'' // What to replace "Private:" with
	);

	$title = preg_replace($findthese, $replacewith, $title);
	return $title;
}
add_filter('the_title', 'the_title_trim');