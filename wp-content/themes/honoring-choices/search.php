<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
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
	
		get_template_part( 'template-parts/blog', 'hero' );
 
	endwhile;
endif;

// We only need to reset the $post variable. If we overwrote $wp_query,
// we'd need to use wp_reset_query() which does both.
wp_reset_postdata();

?>

<div class="column row">
    
    <div id="primary" class="content-area">
    
        <main id="main" class="site-main" role="main">
            <?php
             
            if ( have_posts() ) : ?>
            
                <header class="page-header">
                    <h1 class="page-title"><?php /* translators: the term(s) searched */ printf( esc_html__( 'Search Results for: %s', '_s' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                </header><!-- .page-header -->
    
               <?php
                while ( have_posts() ) :
    
                    the_post();
    
                    get_template_part( 'template-parts/content', 'search' );
    
                endwhile;
                
                $previous = sprintf( '%s<span class="screen-reader-text">%s</span>', 
                                     get_svg( 'arrow' ), __( 'Previous Post', '_s') );
                
                $next = sprintf( '%s<span class="screen-reader-text">%s</span>', 
                                     get_svg( 'arrow' ), __( 'Next Post', '_s') );
                
                the_posts_navigation( array( 'prev_text' => $previous, 'next_text' => $next ) );
                
            else :
    
                get_template_part( 'template-parts/content', 'none' );
    
            endif; ?>
    
        </main>
    
    </div>

</div>

<?php
get_footer();
