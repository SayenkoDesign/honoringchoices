<?php
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