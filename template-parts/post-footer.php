<?php

/*
Post Footer
		
*/


if( ! class_exists( 'Post_Footer' ) ) {
    class Post_Footer extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                                    
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
                     $this->get_name() . '-post-footer'
                ]
            );
        }
        
        
        // Add content
        public function render() {
                                            
            $previous = sprintf( '%s<span class="%s"></span>', 
                    get_svg( 'arrow-left' ), __( 'Previous Post', '_s') );
                    
            $next = sprintf( '%s<span class="%s"></span>', 
                             get_svg( 'arrow-right' ), __( 'Next Post', '_s') );
            
            $navigation = _s_get_the_post_navigation( array( 'prev_text' => $previous, 'next_text' => $next ) );
            
            $share = sprintf( '<h4><span>%s</span></h4>%s', __( 'Share This', '_s' ), _s_get_addtoany_share_icons() );
            
            return sprintf( '<div class="row align-middle"><div class="column text-center">%s%s</div></div>', 
                            $navigation, $share );
                            
        }
    }
}
   
new Post_Footer; 