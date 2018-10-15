(function (document, window, $) {

	'use strict';
    
    $(document).on('facetwp-loaded', function() {
        var $grid = $( '.masonry-grid' ).imagesLoaded( function() {
            $grid.masonry("reloadItems");
            $grid.masonry( {
                itemSelector: '.grid-item',
              columnWidth: '.grid-sizer',
              gutter: '.gutter-sizer',
              percentPosition: true
            });
        });
    });
    
    // Change target for blog and stories
    var target = $('.facetwp-template');
    if($('body').hasClass('blog')) {
        target = $('.facetwp-filters');
    }
    
    // add .is-paging ot trigger no fixed header on facet paging
        
    $(document).on('facetwp-loaded', function() {
        if (FWP.loaded) {
            $('.facetwp-template').addClass('is-paging');
            
            $.smoothScroll({
                scrollTarget: target,
                beforeScroll: function() {
                    
                },
                afterScroll: function() {
                     
                },
                
            });
            
            setTimeout(function() {
               $('.facetwp-template').removeClass('is-paging');
           }, 500);
        }
    });

    
}(document, window, jQuery));
