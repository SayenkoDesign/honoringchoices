(function (document, window, $) {

	'use strict';

	// Load Foundation
	$(document).foundation();
    
    // Accessible menus
    
    $(".nav-primary").accessibleDropDownMenu();
    
    
    $(window).on('load changed.zf.mediaquery', function(event, newSize, oldSize) {
        
        if( Foundation.MediaQuery.atLeast('large') ) {
          $('.sticky-header').css( 'height', $('.site-header').height() );
          $('.site-header').addClass('fixed');
        }
        else {
            $('.sticky-header').css( 'height', '' );
        }
        
        // need to reset sticky on resize. Otherwise it breaks
        if( ! Foundation.MediaQuery.atLeast('large') ) {
            $(document).foundation();
        }
                
    });
    
    
    // Toggle menu
    
    $('li.menu-item-has-children > a').on('click',function(e){
        
        var $toggle = $(this).parent().find('.sub-menu-toggle');
        
        if( $toggle.is(':visible') ) {
            $toggle.trigger('click');
        }
        
        e.preventDefault();

    });
    
    
    // Make sure videos don't play in background
    $(document).on(
      'open.zf.reveal', '#modal-search', function () {
        $(this).find("input").first().focus();
      }
    );
    
   
    
}(document, window, jQuery));
