<?php

// Foundation Accordion


class Foundation_Accordion extends Foundation {
    
    var $accordion_items;
    
    public function __construct( $settings = array() ) {
        parent::__construct();
        
        $defaults = array(
            'class' => 'accordion',
            'data' => array( 'data-accordion' => 'true',  'data-multi-expand' => 'true', 'data-allow-all-closed' => 'true' )            
        );

        $args = wp_parse_args( $settings, $defaults );
        
        $args['data'] = $this->parse_attr( $args['data'] );
        
        $this->settings = $args;
	}
    
    
    public function add_item( $title = '', $content = '', $active = false, $attr = array() ) {
		$this->accordion_items[] = array( 'title' => $title, 'content' => $content, 'active' => $active, 'attr' => $attr );
	}


	public function get_accordion( $items = '' ) {

		$accordion_content = '';
         
        if ( empty( $items ) ) {
			$items = $this->accordion_items;
		}

		if ( empty( $items ) ) {
			return false;
		}

		foreach ( $items as $item ) {

			$title   = $item['title'];
			$content = $item['content'];
            $accordion_title_classes = '';
            
            if( !empty( $item['attr'] ) && isset( $item['attr']['accordion_title_classes'] ) ) {
                $accordion_title_classes = $item['attr']['accordion_title_classes'];
            }
                        
			$active  = $item['active'];

			if ( ! empty( $title ) && ! empty( $content ) ) {
				$accordion_title   = sprintf( '<a href="#" class="accordion-title"><h4>%s</h4></a>', $title );
				$is_active         = ( true == $active ) ? ' is-active' : '';
				$accordion_content .= sprintf( '<li class="accordion-item %s%s" data-accordion-item>%s
                <div class="accordion-content" data-tab-content>%s</div></li>', 
                $accordion_title_classes, $is_active, $accordion_title, $content );
			}
		}

		return sprintf( '<ul class="%s" %s>%s</ul>',
			$this->settings['class'], 
            $this->settings['data'],
            $accordion_content );

	}
}