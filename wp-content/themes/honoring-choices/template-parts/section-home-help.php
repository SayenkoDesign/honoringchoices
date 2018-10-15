<?php
// Home Intro

if( ! class_exists( 'Intro_Section' ) ) {
    class Intro_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'well_help_you' );
            $this->set_fields( $fields );
            
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
                     $this->get_name() . '-home-help'
                ]
            );            
            
        }  
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                
            $row = new Element_Row(); 
            
            $column = new Element_Column(); 
                
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $header );
            
            $grid = new Element_Grid( [ 'fields' => $fields ] ); // set fields from Constructor
            $grid->set_settings( array( 'format' => 'block' ) );
            $column->add_child( $grid );
            
            $row->add_child( $column );
            
            $this->add_child( $row );
        }
        
    }
}
   
new Intro_Section;
