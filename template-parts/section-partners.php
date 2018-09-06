<?php
// Home Intro

if( ! class_exists( 'Partners_Section' ) ) {
    class Partners_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'partners' );
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
                     $this->get_name() . '-partners', 'section-logos'
                ]
            );  
            
            $this->add_render_attribute(
                'wrapper', 'id', [
                     $this->get_name() . '-partners'
                ], true
            );             
            
        }
        
        
       
        public function before_render() {
                            
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            $logo_mark = sprintf( '<div class="logo-mark icon shadow"><img src="%slogo-mark.svg" class="" /></div>', trailingslashit( THEME_IMG ) );  
            
            return sprintf( '<%s %s>%s<div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $logo_mark,
                            $this->get_render_attribute_string( 'wrap' )
                            );
        }
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                
            $row = new Element_Row(); 
            $column = new Element_Column(); 
                            
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            $header = $header->get_element();
            
            // Editor
            $editor = new Element_Editor( [ 'fields' => $fields ] ); // set fields from Constructor
            $editor = $editor->get_element();
            
            $featured_logos = $this->get_logos( true );
            
            $content = new Element_Html( [ 'fields' => [ 'html' => $header . $editor . $featured_logos ] ]  );
            $content->add_render_attribute( 'wrapper', 'class', ['entry-content', 'introduction' ], true );
            $column->add_child( $content );
            
            $row->add_child( $column );
            $this->add_child( $row );
            
            $row = new Element_Row(); 
            $column = new Element_Column(); 
            
            $logos = new Element_Html( [ 'fields' => [ 'html' => $this->get_logos() ] ]  ); 
            $this->add_child( $logos );
            
            $row = new Element_Row(); 
            $column = new Element_Column(); 
                                
            // Button
            $button = new Element_Button( [ 'fields' => $fields ] ); // set fields from Constructor
            $button->add_render_attribute( 'wrapper', 'class', 'text-center' ); 
            $button->add_render_attribute( 'anchor', 'class', [ 'button', 'green-alt' ] ); 
            $column->add_child( $button );
            
            $row->add_child( $column );
            
            $this->add_child( $row );
        }
     
     
        private function get_logos( $featured = false ) {
            
            $logos = $this->get_fields( 'logos');
            
            $columns = $featured_columns = '';
            
            if( ! empty( $logos ) ) {
                
                foreach( $logos as $logo ) {
                    $image = $logo['image'];
                    $url = $logo['url'];
                    $is_featured = $logo['featured'];
                    $image = _s_get_acf_image( $image, 'thumbnail' );
                    $tag = 'span';
                    $this->set_render_attribute( 'anchor', 'href', '' );
                    if( !empty( $url ) ) {
                        $tag = 'a';
                        
                        $this->add_render_attribute( 'anchor', 'href', $url, true );
                        
                        $logo = sprintf( '<div class="column column-block"><div class="logo"><%1$s %2$s>%3$s</%1$s></div></div>', 
                                        $tag, 
                                        $this->get_render_attribute_string( 'anchor' ), 
                                        $image ); 
                        
                        if( $is_featured ) {
                            $featured_columns .= $logo;
                        }
                        else {
                            $columns .= $logo;
                        }
                        
                        
                    }
                    else {
                        $logo = sprintf( '<div class="column column-block"><div class="logo"><%1$s>%2$s</%1$s></div></div>', 
                                        $tag, 
                                        $image );
                        
                        if( $is_featured ) {
                            $featured_columns .= $logo;
                        }
                        else {
                            $columns .= $logo;
                        } 
                    }
                    
                    
                }
                
                $show = $featured ? $featured_columns : $columns;
                $large_columns = $featured ? '' : ' large-up-4';
                
                return sprintf( '<div class="row small-up-1 medium-up-2%s align-middle align-center logos">%s</div>', 
                                $large_columns, $show );
                
            }
        }
        
    }
        
}
   
new Partners_Section;
