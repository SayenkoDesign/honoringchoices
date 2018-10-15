<?php

// Accordions

function _s_create_accordion( $args = [], $content = '' ) {
    
    if( empty( $content ) ) {
        return;   
    }
    
    $matches = array();
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    $count = 0;
    
    foreach($dom->getElementsByTagName('h3') as $node) {
        $key = $dom->saveHtml($node);
        $matches[$count]['heading'] = strip_tags( $key );
        $temp = [];
        while(($node = $node->nextSibling) && $node->nodeName !== 'h3') {
            //if($node->nodeName == 'h3') {
                $temp[] = $dom->saveHtml($node);   
            //}
        }
        $matches[$count]['text'] = join( '', $temp );
        
        $count++;
    }
    
    $accordion = '';
        
    if( ! empty( $matches ) ) {
        foreach( $matches as $match ) {
            if( empty( $match['heading'] ) || empty( $match['text'] ) ) {
                continue;   
            }
            
            $item = sprintf( '<a href="#" class="accordion-title">%s</a>', $match['heading'] );
            
            $item .= sprintf( '<div class="accordion-content" data-tab-content>%s</div>', $match['text'] );
            
            $accordion .= sprintf( '<li class="accordion-item" data-accordion-item>%s</li>', $item );
        }
        
        return sprintf( '<ul class="accordion" data-accordion data-allow-all-closed="true">%s</ul>', $accordion );
    }
}

add_shortcode( 'accordion', '_s_create_accordion' );