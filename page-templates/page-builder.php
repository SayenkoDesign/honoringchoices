<?php
/*
Template Name: Page Builder
*/


/**
 * Custom Body Class
 *
 * @param array $classes
 * @return array
 */
function kr_body_class( $classes ) {
  unset( $classes[array_search('page-template-default', $classes )] );
  $classes[] = 'page-builder';
  return $classes;
}
add_filter( 'body_class', 'kr_body_class', 99 );

get_header(); ?>

<?php
    get_template_part( 'template-parts/hero' );
?>

<div id="primary" class="content-area">

	<main id="main" class="site-main" role="main">
         
	<?php
 	get_template_part( 'template-parts/page-builder' );
	?>
    
	</main>


</div>

<?php
get_footer();
