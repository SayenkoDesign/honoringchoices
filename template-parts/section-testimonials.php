<?php

/*
Testimonials
		
*/    
    
if( ! class_exists( 'Testimonial_Section' ) ) {
    class Testimonial_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = [];
            $fields['testimonials'] = get_field( 'testimonials' );
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
                     $this->get_name() . '-testimonials',
                     $this->get_name() . '-testimonials' . '-' . $this->get_id(),
                ]
            );
        }
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            $slides = '';
            
            $rows = $fields['testimonials'];
            
            if( empty( $rows ) ) {
                return false;
            }
            
            foreach( $rows as $row ) {
                
                $cite = $row->post_title;
                                
                $url = get_field( 'url', $row->ID );
                
                if( !empty( $cite ) ) {
                    
                    $tag = 'span';
                    if( !empty( $url ) ) {
                        $tag = 'a';
                        $this->add_render_attribute( 'anchor', 'href', $url, true );
                        $this->add_render_attribute( 'anchor', 'class', 'button-link', true );
                    }
                    else {
                        $this->add_render_attribute( 'anchor', 'class', '', true );   
                    }
                    
                    $cite = sprintf( '<%1$s %2$s>~ %3$s ~</%1$s>', 
                                     $tag, 
                                     $this->get_render_attribute_string( 'anchor' ), 
                                     $cite );
                                     
                    $cite =  _s_format_string( $cite, 'h3' );
                                        
                }
                
                $blockquote = sprintf( '<blockquote>%s%s</blockquote>', apply_filters( 'pb_the_content', $row->post_content ), $cite );
                
                $slides .= sprintf( '<div class="content">%s</div>', $blockquote );
                
            }  
            
            $quote_mark_icon = sprintf('<img src="%shome/quote.svg" class="" />', trailingslashit( THEME_IMG ) );  
            $quote_mark      = sprintf( '<div class="quote-mark">%s</div>', $quote_mark_icon );  
            
            $photo = sprintf('<img src="%shome/testimonials-photo.png" class="" />', trailingslashit( THEME_IMG ) );    
               
            return sprintf( '<div class="row align-middle"><div class="column">%s<div class="slick">%s</div>%s</div></div>', 
                            $quote_mark, $slides, $photo );
        }
    }
}
   
new Testimonial_Section;

    