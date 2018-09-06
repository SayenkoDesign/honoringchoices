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
                                        
        $fields     = $this->get_fields();
        $settings   = $this->get_settings();
        
       
                                                        
        if ( empty( $fields ) ) {
            return;
        }
                                
        if( empty( $this->get_fields( 'photo' ) ) ) {
            return false;
        }
        
        $photo = $this->get_fields( 'photo' );
                
        $size  = $this->get_settings( 'size' ) ? $this->get_settings( 'size' ) : 'large';
        $image = wp_get_attachment_image( $photo['image'], $size );
                
        $this->add_render_attribute( 'wrapper', 'class', 'element-photo' );
        
        // Add caption
        $caption = $this->get_caption( $photo );
                                                
        return sprintf( '<div %s>%s%s</div>', $this->get_render_attribute_string( 'wrapper' ), $image, $caption );
	}
    
    
    private function get_caption( $photo ) {
        
        if( isset( $photo['caption'] ) && $photo['caption'] ) {
            $caption = wp_get_attachment_caption( $photo['image'] );
            if( !empty( $caption ) ) {
                return sprintf( '<div class="image-caption">%s</div>', $caption );
            }
        }
    }

    private function get_size( $photo ) {
        // Top/Center/Bottom
        if( isset( $photo['shape'] ) ) {
            $shape = strtolower( $photo['shape'] );
            $crop = ( 'circle' == $shape ) ? '-' . strtolower( $photo['crop'] ) : '';
            
            $image_meta = wp_get_attachment_metadata( $photo['image'] );
            
            if( ( 'circle' == $shape ) && $image_meta['width'] - $image_meta['height'] == 0 ) {
                $this->add_render_attribute( 'wrapper', 'class', 'circle' );
            }
        }
        
        return 'large' . $crop;
    }
    
    
    	
}
