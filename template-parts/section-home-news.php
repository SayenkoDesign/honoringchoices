<?php

/*
Home - News Ticker
		
*/    
    
if( ! class_exists( 'Home_News_Section' ) ) {
    class Home_News_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = [];
            $fields = get_field( 'news_ticker' );
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
                     $this->get_name() . '-home-news',
                     $this->get_name() . '-home-news' . '-' . $this->get_id(),
                ]
            );
        }
        
        
        public function before_render() {
                            
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            $before = sprintf( '<div class="arrow-down">%s</div>', '' );
            
            return sprintf( '<%s %s>%s<div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $before,
                            $this->get_render_attribute_string( 'wrap' )
                            );
        }
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();                        
            
            $rows = $fields['grid'];
            
            if( empty( $rows ) ) {
                return false;
            }
            
            $fs_row = new Element_Row(); 
            
            $column = new Element_Column(); 
                        
            $slides = ''; 
                        
            foreach( $rows as $row ) {
                
                $header = new Element_Header( [ 'fields' => [ 'heading' => $row['grid_title'] ] ]  ); // set fields from Constructor
                $header = $header->get_element();   
                
                $editor = new Element_Editor( [ 'fields' => [ 'editor' => wpautop( $row['grid_description'] ) ] ]  ); // set fields from Constructor
                $editor = $editor->get_element();   
                
                $button = new Element_Button( [ 'fields' => [ 'button' => $row['grid_button'] ] ] ); // set fields from Constructor
                $button->add_render_attribute( 'anchor', 'class', ['button', 'green' ] ); 
                $button = $button->get_element();   
                
                $slides .= sprintf( '<div class="slide"><div class="row align-bottom"><div class="column"><article>%s<div class="entry-content">%s%s</div></article></div></div></div>', $header, $editor, $button );
                
            } 
            
            $html = new Element_Html( [ 'fields' => [ 'html' => $slides ] ]  ); 
            $html->add_render_attribute( 'wrapper', 'class', 'slick' );
            
            $background_image       = $this->get_fields( 'background_image' );
            $background_position_x  = $this->get_fields( 'background_position_x' );
            $background_position_y  = strtolower( $this->get_fields( 'background_position_y' ) );
            $background_overlay     = strtolower( $this->get_fields( 'background_overlay' ) );
            
            if( ! empty( $background_image ) ) {
                $background_image = _s_get_acf_image( $background_image, 'hero', true );
                $html->add_render_attribute( 'wrapper', 'class', 'hero-background' );
                                
                $html->add_render_attribute( 'wrapper', 'style', sprintf( 'background-image: url(%s);', $background_image ) );
                $html->add_render_attribute( 'wrapper', 'style', sprintf( 'background-position: %s %s;', 
                                                                          $background_position_x, $background_position_y ) );
                
                if( true == $background_overlay ) {
                     $html->add_render_attribute( 'wrapper', 'class', 'background-overlay' ); 
                }
                                                                          
            }
            
            $column->add_child( $html );
                
            $fs_row->add_child( $column );
            
            $this->add_child( $fs_row );

        }
    }
}
   
new Home_News_Section;

    