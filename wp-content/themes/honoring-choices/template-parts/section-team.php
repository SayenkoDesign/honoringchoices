<?php
// Staff

if( ! class_exists( 'Team_Section' ) ) {
    class Team_Section extends Element_Section {
        
        var $post_type = 'team';
        static public $section;
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'team' );
            
            if( empty( $fields ) ) {
                return false;
            }
            
            //printf( '<section class="section-team" id="section-team"><header class=" column row text-center"><h2>%s</h2></header></section>', 'Our Team' );
            
            echo '<section id="section-team"></div>';
                        
            foreach( $fields as $field ) {
                
                self::$section ++;
                
                $this->set_fields( $field );
                
                // Render the section
                $this->render();
                
                // print the section
                $this->print_element();     
            }
        }
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
            
            $class = ( 1 == self::$section % 2 ) ? $this->get_name() . '-team-curved' : '';
            
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-team',
                     $class
                ], true
            );    
            
            $this->add_render_attribute(
                'wrapper', 'id', [
                     $this->get_name() . '-team-' . self::$section
                ], true
            );            
            
        }  
        
        
        public function before_render() {
                            
            $this->add_render_attribute( 'wrap', 'class', 'wrap', true );
            
            $before = ( 1 == self::$section % 2 ) ? sprintf( '<div class="shape">%s</div>', get_svg( 'curve-top' ) ) : '';
            
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
            
            $after = ( 1 == self::$section % 2 ) ? sprintf( '<div class="shape">%s</div>', get_svg( 'curve-bottom' ) ) : '';  
            
            return sprintf( '</div>%s</%s>', $after, esc_html( $this->get_html_tag() ) );
        }
       
        
        // Add content
        public function render() {
                        
            return $this->team();
            
        }
        
        
        private function team() {
        
            $loop = new WP_Query( array(
                'post_type' => $this->post_type,
                'orderby' => 'post__in',
                'post__in' => $this->get_fields( 'team' ),
                'posts_per_page' => 100,
            ) );
            
            $out = '';
            
            if ( $loop->have_posts() ) : 
            
                $out .= sprintf( '<header class="column row text-center">%s</header>', _s_format_string( $this->get_fields( 'heading' ), 'h2' ) );
                        
                $grid_columns = 'large-up-4';
                
                $out .= sprintf( '<div class="row small-up-1 medium-up-2 %s align-center" data-equalizer data-equalize-on="medium">', $grid_columns );
          
                while ( $loop->have_posts() ) :
    
                    $loop->the_post(); 
                    
                    
                    $out .= sprintf( '<article id="post-%s" class="%s">', get_the_ID(), join( ' ', get_post_class( 'column column-block' ) ) );
    
                    $background = sprintf( ' style="background-image: url(%s)"', get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) );
                    
                    $linkedin = get_field( 'linkedin' );
                    if( ! empty( $linkedin ) ) {
                        $linkedin = sprintf( '<div class="social-icon">%s</div>', _s_format_string( get_svg( 'linkedin' ), 'a', [ 'href' => $linkedin ] ) );
                    }
                    
                    $title  = sprintf( '<header>%s%s</header>', the_title( '<h3>', '</h3>', false ), $linkedin );
                    
                    $position  = get_field( 'position' );
                    $position = _s_format_string( $position, 'p' );
                    
                    $description = get_field( 'description' );
                    $description = _s_format_string( $description, 'p' );
                                        
                    $out .= sprintf( '<div class="thumbnail"%s></div><div class="panel" data-equalizer-watch>%s%s%s', 
                            $background, 
                            $title, 
                            $position,
                            $description
                            
                          );
                    
                    $out .= '</article>';
    
                endwhile;
                
                $out .= '</div>';
                
            endif; 
            
            wp_reset_postdata();
            
            return $out;
        }
        
        
    }
}

   
new Team_Section;
