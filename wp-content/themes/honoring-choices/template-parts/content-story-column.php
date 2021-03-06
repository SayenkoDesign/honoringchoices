<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */
?>

<?php
$classes = 'clearfix';
$play = '';
$play_hover = '';
if( wds_check_if_content_contains_video() )
{
   $classes .= ' post-video';
   $play = sprintf( '<span class="play">%s</span>', get_svg( 'play' ) );
   $play_hover = sprintf( '<span class="play">%s</span>', get_svg( 'play-hover' ) );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	
	<?php 
         
    $tagline = get_field( 'thumbnail_tagline' );
    $tagline = _s_format_string( $tagline, 'h5', [ 'class' => 'tagline' ] );
              
    $post_title = the_title( '<h3>', '</h3>', false );
    
    $more = sprintf( '<span class="arrow">%s</span>', get_svg( 'arrow-right' ) );
    
    $custom_url = get_field( 'custom_link_url' );
    
    $link = ! empty( $custom_url ) ? $custom_url : get_permalink();

    $card = sprintf( '<a class="card" href="%s"><div class="center">%s%s%s</div>%s</a>%s', 
                      $link, $tagline, $post_title, $more, $play_hover, $play  );
                            
    $html = new Element_Html( [ 'fields' => [ 'html' => $card ] ]  ); 
    $html->add_render_attribute( 'wrapper', 'class', 'background-image' );
    
    $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
    
    $width = $image_src[1] > $image_src[2] ? 1 : 2;
    $width = $image_src[$width];
    $height = $width == 1 ? 2 : 1;
    $height = $image_src[$height];
        
    if( ! empty( $image_src ) ) {
        $background = $image_src[0];
        $width      = $image_src[1];
        $min_height = $height * (($width/$height)/100) . 'px';
                    
        $html->add_render_attribute( 'wrapper', 'style', sprintf( 'background-image: url(%s);', $background ) );
        $html->add_render_attribute( 'wrapper', 'style', sprintf( 'min-height: %s;', $min_height ) );
        $html->add_render_attribute( 'wrapper', 'style', sprintf( 'background-color: %s;', '#f5f5f5' ) );                                                                  
    }  
    
    echo $tagline;
    echo $html->get_element();
                    
	?>
		    
    
    
</article><!-- #post-## -->
