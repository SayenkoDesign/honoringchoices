<?php

// Custom content filters - we use this instead of "the_content"

add_filter( 'pb_the_content', 'wptexturize'        );
add_filter( 'pb_the_content', 'convert_chars'      );
add_filter( 'pb_the_content', 'wpautop'            );
add_filter( 'pb_the_content', 'shortcode_unautop'  );
add_filter( 'pb_the_content', 'do_shortcode'       );