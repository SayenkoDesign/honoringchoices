<?php
/*
Template Name: Contact
*/


get_header(); ?>

<?php
get_template_part( 'template-parts/hero' );

?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
	<?php
 	// Default
	section_default();
	function section_default() {
				
		global $post;
		
		$attr = array( 'class' => 'section default' );
		
		$args = array(
            'html5'   => '<section %s>',
            'context' => 'section',
            'attr' => $attr,
        );
        
        _s_markup( $args );
        
        _s_structural_wrap( 'open' );
		
		print( '<div class="row">' );
        
            print( '<div class="column column-block small-12 large-6">' );
            
            while ( have_posts() ) :
    
                the_post();
                            
                echo '<div class="entry-content">';
                
                the_content();
                                
                echo '</div>';
                    
            endwhile;
            
            print( '</div>' );
            
            print( '<div class="column column-block small-12 large-6">' );
            
                $form_id = get_field( 'gravity_form' );
            
                $form = GFAPI::get_form( $form_id );
                
                if( false !== $form ) {
                   printf( '<div class="contact-form"><div class="wrap">%s</div></div>', 
                            do_shortcode( sprintf( '[gravityform id="%s" title="true" description="true" ajax="true"]', $form_id ) ) );
                }
                                        
            print( '</div>' );
        
        print( '</div>' );
        
		_s_structural_wrap( 'close' );
	    echo '</section>';
	}
	?>
	</main>


</div>

<?php
get_footer();
