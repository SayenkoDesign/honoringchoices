<?php

function _s_format_string( $string, $wrap = 'div', $attr = array() ) {
	
	if( empty( $string ) ) {
		return false;	
	}
    
    // incase we want to return a raw string
    if( $wrap == '' ) {
        return $string;
    }
	
	$args = array(
		'open'    => "<{$wrap} %s>",
		'close'   => "</{$wrap}>",
		'content' => $string,
		'context' => ' ',
		'attr'    => $attr,
		'params'  => array(
			'wrap'  => $wrap,
		),
		'echo'    => false,
	);
	
	$output =  _s_markup( $args );
	
	return $output;
}


function _s_wrap_string( $string, $search = '#', $replace = 'span' ) {
	// add span and balance tags
 	$string = force_balance_tags( str_replace( "$search", sprintf('<%s>', $replace), $string ) );
	// remove empty tags
	return str_replace( sprintf('<%1$s></%1$s>', $replace), '', $string );
}