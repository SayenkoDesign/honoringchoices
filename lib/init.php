<?php

/****************************************
	WordPress Cleanup functions - work in progress
*****************************************/
	include_once( 'wp-cleanup.php' );


/****************************************
	Theme Settings - load main stylesheet, add body classes
*****************************************/
	include_once( 'theme-settings.php' );



/****************************************
	include_onces (libraries, Classes etc)
*****************************************/
	include_once( 'includes/cpt-core/CPT_Core.php' );

	include_once( 'includes/taxonomy-core/Taxonomy_Core.php' );
    
    include_once( 'includes/table-class.php' );
    
    include_once( 'includes/theme-functions/array.php' );

    include_once( 'includes/theme-functions/shortcodes.php' );

/****************************************
	Functions
*****************************************/

    include_once( 'functions/svg.php' );

	include_once( 'functions/theme.php' );

	include_once( 'functions/template-tags.php' );

	include_once( 'functions/acf.php' );

	include_once( 'functions/fonts.php' );

	include_once( 'functions/scripts.php' );

	include_once( 'functions/social.php' );
    
    include_once( 'functions/members.php' );

	include_once( 'functions/menus.php' );
    
    include_once( 'functions/store-locator.php' );
    
    include_once( 'functions/blog.php' );
    
    include_once( 'functions/facetwp.php' );
    
	include_once( 'functions/gravity-forms.php' );

	// include_once( 'functions/widgets.php' );

    include_once( 'functions/addtoany.php' );
    
    include_once( 'functions/locations.php' );
    
    include_once( 'functions/the-events-calendar.php' );
    
    include_once( 'functions/bbpress.php' );
    
    include_once( 'functions/learndash.php' );
    
    include_once( 'functions/user-profile.php' );
    
    include_once( 'functions/shortcodes.php' );
    
/****************************************
	include_onces (Foundation)
*****************************************/

include_once( 'foundation/class-foundation.php' );
include_once( 'foundation/class-foundation-accordion.php' );
include_once( 'foundation/class-foundation-tabs.php' );
include_once( 'foundation/class-foundation-grid.php' );

/****************************************
	Page Builder
*****************************************/

    include_once( 'page-builder/init.php' );

/****************************************
	Post Types
*****************************************/
    include_once( 'post-types/cpt-location.php' );
    include_once( 'post-types/cpt-story.php' );
    include_once( 'post-types/cpt-testimonial.php' );    
    include_once( 'post-types/cpt-staff.php' ); 
    include_once( 'post-types/cpt-advisory-board.php' ); 
    
/****************************************
	Widgets
*****************************************/

    include_once( 'widgets/widget-social.php' );