<?php
/**
 * _s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _s_setup() {
		
		/****************************************
		Define Child Theme Definitions
		*****************************************/
		define( 'THEME_DIR', get_template_directory() );
		define( 'THEME_URL', get_template_directory_uri() );
		define( 'THEME_LANG', THEME_URL . '/languages' );
		define( 'THEME_FAVICONS', THEME_URL . '/favicons' );
		define( 'THEME_ASSETS', THEME_URL . '/assets' );
		define( 'THEME_LIB', THEME_URL . '/lib' );
		define( 'THEME_CSS', THEME_ASSETS . '/css' );
		define( 'THEME_IMG', THEME_ASSETS . '/images' );
		define( 'THEME_JS', THEME_ASSETS . '/scripts' );
 		
		define( 'THEME_NAME', sanitize_title( wp_get_theme() ) );
		define( 'THEME_VERSION', '1.0' );	
		
    	define( 'GOOGLE_API_KEY', 'AIzaSyDAkLMe2GIfgDbjsvT7fID-P7RUD9I0K0o' );	

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files.
		 * You will also need to update the Gulpfile with the new text domain
		 * and matching destination POT file.
		 */
		load_theme_textdomain( '_s', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', '_s' ),
            'footer' => esc_html__( 'Footer Menu', '_s' )
		) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );		
        
               
		
		/****************************************
		Theme Library
		*****************************************/
		
		include( THEME_DIR . '/lib/init.php' );

	}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 1200 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {

	// Define sidebars.
	$sidebars = array(
        'header'            => esc_html__( 'Header', '_s' ),
 		'footer-1'          => esc_html__( 'Footer 1', '_s' ),
        'footer-2'          => esc_html__( 'Footer 2', '_s' ),
	);  

	// Loop through each sidebar and register.
	foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
		register_sidebar( array(
			'name'          => $sidebar_name,
			'id'            => $sidebar_id,
			'description'   => sprintf( esc_html__( 'Widget area for %s', '_s' ), $sidebar_name ),
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}

}
add_action( 'widgets_init', '_s_widgets_init' );


// Login Styles
function _s_login_stylesheet() {
    wp_enqueue_style( 'custom-login', trailingslashit( THEME_CSS ) . '/login.css' );
}
add_action( 'login_enqueue_scripts', '_s_login_stylesheet' );

// changing the login logo
function _s_login_logo() {
	$logo = sprintf('%slogo.png', trailingslashit( THEME_IMG ) );
	printf( '<style type="text/css">h1 a { background-image:url(%s)!important; }</style>', $logo );
}
add_action('login_head', '_s_login_logo');



/**
 * Apply theme's stylesheet to the visual editor.
 *
 * @uses add_editor_style() Links a stylesheet to visual editor
 * @uses get_stylesheet_uri() Returns URI of theme stylesheet
 */
function _s_add_editor_styles() {
    add_editor_style( trailingslashit( THEME_CSS ) . 'editor.css' );
}
add_action( 'init', '_s_add_editor_styles' );