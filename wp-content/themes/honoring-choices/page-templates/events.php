<?php
/*
Template Name: Events
*/


get_header(); ?>

<?php
get_template_part( 'template-parts/hero-events' );

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
        
            print( '<div class="column column-block small-12">' );
            
            while ( have_posts() ) :
    
                the_post();
                                            
                the_content();
                                                    
            endwhile;
            
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
