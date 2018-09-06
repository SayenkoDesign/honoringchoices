<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

get_header(); ?>

<?php
// Hero
$args = array(
	'post_type'      => 'page',
	'p'				 => get_option('page_for_posts'),
	'posts_per_page' => 1,
	'post_status'    => 'publish'
);

// Use $loop, a custom variable we made up, so it doesn't overwrite anything
$loop = new WP_Query( $args );

// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
// don't want to use $wp_query, use our custom variable instead.
if ( $loop->have_posts() ) : 
	while ( $loop->have_posts() ) : $loop->the_post(); 
	
		get_template_part( 'template-parts/hero' );
        
        get_template_part( 'template-parts/after-hero', 'news' );
 
	endwhile;
endif;

// We only need to reset the $post variable. If we overwrote $wp_query,
// we'd need to use wp_reset_query() which does both.
wp_reset_postdata();

?>

<div class="row column">

    <div id="primary" class="content-area">
    
        <main id="main" class="site-main" role="main">
            <?php 
            if( function_exists( 'facetwp_display' ) ) {
                
                $reset = "<div><button class=\"button blue\" onclick=\"FWP.reset()\">Reset</button></div>";
                
                printf( '<div class="facetwp-filters"><span>%s</span>%s%s%s</div>', 
                'Filter By:',
                facetwp_display( 'facet', 'categories' ),
                facetwp_display( 'sort' ),
                $reset
                );
            }
            ?>

            <?php
             
            if ( have_posts() ) : ?>
                
               <?php
               
               echo '<div class="row facetwp-template" data-equalizer data-equalize-on="large" data-equalize-by-row="true" id="posts-grid">';
                               
                while ( have_posts() ) :
    
                    the_post();
                    
                    global $wp_query;
                    $post_count = $wp_query->current_post + 1;
                                        
                    $full_width = ( $post_count % 5 == 1 ) ? true : false;
                                        
                    $columns = $full_width ? 'small-12 medium-6 large-12' : 'small-12 medium-6 large-3';
                    
                    printf( '<div class="column column-block %s">', $columns );
                    
                    _s_get_template_part( 'template-parts/content', 'post-column', 
                                          array( 'post_count' => $post_count, 'full_width' => $full_width ) );
                    
                    echo '</div>';
    
                endwhile;
                
                echo '</div>';
                
                if( function_exists( 'facetwp_display' ) ) {
                    echo facetwp_display( 'pager' );
                }
                else {
                    $previous = sprintf( '%s<span class="screen-reader-text">%s</span>', 
                                     get_svg( 'arrow' ), __( 'Previous Post', '_s') );
                
                    $next = sprintf( '%s<span class="screen-reader-text">%s</span>', 
                                         get_svg( 'arrow' ), __( 'Next Post', '_s') );
                    
                    the_posts_navigation( array( 'prev_text' => $previous, 'next_text' => $next ) );
                }
                
            else :
    
                get_template_part( 'template-parts/content', 'none' );
    
            endif; ?>
    
        </main>
    
    </div>

</div>
    

<?php
get_footer();
