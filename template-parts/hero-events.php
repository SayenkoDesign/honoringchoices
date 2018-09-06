<?php

/*
Hero - Events
		
*/


if( ! class_exists( 'Hero_Events_Section' ) ) {
    class Hero_Events_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                                    
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
                        
            $heading        = 'Community Events';
            $heading        = _s_format_string( $heading, 'h1' );
                       
            return sprintf( '<div class="row align-middle"><div class="column">%s</div></div>', $heading );
        }
    }
}
   
new Hero_Events_Section; 