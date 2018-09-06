<?php
/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function kr_body_class( $classes ) {
  $classes[] = 'page-builder';
  return $classes;
}
add_filter( 'body_class', 'kr_body_class' );

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
     
	<?php
    get_template_part( 'template-parts/hero', 'single-location' );

    get_template_part( 'template-parts/hero', 'after-single-location' );
    
    // Add top section
    intro();
    function intro() {
                
        
        $location = [];
        
        $fields = array( 
                        'address' => '', 
                        'contact_name' => '', 
                        'contact_position' => '', 
                        'phone' => '', 
                        'website' => '', 
                        'email' => '', 
                        'map_marker' => ''
                       );
                
        foreach( $fields as $key => $field ) {
            
            $data = get_field( $key );
            
            if( !empty( $data ) ) {
                
                if( 'map_marker' == $key ) {
                    $location['lat'] = $data['lat']; 
                    $location['lng'] = $data['lng']; 
                    $url = wp_is_mobile() ? 'place' : 'dir';
                    $location['directions'] = sprintf( 'https://www.google.com/maps/%s/%s', $url, urlencode( $data['address'] ) );
                }
                                
                if( ! is_array( $data ) ) {
                    
                    switch( $key ) {
                        case 'address':
                        $location[$key] = sprintf( '<div class="address">%s%s</div>', get_theme_icon( 'address' ), nl2br( $location['address'] ) ) ? : '';
                    }
                    
                    $location[$key] = $data;
                }
            }
             
        }
        
        $location = wp_parse_args( $location, $fields );
        
        if( ! empty( $location['address'] ) ) {
            $address = sprintf( '<div class="address">%s%s</div>', get_theme_icon( 'address' ), nl2br( $location['address'] ) );
        }
        
        if( ! empty( $contact_name ) ) { {
            $phone = _s_format_telephone_url( $location['phone'] );
        }
        
        if( ! empty( $phone ) ) { {
            $phone = _s_format_telephone_url( $location['phone'] );
        }
        
        if( ! empty( $phone ) ) { {
            $phone = _s_format_telephone_url( $location['phone'] );
        }
        
        
        
        $content = '';
        
        $content = _s_get_textarea( $location['address'], 'p', array( 'class' => 'location' ) );
        
        $content .= sprintf( '<p><a href="%s" class="arrow">%s</a></p>', $location['directions'], 'Get Directions' );
        
        $content .= sprintf( '<p class="tel"><a href="%s">%s</a></p>', $phone );
        
        $left = sprintf( '<div class="small-12 large-6 columns">%s</div>', $content );
        
       
        $right = sprintf( '<div class="small-12 large-6 columns">%s</div>', $content );
        
        $left = sprintf( '<div class="row">%s%s</div>', $left, $right );
        
        $left = sprintf( '<div class="small-12 medium-6 large-8 columns">%s</div>',  $left );
        
        $content = sprintf( '<p><a href="%s" class="button green">%s</a></p>', '#section-leadership', 'Message Us' ); // #club-contact
        $content .= sprintf( '<p><a href="%s" class="button green">%s</a></p>', _s_format_telephone_url( $location['phone'] ), 'Call Us' );
        $right = sprintf( '<div class="small-12 medium-6 large-4 columns">%s</div>',  $content );
        
        $attr = array( 'id' => 'location-intro', 'class' => 'section-intro' );        	
        
        _s_section_open( $attr );	
           
        printf( '<div class="column row"><div class="box"><div class="row">%s%s</div></div></div>', $left, $right );
        
        _s_section_close();
        
    }
    		
	?>
    
 
    
    
	</main>


</div>

<?php
get_footer();
