<?php

add_action( 'wp_enqueue_scripts', '_s_load_store_locator_scripts' );
function _s_load_store_locator_scripts() {
    
    $store_locator_dir = sprintf( '%slib/plugins/store-locator', trailingslashit( THEME_URL ) );
    
    $store_locator_js = sprintf( '%sdist/assets/js/plugins/storeLocator/jquery.storelocator.js', trailingslashit( $store_locator_dir ) );
    $store_locator_hb = sprintf( '%sdist/assets/js/libs/handlebars.min.js', trailingslashit( $store_locator_dir ) );
    $store_locator_css = sprintf( '%sdist/assets/css/storelocator.css', trailingslashit( $store_locator_dir ) );
    
    
    $gmaps_api = add_query_arg('key', GOOGLE_API_KEY, '//maps.google.com/maps/api/js' );
    wp_register_script( 'gmaps-api', $gmaps_api, array(), '', true );
    
    wp_register_script( 'handlebars', $store_locator_hb, array(), '', true );
    
    wp_register_script( 'store-locator', $store_locator_js, array('jquery', 'handlebars', 'gmaps-api' ), '', true );
    
    wp_register_style( 'store-locator', $store_locator_css );
    
    
    
    if( is_post_type_archive( 'location' ) ) {
        wp_enqueue_script( 'store-locator');
        wp_enqueue_style( 'store-locator' );
    }
}

