<?php


function _s_load_google_fonts() {

	// change array as needed
	$font_families = array(
            'Lato',
			'Open+Sans'
		);

	// do not touch below here:

	$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext,cyrillic,cyrillic-ext',
		);

	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	if( !empty( $font_families ) ) {
		wp_enqueue_style( 'google-fonts', $fonts_url, array(), THEME_VERSION );
	}


}

add_action( 'wp_enqueue_scripts', '_s_load_google_fonts' );