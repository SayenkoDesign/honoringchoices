<?php
// Columns

if( ! class_exists( 'About_Personal_stories_Section' ) ) {
    class About_Personal_stories_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'personal_stories' );
            $fields['button'] = [ 'text' => 'Read More Persoanl Stories >', 'link' => $fields['link_text'] ];
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
                     $this->get_name() . '-personal-stories'
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
            $header = new Element_Header( [ 'fields' => $fields ]  ); // set fields from Constructor
            $column->add_child( $header );
            
            // Editor
            $editor = new Element_Editor( [ 'fields' => $fields ]  ); // set fields from Constructor
            $column->add_child( $editor );
                                            
            // Button - link_text
            $button = new Element_Button( [ 'fields' => $fields ]  ); // set fields from Constructor
            $column->add_child( $button );
            
            $row->add_child( $column );
            
            $column = new Element_Column(); 
            $column->set_settings( array( 'row_id' => $row->get_id(), 'column_widths' => '1/2' ) );
            
            // Right Column
            $card = $this->get_card();
            $html = new Element_Html( [ 'fields' => [ 'html' => $card ] ]  ); // set fields from Constructor
            $column->add_child( $html );
            
            $row->add_child( $column );

            
            $this->add_child( $row );
        }
        
        
        private function get_card() {
         
            $fields = $this->get_fields();
            
            $element = $this->get_fields( 'featured_story' );
            
            // we need a story to link to
            $story = $element[ 'story' ];
            if( empty( $story ) ) {
                return false;
            }
            
            $photo = _s_get_acf_image( $element[ 'photo' ], 'medium', true );
            if( !empty( $photo ) ) {
                $background = sprintf( 'style="background-image: url(%s);"', $photo );
                $photo = sprintf( '<div class="thumbnail"%s></div>', $background );
            }
            $name  = _s_format_string( $element[ 'name' ], 'h3' );
            $button = new Element_Button( [ 'fields' => [ 'button' => [ 'text' => 'Read More >'] ] ] ); // set fields from Constructor
            $button->add_render_attribute( 'anchor', 'href', $story );
            $button = $button->get_element();
            $title = _s_format_string( $element[ 'title' ], 'h5', [ 'class' => 'title' ] );
            $quote = sprintf( '<p class="quote">"%s"</p>', str_replace( '"', '', $element[ 'quote' ] ) );
            $quote_mark = sprintf( '<div class="quote-mark"><img src="%sicons/quote-small.svg" /></div>', trailingslashit( THEME_IMG ) );
            
            return sprintf( '<div class="card clearfix">%1$s%2$s<div class="hover">%4$s%6$s</div><div class="default">%3$s<h5>Personal Story</h5>%5$s</div></div>',
                         
                            $photo,
                            $name,
                            $title,
                            $quote,
                            $quote_mark,
                            $button
                         
                          );
            
        }
        
    }
}
   
new About_Personal_stories_Section;
