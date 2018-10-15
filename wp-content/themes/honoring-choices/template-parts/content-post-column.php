<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */

$even = ( $post_count % 2 == 0 ) ? true : false;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php     
           
    $post_image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
    if( !empty( $post_image ) ) {
        $post_image = sprintf( 'background-image: url(%s);', $post_image );
    }     
    
    $post_date = _s_get_posted_on();
       
    $post_title = sprintf( '<h2><a href="%s">%s</a></h2>', get_permalink(), get_the_title() );
    
    $even = ( $post_count % 2 == 0 ) ? true : false;
    
    $read_more = '';
    
    if( $full_width ) {
        echo '<div class="row">';
        
        $read_more = sprintf( '<p class="read-more"><a href="%s" class="more">%s</a></p>', get_permalink(), __( 'Read More', '_s' ) ) ;
    }
    
    $column = $full_width ? ' small-12 large-6 column' : '';
    
    $post_hero_class = $full_width && $even ? ' small-order-1 large-order-2' : ' small-order-1 large-order-1';
    
    $header_class    = $full_width  && $even ? ' small-order-1 large-order-1' : ' small-order-1 large-order-2';
    
    printf( '<div class="%s%s"><div class="post-hero" style="%s"></div></div>', $column, $post_hero_class, $post_image );
                	
    printf( '<header class="entry-header%s%s">%s%s%s</header>', $column, $header_class, $post_date, $post_title, $read_more );
        
    if( $full_width ) {
                
        echo '</div>';
    }
    ?>
    
</article><!-- #post-## -->
