<?php
// Columns

if( ! class_exists( 'Column_Section' ) ) {
    class Column_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_sub_field( 'columns_section' );
            $this->set_fields( $fields );
            
            $settings = get_sub_field( 'columns_settings' );
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
                     $this->get_name() . '-columns',
                     $this->get_name() . '-columns' . '-' . $this->get_id(),
                ]
            );            
            
        }    
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            $settings = $this->get_settings();
            
            $row = new Element_Row(); 
            
            foreach( $fields as $count => $field ) {
                
                if( $count ) {
                    $this->add_render_attribute( 'wrapper', 'class', 'column-count-2' );
                }
                
                $elements = $field['elements'];  
                                
                $column = new Element_Column( [ 'settings' => $field['settings'] ] ); 
                                
                foreach( $elements as $element ) {  
                
                    // Elements: button, editor, photo, slideshow, video, faq, menu                      
                    
                    // Header
                    $header = new Element_Header( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $header );
                    
                    // Editor
                    $editor = new Element_Editor( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $editor );
                    
                    // Photo
                    $photo = new Element_Photo( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $photo );
                    
                    // Slideshow
                    $slideshow = new Element_Slideshow( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $slideshow );
                    
                    // Video
                    $video = new Element_Video( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $video );
                    
                    // FAQ
                    $faq = new Element_Faq( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $faq );
                    
                    // Menu
                    $menu = new Element_Menu( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $menu );
                    
                    // Button
                    $button = new Element_Button( [ 'fields' => $element ]  ); // set fields from Constructor
                    $column->add_child( $button );
                    
                    
                }
                
                $row->add_child( $column );

            }
            
            $this->add_child( $row );
        }
        
    }
}
   
new Column_Section;
