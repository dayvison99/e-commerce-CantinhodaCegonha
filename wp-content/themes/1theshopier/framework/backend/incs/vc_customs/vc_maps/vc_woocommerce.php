<?php 
// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( "Theshopier_VC_Woocommerce" ) && class_exists( 'Theshopier_VC_Autocomplete' ) ) {
	
	class Theshopier_VC_Woocommerce extends Theshopier_VC_Autocomplete {
		
		private $vc_maps = array();

		function __construct(){
			if( Theshopier::checkPlugin('woocommerce/woocommerce.php') ) {
				$this->vc_maps = array(
					'theshopier_featured_products' 	=> false,
					'theshopier_recent_products'		=> false,
					'theshopier_sale_products'			=> array('cats'),
					'theshopier_best_selling_products'	=> false,
					'theshopier_product_tags'			=> array('tags'),
					'theshopier_product_cats'			=> array('cats'),
					'theshopier_top_rated_products'	=> false,
					'theshopier_products_category'		=> false,
					'theshopier_products_cats_tabs'	=> array('category'),
					'theshopier_products'				=> array('ids'),
					'theshopier_product_subcaterories'	=> array('cat_group_slug', 'slugs'),
					'theshopier_product_brands'		=> array('brand_group_slug'),
					'theshopier_featured_prod_cats'	=> array('slugs'),
					'theshopier_woo_single_cat'		=> array('slug'),
					'theshopier_woo_attributes'		=> array('slugs'),
					'theshopier_woo_cats'				=> array('cats_group_slug'),
				);
			}
			
			$this->init_maps();
		}
		
		public function init_maps(){
			if( count( $this->vc_maps ) > 0 ) {
				foreach( $this->vc_maps as $k => $v ){
					vc_map( call_user_func( __CLASS__ .'::'.$k ) );
					if( $v && is_array($v) ) {
						$base = array(
							'base'	=> $k,
							'params' => $v
						);
						$this->createAutoComplete($base);
					}
				}
			}
		}

		public static function fill_params($params = array()){
			$return = array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Heading", 'theshopier' ),
					"param_name" 	=> "title",
					"admin_label"	=> true,
					"value" 		=> "",
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
					"param_name" 	=> "box_style",
					"value" 		=> array(
						"Default"			=> "",
						"Header center"	=> "heading_center",
						"Boxed as widget"	=> "widget_boxed",
					),
					"edit_field_class"	=> 'vc_col-sm-6 vc_column'
				),

				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
					"param_name" 	=> "head_style",
					"value" 		=> array(
						"Default"			=> "",
						"Underline"			=> "ud-line",
						"Border bottom 1"		=> "border-bottom",
						"Border bottom 2"		=> "border-bottom-solid",
						"Border bottom Solid (4px)" => "border-bottom-solid line-4",
						"Top line"			=> "top-line",
					),
					"edit_field_class"	=> 'vc_col-sm-6 vc_column'
				),

				array(
					"type" 			=> "colorpicker",
					"heading" 		=> esc_html__( "Border color", 'theshopier' ),
					"param_name" 	=> "border_color",
					"dependency"	=> array("element" => "head_style", "value" => array('border-bottom', 'border-bottom-solid', 'border-bottom-solid line-4')),
					"edit_field_class"	=> 'vc_col-sm-6 vc_column'
				),

				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Content as Widget", 'theshopier' ),
					"param_name" 	=> "as_widget",
					"value" 		=> array(
						"No"	=> "0",
						"Yes"	=> "1",
					),
					"edit_field_class"	=> 'vc_col-sm-6 vc_column'
				)
			);
			foreach( $params as $param ){
				$return[] = $param;
			}

			return $return;
		}
		
		public static function tmpObj( $set = array(),$unset = array() ){
			$return = array(
				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Use Big Product", 'theshopier' ),
					"param_name" 	=> "is_biggest",
					"value" 		=> array(
						"No"	=> "0",
						"Yes"	=> "1",
					),
					"dependency"	=> array("element" => "as_widget", "value" => array('0')),
					"edit_field_class"	=> 'vc_col-sm-6 vc_column'
				),

				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Use slider", 'theshopier' ),
					"param_name" 	=> "is_slider",
					"value" 		=> array(
						"Yes"	=> "1",
						"No"	=> "0",
					),
					"dependency"	=> array("element" => "as_widget", "value" => array('0')),
					"edit_field_class"	=> 'vc_col-sm-6 vc_column'
				),

				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Product item style", 'theshopier' ),
					"param_name" 	=> "item_style",
					"value" 		=> array(
						"Grid"	=> "grid",
						"List"	=> "list",
					),
				),

				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Excerpt limit", 'theshopier' ),
					"param_name" 	=> "excerpt_limit",
					"value" 		=> "12",
					"dependency"	=> array( "element" => "item_style", "value" => array('list')),
				),

				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Auto play", 'theshopier' ),
					"param_name" 	=> "auto_play",
					"value" 		=> array(
						"No"	=> "0",
						"Yes"	=> "1"
					),
					"dependency"	=> array("element" => "is_slider", "value" => array('1'))
				),

				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Per Page", 'theshopier' ),
					"param_name" 	=> "per_page",
					"value" 		=> "12",
					"group"			=> "Woocommerce"
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Columns", 'theshopier' ),
					"param_name" 	=> "columns",
					"value" 		=> "4",
					"dependency"	=> array( "element" => "as_widget", "value" => array('0')),
					"group"	=> "Woocommerce"
				),
				
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order by', 'theshopier' ),
					'param_name' 	=> 'orderby',
					'value' 		=> parent::getOrderBy(),
					'description' 	=> sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					"group"			=> "Woocommerce"
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order way', 'theshopier' ),
					'param_name' 	=> 'order',
					'value' 		=> parent::getOrder(),
					'description' 	=> sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					"group"			=> "Woocommerce"
				),
			);

			$return = self::fill_params($return);
			
			if( count( $unset ) > 0 ) {
				foreach( $return as $k => $v ) {
					if( in_array( trim($v['param_name']), $unset ) ) {
						unset( $return[$k] );
					}
				}
			}

			if( !empty( $set ) ) {
				foreach($set as $arg){
					$_pos = !empty($arg['_pos'])? absint($arg['_pos']): 0;
					unset($arg['_pos']);
					array_splice($return, $_pos, 0, array($arg));
				}
			}

			return $return;
		}
		
		public static function theshopier_featured_products(){
			$return = array(
				"name" 		=> parent::getVars('rf') . esc_html__("Featured Products", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> self::tmpObj()
			);
			
			return $return;
		}
		
		public static function theshopier_recent_products(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Recent Products", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> self::tmpObj()
			);
		}
		
		public static function theshopier_sale_products(){
			$_var = parent::getVars('woo');
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Sale Products", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> self::tmpObj(
					array(
						array(
							'type' => 'autocomplete',
							'heading' => esc_html__( 'Categories', 'theshopier' ),
							'param_name' => 'cats',
							'admin_label'	=> true,
							'settings' => array(
								'multiple' => true,
								'sortable' => true,
							),
							'description' => $_var['autocomplete'],
							'_pos'		=> 3
						),
						array(
							"type" 			=> 'dropdown',
							"heading" 		=> esc_html__( 'Deal product', 'theshopier' ),
							"param_name" 	=> "is_deal",
							"value" 		=> array(
								"No"	=> "0",
								"Yes"	=> "1",
							),
							'_pos'		=> 4
						),
						array(
							"type" 			=> 'dropdown',
							"heading" 		=> esc_html__( 'Super Deal Style', 'theshopier' ),
							"param_name" 	=> "supper_style",
							"value" 		=> array(
								"No"	=> "0",
								"Yes"	=> "1",
							),
							"dependency"	=> array("element" => "is_deal", "value" => array('1')),
							'_pos'		=> 5
						)
					)
				)
			);
		}
		
		public static function theshopier_best_selling_products(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Best selling products", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> self::tmpObj( array(), array( 'orderby', 'order' ) )
			);
		}
		
		public static function theshopier_product_tags(){
			$tag_edit_link = add_query_arg( array( 'taxonomy' => 'product_tag', 'post_type' => 'product' ), admin_url( 'edit-tags.php' ) );
			return array(
				"name" => parent::getVars('rf') . esc_html__("Product Tags", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Title", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Title color', 'theshopier' ),
						'param_name' => 't_color',
						'value'		=> '#333333'
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Tags', 'theshopier' ),
						'param_name' => 'tags',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'description' => sprintf( wp_kses(__( 'Please make sure your tags were added in <a target="_blank" href="%s">here</a>', 'theshopier' ), array('a'=>array('target'=>array(), 'href'=>array()))), $tag_edit_link ) ,
					),
					
				),
			);
		}
		
		public static function theshopier_product_cats(){
			$_var = parent::getVars('woo');
			return array(
				"name" => parent::getVars('rf') . esc_html__("Product Categories", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Title", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Categories', 'theshopier' ),
						'param_name' => 'cats',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'description' => $_var['autocomplete'],
					),

					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Hover color', 'theshopier' ),
						'param_name' => 'hover_color',
						'value'		=> '#333333'
					),
				),
			);
		}
		
		public static function theshopier_top_rated_products(){
			return array(
				"name" => parent::getVars('rf') . esc_html__("Top rated products", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> self::tmpObj()
			);
		}
		
		public static function theshopier_products_category(){
			$_var = parent::getVars('woo');
			$_cats = parent::getCategories();
			$params = self::fill_params(array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Category', 'theshopier' ),
					'param_name' 	=> 'category',
					'value'			=> $_cats,
				),

				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Product item style", 'theshopier' ),
					"param_name" => "item_style",
					"value" => array(
						"Grid"		=> "grid",
						"List"		=> "list",
					),
				),
				array(
					"type" 			=> "dropdown",
					"heading" 		=> esc_html__( "Use slider", 'theshopier' ),
					"param_name" 	=> "is_slider",
					"value" 		=> array(
						"Yes"		=> "1",
						"No"		=> "0",
					),
					"dependency"	=> array("element" => "as_widget", "value" => array('0')),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__( "Excerpt limit", 'theshopier' ),
					"param_name" 	=> "excerpt_limit",
					"value" 		=> "12",
					"dependency"	=> array( "element" => "item_style", "value" => array('list')),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Per Page", 'theshopier' ),
					"param_name" => "per_page",
					"value" => "12",
					"group"	=> "Woocommerce"
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Columns", 'theshopier' ),
					"param_name" => "columns",
					"value" => "4",
					"dependency"	=> array(
						"element"	=> "as_widget",
						"value"		=> array('0')
					),
					"group"	=> "Woocommerce"
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'theshopier' ),
					'param_name' => 'orderby',
					'value' => parent::getOrderBy(),
					'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					"group"	=> "Woocommerce"
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order way', 'theshopier' ),
					'param_name' => 'order',
					'value' => parent::getOrder(),
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					"group"	=> "Woocommerce"
				),

			));
			return array(
				"name" => parent::getVars('rf') . esc_html__("Products Category", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> $params
			);
		}
		
		public static function theshopier_products_cats_tabs(){
			$_var = parent::getVars('woo');
			return array(
				"name" => parent::getVars('rf') . esc_html__("Products Categories - tab", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" 			=> "textfield",
						"heading" 		=> esc_html__( "Heading", 'theshopier' ),
						"param_name" 	=> "title",
						"admin_label"	=> true,
						"value" 		=> "",
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "h_style",
						"value" 		=> array(
							"Default"			=> "",
							"Underline"			=> "ud-line",
							"Border bottom"		=> "border-bottom",
							"Border bottom Solid"	=> "border-bottom-solid",
							"Border bottom Solid (4px)" 	=> "border-bottom-solid line-4",
							"Top line"			=> "top-line",
						),
					),
						
					array(
						'type' 			=> 'autocomplete',
						'heading' 		=> esc_html__( 'Category', 'theshopier' ),
						'param_name' 	=> 'category',
						'admin_label'	=> true,
						'settings' 		=> array(
							'multiple' 	=> true,
							'sortable' 	=> true,
						),
						'description' 	=> $_var['autocomplete'],
					),

					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Tabs style", 'theshopier' ),
						"param_name" => "tabs_style",
						"value" => array(
							"Style 1"		=> "",
							"Style 2"		=> "style-2",
						),
					),

					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Product item style", 'theshopier' ),
						"param_name" => "item_style",
						"value" => array(
							"Grid"		=> "grid",
							"List"		=> "list",
						),
					),
					array(
						"type" 			=> "textfield",
						"heading" 		=> esc_html__( "Excerpt limit", 'theshopier' ),
						"param_name" 	=> "excerpt_limit",
						"value" 		=> "12",
						"dependency"	=> array( "element" => "item_style", "value" => array('list')),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Use slider", 'theshopier' ),
						"param_name" => "is_slider",
						"value" => array(
							"Yes"	=> "1",
							"No"	=> "0",
						)
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Using ajax?", 'theshopier' ),
						"param_name" => "use_ajax",
						"value" => array(
							"Yes"		=> "1",
							"No"		=> "0",
						),
					),
						
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Limit", 'theshopier' ),
						"param_name" => "per_page",
						"value" => "12",
						"group"	=> "Woocommerce"
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value" => "4",
						"group"	=> "Woocommerce"
					),
						
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order by', 'theshopier' ),
						'param_name' => 'orderby',
						'value' => parent::getOrderBy(),
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						"group"	=> "Woocommerce"
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order way', 'theshopier' ),
						'param_name' => 'order',
						'value' => parent::getOrder(),
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						"group"	=> "Woocommerce"
					),
						
				),
			);
		}
		
		public static function theshopier_products(){
			$_var = parent::getVars('woo');

			$params = self::fill_params(array(
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Products', 'theshopier' ),
					'param_name' => 'ids',
					'admin_label'	=> true,
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
					),
					'description' => $_var['autocomplete'],
				),

				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Product item style", 'theshopier' ),
					"param_name" => "item_style",
					"value" => array(
						"Grid"		=> "grid",
						"List"		=> "list",
					),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Use slider", 'theshopier' ),
					"param_name" => "is_slider",
					"value" => array(
						"Yes"	=> "1",
						"No"	=> "0",
					),
					"dependency"	=> array(
						"element"	=> "as_widget",
						"value"		=> array('0')
					),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Excerpt limit", 'theshopier' ),
					"param_name" => "excerpt_limit",
					"value" => "12",
					"dependency"	=> array(
						"element"	=> "item_style",
						"value"		=> array('list')
					),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Columns", 'theshopier' ),
					"param_name" => "columns",
					"value" => "4",
					"dependency"	=> array(
						"element"	=> "as_widget",
						"value"		=> array('0')
					),
					"group"	=> "Woocommerce"
				),

				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order by', 'theshopier' ),
					'param_name' => 'orderby',
					'value' => parent::getOrderBy(),
					'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					"group"	=> "Woocommerce"
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Order way', 'theshopier' ),
					'param_name' => 'order',
					'value' => parent::getOrder(),
					'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					"group"	=> "Woocommerce"
				),
			));
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Products", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> $params
			);
		}

		public static function theshopier_product_subcaterories(){
			$_var = parent::getVars('woo');
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Product Sub Categories", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"		=> "",
							"Heading Center"	=> "heading_center",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "h_style",
						"value" 		=> array(
							"Default"			=> "",
							"Underline"			=> "ud-line",
							"Border bottom"		=> "border-bottom",
							"Border bottom Solid"	=> "border-bottom-solid",
							"Border bottom Solid (4px)" 	=> "border-bottom-solid line-4",
							"Top line"			=> "top-line",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "style",
						"value" 		=> array(
							"Default"				=> "style-1",
							"List style (2 row)"	=> "style-2 list 2-row",
						),
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Categories', 'theshopier' ),
						'param_name' => 'slugs',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'dependency'	=> array("element" => "style", "value" => array('style-2 list 2-row')),
						'description' => $_var['autocomplete']
					),

					array(
						'type' 			=> 'param_group',
						'heading' 		=> esc_html__( 'Categories', 'theshopier' ),
						'param_name' 	=> 'cat_group',
						'value'			=> urlencode( json_encode( array(
							array(
								'desc'		=> 'over %s products awaits you!'
							)
						))),
						'dependency'	=> array("element" => "style", "value" => array('style-1')),
						'params'		=> array(
							array(
								'type' => 'attach_image',
								'heading' => esc_html__( 'Background image', 'theshopier' ),
								'param_name' => 'bg_img',
							),
							array(
								'type' => 'autocomplete',
								'heading' => esc_html__( 'Category', 'theshopier' ),
								'param_name' => 'slug',
								'admin_label'	=> true,
								'settings' => array(
									'multiple' => false,
									'sortable' => false,
								),
								'description' => $_var['autocomplete'],
								'admin_label' 	=> true
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Description', 'theshopier' ),
								'param_name' 	=> 'desc',
								'description' => esc_html__( 'Ex: Over %s products awaits you!', 'theshopier' ),
								'admin_label' 	=> false
							)
						),
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value" => "3",
						"description"	=> $_var['columns_txt'],
						"group"	=> "Woocommerce"
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Limit", 'theshopier' ),
						"param_name" => "per_page",
						"value" => "3",
						"group"	=> "Woocommerce"
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order by', 'theshopier' ),
						'param_name' => 'orderby',
						'value' => parent::getOrderBy(),
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						"group"	=> "Woocommerce"
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order way', 'theshopier' ),
						'param_name' => 'order',
						'value' => parent::getOrder(),
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						"group"	=> "Woocommerce"
					),
				)
			);
		}

		public static function theshopier_product_brands(){
			$_var = parent::getVars('woo');
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Product Brands", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),

					array(
						'type' 			=> 'param_group',
						'heading' 		=> esc_html__( 'Product Brands', 'theshopier' ),
						'param_name' 	=> 'brand_group',
						'value'			=> urlencode( json_encode( array(
							array(
								'scr'		=> 'Up to 50% off'
							)
						))),
						'params'		=> array(
							array(
								'type' => 'attach_image',
								'heading' => esc_html__( 'Brand logo', 'theshopier' ),
								'param_name' => 'br_logo',
							),
							array(
								'type' => 'autocomplete',
								'heading' => esc_html__( 'Brand', 'theshopier' ),
								'param_name' => 'slug',
								'admin_label'	=> true,
								'settings' => array(
									'multiple' => false,
									'sortable' => false,
								),
								'description' => $_var['autocomplete'],
								'admin_label' 	=> true
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Description', 'theshopier' ),
								'param_name' 	=> 'scr',
								'admin_label' 	=> true
							)
						),
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value" => "4",
						"description"	=> $_var['columns_txt'],
						"group"	=> "Woocommerce"
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Limit", 'theshopier' ),
						"param_name" => "per_page",
						"value" => "4",
						"group"	=> "Woocommerce"
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order by', 'theshopier' ),
						'param_name' => 'orderby',
						'value' => parent::getOrderBy(),
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						"group"	=> "Woocommerce"
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order way', 'theshopier' ),
						'param_name' => 'order',
						'value' => parent::getOrder(),
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						"group"	=> "Woocommerce"
					),
				)
			);
		}

		public static function theshopier_featured_prod_cats(){
			$_var = parent::getVars('woo');
			return array(
				"name" => parent::getVars('rf') . esc_html__("Featured Categories", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"		=> "",
							"Heading Center"	=> "heading_center",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "h_style",
						"value" 		=> array(
							"Default"			=> "",
							"Underline"			=> "ud-line",
							"Border bottom"		=> "border-bottom",
							"Border bottom Solid"	=> "border-bottom-solid",
							"Border bottom Solid (4px)" 	=> "border-bottom-solid line-4",
							"Top line"			=> "top-line",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Categories', 'theshopier' ),
						'param_name' => 'slugs',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'description' => $_var['autocomplete'],
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Style", 'theshopier' ),
						"param_name" 	=> "style",
						"value" 		=> array(
							"Default"		=> "",
							"None Style"	=> "none-style",
							"Inside meta"	=> "inside-meta",
						)
					),

					array(
						"type" => "checkbox",
						"heading" => esc_html__( "Hidden mega cat", 'theshopier' ),
						"param_name" => "cat_fills",
						"value" => array(
							esc_html__('Hidden counting?', 'theshopier')	=> 'count',
							esc_html__('Hidden category link?', 'theshopier')	=> 'link',
						),
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value" => "4",
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Use slider", 'theshopier' ),
						"param_name" 	=> "is_slider",
						"value" 		=> array(
							"Yes"	=> "1",
							"No"	=> "0",
						)
					),
				),
			);
		}

		public static function theshopier_woo_single_cat(){
			$_var = parent::getVars('woo');
			return array(
				"name" => parent::getVars('rf') . esc_html__("Woo Single Category", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					/*array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Category', 'theshopier' ),
						'param_name' => 'slug',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => false,
							'sortable' => false,
						),
						'description' => $_var['autocomplete'],
					),*/
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Category', 'theshopier' ),
						'param_name' 	=> 'slug',
						'value'			=> parent::getCategories(),
					),
				),
			);
		}

		public static function theshopier_woo_attributes(){
			$_var = parent::getVars('woo');
			$attribute_array = array(esc_html__('--Select--', 'theshopier') => '');
			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {
					if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
						$key_attr = isset( $tax->attribute_label ) && strlen( $tax->attribute_label ) > 0 ? $tax->attribute_label: $tax->attribute_name;
						$attribute_array[ $key_attr ] = $tax->attribute_name;
					}
				}
			}

			return array(
				"name" => parent::getVars('rf') . esc_html__("Woo Attributes", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Attribute', 'theshopier' ),
						'param_name' => 'attribute',
						'value' => $attribute_array
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Columns', 'theshopier' ),
						'param_name' => 'columns',
						'value' => '6'
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Limit', 'theshopier' ),
						'param_name' => 'limit',
						'value' => '15'
					),
				),
			);
		}

		public static function theshopier_woo_cats(){
			$_var = parent::getVars('woo');
			$_cats = parent::getCategories();
			return array(
				"name" => parent::getVars('rf') . esc_html__("Woo Categories", 'theshopier' ),
				"base" => __FUNCTION__,
				"icon" => "nth-icon",
				"category" => parent::getVars('c1'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"		=> "",
							"Heading Center"	=> "heading_center",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "h_style",
						"value" 		=> array(
							"Default"			=> "",
							"Underline"			=> "ud-line",
							"Border bottom"		=> "border-bottom",
							"Border bottom Solid"	=> "border-bottom-solid",
							"Border bottom Solid (4px)" 	=> "border-bottom-solid line-4",
							"Top line"			=> "top-line",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						'type' 			=> 'param_group',
						'heading' 		=> esc_html__( 'Features', 'theshopier' ),
						'param_name' 	=> 'cats_group',
						'value'			=> '',
						'params'		=> array(
							array(
								'type' => 'autocomplete',
								'heading' => esc_html__( 'Category', 'theshopier' ),
								'param_name' => 'slug',
								'admin_label'	=> true,
								'settings' => array(
									'multiple' => false,
									'sortable' => false,
								),
								'description' => $_var['autocomplete'],
							),
							array(
								'type' => 'attach_image',
								'heading' => esc_html__( 'Category image', 'theshopier' ),
								'param_name' => 'cat_image',
							),
						),
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Button text", 'theshopier' ),
						"param_name" => "button_txt",
						"value" => "Show now",
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Shop all text", 'theshopier' ),
						"param_name" => "shop_all_text",
						"value" => "",
					),
				),
			);
		}
		
	}
	
	new Theshopier_VC_Woocommerce();
	
}
	


