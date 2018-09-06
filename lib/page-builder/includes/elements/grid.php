<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Grid extends Element_Base {

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
		return 'grid';
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
        
        if( ! class_exists( 'Foundation_Grid' ) ) {
            return;
        }
                                
		$fields = $this->get_fields(); 
        $settings = $this->get_settings();
                
        $fg         = new Foundation_Grid( $settings );
        $grid       = $fg->generate( $fields['grid'] ); 
        
        $this->add_render_attribute( 'element', 'class', 'grid' );
                                    
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'element' ), $grid );
	}
    	
}
