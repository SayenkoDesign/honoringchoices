<?php
/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function kr_body_class( $classes ) {
  unset( $classes[array_search('page-template-default', $classes )] );
  // $classes[] = 'page-builder';
  return $classes;
}
add_filter( 'body_class', 'kr_body_class', 99 );

get_header(); ?>

<?php
get_template_part( 'template-parts/hero', 'home' );
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
     
	<?php
 	 _s_get_template_part( 'template-parts/section', 'home-help' );
     
     _s_get_template_part( 'template-parts/section', 'home-news' );
     
     _s_get_template_part( 'template-parts/section', 'home-join' );
     
     _s_get_template_part( 'template-parts/section', 'testimonials' );
   	?>
    
    
    
	</main>


</div>

<?php
get_footer();
