<?php
/*
 * Display product categories
 */
if (!class_exists('WooCommerce')) return;

class ecommerce_plus_product_search_widget extends WC_Widget {

		function __construct() {
		
				$this->widget_cssclass    = 'woocommerce product_search_widget';
				$this->widget_description = __( 'Display product search.', 'ecommerce-plus' );
				$this->widget_id          = 'ecommerce_plus_product_search_widget';
				$this->widget_name        = __( '+ Product Search', 'ecommerce-plus' );
		
				parent::__construct();
				
		}

		// Creating widget front-end
		public function widget($args, $instance) {
		?>
        <div class="product-search-widget">
          <?php if ( class_exists( 'WooCommerce' ) ) { ?>
          <div class="woo-product-search-form">
            <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
              <select class="woo-product-search-select" name="product_cat">
                <option value="">
                <?php esc_html_e( 'All Products', 'ecommerce-plus' ); ?>
                </option>
                <?php
								$args = array(
									'taxonomy'     => 'product_cat',
									'orderby'      => 'date',
									'order'      	=> 'ASC',
									'show_count'   => 1,
									'pad_counts'   => 0,
									'hierarchical' => 1,
									'title_li'     => '',
									'hide_empty'   => 1,
								);
								$categories = get_categories( $args);
								foreach ( $categories as $category ) {
									$option = '<option value="' . esc_attr( $category->category_nicename ) . '">';
									$option .= esc_html( $category->cat_name );
									$option .= ' (' . absint( $category->category_count ) . ')';
									$option .= '</option>';
									echo ($option); 
								}
								?>
              </select>
              <input type="hidden" name="post_type" value="product" />
              <input class="woo-product-search-input" name="s" type="text" placeholder="<?php esc_attr_e( 'Search...', 'ecommerce-plus' ); ?>"/>
              <button class="woo-product-search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </form>
          </div>
          <?php } ?>
        </div>		
		<?php
		}

		public function form($instance) {
		}

		public function update($new_instance, $old_instance) {
				$instance = array();
				return $instance;
		}
}


function ecommerce_plus_product_search_widget() {
		register_widget('ecommerce_plus_product_search_widget');
}
add_action('widgets_init', 'ecommerce_plus_product_search_widget');





