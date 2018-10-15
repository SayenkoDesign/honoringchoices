<?php

class Single_location {
 
    public $location_data = [];
    public $fields = [];
    public $icon_folder = '';
        
    public function __construct() {
		        
        $this->init();
	}
    
    private function get_theme_icon( $name ) {
        return sprintf( '<span class="location-icon"><img src="%s%s.svg" /></span>', $this->icon_folder, $name );
    }
    
    private function init() {
        
        
        $this->defaults = array(
            'address' => '', 
            'contact_name' => '', 
            'contact_position' => '', 
            'phone' => '', 
            'website' => '', 
            'email' => '', 
            'map_marker' => ''
        );
        
		$this->fields = apply_filters( 'single_location_fields', $this->defaults );
        
        $this->icon_folder = apply_filters( 'single_location_icon_folder', sprintf( '%sicons/', trailingslashit( THEME_IMG ) ) );
        
     
        $data = [];
        
        foreach( $this->fields as $key => $field ) {
            
            $field = get_field( $key );
            
            if( !empty( $field ) ) {
                                
                if( 'map_marker' == $key ) {
                    $data['lat'] = $field['lat']; 
                    $data['lng'] = $field['lng']; 
                    $url = wp_is_mobile() ? 'place' : 'dir';
                    $data['directions'] = sprintf( 'https://www.google.com/maps/%s/%s', $url, urlencode( $field['address'] ) );
                }
                else {
                    $data[$key] = $field;   
                }
            }
        }
        
        $this->data = $data;
        
    }
    
    
    public function get_field( $field = '' ) {
        if( empty( $field ) ) {
            return '';
        }
        
        $method = sprintf( 'get_%s', $field );
        
        if( ! method_exists( $this, $method ) ) {
            wp_die( __( 'Method does not exist in Class Single_Location ', '_s' ) );
        }
                
        if( empty( $this->data[$field] ) ) {
            return false;
        }
        
        return call_user_func_array( array( $this, $method ), [$field] );
        
    }
    
    
    public function get_address( $key ) {
        return sprintf( '<div class="address">%s<span>%s</span></div>', 
                            $this->get_theme_icon( 'address' ), 
                            nl2br( $this->data[$key] ) );
    }
    
    
    public function get_phone( $key ) {
        return sprintf( '<div class="phone">%s<span><a href="%s">%s</a></span></div>', 
                        $this->get_theme_icon( 'phone' ), 
                        $this->maybe_format_telephone_url( $this->data[$key] ), 
                        $this->data[$key] );
    }
    
    
    public function get_website( $key ) {
        return sprintf( '<div class="website">%s<span><a href="%s">Website</a></span></div>', 
                        $this->get_theme_icon( 'website' ), 
                        $this->maybe_add_http( $this->data[$key] ) );
    }
    
    
    public function get_email( $key ) {
        return sprintf( '<div class="email">%s<span><a href="%s">%s</a></span></div>', 
                        $this->get_theme_icon( 'email' ), 
                        $this->maybe_format_email_url( $this->data[$key] ), 
                        antispambot( $this->data[$key] ) );
    }
    
    
    function get_events( $event_category = false ) {
                
        if( empty( $event_category ) ) {
            return false;
        }
        
        $event_categories = wp_list_pluck( $event_category, 'slug' );
                
        $posts = [];
        
        $events = tribe_get_events( array(
           'eventDisplay' => 'list',
           'posts_per_page' => 10,
           //'tribe_events_cat' => implode( ', ', $event_categories )
           'tax_query' => array(
                    array(
                        'taxonomy' => 'tribe_events_cat',
                        'field' => 'slug',
                        'terms' => $event_categories
                    )
                )
           ) 
        );
                    
        // The result set may be empty
        if ( empty( $events ) ) {
           //return false;
        }
        
        foreach( $events as $event ) {
            $posts[] = $this->get_single_event( $event );                            
        } 
        
        wp_reset_postdata();
        
        $posts = sprintf( '<div class="row small-up-1 large-up-2">%s</div>', implode( '', $posts ) );
        
        return sprintf( '<div class="events"><h3>Upcoming Events</h3>%s</div>', $posts );
        
    }
    
    
    private function get_single_event( $event ) {
            
        setup_postdata( $event );
        
        $link = esc_url( tribe_get_event_link( $event ) );
        
        $full_date = sprintf( '<span class="event-date">%s</span>', tribe_get_start_date( $event, false, 'F j, Y g:iA' ) );
        
        $venue = sprintf( '<span class="event-venue">%s</span>', strip_tags( tribe_get_venue( $event ) ) );
        
        // time
        $time = sprintf( '<span class="event-time">%s</span>', tribe_get_start_time( $event, 'g:iA' ) );
        
        // Price - custom field
        $price = get_field( 'event_price', $event );
        if( !empty( $price ) ) {
            $price = sprintf( '<span class="event-price">%s</span>', $price );
        }
        
        $time_price = sprintf( '<span class="event-time-price">%s%s</span>', $time, $price );
        
        $event_meta = sprintf( '<p>%s%s</p>', $full_date, $venue );
        
        $custom_link_text = get_field( 'custom_link_text', $event );
        
        $permalink = sprintf( '<a href="%s" class="more">%s</a>', $link, $custom_link_text ? $custom_link_text : 'more info' );
       
        return sprintf( '<div class="column column-block event"><div class="event-details"><header><a href="%s"><h4>%s</h4></a></header>%s%s</div></div>', 
                        $link,
                        get_the_title( $event ),
                        $event_meta,
                        $permalink                
        
        );
    }
    
    
    
    private function maybe_format_email_url( $email ) {
        if ( strpos( $email, 'mailto:' ) !== false ) {
            return $email;
        }
       
        return sprintf( 'mailto:%s', antispambot( $email ) ); 
    } 
    
    
    private function maybe_format_telephone_url( $number ) {
        if ( strpos( $number, 'tel:' ) !== false ) {
            return $number;
        }
        
        return sprintf( 'tel:%s', preg_replace( '/[^0-9]/','', $number ) );       
    } 
    
    
    private function maybe_add_http( $url, $ssl = false ) {
        $scheme = $ssl ? 's' : '';    
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = sprintf( 'http%s://%s', $scheme, $url );
        }
        
        return $url;
    }
    
}

/*
function single_location_load_value( $value, $post_id, $field )
{
    if( 'location' != get_post_type( $post_id ) ) {
        return $value;
    }

    if( 'contact_position' == $field['name'] ) {
        $value = sprintf( '<div class="position">%s</div>', $value );
    }
    
    return $value;
}

// acf/load_value - filter for every value load
add_filter('acf/load_value', 'single_location_load_value', 10, 3);

function filter_get_post_meta($metadata, $object_id, $meta_key, $single){

    // Here is the catch, add additional controls if needed (post_type, etc)
    $meta_needed = 'fields_titles';
    if ( isset( $meta_key ) && $meta_needed == $meta_key ){
        remove_filter( 'get_post_metadata', 'getqtlangcustomfieldvalue', 100 );
        $current_meta = get_post_meta( $object_id, $meta_needed, TRUE );
        add_filter('get_post_metadata', 'getqtlangcustomfieldvalue', 100, 4);

        // Do what you need to with the meta value - translate, append, etc
        // $current_meta = qtlangcustomfieldvalue_translate( $current_meta );
        // $current_meta .= ' Appended text';
        return $current_meta;
    }

    // Return original if the check does not pass
    return $metadata;

}

add_filter( 'get_post_metadata', 'getqtlangcustomfieldvalue', 100, 4 );
*/


// Are we using a custom url?
add_filter( 'post_type_link', function( $url, $post, $leavename=false ) {
    if ( is_archive( 'location' ) && $post->post_type == 'location' ) {
		$custom_link_url = get_field( 'custom_link_url' );
        if( ! empty( $custom_link_url ) ) {
            $url = $custom_link_url;
        }
	}
	return $url;
}, 10, 3 );


// If we have a custom url, we skip the single location page
add_action( 'template_redirect', function() {
    global $post;
    if ( is_singular( 'location' ) ) {
		$custom_link_url = get_field( 'custom_link_url' );
        if( ! empty( $custom_link_url ) ) {
            wp_redirect( $custom_link_url );
            die;
        }
	}
});



function _s_get_location_term_object() {
    $taxonomy = 'locaiton_category';
    $terms = wp_get_post_terms( get_the_ID(), $taxonomy );
    if( !is_wp_error( $terms ) ) {
        return array_pop($terms);
    }
    return false;
}