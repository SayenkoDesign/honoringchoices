<?php

// Run the facet index on save_post

/* Register a hook to fire only when the "my-cpt-slug" post type is saved */
add_action( 'save_post_my-cpt-slug', 'myplugin_save_postdata', 10, 3 );

/* When a specific post type's post is saved, saves our custom data
 * @param int     $post_ID Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an existing post being updated or not.
*/
function myplugin_save_postdata( $post_id, $post, $update ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
      
  if( ! class_exists( 'FWP' ) ) {
      return;
  }

  FWP()->indexer->index();
  
}

function my_facetwp_pager_html( $output, $params ) {
    $output = '<ul>';
    $page = (int) $params['page'];
    $total_pages = (int) $params['total_pages'];
 
    // Only show pagination when > 1 page
    if ( 1 < $total_pages ) {
 
        if ( 1 < $page ) {
            $output .= '<li><a class="facetwp-page" data-page="' . ( $page - 1 ) . '">&laquo; Previous Page</a></li>';
        }
        else {
             $output .= '<li><span>&laquo; Previous Page</span></li>';
        }
        
        if ( 3 < $page ) {
            $output .= '<li><a class="facetwp-page first-page" data-page="1">1</a></li>';
            $output .= ' <span class="dots">…</span> ';
        }
        for ( $i = 2; $i > 0; $i-- ) {
            if ( 0 < ( $page - $i ) ) {
                $output .= '<li><a class="facetwp-page" data-page="' . ($page - $i) . '">' . ($page - $i) . '</a></li>';
            }
        }
 
        // Current page
        $output .= '<li class="active" aria-label="Current page"><a class="facetwp-page active" data-page="' . $page . '">' . $page . '</a></li>';
 
        for ( $i = 1; $i <= 2; $i++ ) {
            if ( $total_pages >= ( $page + $i ) ) {
                $output .= '<li><a class="facetwp-page" data-page="' . ($page + $i) . '">' . ($page + $i) . '</a></li>';
            }
        }
        if ( $total_pages > ( $page + 2 ) ) {
            $output .= ' <span class="dots">…</span> ';
            $output .= '<li><a class="facetwp-page last-page" data-page="' . $total_pages . '">' . $total_pages . '</a></li>';
        }
        
        if ( $page < $total_pages ) {
            $output .= '<li><a class="facetwp-page" data-page="' . ( $page + 1 ) . '">Next Page &raquo;</a></li>';
        }
        else {
             $output .= '<li><span>Next Page &raquo;</span></li>';
        }
    }
 
    $output .= '</ul>';
 
    return $output;
}

add_filter( 'facetwp_pager_html', 'my_facetwp_pager_html', 10, 2 );