<?php

/*
Hero - Home
		
*/


if( ! class_exists( 'Hero_Archive_Section' ) ) {
    class Hero_Archive_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'hero' );
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
                     $this->get_name() . '-hero'
                ]
            );
        }
        
                
        // Add content
        public function render() {
            
            $fields = $this->get_fields(); 
            
            $heading        = $this->get_fields( 'heading' ) ? $this->get_fields( 'heading' ) : get_the_title();
            $heading        = _s_format_string( $heading, 'h1' );
           
            return sprintf( '<div class="row"><div class="column"><div class="caption">%s</div></div></div>', $heading );
        }
    }
}
   
new Hero_Archive_Section; 