<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( !class_exists( 'Theshopier_Ajax' ) ) {
	
	class Theshopier_Ajax {
		
		function __construct(){
			$this->init();
		}
		
		public function init(){
			$ajax_events = array(
				'add_widgetsidebar'		=> false,
				'del_widgetsidebar'		=> false,
				'get_newsletter_popup'	=> true,
				'ajax_login'			=> true,
				'update_cart'			=> true,
			);
			
			if( Theshopier::checkPlugin('woocommerce/woocommerce.php') ) {
				$ajax_events['woo_remove_cart_item']	= true;
				$ajax_events['woo_getproductinfo']		= true;
				
				if( class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL') ) {
					$ajax_events['added_to_wishlist']		= true;
				}

				if( class_exists('YITH_Woocompare') ) {
					$ajax_events['added_to_compare']		= true;
				}
			}
			
			foreach ( $ajax_events as $ajax_event => $nopriv ) {
				add_action( 'wp_ajax_nth_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				if ( $nopriv ) {
					add_action( 'wp_ajax_nopriv_nth_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				}
			}
			
			/**
			 * CUSTOM AJAX CART
			**/
			add_filter( 'woocommerce_add_to_cart_fragments', array( __CLASS__, 'woo_cart_fragments' ) );
		}
		
		public static function add_widgetsidebar(){
			$option_name = 'theshopier_custom_sidebars';
			$name = trim($_REQUEST['sidebar_name']);
			$desc = trim($_REQUEST['sidebar_desc']);
			$slug = sanitize_title( $name );
			if( strlen( $slug ) == 0 ) die( esc_html__("Please enter your sidebar name!", 'theshopier' ) );
			
			if (!wp_verify_nonce($_REQUEST['_wpnonce_nth_add_sidebar'],'nth-add-sidebar-widgets') ) die( 'Security check' );
			
			if(!get_option($option_name) || get_option($option_name) == '') delete_option($option_name); 
			
			if($data = get_option($option_name)) {
				$data = unserialize($data);
				foreach( $data as $k => $v ) {
					if( $k == $slug ) die( esc_html__("This name was used.", 'theshopier' ));
				}
				$data[$slug] = array(
					'name'	=> $name,
					'desc'	=> $desc
				);
				$result = update_option($option_name, serialize($data));
			} else {
				$data = array();
				$data[$slug] = array(
					'name'	=> $name,
					'desc'	=> $desc
				);
				$result = add_option($option_name, serialize($data));
			}
			
			if($result) die("success"); else die("Update error!");
		}
		
		public static function del_widgetsidebar(){
			$id = trim($_REQUEST['sidebar_id']);
			if( strlen($id) == 0 ) die('error');
			$option_name = 'theshopier_custom_sidebars';
			
			if($data = get_option($option_name)) {
				$data = unserialize($data);
				if( array_key_exists( $id, $data ) ) {
					unset( $data[$id] );
				}
				if( count($data) > 0 ) $result = update_option($option_name, serialize($data));
				else delete_option($option_name);
			}
			die();
		}
		
		public static function woo_remove_cart_item(){
			$key = $_REQUEST['key'];
			$nonce = $_REQUEST['nonce'];
			if( !wp_verify_nonce( $nonce, 'nth_remove_cart_item' ) ) die('Security check');
			$result = WC()->cart->remove_cart_item( $key );
			WC_AJAX::get_refreshed_fragments();
			die();
		}
		
		public static function woo_getproductinfo(){
			$pro_id = isset($_REQUEST['product_id'])? $_REQUEST['product_id']: 0;
			$meta_query = WC()->query->get_meta_query();
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 1,
				'no_found_rows'  => 1,
				'post_status'    => 'publish',
				'meta_query'     => $meta_query
			);
			$args['p'] = $pro_id;
			
			$products = new WP_Query( $args );
			
			while ( $products->have_posts() ) : $products->the_post(); global $product;
				
				printf( '<div class="nth_add_to_cart_product_info"><a href="%s" title="%s">%s<span class="product-title">%s</span></a>%s</div>', esc_url( get_permalink( $product->get_id() ) ), esc_attr( $product->get_title() ), $product->get_image(), $product->get_title(), $product->get_price_html() );
			
			endwhile;
			
			wp_reset_postdata();
			die();
		}

		public static function get_newsletter_popup(){
			$slug = isset($_REQUEST['slug'])? $_REQUEST['slug']: '';
			ob_start();
			?>
			<div class="nth-popup nth-newsletter" id="nth_newsletter_popup">
				<div class="popup-wrapper animated flipInX">
					<div class="popup-content">
						<?php Nexthemes_StaticBlock::getSticBlockContent($slug);?>
					</div>
				</div>
			</div>
			<?php

			echo ob_get_clean();
			die();
		}

		public static function ajax_login(){
			$creds = array();
			$creds['user_login'] = esc_attr($_POST['log']);
			$creds['user_password'] = esc_attr($_POST['pwd']);
			$creds['remember'] = isset($_POST['remember'])? esc_attr($_POST['remember']): false;
			$user = wp_signon( $creds, false );

			$json = array('redirect_to' => esc_url($_POST['redirect_to']));
			$json['code'] = $user->get_error_code();
			if ( is_wp_error($user) ) {
				$json['mess'] = $user->get_error_message();
			} else {
				$json['mess'] = esc_html__('Login success!', 'theshopier');
			}
			echo wp_json_encode($json);
			wp_die();
		}
		
		public static function added_to_wishlist(){
			$wishlist_count = yith_wcwl_count_products();
			$fragments = array();
			$fragments['.toolbar_item.nth-wishlist-item > a .nth-icon'] = sprintf('<span class="nth-icon icon-nth-heart" data-count="%s"></span>', absint($wishlist_count));
			ob_start(); ?>
			<div class="nth-toolbar-popup-cotent"><?php do_action('theshopier_toolbar_wishlist');?></div>
			<?php 
			$fragments['.toolbar_item.nth-wishlist-item > .nth-toolbar-popup-cotent'] = ob_get_clean();
			wp_send_json($fragments);
		}

		public static function added_to_compare(){
			global $yith_woocompare; $fontend = $yith_woocompare->obj;
			$compare_count = count($fontend->products_list);
			$fragments = array();
			$fragments['.toolbar_item.nth-compare-item > a .nth-icon'] = sprintf('<span class="nth-icon icon-nth-exchange" data-count="%s"></span>', absint($compare_count));
			ob_start(); ?>
			<div class="nth-toolbar-popup-cotent"><?php do_action('theshopier_toolbar_compare');?></div>
			<?php $fragments['.toolbar_item.nth-compare-item > .nth-toolbar-popup-cotent'] = ob_get_clean();

			wp_send_json($fragments);
		}
		
		public static function woo_cart_fragments( $fragments ){
			
			$fragments['.nth-shopping-hover .icon-nth-cart'] = sprintf( '<span class="nth-icon icon-nth-cart" data-count="%s"></span>', absint(WC()->cart->cart_contents_count) );
			
			$fragments['.nth-shopping-hover span.cart-total'] = '<span class="cart-total hidden-xs">' . WC()->cart->get_cart_total() . '</span>';
			
			$fragments['.toolbar_item.nth-shopping-cart-item > a'] = sprintf( '<a href="%s" title="%s"><span class="nth-icon icon-nth-cart" data-count="%s"></span></a>', esc_url(wc_get_cart_url()), esc_html__( "Browse Shopping cart", 'theshopier' ), absint(WC()->cart->cart_contents_count) );

			$fragments['.nth-shopping-hover > a .cart-meta-st5'] = '<span class="cart-meta-st5">' .sprintf( __('Cart: %s item(s)', 'theshopier'), absint(WC()->cart->cart_contents_count)) . '</span>';

			return $fragments;
		}

		public static function update_cart(){
			if( !class_exists('WC_AJAX')) wp_die(0);
			WC_AJAX::get_refreshed_fragments();
			wp_die();
		}

	}
	
	new Theshopier_Ajax();
	
}

