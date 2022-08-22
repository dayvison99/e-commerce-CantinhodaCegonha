
(function($) {
	"use strict";
	
	$.fn.theshopier_block = function( options ){
		var defaults = {
			message: null,
			overlayCSS: {
				background: "#fff url("+theshopier_data.loading_icon+") no-repeat center"
			}
		}
		var opts = $.extend( {}, defaults, options );
		return this.each(function() {
			var elem = $( this );
			elem.block(opts);
		});
	};
	
	$.fn.updateMegaMenuPosition = function(){
		var i = 0 - ($(this).outerWidth() - $(this).parent().outerWidth())/2;
		
		var off_left = $(this).parents('.container').offset().left;
		var off_right = off_left + $(this).parents('.container').width();
		if( $(this).parent().offset().left + i - off_left < 15 ) {
			i = 0 - $(this).parent().offset().left + off_left;
		}
		
		if( $(this).parent().offset().left + $(this).outerWidth() > off_right ) {
			//i = 0 - $(this).parent().offset().left + off_left;
			var over_right = $(this).parent().offset().left - i - off_right;
			i = i - over_right - $(this).parent().width();
		}
		if( $(this).parent('li').hasClass( 'menu-item-level-0' ) ) {
			$(this).css('left', i + 'px');
		}
		
		
		if( $(this).parents('.menu-item-level-0').offset().left + $(this).outerWidth()*2 + i >  off_right ) {
			var sub_menu = $('ul.sub-menu');
			$(this).find( sub_menu ).addClass( 'nth-pos-left' );
		}
	}
	
	var NTH = {
		initialized: false,
		prodInfo: {
			timeout: {
				obj: false,
				time: 5000
			}
		},
		initialize: function(){
			if (this.initialized) return;
			this.initialized = true;
			this.build();
			NTH.events();
		},
		data: {
			shortcode: {
				product_tab: []
			},
			shop_dropText: $('.nth-toolbar-popup-cotent .shop-cart-dropable-box').text(),
			touchDevice: !!("ontouchstart" in window) ? 1 : 0
		},
		build: function(){
			NTH.setCartScrollbar();
			NTH.getJSScrollbar();
			NTH.owlCarousel();
			NTH.dropDragProduct();
			NTH.headerSticky();
			NTH.megaMenu();
		},
		events: function(){
			NTH.eventsGeneral();
			NTH.ajax_response();
			NTH.shortcodeEvents();
			NTH.windowResize();
			NTH.quickShop();
		},
		headerSticky: function(){
			if( NTH.data.touchDevice ) return false;
			
			var wpbar_top = $('#wpadminbar').length > 0 ? $('#wpadminbar').height(): 0;
			
			$('#header .nth_header_bottom').sticky({topSpacing: wpbar_top})
			.on('sticky-start', function(){
				$(this).find('.vertical-menu-wrapper .vertical-menu-inner.no_toggle').addClass('toggle');
			})
			.on('sticky-end', function(){
				$(this).find('.vertical-menu-wrapper .vertical-menu-inner.no_toggle').removeClass('toggle');
			});
		},
		megaMenu: function(){
			$('.main-menu ul.menu > li ul.sub-menu').each(function(e,i){
				$(this).updateMegaMenuPosition();
			});
			$('.main-menu li.menu-item-has-children').hover(function(){
				$(this).find("> ul.sub-menu").slideDown(300);
			},function(){
				$(this).find("> ul.sub-menu").hide();
			});
		},
		eventsGeneral: function(){
			$('body').trigger("nth_single_product_trigger");
			
			$('.widget_categories ul > li.cat-item ul').each( function( index ){
				$(this).parent().addClass( 'cat-parent' );
			} );
			
			$( '.shortcode-woo-tabs li.tab-item' ).on( 'click', function( e ){
				if( $(this).hasClass('active') ) return false;
				var _id = $(this).find( 'a' ).data('id');
				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');
				$('#'+_id).parent().find('.show').removeClass('show').addClass('hidden');
				$('#'+_id).removeClass('hidden').addClass('show');
			} );
			
			$('.nth-phone-menu-icon').on('click', function(){
				$('.nth-menu-wrapper .main-menu.pc-menu').removeClass('pc-menu').addClass('mb-menu');
				$('.nth-menu-wrapper .main-menu.mb-menu').toggleClass('fadeInDown');
				$('.nth-menu-wrapper').toggleClass('hidden-xs');
				$(this).toggleClass('active');
			});
			
			$( 'div.quantity:not(.buttons_added)' )
				.addClass('buttons_added')
				.prepend('<input type="button" value="-" class="minus" />')
				.append('<input type="button" value="+" class="plus" />');
			
			$(document).on( 'click', '.quantity .plus, .quantity .minus', function(e){
				
				//get value
				var $qty		= $(this).closest( '.quantity' ).find( '.qty' ),
					currentVal	= parseFloat( $qty.val() || 0 ),
					max			= parseFloat( $qty.attr( 'max' ) || 0 ),
					min			= parseFloat( $qty.attr( 'min' ) || 0 ),
					step		= parseFloat( $qty.attr( 'step' ) || 1 );
				
				// Format values
				if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
				if ( max === '' || max === 'NaN' ) max = '';
				if ( min === '' || min === 'NaN' ) min = 0;
				if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;
				
				// Change the value		
				if ( $( this ).is( '.plus' ) ) {
					if ( max && ( max == currentVal || currentVal > max ) ) {
						$qty.val( max );
					} else {
						$qty.val( currentVal + parseFloat( step ) );
					}
				} else {
					if ( min && ( min == currentVal || currentVal < min ) ) {
						$qty.val( min );
					} else if ( currentVal > 0 ) {
						$qty.val( currentVal - parseFloat( step ) );
					}
				}
				
				// Trigger change event
				$qty.trigger( 'change' );
			} );
			
			if( $('#menu-vertical-menu').length > 0 ) {
				var verti_height = $('#menu-vertical-menu').height();
				$('#menu-vertical-menu > li > ul.sub-menu').height(verti_height + 2);
			}
			
			$('#menu-vertical-menu > li').on('hover',function(){
				var verti_height = $('#menu-vertical-menu').height();
				$(this).find('> ul.sub-menu').height(verti_height + 2);
			});
		},
		owlCarousel: function(){
			
			$('.nth-owlCarousel:not(.initialized)').each( function(){
				var sl_root = $(this);
				var defaults = {
					items: 5,
					itemsCustom: false,
                    itemsDesktop: [1199, 4],
                    itemsDesktopSmall: [980, 3],
                    itemsTablet: [768, 2],
                    itemsTabletSmall: false,
                    itemsMobile: [479, 1],
					autoPlay: false,
					pagination: false,
					navigation: true,
					lazyload: true,
					afterInit: function(){
						sl_root.addClass('initialized').removeClass('loading');
					}
				};
				var slider = sl_root.data('slider');
				var base = sl_root.data('base');
				
				var config = $.extend({}, defaults, sl_root.data("options"));
				
				if( typeof base !== "undefined" && base == 1 ) {
					config.responsiveBaseWidth = sl_root;
				}
				if( typeof slider !== "undefined" && slider !== 'this' ) {
					sl_root.find(slider).owlCarousel(config);
				} else {
					sl_root.owlCarousel(config);
				}
				
			} );
		},
		dropDragProduct: function(){
			$('.woocommerce .products.shop_dragdrop:not(.owl-carousel) section.product-type-simple').draggable({
				revert: 'invalid',
				cancel: '.product-meta-wrapper',
				cursorAt: { top: 75, left: 75 },
				helper: function(){
					var drop_elem = $(this).find('.product-thumbnail-wrapper').clone();
					drop_elem.css({'z-index': 9999, 'width': '150px'});
					drop_elem.find('img').css({'border': '1px solid #999'});
					return drop_elem;
				},
				start: function(){
					$('.toolbar_item.nth-shopping-cart-item > .nth-toolbar-popup-cotent:not(.adding)').css({'visibility': 'visible', 'opacity': 1, 'right': '50px'});
				},
				stop: function(){
					$('.toolbar_item.nth-shopping-cart-item > .nth-toolbar-popup-cotent:not(.adding)').css({'visibility': '', 'opacity': '', 'right': ''});
				}
			});
			
			$( ".nth-toolbar-popup-cotent.nth-shopping-cart-content:not(.adding)" ).droppable({
				activeClass: "droppable_active",
				hoverClass: "droppable_in",
				drop: function( event, ui ) {
					$( this ).addClass('adding');
					var clone = ui.draggable.find('.product-thumbnail-wrapper img').clone();
					$( this ).find('.shop-cart-dropable-box').html(clone);
					$( this ).find('.shop-cart-dropable-box').theshopier_block();
					var cart_btn = ui.draggable.find('.product-meta-wrapper .add_to_cart_button');
					cart_btn.trigger('click');
				}
			});
			
			$('body').on('added_to_cart', function(){
				$('.toolbar_item.nth-shopping-cart-item > .nth-toolbar-popup-cotent.adding').removeClass('adding').css({'visibility': '', 'opacity': '', 'right': ''});
				$( ".nth-toolbar-popup-cotent.nth-shopping-cart-content .shop-cart-dropable-box" ).unblock().html(NTH.data.shop_dropText)
			});
		},
		//events
		ajax_response: function(){
			NTH.added_to_cart();
			NTH.removeCartItem();
			NTH.removeWishList();
			
		},
		shortcodeEvents: function(){
			
			$('ul.shortcode-woo-tabs li.tab-item-ajax:not(.active)').live('click', function(e){
				var cat_slug = $(this).find('> a').data('slug');
				var tab_id = $(this).find('> a').data('id');
				var element = $(this).parents('.nth-shortcode').find('.nth-shortcode-content .products');
				var tab_ajax_content = $(this).parents('.nth-shortcode').find('.nth-shortcode-content .tab-content-item.ajax-content')
				var data = {
					action: 'nth_woo_get_product_by_cat',
					atts: $(this).parents('.nth_products_categories_shortcode').data('atts'),
					cat_slug: cat_slug
				}
				
				$(this).siblings().removeClass('active');
				$(this).addClass('active');
				
				if( NTH.data.shortcode.product_tab[tab_id] ) {
					tab_ajax_content.html(NTH.data.shortcode.product_tab[tab_id]);
					NTH.owlCarousel();
					return;
				}
				
				$.ajax({
					type : "POST",
					timeout : 30000,
					url : theshopier_data.ajax_url,
					data : data,
					error: function(xhr,err){
						element.unblock();
					},
					beforeSend: function(){
						element.theshopier_block();
					},
					success: function( response ){
						element.unblock();
						tab_ajax_content.html(response);
						NTH.data.shortcode.product_tab[tab_id] = response;
						NTH.owlCarousel();
					}
				});
				
			});
		},
		windowResize: function(){
			$(window).resize(function(){
				NTH.headerSticky();
			});
		},
		quickShop: function(){
			$('.nth_quickshop_link').prettyPhoto({
				social_tools: false,
				opacity: 0.6,
				show_title: false,
				default_width: 900,
				default_height: 500,
				theme: 'pp_woocommerce',
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
		},
		added_to_cart: function(){
			$("body").bind('added_to_cart', function(){
				NTH.setCartScrollbar();
			});
		},
		removeCartItem: function(){
			$('body').on('click', '.nth_remove_cart', function(e){
				e.preventDefault();
				var $thisbutton = $(this);
				var data = {
					action: "nth_woo_remove_cart_item"
				};
				
				$.each($thisbutton.data(), function( key, value ){
					data[key] = value;
				});
				
				$.ajax({
					url: theshopier_data.ajax_url,
					data: data,
					type: "POST",
					beforeSend: function(){
						$thisbutton.parents('.widget_shopping_cart_content').theshopier_block();
					},
					success: function(response){
						if ( ! response ) return;
						
						var this_page = window.location.toString();
						
						// Block fragments class
						var fragments = response.fragments;
						if ( fragments ) {
							$.each( fragments, function( key, value ) {
								$( key ).addClass( 'updating' );
							});
						}
						
						// Block widgets and fragments
						$( '.shop_table.cart, .updating, .cart_totals' ).theshopier_block();
						
						// Replace fragments
						if ( fragments ) {
							$.each( fragments, function( key, value ) {
								$( key ).replaceWith( value );
							});
						}

						// Unblock
						$( '.widget_shopping_cart, .updating' ).stop( true ).css( 'opacity', '1' ).unblock();
						
						// Cart page elements
						$( '.shop_table.cart' ).load( this_page + ' .shop_table.cart:eq(0) > *', function() {
							$( '.shop_table.cart' ).stop( true ).css( 'opacity', '1' ).unblock();
							$( 'body' ).trigger( 'cart_page_refreshed' );
						});

						$( '.cart_totals' ).load( this_page + ' .cart_totals:eq(0) > *', function() {
							$( '.cart_totals' ).stop( true ).css( 'opacity', '1' ).unblock();
						});
						$( 'body' ).trigger( 'added_to_cart');
					}
				});
			});
		},
		removeWishList: function(){
			$('body').on('click', '.nth_remove_from_wishlist', function(){
				var remove_btn = $(this),
					pagination = remove_btn.data( 'pagination' ),
					wishlist_id = remove_btn.data( 'id' ),
					wishlist_token = remove_btn.data( 'token' ),
					prod_id = remove_btn.data( 'prod_id' ),
					par_box = remove_btn.parents('.nth-toolbar-popup-cotent');
				var data = {
					action: 'remove_from_wishlist',
					remove_from_wishlist: prod_id,
					wishlist_id: wishlist_id,
					wishlist_token: wishlist_token
				}
				$.ajax({
					url: theshopier_data.ajax_url,
					data: data,
					type: "POST",
					beforeSend: function(){
						par_box.theshopier_block();
					},
					success: function(response){
						ul_pre.unblock();
						$('body').trigger('added_to_wishlist');
					}
				});
			});
		},
		setCartScrollbar: function(){
			$("ul.cart_list.product_list_widget").css('position', 'relative');
			$("ul.cart_list.product_list_widget").perfectScrollbar({wheelSpeed:0.5,suppressScrollX:true});
			$("ul.cart_list.product_list_widget").perfectScrollbar("update");
		},
		getJSScrollbar: function(){
			var element = $(".nth-toolbar-popup-cotent ul.product_list_widget");
			element.css('position', 'relative');
			element.perfectScrollbar({wheelSpeed:0.5,suppressScrollX:true});
			element.perfectScrollbar("update");
		}
	};
	
	$('body').on('nth_single_product_trigger', function(){
		if( $('#zoom1 img').length ){
			$('#zoom1 img').elevateZoom({
				//scrollZoom	: true,
				//cursor		: "crosshair",
				easing 		: true,
				zoomType	: "inner",
				gallery		: 'nth_prod_thumbnail', 
				cursor		: 'pointer', 
				galleryActiveClass: "active"
			});
			
			$("#zoom1 img").bind("click", function(e) {
				var ez = jQuery('#zoom1 img').data('elevateZoom');
				$.fancybox(ez.getGalleryList());
				return false;
			});
		}
		
	});
	
	$(document).ready(function(){
		NTH.initialize();
	});
	
	$(window).load(function() {
        NTH.setCartScrollbar();
    });
	
	/*Product page*/
	$('body').on( "click", ".variations_form .nth-variable-attr-swapper .select-option", function(e){
		
		var val = $(this).attr('data-value');
		var _this = $(this);
		var color_select = $(this).parents('.value').find('select');
		color_select.trigger('focusin');
		if(color_select.find('option[value='+val+']').length !== 0) {
			color_select.val( val ).change();
			$(this).parent( ".nth-variable-attr-swapper" ).find('.selected').removeClass('selected');
			_this.addClass('selected');
		}
		
	} );
	
	jQuery('.variations_form').on('click', '.reset_variations', function(e){
		jQuery(this).parents('.variations').find('.nth-variable-attr-swapper .select-option.selected').removeClass('selected');
	});
	
	$('#back_to_top').on('click', function(){
		$('html, body').animate({scrollTop: 0}, 300);
	});
	
	$(document).on('added_to_wishlist', function(e){
		if( typeof woocommerce_params == 'undefined' ) return false;
		$.ajax({
			url: theshopier_data.ajax_url,
			type: "POST",
			data: {
				action: 'nth_added_to_wishlist'
			},
			success: function( data ){
				if ( data ) {
					$.each( data, function( key, value ) {
						$( key ).replaceWith( value );
					});
				}
				
				NTH.getJSScrollbar();
			}
		});
	});
	
	$('.nth_header_toolbar .nth-compare-item a').on('click', function(e){
		e.preventDefault();
		var res = $(this).attr('href');
		 $('body').trigger( 'yith_woocompare_open_popup', { response: res } );
	});
	
	$(document).on('click', '.add_to_cart_button.product_type_simple', function(){
		var product_id = $(this).data('product_id');
		
		$.ajax({
			url: theshopier_data.ajax_url,
			type: "POST",
			data: {
				action: "nth_woo_getproductinfo",
				product_id: product_id
			}, success: function(data){
				$('.current-product-added-to-cart').removeClass('zoomOutRight').addClass('flipInX').html(data).show();
				clearTimeout( NTH.prodInfo.timeout.obj );
				NTH.prodInfo.timeout.obj = setTimeout(function(){
                    $('.current-product-added-to-cart').removeClass('flipInX').addClass('zoomOutRight');
                }, NTH.prodInfo.timeout.time);
			}
		});
	});
	
})(jQuery);