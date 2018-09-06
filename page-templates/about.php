<?php
/*
Template Name: About
*/


get_header(); ?>

<?php
get_template_part( 'template-parts/hero' );
        
get_template_part( 'template-parts/after-hero', 'about' );

?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
	<?php
        get_template_part( 'template-parts/section', 'about-personal-stories' );       
        
		get_template_part( 'template-parts/section', 'staff' );   
        
        get_template_part( 'template-parts/section', 'board' ); 
        
        get_template_part( 'template-parts/section', 'supporters' ); 
        
        get_template_part( 'template-parts/section', 'partners' ); 
        
        get_template_part( 'template-parts/section', 'program-participants' ); 
	?>
	</main>


</div>

<?php
get_footer();
