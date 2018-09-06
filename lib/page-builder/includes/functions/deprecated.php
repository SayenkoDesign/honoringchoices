<?php

function _s_get_textarea( $string, $wrap = 'div', $attr = array() ) {
    _deprecated_function( __FUNCTION__, '1.2.0', '_s_format_string()' );
	return _s_format_string( $string, $wrap, $attr );
}

function _s_parse_section_settings( $settings ) {
    
    _deprecated_function( __FUNCTION__, '2.0' );
    
}

if( ! function_exists( '_s_section' ) ) {
 
    function _s_section( $content = '', $attr = array() ) {
                
        if( empty( $content ) ) {
            return;
        }
         
        static $counter;
        $counter++;
                
        $defaults = array(
            'id' => sprintf( 'section-%s', $counter ),
            'class' => array(),
            'style' => array()
        );
        
        // Parse default attributes
        $attr = wp_parse_args( $attr, $defaults );
        
        _s_section_open( $attr );
           
        echo $content;
        
        _s_section_close();
                     
    }
    
}

function _s_section_open( $attr ) {
		
	$args = array(
		'html5'   => '<section %s>',
		'context' => 'section',
		'attr' => $attr,
		'echo' => false
	);
	
	$out = _s_markup( $args );
	
	$out .= _s_structural_wrap( 'open', false );
	
	echo $out;
}

function _s_section_close() {
	$out = _s_structural_wrap( 'close', false );
	$out .= '</section>';
	echo $out;
}