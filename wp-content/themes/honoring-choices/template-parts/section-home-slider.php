<?php

/*
Home - News Ticker
		
*/    
    
if( ! class_exists( 'Home_Slider_Section' ) ) {
    class Home_Slider_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = [];
            $fields = get_field( 'slider' );
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
            
            $rows = $this->get_fields();                        
                        
            if( empty( $rows ) ) {
                return false;
            }
            
            $fs_row = new Element_Row(); 
            
            $column = new Element_Column(); 
                        
            $slides = ''; 
                        
            foreach( $rows as $row ) {
                
                $photo = _s_get_acf_image( $row['photo'] );
                $link = $row['link'];
                $anchor_open = $anchor_close = '';
                if( ! empty( $link ) ) {
                    $anchor_open = sprintf( '<a href="%s">', $link );
                    $anchor_close = '</a>';
                }
                
                $slides .= sprintf( '<div class="slide">%s%s%s</div>', $anchor_open, $photo, $anchor_close );
                
            } 
            
            $html = new Element_Html( [ 'fields' => [ 'html' => $slides ] ]  ); 
            $html->add_render_attribute( 'wrapper', 'class', 'slick' );
                        
            $column->add_child( $html );
                
            $fs_row->add_child( $column );
            
            $this->add_child( $fs_row );

        }
    }
}
   
new Home_Slider_Section;

    