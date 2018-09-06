(function (document, window, $) {

	'use strict';
    
    // Scroll up show header

	var $site_header =  $('.site-header');

	// clone header
	var $sticky = $site_header.clone()
							   .prop('id', 'masthead-fixed' )
							   .attr('aria-hidden','true')
							   .addClass('fixed')
							   .insertBefore('#masthead');
            
    $sticky.each(function () {
        var $win = $(window), 
            $self = $(this),
            isShow = false,
            delta = 300, // distance from top where its active
            lastScrollTop = 0;
    
        $win.on('scroll', function () {
          
          // don't show below sticky menu
          if( $('.facetwp-template').hasClass('is-paging') ) {
              return;
          }
          
          var scrollTop = $win.scrollTop();
          var offset = scrollTop - lastScrollTop;
          lastScrollTop = scrollTop;
          
    
    
          // min-offset, min-scroll-top
          if (offset < 0 && scrollTop > delta ) {
            if (!isShow ) {
              $self.addClass('fixed-show');
              isShow = true;
            }
          } else if (offset > 0 || offset < lastScrollTop ) {
            if (isShow) {
              $self.removeClass('fixed-show');
              isShow = false;
            }
          }
        });
    });
    

}(document, window, jQuery));