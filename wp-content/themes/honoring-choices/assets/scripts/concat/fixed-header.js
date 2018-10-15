(function (document, window, $) {

	'use strict';
    
    // Scroll up show header

	var $sticky =  $('.site-header');
            
    $sticky.each(function (i, element) {
        
        var $win = $(window), 
            $self = $(this),
            isShow = false,
            delta = 400, // distance from top where its active
            lastScrollTop = 0;
            
        var scrollHeight = $(document).height();

        $win.on("scroll", function() {
            var scrollPosition = $(window).height() + $(window).scrollTop();
            var scrollBottom = ( (scrollHeight - scrollPosition) / scrollHeight ) * 100;
            var scrollTop = $win.scrollTop();
            var offset = scrollTop - lastScrollTop;
            lastScrollTop = scrollTop;
            
            /*
            console.log( 'ScrollTop: ' + scrollTop );
            
            console.log( 'ScrollHeight: ' + scrollHeight );
            
            console.log( 'ScrollPosition: ' + scrollPosition );
            
            console.log( 'scrollBottom:' + scrollBottom );
            */
            
            if( scrollHeight < (delta * 2) ) {
                return;
            }
            
            if ( scrollTop > delta && scrollBottom > 0 ) {
                
                $self.addClass('fixed');
                
                if (offset < 0 ) {
                    if (!isShow ) {
                      $self.addClass('fixed-show');
                      isShow = true;
                    }
                } else if (offset > 0 || offset <= lastScrollTop ) {
                    if (isShow) {
                      $self.removeClass('fixed fixed-show');
                      isShow = false;
                    }
                }
                else {
                    $self.removeClass('fixed fixed-show');
                    isShow = false;
                }
                
            }
            else {
                
                $self.removeClass('fixed fixed-show'); 
                isShow = false; 
                 
            }
            
        });
    });
    

}(document, window, jQuery));