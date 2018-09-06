<?php
// Home Intro

if( ! class_exists( 'Intro_Section' ) ) {
    class Intro_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'introduction' );
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
                     $this->get_name() . '-intro',
                     $this->get_name() . '-intro' . '-' . $this->get_id(),
                ]
            );            
            
        }  
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                
            $row = new Element_Row(); 
            
            $column = new Element_Column(); 
            $column->set_settings( array( 'row_id' => $row->get_id(), 'column_widths' => '1/2' ) );
                
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $header );
            
            // Editor
            $editor = new Element_Editor( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $editor );
                                
            // Button
            $button = new Element_Button( [ 'fields' => $fields ] ); // set fields from Constructor
            $button->add_render_attribute( 'anchor', 'class', 'button' ); 
            $column->add_child( $button );
            
            $row->add_child( $column );
            
            $column = new Element_Column(); 
            $column->set_settings( array( 'row_id' => $row->get_id(), 'column_widths' => '1/2' ) );
            
            // Photo
            $photo = new Element_Photo( [ 'fields' => $fields ]  ); // set fields from Constructor
            $column->add_child( $photo );
            
            $row->add_child( $column );
            
            $this->add_child( $row );
        }
        
    }
}
   
new Intro_Section;
