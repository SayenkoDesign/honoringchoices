<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Editor extends Element_Base {

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
		return 'editor';
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
                                                                
        if ( ! isset( $fields['editor'] ) || empty( $fields['editor'] ) ) {
            return;
        }
        
        $editor = $fields['editor'];
                
        if( strpos( $editor, '<!--more-->' ) ) {
            
            $content_arr = get_extended( $editor );
	
            $clean_content_arr = array_map( 'trim', $content_arr);
            
            if( !empty( $clean_content_arr['extended'] ) ) {
                            
                $editor = $this->read_more( $clean_content_arr['main'], $clean_content_arr['extended'] );
            }
        }
        
        $this->add_render_attribute( 'wrapper', 'class', 'element-editor' );
		$this->add_render_attribute( 'wrapper', 'class', 'entry-content' );
                                        
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'wrapper' ), $editor );
	}
    
    
    private function read_more( $main, $extended ) {
				
	
        $defaults = array(
            'more_text'  => 'Read More',
            'less_text'  => 'Read Less'
        );
        
        /* Apply filters to the arguments. */
        $args = apply_filters( 'kr_read_more_inline_args', $defaults );			
        
        $more_link = sprintf('<p class="more read-more-show button-link"><a href="#">%s</a></p>', $args['more_text'] );
        
        $less_link = sprintf('<p class="more read-more-hide button-link"><a href="#">%s</a></p>', $args['less_text'] );
                
        if( !empty( $extended ) ) {
                        
            $main 	  = apply_filters('the_content', $main );
            $extended = apply_filters('the_content', $extended );
                        
            return  sprintf( '%s%s<div class="read-more-content hide">%s%s</div>', $main, $more_link, $extended, $less_link );								
        }
        else {
            
            return $main;
            
        }
    }
    
    
    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data );
	}
    	
}
