<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Header extends Element_Base {

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
		return 'header';
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
        
        $heading_size = $this->get_settings( 'heading_size' ) ? $this->get_settings( 'heading_size' ) : 'h2';
        
        $heading        = _s_format_string( $this->get_fields( 'heading' ), $heading_size );
        $subheading     = _s_format_string( $this->get_fields( 'subheading' ), 'h4' );
        $description    = _s_format_string( $this->get_fields( 'description' ), 'p' );
        
        if( empty( $heading ) ) {
            return;
        }
        
        // $this->add_render_attribute( 'wrapper', 'class', 'column' );
        // $this->add_render_attribute( 'wrapper', 'class', 'row' );
        $this->add_render_attribute( 'wrapper', 'class', 'header' );
                                        
        return sprintf( '<header %s>%s%s%s</header>', $this->get_render_attribute_string( 'wrapper' ), $heading, $subheading, $description );
	}
    	
}
