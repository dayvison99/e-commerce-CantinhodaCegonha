/**
 * NTH - QuickShop
 * @version 1.0.0
 *
 * @license commercial software
 */

(function($) {
	
	$(document).ready( function(){
		$('.nth_quickshop_link').prettyPhoto({
			social_tools: false,
			opacity: 0.6,
			show_title: false,
			default_width: 900,
			default_height: 500,
			theme: 'pp_woocommerce pp_nexthemes',
			changepicturecallback: function(){
				$( 'div.quantity:not(.buttons_added)' ).addClass('buttons_added')
					.prepend('<input type="button" value="-" class="minus" />')
					.append('<input type="button" value="+" class="plus" />');
				
				$('.pp_inline').find('form.variations_form').wc_variation_form();
				$('.pp_inline').find('form.variations_form .variations select').change();
				jQuery('body').trigger('wc_fragments_loaded');
				
				$('body').trigger("nth_single_product_trigger");
				var $this_ = jQuery('#nth_prod_thumbnail');
				var owl = $this_.owlCarousel({
					items : 3,
					pagination: false,
					navigation: true,
					responsiveBaseWidth: $this_,
					itemsDesktop : [1000,6], //5 items between 1000px and 901px
					itemsDesktopSmall : [900,4], // betweem 900px and 601px
					itemsTablet: [600,3], //2 items between 600 and 0
					itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
				});	
				
			}
		});
	} );
	
})(jQuery);