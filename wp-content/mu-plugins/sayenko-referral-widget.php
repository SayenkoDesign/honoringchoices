<?php
/**
 * Plugin Name: Sayenko Referral Widget
 * Description: Creates a dashboard referral widget
 * Version:     1.0
 * Author:      Sayenko Design
 * Author URI:  http://www.sayenkodesign.com
 * License:     MIT
 * License URI: http://www.opensource.org/licenses/mit-license.php
 */


/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function example_add_dashboard_widgets() {
	
	// use add meta box so we can choose position
	add_meta_box(
	 'example_dashboard_widget', // Widget slug.
	 'RECEIVE $500 in CASH FOR A WEBSITE REFERRAL!!', // Title.
	 'example_dashboard_widget_function', // Display function.
	 'dashboard', 'normal', 'high'
	 );	
	 
 }
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );


/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function example_dashboard_widget_function() {
	
	$url = 'http://www.sayenkodesign.com';
	$email = 'mike@sayenkodesign.com';
	$img = 'http://www.sayenkodesign.com/wp-content/uploads/2014/08/Sayenko-Design-WP-Referral-Bonus-460.jpg';
	$img_alt = 'Seattle Web Design';
	$cta = sprintf( '<p>Simply introduce us via email along with the prospects phone number. Email introductions can be sent to <a href="mailto:%1$s">%1$s</a></p>', $email );
	
	printf( '<div class="sayenko-referral-widget"><a href="%s" target="_blank"><img alt="%s" src="%s"></a>%s</div>', $url, $img_alt, $img, $cta );
} 

/**
 * Add custom widget styles to admin
 */
add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    .sayenko-referral-widget {
      
    } 
	.sayenko-referral-widget img {
      	margin-bottom: 10px;
		max-width: 100%;
    } 
	
	.sayenko-referral-widget p {
      
    } 
  </style>';
}
?>