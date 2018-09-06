<?php

/*
Hero Post
		
*/


if( ! class_exists( 'Hero_Post' ) ) {
    class Hero_Post extends Element_Section {
        
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
                     $this->get_name() . '-hero'
                ]
            );
        }
        
        
        // Add content
        public function render() {
                                
            $heading        = $this->get_fields( 'heading' ) ? $this->get_fields( 'heading' ) : get_the_title();
            $heading        = _s_format_string( $heading, 'h1' );
            
            $post_date = _s_get_posted_on();
                        
            // Use hero_background from category
            $category_hero = get_field( 'category_hero' );
                        
            $background_position_x = 'center'; 
            $background_position_y = 'center';
            
            if( ! empty( $category_hero ) ) {
                
                $hero_background = get_field( 'hero_background', $category_hero );
                                
                if( ! empty( $hero_background ) ) {
                    
                    $background_image = wp_get_attachment_image_src( $hero_background, 'hero' );
                    $background       = $background_image[0];
                                    
                    $this->add_render_attribute( 'wrapper', 'class', 'hero-background' );
                    
                    $this->add_render_attribute( 'wrap', 'style', sprintf( 'background-image: url(%s);', $background ) );
                    
                    $this->add_render_attribute( 'wrap', 'style', sprintf( 'background-position: %s %s;', 
                                                                              $background_position_x, $background_position_y ) );
    
                    $this->add_render_attribute( 'wrap', 'class', 'background-overlay' ); 
                }
                
                
                                                                          
            }  
            
            $post_author = _s_get_post_author();
            
            if( ! empty( $post_author ) ) {
                $this->add_render_attribute( 'wrapper', 'class', 'has-post-author' );   
            }
            
            return sprintf( '<div class="row align-middle"><div class="column"><div class="caption">%s%s%s</div></div></div>', 
                           get_the_category_list( '' ), 
                           $heading, 
                           $post_date );
        }
    }
}
   
new Hero_Post; 