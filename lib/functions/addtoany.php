<?php

add_action( 'wp_enqueue_scripts', 'load_addtoany_scripts', 15 );
function load_addtoany_scripts() {
		wp_register_script( 'addtoany', '//static.addtoany.com/menu/page.js', FALSE, NULL, TRUE );
 		//wp_register_script( 'addtoany-config', THEME_JS . '/addtoany-config.js', array('addtoany'), NULL, TRUE );
 		
		if( is_singular( 'post' ) ) {
 			wp_enqueue_script( 'addtoany' );
 		}
}

function addtoany_share( $label = 'Share' ) {
	return sprintf( '<span class="social-share">
					<a class="a2a_dd" href="https://www.addtoany.com/share">%s &nbsp;&nbsp;<i class="ion-icons ion-android-share-alt"></i></a></span>', $label );
	
}

// Social icons used in header/footer
function _s_get_addtoany_share_icons( $url = '', $title = '' ) {
	
	global $post;
	
	$socials = array(
			'facebook'     => 'facebook',
			'twitter'      => 'twitter',
            'pinterest'    => 'pinterest',
            'linkedin'     => 'linkedin',
            'google_plus'  => 'google_plus'
 	);
	
	
	$anchor_class = 'a2a_button_'; // a2a_button_
	
	$list = '';
	
	
	
	foreach( $socials as $network => $icon ) {
		
		$svg = get_svg( $icon );
		
		$list .= sprintf('<li class="%1$s"><a class="%2$s%1$s">%3$s<span class="screen-reader-text">%1$s</span></a></li>', $network, $anchor_class, $svg );	
		
	}
			
	return sprintf( '<ul class="share-icons a2a_kit clearfix" data-a2a-url="%s" data-a2a-title="%s">%s</ul>', $url, $title, $list );
}



function _s_get_addtoany_share_email( $url = '', $title = '' ) {
	
	global $post;
		
	$icon = 'share';
	
	$share = sprintf('<a class="share a2a_button_email"><i class="icon icon-share" aria-hidden="true"></i><span>Email this listing</span></a></li>', $icon );	
	
		
	return sprintf( '<div class="a2a_kit clearfix" data-a2a-url="%s" data-a2a-title="%s">%s</div>', $url, $title, $share );
}


