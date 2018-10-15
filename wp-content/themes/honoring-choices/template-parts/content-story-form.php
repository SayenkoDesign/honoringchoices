<?php
/**
 * Template part for displaying story form
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */
 
// check if we're on a single story
$is_single_story = is_singular( 'story' ) ? true: false;
?>

<div class="column row story-form" id="story-form">
    <div class="wrap">
    <?php
    $page_id = 239;
    
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
            
            if( ! $is_single_story ) {
                
                echo '<div class="entry-content">';
                the_content();
                echo '</div>';
            }
            
            $form_id = get_field( 'gravity_form' );
            
            $form = GFAPI::get_form( $form_id );
            
            if( false !== $form ) {
               echo do_shortcode(  sprintf( '[gravityform id="%s" title="true" description="true" ajax="true"]', $form_id ) );
            }
                                 
        endwhile;
    endif;
    
    // We only need to reset the $post variable. If we overwrote $wp_query,
    // we'd need to use wp_reset_query() which does both.
    wp_reset_postdata();

    ?>
   </div> 
</div>