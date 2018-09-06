<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Column extends Element_Base {

	static public $count = 0;
    
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
		return 'column';
	}    
    
    /**
	 * Get default data.
	 *
	 * Retrieve the default data. Used to reset the data on initialization.
	 *
	 * @since 1.4.0
	 * @access protected
	 *
	 * @return array Default data.
	 */
	protected function get_default_data() {
		        
        $default_data = parent::get_default_data();
        
        self::$count++;
        
        return [
			'id' => self::$count,
			'settings' => [],
            'fields' => [],
		];
	}
    
    
    protected function _add_render_attributes() {
		parent::_add_render_attributes();
        
        $id = $this->get_id();

		$this->add_render_attribute(
			'wrapper', 'class', [
				'column',
                'column-block',
                $this->get_name() . '-' . $id
			]
		);
                
        
        // Generate column classes
        $count = self::$count;
        
        $column_width = $this->get_settings( 'column_widths' );
        
        $row_id = $this->get_settings( 'row_id' );
                                        
        $width = 12;
        
        if( isset( $column_width ) && !empty( $column_width ) ) {
            $width = $this->convert_to_columns( $column_width ); 
        }   
                
        $this->add_render_attribute( 'wrapper', 'class', sprintf( 'small-12 large-%s', $width ) );  
        
        $small_even_order = $this->get_settings( 'small_even_order' ) ? $this->get_settings( 'small_even_order' ) : 'small-order-2'; 
        $small_odd_order = $this->get_settings( 'small_odd_order' ) ? $this->get_settings( 'small_odd_order' ) : 'small-order-1';  
        $large_even_order = $this->get_settings( 'large_even_order' ) ? $this->get_settings( 'large_even_order' ) : 'large-order-1';  
        $large_odd_order = $this->get_settings( 'large_odd_order' ) ? $this->get_settings( 'large_odd_order' ) : 'large-order-2';  
        
        if( $id % 2 == 0 ) {
            $this->add_render_attribute( 'wrapper', 'class', $small_even_order );
        }
        else {
            $this->add_render_attribute( 'wrapper', 'class', $small_odd_order );
        }
        
        // Desktop order?        
        
        if( ( $id + $row_id ) % 2 == 0 ) {
            $this->add_render_attribute( 'wrapper', 'class', $large_even_order );
        }
        else {
            $this->add_render_attribute( 'wrapper', 'class', $large_odd_order );
        }
    }
	
	/**
	 * Before section rendering.
	 *
	 * Used to add stuff before the section element.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function before_render() {
        return sprintf( '<div %s>', $this->get_render_attribute_string( 'wrapper' ) );
	}

	/**
	 * After section rendering.
	 *
	 * Used to add stuff after the section element.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function after_render() {
        return '</div>';
	}
    
    public function render() {}
    
    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data );
        
        // Add default settings
        //$this->set_fields( array( 'class' => 'button', 'is_external' => '', 'nofollow' => '' ) );
	}
    
    private function convert_to_columns( $fraction )
    {
        $numbers = explode( '/', $fraction );
        return round( ( $numbers[0] / $numbers[1] ) * 12 );
    }
    	
}
