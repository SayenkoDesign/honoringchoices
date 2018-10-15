(function (document, window, $) {

	'use strict';

	$('.section-testimonials .slick').slick({
      dots: false,
      arrows: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
    });
    
    
    $('.section-home-news .slick').slick({
      dots: true,
      arrows: false,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,
    });
    
    
    $('.slick-posts').slick({
        dots: false,
        centerMode: false,
        //centerPadding: 0,
        slidesToShow: 4,
        arrows: true,
        //nextArrow: '<div class="arrow-right"><span class="screen-reader-text">Next</span></div>',
        //prevArrow: '<div class="arrow-left"><span class="screen-reader-text">Previous</span></div>',
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                centerMode: false,
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 980,
              settings: {
                centerMode: false,
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 600,
              settings: {
                centerMode: false,
                slidesToShow: 1,
              }
            }
        ]
    });
    
    
    $('.slick-posts').on('beforeChange', function(event, slick, currentSlide, nextSlide){
        new Foundation.Equalizer($('#slick-posts'));
    });
   
    
}(document, window, jQuery));


