<?php
 
/**
 * Create new CPT - Team
 */
 
class CPT_Team extends CPT_Core {

    const POST_TYPE = 'team';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Team', self::TEXTDOMAIN ), // Singular
				__( 'Team', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array( 
				'public'              => false,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'post',
				'has_archive'         => false,
				'hierarchical'        => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => true,
				//'rewrite'             => array( 'slug' => 'teams' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			)

        );
		        
     }
 
}

new CPT_Team();

/*

$team_categories = array(
    __( 'Team Category', CPT_Team::TEXTDOMAIN ), // Singular
    __( 'Team Categories', CPT_Team::TEXTDOMAIN ), // Plural
    'team_cat' // Registered name
);

register_via_taxonomy_core( $team_categories, 
	array(
		//'public' => false,
        'rewrite' => false,
	), 
	array( CPT_Team::POST_TYPE ) 
);

*/