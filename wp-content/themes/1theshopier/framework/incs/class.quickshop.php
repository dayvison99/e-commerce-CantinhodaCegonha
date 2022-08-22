<?php 

if( !class_exists( 'Theshopier_Quickshop' ) ) {
	class Theshopier_Quickshop{
		
		private $options = array();
		
		public function __construct(){
			$this->setOptions(array(
				"label"		=> esc_html__( "Quick shop", 'theshopier' ),
			));

			add_action('init', array($this, 'init_hook'));
			add_action('init', array($this, 'init_ajaxHandle'));
		}
		
		public function setOptions( $options ){
			$this->options = $options;
		}
		
		public function init_hook(){
			global $theshopier_datas;
			if(isset($theshopier_datas['shop-quickshop']) && absint($theshopier_datas['shop-quickshop']) == 0) return;
			add_action('wp_enqueue_scripts',array($this,'registerScript'));
			add_action( "woocommerce_before_shop_loop_item", array( $this, 'quickshop_btn'), 10 );
		}
		
		public function registerScript(){
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}
		
		public function init_ajaxHandle(){
			global $theshopier_datas;
			if(isset($theshopier_datas['shop-quickshop']) && absint($theshopier_datas['shop-quickshop']) == 0) return;
			add_action('wp_ajax_quickshop_prod_content', array( $this, 'ajax_callback_func') );
			add_action('wp_ajax_nopriv_quickshop_prod_content', array( $this, 'ajax_callback_func') );		
		}
		
		public function update_add_to_cart_button( $atc_url ){
			$_url = wp_get_referer();
			$_url = remove_query_arg( array('added-to-cart','add-to-cart') , $_url );
			$_url = add_query_arg( array( 'add-to-cart' => $this->id ),$_url );
			return $_url;
		}
		
		public function ajax_callback_func(){
			global $post, $product;
			$prod_id = absint( $_REQUEST['product_id'] );
			
			$post = get_post( $prod_id );
			$product = wc_get_product( $prod_id );
			if( $prod_id <= 0 || !isset($post->post_type) || strcmp($post->post_type, 'product') != 0 )
				die("Invalid Products");
			
			add_filter('woocommerce_add_to_cart_url', array($this, 'update_add_to_cart_button'),10);
			remove_action("woocommerce_single_product_summary", 'woocommerce_template_single_sharing', 50 );
			
			ob_start();?>
<div class="woocommerce nth-quickshop-wrapper">
	<div itemscope itemtype="<?php echo woocommerce_get_product_schema();?>" id="product-<?php echo get_the_ID();?>" class="nth-quickshop product">
	
		<?php do_action( 'woocommerce_before_single_product_summary' );?>
		<?php 
		$columns = 1;
		$options = array(
			"items"			=> $columns,
			"itemsDesktop"		=> array(1199,round( $columns * (1199 / 1200) )),
			"itemsDesktopSmall"	=> array(980, round( $columns * (980  / 1200) )),
			"itemsTablet"		=> array(768, round( $columns * (768 / 1200) )),
			"itemsMobile"		=> array(479, round( $columns * (479 / 1200) ))
		);
		?>
		
		<div class="col-sm-12 summary entry-summary">
			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>
		</div>
	</div><!-- .nth-quickshop -->
</div><!-- .nth-quickshop-wrapper -->
			<?php 
			remove_filter( 'woocommerce_add_to_cart_url', array($this, 'update_add_to_cart_button') );
			$output = ob_get_clean();
			add_action("woocommerce_single_product_summary", 'woocommerce_template_single_sharing', 50 );
			die( $output );
		}
		
		public function quickshop_btn(){
			global $product;
			$query_args = array(
				'ajax' => 'true',
				'action' => 'quickshop_prod_content',
				'product_id' => absint($product->get_id())
			);
			$_link = add_query_arg( $query_args, get_admin_url() . 'admin-ajax.php' );
			?>
			<a class="nth_quickshop_link icon-nth-search button hidden-xs" title="<?php esc_attr_e( 'Quick shop', 'theshopier' )?>" href="<?php echo esc_url($_link); ?>"><?php esc_attr_e( 'Quick shop', 'theshopier' )?></a>
			<?php 
		}
		
	}
	
	if( in_array( "woocommerce/woocommerce.php", get_option( 'active_plugins' ) ) ) {
		$detect = new Mobile_Detect;
		if( !$detect->isMobile() ){
			new Theshopier_Quickshop();
		}
	}
}