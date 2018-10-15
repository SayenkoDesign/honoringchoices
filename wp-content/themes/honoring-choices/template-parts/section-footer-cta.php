<?php

/*
Footer CTA
		
*/    
    
if( ! class_exists( 'Footer_CTA_Section' ) ) {
    class Footer_CTA_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = [];
            $fields = get_field( 'footer_cta', 'option' );
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
                     $this->get_name() . '-footer-cta'
                ]
            );
        }
        
        // Add content
        public function render() {
            
            $elements = $this->get_fields();
                        
            $settings = $this->get_settings();
                        
            $row = new Element_Row(); 
                        
            $column = new Element_Column(); 
            
            // Header
            $header = new Element_Header( [ 'fields' => $elements ]  ); // set fields from Constructor
            $column->add_child( $header );
            
            // Editor
            $editor = new Element_Editor( [ 'fields' => $elements ]  ); // set fields from Constructor
            $column->add_child( $editor );
                                            
            // Button
            $button = new Element_Button( [ 'fields' => $elements ]  ); // set fields from Constructor
            $button->add_render_attribute( 'anchor', 'class', [ 'button', 'blue' ] ); 
            $column->add_child( $button );
            
            $row->add_child( $column );
            
            $this->add_child( $row );
        }
    }
}
   
new Footer_CTA_Section;

    