<?php 
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Theshopier_WoocommerceProducts_Widget extends Theshopier_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'nth-widgets nth-woo-products-widget';
		$this->widget_description = esc_html__( "Display a list of your products on your site.", 'theshopier' );
		$this->widget_id          = 'theshopier_woo_products';
		$this->widget_name        = esc_html__('WooCommerce Products', 'theshopier' );
		
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
				'max'   => '',
				'std'   => 5,
				'label' => esc_html__( 'Number of products to show', 'theshopier' )
			),
			'show' => array(
				'type'  => 'select',
				'std'   => '',
				'label' => esc_html__( 'Show', 'theshopier' ),
				'options' => array(
					''         => esc_html__( 'All Products', 'theshopier' ),
					'featured' => esc_html__( 'Featured Products', 'theshopier' ),
					'onsale'   => esc_html__( 'On-sale Products', 'theshopier' ),
				)
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => esc_html__( 'Order by', 'theshopier' ),
				'options' => array(
					'date'   => esc_html__( 'Date', 'theshopier' ),
					'price'  => esc_html__( 'Price', 'theshopier' ),
					'rand'   => esc_html__( 'Random', 'theshopier' ),
					'sales'  => esc_html__( 'Sales', 'theshopier' ),
				)
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'desc',
				'label' => esc_attr_x( 'Order', 'Sorting order', 'theshopier' ),
				'options' => array(
					'asc'  => esc_html__( 'ASC', 'theshopier' ),
					'desc' => esc_html__( 'DESC', 'theshopier' ),
				)
			),
			'hide_free' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Hide free products', 'theshopier' )
			),
			'show_hidden' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => esc_html__( 'Show hidden products', 'theshopier' )
			)
		);
		
		parent::__construct();
    }
	
    public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) return;
		
		ob_start();
		$this->widget_start( $args, $instance );
		
		if ( empty( $instance['show_hidden'] ) ) $instance['show_hidden'] = '0';
		if ( empty( $instance['hide_free'] ) ) $instance['hide_free'] = '0';
		if ( empty( $instance['show'] ) ) $instance['show'] = '';
		
		switch( $instance['show'] ){
			case 'featured': 
				echo do_shortcode( '[theshopier_featured_products per_page="'.absint( $instance['number'] ).'" item_style="'.esc_attr( $instance['item_style'] ).'" orderby="'.esc_attr( $instance['orderby'] ).'" order="'.esc_attr( $instance['order'] ).'" as_widget="1" hide_free="'.absint( $instance['hide_free'] ).'" show_hidden="'.absint( $instance['show_hidden'] ).'"]' );
				break;
			case 'onsale': 
				echo do_shortcode( '[theshopier_sale_products per_page="'.absint( $instance['number'] ).'" item_style="'.esc_attr( $instance['item_style'] ).'" orderby="'.esc_attr( $instance['orderby'] ).'" order="'.esc_attr( $instance['order'] ).'" as_widget="1" hide_free="'.absint( $instance['hide_free'] ).'" show_hidden="'.absint( $instance['show_hidden'] ).'"]' );
				break;
			default: 
				echo do_shortcode( '[theshopier_recent_products per_page="'.absint( $instance['number'] ).'" item_style="'.esc_attr( $instance['item_style'] ).'" orderby="'.esc_attr( $instance['orderby'] ).'" order="'.esc_attr( $instance['order'] ).'" as_widget="1" hide_free="'.absint( $instance['hide_free'] ).'" show_hidden="'.absint( $instance['show_hidden'] ).'"]' );
		}
		
		$this->widget_end( $args );
		
		echo $this->cache_widget( $args, ob_get_clean() );
	}
}
