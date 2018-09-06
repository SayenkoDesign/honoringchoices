<?php

/**
 * Add http:// if missing
 */
function addhttp($url) {
    if (false === strpos($url, '://')) {
		$url = 'http://' . $url;
	}
    return $url;
}

function reverse_words( $str )
{
	$myArray = str_word_count($str, 1);
	$reverse = array_reverse($myArray);
	return 	implode( ' ', $reverse );
}

// return lines as list items
if( !function_exists( 'nl2li' ) ) {
    function nl2li( $string ) {
        return '<li>' . implode( '</li><li>', explode( "\n", $string ) ) . '</li>';
    }
}