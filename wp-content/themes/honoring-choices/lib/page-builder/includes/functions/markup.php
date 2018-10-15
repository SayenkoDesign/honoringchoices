<?php

/**
 * Output markup conditionally.
 *
 * Supported keys for `$args` are:
 *
 *  - `html5` (`sprintf()` pattern markup),
 *  - `xhtml` (XHTML markup),
 *  - `context` (name of context),
 *  - `echo` (default is true).
 *
 *
 * @param array $args Array of arguments.
 *
 * @return string Markup.
 */
function _s_markup( $args = array( ) ) {

	$defaults = array(
		'html5'   => '',
		'xhtml'   => '',
		'context' => 'section',
		'open'    => '',
		'close'   => '',
		'content' => '',
		'attr'    => '',
		'echo'    => true,
	);

	$args = wp_parse_args( $args, $defaults );
	
	// Short circuit filter.
	$pre = apply_filters( "_s_markup_{$args['context']}", false, $args );
	if ( false !== $pre ) {

		if ( ! $args['echo'] ) {
			return $pre;
		}

		echo $pre;
		return;

	}

	if ( $args['html5'] || $args['xhtml'] ) {

		// If HTML5, return HTML5 tag. Maybe add attributes. Else XHTML.
		if ( current_theme_supports( 'html5' ) ) {
			$tag = $args['context'] ? sprintf( $args['html5'], _s_attr( $args['context'], $args['attr'] ) ) : $args['html5'];
		} else {
			$tag = $args['xhtml'];
		}

		// Contextual filter.
		$tag = $args['context'] ? apply_filters( "_s_markup_{$args['context']}_output", $tag, $args ) : $tag;

		if ( ! $args['echo'] ) {
			return $tag;
		}

		echo $tag;
		return;

	}

	// Add attributes to open tag.
	if ( $args['context'] ) {

		$open = sprintf( $args['open'], _s_attr( $args['context'], $args['attr'] ) );
		$open = apply_filters( "_s_markup_{$args['context']}_open", $open, $args );
		$close = apply_filters( "_s_markup_{$args['context']}_close", $args['close'], $args );

	} else {

		$open = $args['open'];
		$close = $args['close'];

	}

	if ( $args['content'] || $open ) {
		$open = apply_filters( '_s_markup_open', $open, $args );
	}

	if ( $args['content'] || $close ) {
		$close = apply_filters( '_s_markup_close', $close, $args );
	}

	if ( $args['echo'] ) {
		echo $open . $args['content'] . $close;
	} else {
		return $open . $args['content'] . $close;
	}

}


/**
 * Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * The contextual filter is of the form `_s_attr_{context}`.
 *
 * @since 2.0.0
 *
 * @param  string $context    The context, to build filter name.
 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return array Merged and filtered attributes.
 */
function _s_parse_attr( $context, $attributes = array() ) {

    if( !empty( $context ) ) {
        $defaults = array(
            'class' => sanitize_html_class( $context ),
        );
    
        $attributes = wp_parse_args( $attributes, $defaults );
    }
    
    //* Contextual filter
    return apply_filters( "_s_attr_{$context}", $attributes, $context );

}

/**
 * Build list of attributes into a string and apply contextual filter on string.
 *
 * The contextual filter is of the form `_s_attr_{context}_output`.
 *
 * @since 2.0.0
 *
 * @uses _s_parse_attr() Merge array of attributes with defaults, and apply contextual filter on array.
 *
 * @param  string $context    The context, to build filter name.
 * @param  array  $attributes Optional. Extra attributes to merge with defaults.
 *
 * @return string String of HTML attributes and values.
 */
function _s_attr( $context, $attributes = array() ) {

    $attributes = _s_parse_attr( $context, $attributes );

    $output = '';

    //* Cycle through attributes, build tag attribute string
    foreach ( $attributes as $key => $value ) {

		if ( ! $value ) {
			continue;
		}

		if ( true === $value ) {
			$output .= esc_html( $key ) . ' ';
		} else {
			$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );
		}

    }

    $output = apply_filters( "_s_attr_{$context}_output", $output, $attributes, $context );

    return trim( $output );

}


/**
 * Potentially echo or return a structural wrap div.
 *
 * A check is made to see if the `$context` is in the `_s-structural-wraps` theme support data. If so, then the
 * `$output` may be echoed or returned.
 *
 * @since 1.6.0
 *
 * @param string $context The location ID.
 * @param string $output  Optional. The markup to include. Can also be 'open'
 *                        (default) or 'closed' to use pre-determined markup for consistency.
 * @param boolean $echo   Optional. Whether to echo or return. Default is true (echo).
 *
 * @return string Wrap HTML.
 */
function _s_structural_wrap( $output = 'open', $echo = true ) {
	
	$context = 'wrap';
	
	switch ( $output ) {
		case 'open':
			$output = sprintf( '<div %s>', _s_attr( $context ) );
			break;
		case 'close':
			$output = '</div>';
			break;
	}


	if ( $echo )
		echo $output;
	else
		return $output;

}


function parse_attributes( $val, $divider = ':', $sep = '; ' ) {
	if( is_array( $val ) ) {
		$t = array();
		foreach( $val as $k => $v ) {
			if( !empty( $v ) ) {
				$t[] = sprintf('%s%s%s', $k, $divider, $v);
			}
		}
		
		return implode( $sep, $t );
	}
	else {
		return $val;	
	}
}