<?php 

if( !class_exists( 'Theshopier_Shop_Dragdrop' ) ) {
	class Theshopier_Shop_Dragdrop{
		
		function __construct(){
			add_action( 'wp' , array( $this, 'init' ) , 30);
		}
		
		public function init(){
			//add_action('woocommerce_before_shop_loop');
			add_filter('theshopier_woocommerce_product_loop_class_filter', array($this, 'product_loop_class_filter'), 10, 2);
			add_action('theshopier_after_shop_cart_toolbar_icon', array($this, 'after_shop_cart_toolbar_droppable'), 10);
			add_action('wp_enqueue_scripts', array( $this, 'init_script' ) );
		}
		
		public function init_script(){
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-droppable' );
		}
		
		public function product_loop_class_filter( $class, $style = '' ){
			$class[] = 'shop_dragdrop';
			return $class;
		}
		
		public function after_shop_cart_toolbar_droppable(){
			?>
			<p class="shop-cart-dropable-box"><?php esc_html_e('Drop product in here', 'theshopier' );?></p>
			<?php 
		}
		
		
	}
	
	
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		new Theshopier_Shop_Dragdrop();
	}
	
}