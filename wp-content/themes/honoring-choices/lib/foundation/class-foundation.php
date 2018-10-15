<?php

// Foundation


class Foundation {
    
    public function __construct() {
        
        
    }
    
    protected function parse_attr( $attributes = array() ) {

        if( !is_array( $attributes ) ) {
            return false;
        }
            
        $output = '';
    
        //* Cycle through attributes, build tag attribute string
        foreach ( $attributes as $key => $value ) {
    
            if ( ! $value ) {
                continue;
            }
    
            if ( true === $value ) {
                $output .= esc_html( $key ) . ' ';
            } else {
                $output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
            }
    
        }
    
        return trim( $output );
    
    }
    
}