<?php 
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Theshopier_ProductCategory_Widget extends Theshopier_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'nth-widgets nth-product-category-widget';
		$this->widget_description = esc_html__( "Display a list of your products of a category.", 'theshopier' );
		$this->widget_id          = 'theshopier_product_category';
		$this->widget_name        = esc_html__('Product Category', 'theshopier' );
		
		
		
		parent::__construct();
    }
	
	public function form( $instance ) {
		$this->init_settings();
		parent::form( $instance );
	}
	
	public function update( $new_instance, $old_instance ) {
		$this->init_settings();

		return parent::update( $new_instance, $old_instance );
	}
	
	
	public function init_settings(){
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Products', 'theshopier' ),
				'label' => esc_html__( 'Title', 'theshopier' )
			),
			'item_style' => array(
				'type'  => 'select',
				'std'   => 'list',
				'label' => esc_html__( 'Item Style', 'theshopier' ),
				'options' => array(
					'grid'   => esc_html_x( 'Grid', "NTH WooCommerce Products Widgets", 'theshopier' ),
					'list'  => esc_html_x( 'List', "NTH WooCommerce Products Widgets", 'theshopier' ),
				)
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => 20,
				'std'   => 5,
				'label' => esc_html__( 'Number of products to show', 'theshopier' )
			),
			'category' => array(
				'type'  => 'select',
				'std'   => '',
				'label' => esc_html__( 'Category', 'theshopier' ),
				'options' => $this->get_productCat(),
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => esc_html__( 'Order by', 'theshopier' ),
				'options' => $this->getOrderby(),
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'desc',
				'label' => esc_html_x( 'Order', 'Sorting order', 'theshopier' ),
				'options' => $this->getOrder(),
			)
		);
	}
	
    public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) return;
		
		ob_start();
		$this->widget_start( $args, $instance );
		
		echo do_shortcode( '[theshopier_products_category category="'.esc_attr( $instance['category'] ).'" per_page="'.absint( $instance['number'] ).'" item_style="'.esc_attr( $instance['item_style'] ).'" orderby="'.esc_attr( $instance['orderby'] ).'" order="'.esc_attr( $instance['order'] ).'" as_widget="1"]' );
		
		$this->widget_end( $args );
		
		echo $this->cache_widget( $args, ob_get_clean() );
	}
}
