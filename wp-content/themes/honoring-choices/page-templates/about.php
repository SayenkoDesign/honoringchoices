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
        
        /*
        **** Create a "Tram Section"
        Combine staff and board into a "Team" section and query by the categories. Create a relaitonship field inside About page edit screen to choose the categories to show. */
		get_template_part( 'template-parts/section', 'team' );   
        
        if( ! function_exists( 'get_section_logos' ) ) {
            function get_section_logos() {
                
                $post_ids = get_field( 'logos' );
                                        
                if( empty( $post_ids ) ) {
                    return;
                }
                
                // arguments, adjust as needed
                $args = array(
                    'post_type'      => 'logo',
                    'posts_per_page' => 100,
                    'post_status'    => 'publish'
                );
                
            
                $args['orderby'] = 'post__in';
                $args['post__in'] = $post_ids;
                    
                // Use $loop, a custom variable we made up, so it doesn't overwrite anything
                $loop = new WP_Query( $args );
            
                // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
                // don't want to use $wp_query, use our custom variable instead.
                if ( $loop->have_posts() ) : 
                
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                        
                        $group = sanitize_title( get_the_title() );
                                                    
                        _s_get_template_part( 'template-parts/section', 'logos', [ 'group' => $group ] );
           
            
                    endwhile;
                endif;
            
                wp_reset_postdata();
            }
        }
        
        get_section_logos();
                
        
	?>
	</main>


</div>

<?php
get_footer();
