(function($) {
  'use strict';
		
	// slider-info-slider
	  var owlsliderinfoproducts = $(".slider-info-slider");
	  owlsliderinfoproducts.owlCarousel({
		rtl: $("html").attr("dir") == 'rtl' ? true : false,
		loop: true,
		items: 1,
		nav: false,
		dots: true,
		margin: 0,
		mouseDrag: true,
		touchDrag: true,
		autoplay: true,
		autoplayTimeout: 12000,
		stagePadding: 0
	  });	
}(jQuery));


