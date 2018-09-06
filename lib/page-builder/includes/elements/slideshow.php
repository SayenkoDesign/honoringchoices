<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Slideshow extends Element_Base {

	static public $count;
    
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
		return 'slideshow';
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
                                                        
        if ( ! isset( $fields['photos'] ) || empty( $fields['photos'] ) ) {
            return;
        }
        
        $photos = $fields['photos'];
        
        $slides = '';
        
        foreach( $photos as $photo ) {
             $caption = wp_get_attachment_caption( $photo['ID'] );
             $image = wp_get_attachment_image( $photo['ID'], 'large', false, array( 'class' => 'rsImg', 'alt' => $caption ) );
             $slides .= sprintf( '<div class="rsContent">%s</div>', $image );
        }
        
        $slider = sprintf( '<div class="royalSlider rsDefault">%s</div>', $slides );
        
        $this->add_render_attribute( 'wrapper', 'class', 'element-slideshow' );
        $this->add_render_attribute( 'wrapper', 'class', 'clearfix' );
                                        
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'wrapper' ), $slider );
	}
    
    
    
    
    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data );
	}
    	
}
