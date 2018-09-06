<?php

/*
Section - WYSIWYG
		
*/

if( ! function_exists( 'section_wysiwyg' ) ) {
 
    function section_wysiwyg() {
                
        $output = '';
              
        $prefix = 'wysiwyg';
        $prefix = set_field_prefix( $prefix );
        
        $fields = get_sub_field( sprintf( '%ssection', $prefix ) );
        
        $settings = get_sub_field( sprintf( '%ssettings', $prefix ) );
        
        // Markup attributes              
        $attributes = new Markup_Attributes( $settings );
        $attributes->set( 'class', 'section-wysiwyg' );
        $attr = $attributes->get();
                      
        $heading 		        = $fields['heading'];
        $editor	                = $fields['editor'];
        $button                 = $fields['button'];
                  
        $content = '';
                 
        if( !empty( $heading ) ) {
            $content .= _s_get_heading( $heading, 'h2' );
        }
        
        if( !empty( $editor ) ) {
            $content .= $editor;
         }

        if( !empty( $button ) ) {
            $content .= sprintf( '<p>%s</p>', pb_get_cta_button( $button, array( 'class' => 'button green' ) ) );
        }        
        
        $output = sprintf( '<div class="column row"><div class="entry-content">%s</div></div>', $content );
        
        // Do not change
        _s_section( $output, $attr );
            
    }
    
}

section_wysiwyg();
    