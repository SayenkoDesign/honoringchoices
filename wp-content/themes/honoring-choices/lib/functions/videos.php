<?php

function youtube_embed( $url ) {
    $params = array(
		'controls'    => 1,
		'hd'        => 1,
		'autohide'    => 1,
		'rel' => 0,
        'autoplay' => 1
	);
    
        
    $video_id = _s_get_youtube_video_ID( $url );
    
    if( empty( $video_id ) ) {
        return false;
    }
    
    $video_url = sprintf( 'https://www.youtube.com/embed/%s', $video_id ); 

	return add_query_arg($params, $video_url );
}

function _s_get_youtube_video_ID( $url ) {
    $pattern = '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:
            www\. 
          | m\.
        )?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /&v=/       # or ?feature=youtu.be&v=NXwxHU2Q0bo
          | /watch\?v=  # or /watch\?v=
          | /watch\?feature=youtu\.be&v= # alternativ link with watch
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';

    preg_match($pattern, $url, $matches);
    
    if( !empty( $matches ) && isset( $matches[1] ) ) {
        return $matches[1];
    }

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
	if ( preg_match( '/\/\/(www\.)?(youtu|youtube)\.(com|be)\/(watch|embed)?\/?(\?v=)?([a-zA-Z0-9\-\_]+)/', $content, $youtube_matches ) ) {
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
