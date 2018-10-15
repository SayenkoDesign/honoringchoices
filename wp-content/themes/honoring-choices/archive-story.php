<?php
get_header(); ?>

<?php
$page_id = 239; // Stories page

$args = array(
	'post_type'      => 'page',
	'p'				 => $page_id, 
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
        
        get_template_part( 'template-parts/after-hero', 'stories' );
 
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
             
            if ( have_posts() ) : ?>
                
               <?php
               if( function_exists( 'facetwp_display' ) ) {
                
                printf( '<div class="hide">%s</div>', facetwp_display( 'facet', 'story_categories' ) );
               
            }
               
               echo '<div class="masonry-grid facetwp-template">';
               
               echo '<div class="grid-sizer"></div>';
               
               echo '<div class="gutter-sizer"></div>';
                               
                while ( have_posts() ) :
    
                    the_post();
                    
                    print( '<div class="grid-item">' );
                    
                    _s_get_template_part( 'template-parts/content', 'story-column', [] );
                    
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
    
                get_template_part( 'template-parts/story', 'none' );
    
            endif; ?>
    
        </main>
    
    </div>
    
    <div id="secondary">
        
        <?php
        get_template_part( 'template-parts/content', 'story-form' );
        ?>
        
    </div>

</div>
    

<?php
get_footer();
