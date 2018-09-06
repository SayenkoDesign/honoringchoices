<?php

function disable_team_link() {
    
    global $post;
    
    $disable_link = get_field( 'disable_link' );
    
    if( $disable_link ) {
        wp_redirect( get_permalink( 10 ) );
        exit;
    }

}
add_action( 'template_redirect', 'disable_team_link' );



function _s_get_team_author() {
    
    $post_id = get_field( 'team_bio' );
        
    $title          = get_the_title( $post_id );
    $permalink      = get_permalink( $post_id );
    $thumbnail      = get_the_post_thumbnail( $post_id, 'post-author' );
        
    if( ! empty( $title ) && ! empty( $thumbnail ) ) {
         return sprintf( '<div class="post-author"><a href="%s">%s<h4>%s</h4></a></div>',$permalink, $thumbnail, $title );
    }
    
    return '';
        
}