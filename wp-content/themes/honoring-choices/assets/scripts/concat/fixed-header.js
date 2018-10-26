(function (document, window, $) {

	'use strict';
    
    var didScroll;
    var lastScrollTop = 0;
    var delta = 300;
    var navbarHeight = $('.site-header').outerHeight();
    
    $(window).scroll(function(event){
        didScroll = true;
    });
    
    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);
    
    function hasScrolled() {
        var st = $(window).scrollTop();
        
        // Make scroll more than delta
        if(Math.abs(lastScrollTop - st) <= delta) {
            return;
        }
        
        // If scrolled down and past the navbar, add class .nav-up.
        if (st > lastScrollTop && st > navbarHeight){
            // Scroll Down
            $('.site-header').removeClass('nav-down').addClass('nav-up shrink');
        } else {
            // Scroll Up
            if(st + $(window).height() < $(document).height()) {
                $('.site-header').removeClass('nav-up').addClass('nav-down');
            }
        }
        
        if(st <= delta) {
            $('.site-header').removeClass('shrink')
        }
      
        lastScrollTop = st;
    }

}(document, window, jQuery));