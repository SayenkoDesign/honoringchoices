<?php

/**
 * Shortcode Parse Attributes
 *
 * @param $val
 *
 * @return string
 */
function shortcode_parse_args( $val ) {
	if ( is_array( $val ) ) {
		$t = array();
		foreach ( $val as $k => $v ) {
			if ( ! empty( $v ) ) {
				$t[] = sprintf( '%s="%s"', $k, $v );
			}
		}

		return implode( ' ', $t );
	} else {
		return $val;
	}
}


/*
Usage

$args = array(
    'id'            => 4,
    'title'         => 'false',
    'description'   => true,
    'ajax'          => 'true',
    'tabindex'      => '99'
 );
 
echo do_shortcode( sprintf( '[gravityform %s]', shortcode_parse_args( $args ) ) );

*/