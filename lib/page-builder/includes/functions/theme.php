<?php

if( !function_exists( 'get_logos' ) ) {
    function get_logos( $rows ) {
        
        if( empty( $rows ) ) {
            return false;
        }
        
        $logos = '';
               
        foreach( $rows as $row ) {
            $attachment_id = $row['image'];
            $url = $row['url'];
            $image = wp_get_attachment_image( $attachment_id, 'medium' );
            $tag = 'span';
            $href = '';
            if( !empty( $url ) ) {
                $tag = 'a';
                $href = sprintf( 'href="%s"', $url );
            }
            $logos .= sprintf( '<%1$s %2$s>%3$s</%1$s>', 
                                $tag, 
                                $href, 
                                $image );                
        }  
        
        return sprintf( '<div class="logos">%s</div>', $logos );    
    }
}
