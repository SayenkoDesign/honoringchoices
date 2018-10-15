<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Menu extends Element_Base {

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
		return 'menu';
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
                                                                
        if ( ! isset( $fields['menu'] ) || empty( $fields['menu'] ) ) {
            return;
        }
        
        $field = $fields['menu'];
        
        if( !empty( $field ) && !isset( $field->ID ) ) {
            return false;
        }
        
        $menu = wp_nav_menu( [ 'menu' => $field->ID, 'echo' => false ] );
        
        $this->add_render_attribute( 'wrapper', 'class', 'element-menu' );
                                        
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'wrapper' ), $menu );
	}
    
    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data );
	}
    	
}
