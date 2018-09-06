<?php

/*
Hero - Home
		
*/


if( ! class_exists( 'Hero_After_Location_Section' ) ) {
    class Hero_After_Location_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $post_id = 'options';    
            $fields = get_field( 'location_archive', $post_id );        
            $this->set_fields( $fields );
            
            $settings = [];
            $this->set_settings( $settings );
            
            // Render the section
            $this->render();
            
            // print the section
            $this->print_element();        
        }
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
    
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-after-hero'
                ]
            );
        }
        
        
        public function after_render() {
        
            $wave = sprintf( '<div class="wave-bottom show-for-large">%s</div>', get_svg( 'wave-bottom' ) );;
                
            return sprintf( '</div>%s</section>', $wave );
        }
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields(); 
           
            $background_image       = $this->get_fields( 'background_image' );
            $background_position_x  = $this->get_fields( 'background_position_x' );
            $background_position_y  = strtolower( $this->get_fields( 'background_position_y' ) );
            $background_overlay     = strtolower( $this->get_fields( 'background_overlay' ) );
            
            if( ! empty( $background_image ) ) {
                $background_image = _s_get_acf_image( $background_image, 'hero', true );
                $this->add_render_attribute( 'wrapper', 'class', 'hero-background' );
                                
                $this->add_render_attribute( 'wrap', 'style', sprintf( 'background-image: url(%s);', $background_image ) );
                $this->add_render_attribute( 'wrap', 'style', sprintf( 'background-position: %s %s;', 
                                                                          $background_position_x, $background_position_y ) );
                
                if( true == $background_overlay ) {
                     $this->add_render_attribute( 'wrap', 'class', 'background-overlay' ); 
                }
                                                                          
            }  
           
            return;
        }
    }
}
   
new Hero_After_Location_Section; 