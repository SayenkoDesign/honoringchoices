<?php
$content = '<h3>This is a heading</h3><p>content</p><ul><li>list item</li></ul><h3>This is a second heading</h3><p>content</p><h3>This is a third heading</h3><p>content</p>';
//preg_match_all('/<h3[^>]*>([\s\S]*?)<\/h3[^>]*>/', $content, $matches );
//$text = preg_replace('/<h3[^>]*>([\s\S]*?)<\/h3[^>]*>/', '', $content );

$matches = array();
$dom = new DOMDocument;
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

print_r( $matches );

/*
$output = '';

if( ! empty( $matches ) ) {
    foreach( $matches as $match ) {
        if( ! empty( $match['heading'] ) ) {
            $output .= sprintf( '<a href="#" class="accordion-title">%s</a>',  );
        }
    }
}
*/