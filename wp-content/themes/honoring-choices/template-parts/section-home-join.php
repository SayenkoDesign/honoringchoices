<?php
// Home - join

if( ! class_exists( 'Home_Join_Section' ) ) {
    class Home_Join_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'join' );
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
                     $this->get_name() . '-join',
                     $this->get_name() . '-join' . '-' . $this->get_id(),
                ]
            );            
            
        }  
        
        
        public function before_render() {
                            
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            $before = sprintf( '<div class="shape">%s</div>', get_svg( 'curve-top' ) );
            
            return sprintf( '<%s %s>%s<div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $before,
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
            
            $after = sprintf( '<div class="shape">%s</div>', get_svg( 'curve-bottom' ) );  
            
            return sprintf( '</div>%s</%s>', $after, esc_html( $this->get_html_tag() ) );
        }
        
        
        // Add content
        public function render() {
            
            $elements = $this->get_fields();
                        
            $settings = $this->get_settings();
                        
            $row = new Element_Row(); 
            
            // Column
            $column = new Element_Column(); 
            $column->set_settings( array( 
                                         'row_id' => $row->get_id(), 
                                         'column_widths' => '5/12', 
                                         'small_odd_order' => 'small-order-2', 
                                         'small_even_order' => 'small-order-1' ) 
                                  );
            
                // Photo
                $photo = new Element_Photo( [ 'fields' => $elements ]  ); // set fields from Constructor
                $column->add_child( $photo );
            
            $row->add_child( $column );
            
            // Column           
            $column = new Element_Column(); 
            $column->set_settings( array( 
                                         'row_id' => $row->get_id(), 
                                         'column_widths' => '7/12', 
                                         'small_odd_order' => 'small-order-2', 
                                         'small_even_order' => 'small-order-1' ) 
                                  );
            
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
   
new Home_Join_Section;
