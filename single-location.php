<?php

get_header(); ?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
     
	<?php
    get_template_part( 'template-parts/hero', 'single-location' );

    get_template_part( 'template-parts/hero', 'after-single-location' );
    
    // Add top section
    intro();
    function intro() {
        
        add_filter( 'single_location_icon_folder', function() {
            return sprintf( '%sicons/location/', trailingslashit( THEME_IMG ) );
        });
        
        $location = new Single_location;
                
        $left = sprintf( '<div class="small-12 medium-6 large-4 columns column-block">%s%s%s%s</div>',  
                        $location->get_field( 'address' ),
                        $location->get_field( 'phone' ),
                        $location->get_field( 'website' ),
                        $location->get_field( 'email' )
                );
                
        $position = _s_format_string( get_field( 'contact_position' ), 'h3', [] );
        $name = _s_format_string( get_field( 'contact_name' ), 'h4', [] );
        $email = get_field( 'email' );
        if( ! empty( $email ) ) {
            $email = sprintf( '<p>%s</p>', _s_format_string( antispambot( $email ), 'a', [ 'href' => antispambot( $email ) ] ) );
        }
        
        $event_category = get_field( 'event_category' );
        
        $events = $location->get_events( $event_category );
        
        $right = sprintf( '<div class="small-12 medium-6 large-8 columns column-block"><div class="details">%s%s%s</div>%s</div>',  
                          $position, 
                          $name, 
                          $email,
                          $events
                );
        
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
