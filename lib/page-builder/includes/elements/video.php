<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Video extends Element_Base {

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
		return 'video';
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
                                                
        if ( ! isset( $fields['video'] ) || empty( $fields['video'] ) ) {
            return;
        }
        
        $video = $fields['video']; 
                
        $video = wp_oembed_get( $video );
               
        $this->add_render_attribute( 'wrapper', 'class', 'element-video' );
                                        
        return sprintf( '<div %s>%s</div>', $this->get_render_attribute_string( 'wrapper' ), $video );
	}    

    public function strip_related_videos( $return, $data, $url ) {
        if ($data->provider_name == 'YouTube') {
            $params = array(
                'feature' => 'oembed',
                'controls'    => 1,
                'hd'        => 1,
                'autohide'    => 1,
                'rel' => 0
            );
            
            if (strpos( $data->html, 'rel') === false) {
                $data->html = str_replace('feature=oembed', build_query( $params ), $data->html );
            }            
            return $data->html;
        } else return $return;
    }  
    
    public function __construct( array $data = [], array $args = null ) {
        parent::__construct( $data );
        
        add_filter( 'oembed_dataparse', array( $this, 'strip_related_videos' ), 10, 3 );
	}
    	
}
