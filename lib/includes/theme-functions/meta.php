<?php

function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {
    global $wpdb;
    if( empty( $key ) )
        return;
    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );
    return $r;
}

function get_unique_meta_values( $key = '', $type = 'post', $match_keys = FALSE, $status = 'publish' )
{
	$values = get_meta_values( $key, $type, $status );
	
	if( $match_keys ) {
		return array_combine( $values, $values );
	}
	
	return array_unique( $values );	
}
