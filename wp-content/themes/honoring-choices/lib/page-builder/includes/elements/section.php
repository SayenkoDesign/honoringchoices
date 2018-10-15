<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor section element class.
 *
 * Elementor repeater handler class is responsible for initializing the section
 * element.
 *
 * @since 1.0.0
 */
class Element_Section extends Element_Base {

	
    static public $count;
    
    /**
	 * Get section name.
	 *
	 * Retrieve the section name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Section name.
	 */
	public function get_name() {
		return 'section';
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
		
        self::$count ++;
        
        $default_data = parent::get_default_data();
        
        return [
			'id' => self::$count,
			'settings' => [],
            'fields' => [],
		];
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
        $curve = '';
            
        $settings = $this->get_settings();
        foreach( $settings as $name => $value ) {
            
            if( empty( $value ) ) {
                continue;
            }
            
            if( 'curved' == $name ) {
                $curve = sprintf( '<div class="shape">%s</div>', get_svg( 'curve-top' ) );
                $this->add_render_attribute( 'wrapper', 'class', 'section-curved' );
            }
        }
        
        $this->add_render_attribute( 'wrap', 'class', 'wrap' );
        
        return sprintf( '<%s %s>%s<div %s>', 
                        esc_html( $this->get_html_tag() ), 
                        $this->get_render_attribute_string( 'wrapper' ), 
                        $curve,
                        $this->get_render_attribute_string( 'wrap' )
                        );
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
        
        $curve = '';
            
        $settings = $this->get_settings();
        foreach( $settings as $name => $value ) {
            
            if( empty( $value ) ) {
                continue;
            }
            
            if( 'curved' == $name ) {
                $curve = sprintf( '<div class="shape">%s</div>', get_svg( 'curve-bottom' ) );
                $this->add_render_attribute( 'wrapper', 'class', 'section-curved' );
            }
        }
            
        return sprintf( '</div>%s</%s>', $curve, esc_html( $this->get_html_tag() ) );
	}
    

	/**
	 * Add section render attributes.
	 *
	 * Used to add render attributes to the section element.
	 *
	 * @since 1.3.0
	 * @access protected
	 */
	protected function _add_render_attributes() {
		parent::_add_render_attributes();
        
        $id = $this->get_id();

		$this->add_render_attribute(
			'wrapper', 'class', [
				$this->get_name(),
                $this->get_name() . '-' . $id
			]
		);
        
        $this->add_render_attribute(
			'wrapper', 'id', [
				'section-' . $id
			]
		);
        
        
        // Process settings
        $settings = $this->get_settings();
        
        $wrap_padding = false;
        
        if( $this->get_settings( 'background_color' ) ) {
            $wrap_padding = true;   
        }
        
        foreach( $settings as $name => $value ) {
        
            if( '' == $value ) {
                continue;
            }            
                            
            switch( $name ) {
                case 'id':
                    $this->add_render_attribute( 'wrapper', 'id', $value, true ); // overwrite for single ID
                break;
                case 'class':
                    $this->add_render_attribute( 'wrapper', 'class', $value );
                break;
                case 'background_color':
                    $this->add_render_attribute( 'wrapper', 'class', sprintf( 'background-%s', strtolower( $value ) ) );
                break;
                case 'margin_top':
                case 'margin_bottom':
                $name = str_replace( '_', '-', $name );
                $this->add_render_attribute( 'wrapper', 'style', sprintf( '%s:%spx;', $name, $value ) );
                break;
                case 'padding_top':
                case 'padding_bottom':
                    $name = str_replace( '_', '-', $name );
                    $tag = $wrap_padding ? 'wrap' : 'wrapper';
                    $this->add_render_attribute( $tag, 'style', sprintf( '%s:%spx;', $name, $value ) );
                    
                break;                    
            }
            
        }	

	}

	/**
	 * Get HTML tag.
	 *
	 * Retrieve the section element HTML tag.
	 *
	 * @since 1.5.3
	 * @access private
	 *
	 * @return string Section HTML tag.
	 */
	public function get_html_tag() {
	
		$html_tag = 'section';

		return $html_tag;
	}
    
}
