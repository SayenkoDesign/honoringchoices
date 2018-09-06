<?php

// Get icon

function get_theme_icon( $name ) {
    return sprintf( '<img src="icons/%s.svg" />', THEME_IMG );
}

function location_address( $string ) {
    if( empty( $string ) ) {
        return '';
    }
    // return _s_format_string( $string, $wrap = 'div', $attr = array() ) {
        return sprintf( '<div class="address">%s%s</div>', get_theme_icon( 'address' ), nl2br( $location['address'] ) );
}

function location_website() {
    
}