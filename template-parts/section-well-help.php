<?php
// Columns

if( ! class_exists( 'Team_Section' ) ) {
    class Team_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = [];
            $fields['heading'] = get_sub_field( 'team_heading' );
            $fields['team'] = get_sub_field( 'team' );
            $fields['staff'] = get_sub_field( 'staff' );
            $this->set_fields( $fields );
                        
            $settings = get_sub_field( 'team_settings' );
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
                     $this->get_name() . '-team',
                     $this->get_name() . '-team' . '-' . $this->get_id(),
                ]
            );            
            
        } 
        
        public function before_render() {
            
        }
        
        public function after_render() {
            
        }
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            $settings = $this->get_settings();
            
            $heading = _s_format_string( $fields['heading'], 'h2' );
            if( !empty( $heading ) ) {
                $heading = sprintf( '<header class="column row header"><span>%s</span></header>', $heading );
            }
            
            $sections = '';
            
            $rows = $this->get_fields( 'team' );
            
            if( !empty( $rows ) ) {
                
                foreach( $rows as $key => $row ) {
                    
                    $post_id = $row->ID;
                    
                    /*
                        photo
                        logos
                        title
                        linkedin
                        content
                        faq
                    */
                    
                    $icons = '';
                    
                    $email = get_field( 'email', $post_id );
                    if( !empty( $email ) ) {
                        $icons .= sprintf( '<li><a href="%s">%s</a></li>', $email, get_svg( 'email' ) );
                    }
                    
                    $linkedin = get_field( 'linkedin', $post_id );
                    if( !empty( $linkedin ) ) {
                        $icons .= sprintf( '<li><a href="%s">%s</a></li>', $linkedin, get_svg( 'linkedin' ) );
                    }
                    
                    $icons = _s_format_string( $icons, 'ul', array( 'class' => 'social-icons' ) );
                    
                    
                    $title = sprintf( '<h3>%s</h3>%s', $row->post_title, $icons );
                    
                    $content = '';
                    $content = sprintf( '<div class="entry-content">%s</div>', apply_filters( 'the_content', $row->post_content ) );
                    
                    
                    $photo = get_post_thumbnail_id( $post_id );
                    if( !empty( $photo ) ) {
                        $element['photo'] = [ 'image' => $photo, 'shape' => true ];
                        $photo = new Element_Photo( [ 'fields' => $element ]  ); // set fields from Constructor
                        $photo = $photo->get_element();
                    }
                    
                    $logos = get_field( 'logos', $post_id );
                    
                    if( !empty( $logos ) ) {
                        $logos = get_logos( $logos );
                    }
                    
                    $faq = get_field( 'faq', $post_id );
                    if( !empty( $faq ) ) {
                        $element['faq']['faq'] = get_field( 'faq', $post_id );
                        $faq = new Element_Faq( [ 'fields' => $element ]  ); // set fields from Constructor
                        $faq = $faq->get_element();
                    }
                    
                    $columns = '';
                    $column_classes_one = 'small-12 large-4 columns';
                    $column_classes_two = 'small-12 large-8 columns';
                    
                    if( $key % 2 == 0 ) {
                        $title = sprintf( '<header class="row align-right header-member"><div class="column large-8">%s</div></header>', $title );
                    }
                    else {
                        $heading = '';
                        $title = sprintf( '<header class="column row header-member">%s</header>', $title );
                       
                        $column_classes_one .= ' small-order-1 large-order-2';
                        $column_classes_two .= ' small-order-2 large-order-1';
                    }
                    
                    $columns  = sprintf( '<div class="column %s">%s%s</div>', $column_classes_one, $photo, $logos );
                    $columns .= sprintf( '<div class="column %s">%s%s</div>', $column_classes_two, $content, $faq );
                    
                    $before = sprintf( '<div class="shape">%s</div>', get_svg( 'curve-top' ) );
                    $after = sprintf( '<div class="shape">%s</div>', get_svg( 'curve-bottom' ) );
                    
                    $sections .= sprintf( '<section class="section-team">%s<div class="wrap">%s%s<div class="row">%s</div></div>%s</section>', 
                                          $before, $heading, $title, $columns, $after );
                    
                }
            }
            
            return $sections;
            
        }
        
    }
}
   
new Team_Section;