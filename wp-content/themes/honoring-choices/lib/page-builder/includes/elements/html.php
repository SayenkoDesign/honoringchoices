<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_HTML extends Element_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'html';
	}
    
	
	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	public function render() {
                                        
        $fields = $this->get_fields();
                                                        
        if ( empty( $fields ) ) {
            return;
        }
                                
        if( empty( $this->get_fields( 'html' ) ) ) {
            return false;
        }        
                
        $this->add_render_attribute( 'wrapper', 'class', 'element-html' );
     
                                                
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'wrapper' ), $this->get_fields( 'html' ) );
	}
    	
}
