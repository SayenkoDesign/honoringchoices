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
                'column-block'
			]
		);
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
