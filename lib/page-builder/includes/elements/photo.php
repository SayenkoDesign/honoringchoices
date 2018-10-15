<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Photo extends Element_Base {

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
		return 'photo';
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
        
        $settings   = $this->get_settings();
                                                                                                                
        $photo = $this->get_fields( 'photo' );
        
        if( empty( $photo['image'] ) ) {
            return false;
        }
                
        $size  = $this->get_settings( 'size' ) ? $this->get_settings( 'size' ) : 'large';
        $image = wp_get_attachment_image( $photo['image'], $size );
                
        $this->add_render_attribute( 'wrapper', 'class', 'element-photo' );
                                                        
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'wrapper' ), $image );
	}
    
}
