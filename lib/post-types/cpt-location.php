<?php
 
/**
 * Create new CPT - Location
 */
 
class CPT_Location extends CPT_Core {

    const POST_TYPE = 'location';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Location', self::TEXTDOMAIN ), // Singular
				__( 'Locations', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array( 
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'post',
				'has_archive'         => true,
				'hierarchical'        => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'exclude_from_search' => false,
				'rewrite'             => array( 'slug' => 'locations' ),
				'supports' => array( 'title', 'revisions' ),
			)

        );
		
        add_action( 'pre_get_posts', array( $this,'pre_get_posts' ) );
		
     }
	 
     function pre_get_posts($query) {
						
		if ( $query->is_main_query() && is_post_type_archive( self::POST_TYPE ) && !is_admin() ) {
			            											
			$query->set('posts_per_page', '-1' );
		
		}
			
		return $query;
	}    
     
}

new CPT_Location();


$location_categories = array(
    __( 'Location Category', CPT_Location::TEXTDOMAIN ), // Singular
    __( 'Location Category', CPT_Location::TEXTDOMAIN ), // Plural
    'location_cat' // Registered name
);

register_via_taxonomy_core( $location_categories, 
	array(
		'public' => false,
        // 'rewrite' => 'story-category',
	), 
	array( CPT_Location::POST_TYPE ) 
);
