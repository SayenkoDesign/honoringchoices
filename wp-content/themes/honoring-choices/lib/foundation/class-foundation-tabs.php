<?php

// Foundation Tabs

/*

<li class="tabs-title is-active"><a href="#panel1v" aria-selected="true">Business Cards</a></li>

<div class="tabs-panel is-active" id="panel1v">
<div class="tabs-content" data-tabs-content="services-tabs">
*/


class Foundation_Tabs extends Foundation {
    
    var $titles;
    var $panels;
    var $tab_links;
    var $settings = array();
    static $tab_count;
    
    public function __construct( $settings = array() ) {
        parent::__construct();
        
        self::$tab_count++;
        
        $defaults = array(
            'class' => 'tabs',
            'data' => array( 'data-tabs' => 'true' ),
            'id' => sprintf( 'tabs-%s',  self::$tab_count )
        );

        $args = wp_parse_args( $settings, $defaults );
        
        $args['data'] = $this->parse_attr( $args['data'] );
        
        $this->settings = $args;
	}
    
    /**
	 * Add Tab
	 *
	 * Add title and panel
	 *
	 * @param	array : title(required)|content(required)|active|href(overide)|id
	 * @return	array
	 */
    public function add_tab( $args = array() ) {
                
        if( !is_array( $args ) ) {
            wp_die( __( 'It is required to pass an array of arguments: title, content, with optional href, active and id', 'foundation' ) );
        }
        
        if( ! isset( $args['title'] ) && ! isset( $args['content'] ) ) {
            wp_die( __( 'Tab title and content are required', 'foundation' ) );
        }
        
        $this->add_title( $args );
        $this->add_panel( $args );
	}
    
    
    private function add_title( $args = array() ) {
        
        if( !is_array( $args ) && ! isset( $args['title'] ) ) {
            wp_die( __( 'It is required to pass a title', 'foundation' ) );
        }
        
        $defaults = array(
            'title' => '',
            'active' => false
        );

        $args = wp_parse_args( $args, $defaults );
        
        $args['href'] = sprintf( '#%s', sanitize_title_with_dashes( $args['title'] ) );
        
        // Set active tab
        $args['active'] = true == $args['active'] ? 'is-active' : '';
        
        $this->titles[] = $args;
    }
    
    
    private function add_panel( $args = array() ) {
        
        $defaults = array(
            'content' => '',
        );

        $args = wp_parse_args( $args, $defaults );
        
        $args['id'] = sprintf( '%s', sanitize_title_with_dashes( $args['title'] ) );
        
        $this->panels[] = $args;
    }
    

	public function get_tabs( $args = array() ) {
        
        $titles = $this->titles;
        $panels = $this->panels;
         
        if( empty( $titles ) || empty( $panels ) ) {
            return;
        }

		if( count( $titles ) != count( $panels ) ) {
            return;
        }
               
        $out = '';
        // Generate tabs
		foreach ( $titles as $tab ) {

			$title  = $tab['title'];
			$href   = $tab['href'];
			$active = $tab['active'];

			$out .= sprintf( '<li class="tabs-title %s"><a href="%s">%s</a></li>', $active, $href, $title );
		}

		return  sprintf( '<ul class="%s" id="%s" %s>%s</ul>', $this->settings['class'], $this->settings['id'], $this->settings['data'], $out );

	}
    
    
    public function get_panels( $args = array() ) {

		$titles = $this->titles;
        $panels = $this->panels;
         
        if( empty( $titles ) || empty( $panels ) ) {
            return;
        }

		if( count( $titles ) != count( $panels ) ) {
            return;
        }
                 
        $out = '';
        
        foreach ( $panels as $panel ) {			

			$out .= sprintf( '<div class="tabs-panel" id="%s">%s</div>', $panel['id'], $panel['content'] );
		}
        
        $styles = isset( $this->settings['tabs_content']['styles'] ) ? $this->settings['tabs_content']['styles'] : '';

		return sprintf( '<div class="tabs-content" data-tabs-content="%s" %s>%s</div>', $this->settings['id'], $styles, $out );
        
	}
    
    
    public function clear() {
        // Clear any previous tabs
        $this->tabs = array();
        $this->tabs_content = array();
        $this->tabs_classes = array();
        $this->tabs_classes = array();
    }
    
    
    public function add_tab_link( $args = array() ) {   
        
        $defaults = array(
            'title' => '',
            'href' => false,
            'active' => false
        );

        $args = wp_parse_args( $args, $defaults );
                
        // Set active tab
        $args['active'] = true == $args['active'] ? 'aria-selected="true"' : '';
         
        $this->tab_links[] = $args;
	}
    
    
    public function get_tab_links() {
        
        $tab_links = $this->tab_links;
        
        var_dump( $tab_links );
        
        if( empty( $tab_links ) ) {
            return false;
        }
        
        $out = '';
        
        foreach ( $tab_links as $tab ) {

			$title  = $tab['title'];
			$href   = $tab['href'];
			$active = $tab['active'];

			$out .= sprintf( '<li class="tabs-title"><a href="%s" %s>%s</a></li>', $href, $active, $title );
		}
        
        return  sprintf( '<ul class="%s" id="%s">%s</ul>', $this->settings['class'], $this->settings['id'], $out ); 
    }
}