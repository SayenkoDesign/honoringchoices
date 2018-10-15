<?php

// Foundation Accordion


class Foundation_Grid extends Foundation {
    
    /**
	 * Holds settings defaults, populated in constructor.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $defaults;
    
    
    /**
	 * Holds settings
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $settings;
    
    
    private $grid_items = array();
    
    
    public function __construct( $settings = array() ) {
        parent::__construct();
        
        $this->defaults = array(
            'image_size' => 'large',
            'title_position' => 'after',
            'title_tag' => 'h3',
            'description_tag' => 'p',
            'class' => 'row small-up-1 large-up-3 grid align-center',
            'format' => 'item', // item (has link/button)| block (entire item is clickable)
            'return' => 'string', //string|array
            'echo' => false
		);
        
        $this->settings = wp_parse_args( $settings, $this->defaults );
        
	}
    
    
    public function generate( $rows ) 
    {
        if( empty( $rows ) ) {
            return false;
        }
        
        extract( $this->settings );
        
        // Let's cache the media
        foreach ($rows as $row) {
            if( isset( $row['grid_image'] ) && !empty( $row['grid_image'] ) )
            $ids[] = $row['grid_image'];
        }
        
        if( !empty( $ids ) ) {
            $cache = get_posts(array('post_type' => 'attachment', 'numberposts' => -1, 'post__in' => $ids));
        }
        
        $grid = '';
        
        $grid_items = array();
                
        foreach( $rows as $row ) {
                    
            $image = isset(  $row['grid_image'] ) ? $row['grid_image']: '';
                    
            if( $image ) {
                
                if( wp_is_mobile() ) {
                    $image_size = 'thumbnail';
                }
                
                $image = sprintf( '<div class="thumbnail">%s</div>', wp_get_attachment_image( $image, $image_size ) );
            }
            
            $title = !empty(  $row['grid_title'] ) ? sprintf( '<%1$s>%2$s</%1$s>', $title_tag, $row['grid_title'] ) : '';
            $title_before = $title_after = $title;
            if( $title_position == 'before' ) {
                $title_after = '';
            } else {
                $title_before = '';
            }
            
            $description = isset(  $row['grid_description'] ) ? sprintf( '<%1$s>%2$s</%1$s>', $description_tag, $row['grid_description'] ): '';
            
            $button      = isset(  $row['grid_button'] ) ? $row['grid_button']: '';
            
            $anchor_open = '<div class="panel">';
            $anchor_close = '</div>';
            
            if( !empty( $button ) ) {
                
                if( 'block' == $format ) {
                      
                    if ( $button['link'] == 'Page' ) {
                        if ( ! empty( $button['page'] ) ) {
                            $url = $button['page'];
                        }
                    } 
                    else if( $button['link'] == 'Absolute URL' ) {
                        if ( ! empty( $button['url'] ) ) {
                            $url = $button['url'];
                        }
                    }
                    else {
                        $url = '';   
                    }
                    
                    if( !empty( $url ) ) {
                        $anchor_open = sprintf( '<a href="%s" class="panel">', $url );
                        $anchor_close = '</a>';
                        $button = sprintf( '<div><span class="more">%s</span></div>', $button['text'] );
                    }
                    else {
                        $button = '';   
                    }
                    
                }
                else {
                    $button = new Element_Button( [ 'fields' => [ 'button' => $button ] ] ); // set fields from Constructor
                    $button->add_render_attribute( 'wrapper', 'class', 'more' ); 
                    $button = $button->get_element();   
                }
            }
                                     
            $grid_items[] = sprintf( '<div class="column column-block">%s%s%s<div class="description" data-equalizer-watch>%s%s</div>%s%s</div>', 
                                     $anchor_open, $title_before, $image, $title_after, $description, $button, $anchor_close );
        }
        
        if( empty( $grid_items ) ) {
            return;   
        }
        
        if( 'array' == $return ) {
            return $grid_items;
        }
        
        $grid = sprintf( '<div class="%s" data-equalizer data-equalize-on="medium" data-equalize-by-row="true">%s</div>', $class, join( '', $grid_items ) );
        
        if( $echo ) {
            echo $grid;
        }
        
        return $grid;
        
    }
    
   
}