<?php
 
/**
 * Create new CPT - Story
 */
 
class CPT_Story extends CPT_Core {

    const POST_TYPE = 'story';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Story', self::TEXTDOMAIN ), // Singular
				__( 'Stories', self::TEXTDOMAIN ), // Plural
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
				'show_in_nav_menus'   => false,
				'exclude_from_search' => false,
				'rewrite'             => array( 'slug' => 'stories' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
			)

        );
		        
     }
 
}

new CPT_Story();


$story_categories = array(
    __( 'Story Category', CPT_Story::TEXTDOMAIN ), // Singular
    __( 'Story Categories', CPT_Story::TEXTDOMAIN ), // Plural
    'story_cat' // Registered name
);

register_via_taxonomy_core( $story_categories, 
	array(
		//'public' => false,
        'rewrite' => 'story-category',
	), 
	array( CPT_Story::POST_TYPE ) 
);

