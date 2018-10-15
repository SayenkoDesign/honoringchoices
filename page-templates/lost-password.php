<?php
/*
Template Name: Lost Password
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
		
		print( '<div class="column row">' );
		
		while ( have_posts() ) :

			the_post();
            			
            echo '<div class="entry-content">';
            
			the_content();
            
            echo '</div>';
				
		endwhile;
		
		print( '</div>' );
        
		_s_structural_wrap( 'close' );
	    echo '</section>';
	}
	?>
	</main>


</div>

<?php
get_footer();
