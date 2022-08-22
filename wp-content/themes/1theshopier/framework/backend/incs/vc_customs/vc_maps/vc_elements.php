<?php
// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( "Theshopier_VC_Elements" ) && class_exists( 'Theshopier_VC_Autocomplete' ) ) {

	class Theshopier_VC_Elements extends Theshopier_VC_Autocomplete {

		private $vc_maps = array();

		function __construct(){

			$this->vc_maps = array(
				'theshopier_banner' 			=> false,
				'theshopier_brands'				=> false,
				'theshopier_infobox'			=> false,
				'theshopier_recent_posts'		=> false,
				'theshopier_pricing'			=> false,
				'theshopier_action'				=> false,
				'theshopier_maps'				=> false,
				'theshopier_button'				=> false,
				'theshopier_social'				=> false,
				'theshopier_instagram'			=> false,
				'theshopier_qrcode'				=> false,
				'theshopier_store_location'		=> false,
				'theshopier_tag_cloud'			=> false,
			);

			if( Theshopier::checkPlugin('nexthemes-plugin/nexthemes-plugin.php') ) {
				if( class_exists('Nexthemes_Portfolio') ) $this->vc_maps['theshopier_portfolio'] = array('cats');
			}

			if( class_exists( 'Nexthemes_StaticBlock' ) ) {
				$this->vc_maps['theshopier_staticblock'] = false;
			}

			if( class_exists( 'Nexthemes_TeamMembers' ) ) {
				$this->vc_maps['theshopier_teams'] = array('ids');
			}

			if( class_exists('Woothemes_Testimonials') ) {
				$this->vc_maps['theshopier_testimonials'] = array('ids');
			}
			
			if( class_exists('Woothemes_Features') ) {
				$this->vc_maps['theshopier_features'] = array('id');
			}

			if( Theshopier::checkPlugin('projects-by-woothemes/projects.php') ) {
				//$this->vc_maps['theshopier_project'] = array('id');
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

		public static function theshopier_banner(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Banners", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "vc_link",
						"heading" => esc_html__( "Banner Link", 'theshopier' ),
						"param_name" => "link",
						"value" => "#",
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Background image", 'theshopier' ),
						"param_name" => "bg_img",
						"value" => "",
					),
					array(
						"type" => "textarea_html",
						"heading" => esc_html__( "Cotent", 'theshopier' ),
						"param_name" => "content",
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Display Inline", 'theshopier' ),
						"param_name" => "class",
						"value" => array(
							"No"	=> '',
							"Yes"	=> 'pull-left',
						),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Hidden on?", 'theshopier' ),
						"param_name" => "hidden_on",
						"value" => array(
							"None"	=> '',
							"Tablet Medium"	=> 'hidden-md hidden-sm hidden-xs',
							"Tablet Small"	=> 'hidden-sm hidden-xs',
							"Mobile"		=> 'hidden-xs',
						),
					),
					array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'Css', 'theshopier' ),
						'param_name' => 'css',
						'group' => esc_html__( 'Design options', 'theshopier' ),
					),
				)
			);
		}

		public static function theshopier_brands(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Brands", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Heading", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "title",
						"value" => "",
						"description" => '',
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "h_style",
						"value" 		=> array(
							"Default"				=> "",
							"Underline"				=> "ud-line",
							"Border bottom"			=> "border-bottom",
							"Border bottom Solid" 	=> "border-bottom-solid",
							"Border bottom Solid (4px)" 	=> "border-bottom-solid line-4",
							"Top line"				=> "top-line",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Style", 'theshopier' ),
						"param_name" 	=> "style",
						"value" 		=> array(
							"Default"			=> "",
							"None shashow"		=> "none-shadow"
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "attach_images",
						"class" => "",
						"heading" => esc_html__("Brand images", 'theshopier' ),
						"param_name" => "imgs",
						"description" => ''
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Columns", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "column",
						"value" => "6",
					),
					array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'Css', 'theshopier' ),
						'param_name' => 'css',
						'group' => esc_html__( 'Design options', 'theshopier' ),
					),
				)
			);
		}

		public static function theshopier_infobox(){
			$group_1 = esc_html__( 'Icon options', 'theshopier' );
			$group_2 = esc_html__( 'Color options', 'theshopier' );

			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Infobox", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Title", 'theshopier' ),
						"param_name" => "title",
						"value" => "Title",
					),
					array(
						"type" => "textarea",
						"heading" => esc_html__( "Description", 'theshopier' ),
						"param_name" => "desc",
						"value" => "",
					),

					// Icon options
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Use icon?', 'theshopier' ),
						'value' => array(
							"Yes" => 'yes',
							"No" => 'no',
						),
						'param_name' => 'use_icon',
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon library', 'theshopier' ),
						'value' => array(
							esc_html__( 'Font Awesome', 'theshopier' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'theshopier' ) => 'openiconic',
							esc_html__( 'Typicons', 'theshopier' ) => 'typicons',
							esc_html__( 'Entypo', 'theshopier' ) => 'entypo',
							esc_html__( 'Linecons', 'theshopier' ) => 'linecons',
							esc_html__( 'Icon Image', 'theshopier' ) => 'icon_img',
						),
						'admin_label' => true,
						'param_name' => 'type',
						'description' => esc_html__( 'Select icon library.', 'theshopier' ),
						"dependency" => array('element' => "use_icon", 'value' => array('yes')),
						'group'		=> $group_1,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'icon_fontawesome',
						'value' => 'fa fa-adjust',
						'settings' => array(
							'emptyIcon' => false,
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'fontawesome',
						),
						'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
						'group'		=> $group_1,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'icon_openiconic',
						'value' => 'vc-oi vc-oi-dial',
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'openiconic',
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'openiconic',
						),
						'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
						'group'		=> $group_1,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'icon_typicons',
						'value' => 'typcn typcn-adjust-brightness',
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'typicons',
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'typicons',
						),
						'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
						'group'		=> $group_1,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'icon_entypo',
						'value' => 'entypo-icon entypo-icon-note',
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'entypo',
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'entypo',
						),
						'group'		=> $group_1,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'icon_linecons',
						'value' => 'vc_li vc_li-heart',
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'linecons',
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'type',
							'value' => 'linecons',
						),
						'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
						'group'		=> $group_1,
					),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Icon image', 'theshopier' ),
						'param_name' => 'icon_img',
						'value' => '',
						'dependency' => array(
							'element' => 'type',
							'value' => 'icon_img',
						),
						'description' => esc_html__( 'Select icon from media.', 'theshopier' ),
						'group'		=> $group_1,
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Background Style', 'theshopier' ),
						'param_name' => 'background_style',
						'value' => array(
							esc_html__( 'Circle', 'theshopier' ) => 'rounded',
							esc_html__( 'Square', 'theshopier' ) => 'boxed',
							esc_html__( 'Rounded', 'theshopier' ) => 'rounded-less',
						),
						'description' => esc_html__( 'Background style for icon.', 'theshopier' ),
						'group'		=> $group_1,
					),

					/**
					 * COLOR OPTION
					 */
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Color', 'theshopier' ),
						'param_name' => 'color',
						'value' => Theshopier_VC_Autocomplete::getColors(1),
						'description' => esc_html__( 'Infobox color.', 'theshopier' ),
						'param_holder_class' => 'vc_colored-dropdown',
						'group'		=> $group_2,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Custom Color', 'theshopier' ),
						'param_name' => 'custom_color',
						'description' => esc_html__( 'Select custom color.', 'theshopier' ),
						'dependency' => array(
							'element' => 'color',
							'value' => 'custom',
						),
						'group'		=> $group_2,
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon backgound', 'theshopier' ),
						'param_name' => 'icon_background',
						'value' => Theshopier_VC_Autocomplete::getColors(1),
						'std' => 'grey',
						'description' => esc_html__( 'Background Color.', 'theshopier' ),
						'param_holder_class' => 'vc_colored-dropdown',
						'group'		=> $group_2,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Custom icon backgound', 'theshopier' ),
						'param_name' => 'custom_icon_background',
						'description' => esc_html__( 'Select custom icon backgound.', 'theshopier' ),
						'dependency' => array(
							'element' => 'icon_background',
							'value' => 'custom',
						),
						'group'		=> $group_2,
					),
				)
			);
		}

		public static function theshopier_portfolio(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Portfolio", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Style", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "style",
						"value" => array(
							'Default' 			=> '',
							'By list Categories' 	=> 'cats'
						)
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Portfolio Cats', 'theshopier' ),
						'param_name' => 'cats',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'description' => esc_html__( 'Please type [name], [slug] or [id] of Portfolio.', 'theshopier' ),
						"dependency"	=> array( 'element' => 'style', 'value'	=> array('cats') )
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Filter align", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "filter_alight",
						"value" => array(
							'Default' 		=> '',
							'Left' 			=> 'text-left',
							'Center' 		=> 'text-center',
							'Right' 		=> 'text-right',
						),
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),

					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Filter Style", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "filter_style",
						"value" => array(
							'Default' 		=> '',
							'Round' 		=> 'round',
						),
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),


					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Content style", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "tab_cont_style",
						"value" => array(
							'Default' 			=> '',
							'Big first item' 	=> 'big_item'
						),
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),

					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Columns", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "columns",
						"value" => '4',
						"description" => '',
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => esc_html__("Per Page", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "limit",
						"value" => '-1',
						"description" => '',
						"edit_field_class"	=> 'vc_col-sm-3 vc_column'
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Show Filter", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "filter_s",
						"value" => array(
							'Yes' => '1',
							'No' => '0'
						),
						"edit_field_class"	=> 'vc_col-sm-3 vc_column'
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Show Title", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "title_s",
						"value" => array(
							'Yes' => '1',
							'No' => '0'
						),
						"edit_field_class"	=> 'vc_col-sm-3 vc_column'
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__("Show Excerpt", 'theshopier' ),
						"admin_label" => true,
						"param_name" => "desc_s",
						"value" => array(
							'Yes' => '1',
							'No' => '0'
						),
						"edit_field_class"	=> 'vc_col-sm-3 vc_column'
					),
				)
			);
		}

		public static function theshopier_recent_posts(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Recent posts", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "head_style",
						"value" 		=> array(
							"Default"			=> "",
							"Underline"	=> "ud-line",
							"Top line"	=> "top-line",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Limit", 'theshopier' ),
						"param_name" => "limit",
						"value"		=> '5'
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Excerpt Limit", 'theshopier' ),
						"param_name" => "excerpt_words",
						"value"		=> '15'
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'theshopier' ),
						'param_name' => 'style',
						'value' => array(
							esc_html__('Normal', 'theshopier' ) 	=> '',
							esc_html__('List', 'theshopier' )	=> 'list',
							esc_html__('Grid', 'theshopier' )	=> 'grid',
							esc_html__('Grid style 2', 'theshopier' )	=> 'grid bt_link_style',
							esc_html__('Grid style 3', 'theshopier' )	=> 'grid grid_style_3',
							esc_html__('Grid Overflow', 'theshopier' )	=> 'grid overflow'
						),
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value"		=> '1',
						"dependency"	=> array( 'element' => 'style', 'value'	=> array('grid', 'grid overflow', 'grid bt_link_style', 'grid grid_style_3') )
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order by', 'theshopier' ),
						'param_name' => 'orderby',
						'default'	=> '',
						'value' => parent::getOrderBy( array('comment_count', 'modified', 'menu_order') ),
						'description' => sprintf( esc_html__( 'Select how to sort retrieved products. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order way', 'theshopier' ),
						'param_name' => 'order',
						'value' => parent::getOrder(),
						'description' => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'theshopier' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					),

					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show cats', 'theshopier' ),
						'param_name' => 's_cats',
						'value' => array(
							'Yes'	=> '1',
							'No'	=> '0'
						),
						'group'	=> parent::getVars('c3'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show Author', 'theshopier' ),
						'param_name' => 's_author',
						'value' => array(
							'No'	=> '0',
							'Yes'	=> '1'
						),
						'group'	=> parent::getVars('c3'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show excerpt', 'theshopier' ),
						'param_name' => 's_excerpt',
						'value' => array(
							'Yes'	=> '1',
							'No'	=> '0'
						),
						'group'	=> parent::getVars('c3'),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Show read more', 'theshopier' ),
						'param_name' => 's_button',
						'value' => array(
							'Yes'	=> '1',
							'No'	=> '0'
						),
						'group'	=> parent::getVars('c3'),
					),
				)
			);
		}

		public static function theshopier_staticblock(){
			$static_blocks = Nexthemes_StaticBlock::getStaticBlocks();

			$pr_args = array();

			if( count( $static_blocks ) > 0 ) {
				foreach( $static_blocks as $val ){
					$pr_args[$val['title']] = $val['slug'];
				}
			}

			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Static Block", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Static block", 'theshopier' ),
						"param_name" => "id",
						"value" => $pr_args,
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Display", 'theshopier' ),
						"param_name" => "style",
						"value" => array(
							'Normal'	=> '',
							'As grid'	=> 'grid'
						),
					),
				),
			);
		}

		public static function theshopier_teams(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Team Member", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
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
							"Default"			=> "",
							"Header center"	=> "heading_center",
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
						'heading' => esc_html__( 'Members', 'theshopier' ),
						'param_name' => 'ids',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'description' => esc_html__( 'Please type [name], [slug] or [id] of Team Members.', 'theshopier' ),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Style", 'theshopier' ),
						"param_name" => "style",
						"value" => array(
							'Default'	=> '',
							'Bounce'	=> 'bounce',
							'Overlay'	=> 'overlay',
							'Overlay 2 (no padding)' => 'overlay-2 no-padding',
						),
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value" => '4',
					),

					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Use Slider?", 'theshopier' ),
						"param_name" => "is_slider",
						"value" => array(
							'No'	=> '',
							'Yes'	=> 'yes',
						),
					),
				)
			);
		}

		public static function theshopier_testimonials(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Testimonials", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
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
							"Default"			=> "",
							"Header center"	=> "heading_center",
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
						"type" 			=> "checkbox",
						"heading" 		=> esc_html__( "Use slider?", 'theshopier' ),
						"param_name" 	=> "use_slider",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column',
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Style", 'theshopier' ),
						"param_name" 	=> "style",
						"value" 		=> array(
							"Default"			=> "def",
							"Style 01"			=> "1",
							"Style 02"			=> "2"
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column',
					),

					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Testimonial', 'theshopier' ),
						'param_name' => 'ids',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => true,
							'sortable' => true,
						),
						'description' => esc_html__( 'Please type [name], [slug] or [id] of testimonials.', 'theshopier' ),
					)
				)
			);
		}
		
		public static function theshopier_pricing(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Pricing", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"admin_label"	=> true,
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Label", 'theshopier' ),
						"param_name" => "label",
						"value" => array(
							'Normal'	=> '',
							'Popular'	=> 'popular'
						),
					),
					array(
						"type" 			=> "textfield",
						"heading" 		=> esc_html__( "Label text", 'theshopier' ),
						"param_name" 	=> "label_text",
						"value" 		=> "Most Popular",
						"dependency"	=> array( 'element' => 'label', 'not_empty'	=> true )
					),
					array(
						'type' 			=> 'textfield',
						'heading' 		=> esc_html__( 'Pricing', 'theshopier' ),
						'param_name' 	=> 'price',
						'value'			=> '$|11.99|mo',
						"description"	=> esc_html__('Ex: $|11.99|mo, Free|30 days', 'theshopier')
					),
					array(
						'type' 			=> 'textarea',
						'heading' 		=> esc_html__( 'Description', 'theshopier' ),
						'param_name' 	=> 'desc',
						'value'			=> '',
					),
					array(
						'type' 			=> 'param_group',
						'heading' 		=> esc_html__( 'Features', 'theshopier' ),
						'param_name' 	=> 'features',
						'value'			=> urlencode( json_encode( array(
							array(
								'title'		=> esc_attr__('Pack feature here...', 'theshopier')
							),
							array(
								'title'		=> esc_attr__('Pack feature here...', 'theshopier'),
								'tooltip'	=> esc_attr__('Tooltip goes here...', 'theshopier')
							),
							array(
								'title'		=> esc_attr__('Pack feature here...', 'theshopier')
							)
						))),
						'params'		=> array(
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Title', 'theshopier' ),
								'param_name' 	=> 'title',
								'admin_label' 	=> true
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Tooltip content', 'theshopier' ),
								'param_name' 	=> 'tooltip',
								'admin_label' 	=> true
							),
						),
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Button text", 'theshopier' ),
						"param_name" => "bt_text",
						"value" => "Buy now",
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__( "Button link", 'theshopier' ),
						"param_name" => "bt_link",
						"value" => "",
					),
					
				)
			);
		}
		
		public static function theshopier_action(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Action", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Label", 'theshopier' ),
						"param_name" => "label",
						"value" => "",
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Button text", 'theshopier' ),
						"param_name" => "bt_text",
						"value" => "",
					),
					array(
						"type" => "vc_link",
						"heading" => esc_html__( "Button link", 'theshopier' ),
						"param_name" => "bt_link",
						"value" => "",
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Use icon?', 'theshopier' ),
						'value' => array(
							"Yes" => '1',
							"No" => '0',
						),
						'param_name' => 'use_icon',
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'bt_icon',
						'value' => 'fa fa-adjust',
						'settings' => array(
							'emptyIcon' => false,
							'iconsPerPage' => 4000,
						),
						'dependency' => array(
							'element' => 'use_icon',
							'value' => '1',
						),
						'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
						'group'		=> 'Icon options',
					),
				)
			);
		}
		
		public static function theshopier_maps(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Google maps", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "place_autocomplete",
						"heading" => esc_html__( "Your Addpress", 'theshopier' ),
						"param_name" => "address",
						"admin_label"	=> true,
						"value" => "",
						"description"	=> esc_html__('Please type your address here.', 'theshopier')
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Style", 'theshopier' ),
						"param_name" => "style",
						"value" => array(
							'Normal'		 => '',
							'Facebook' 		=> 'facebook',
							'Gray' 			=> 'gray',
							'Light Gray' 	=> 'lightgray',
							'Custom color'	=> 'custom_color'
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "textarea_raw_html",
						"heading" => esc_html__( "Map style JSON data", 'theshopier' ),
						"param_name" => "m_color",
						"value" => "JTVCJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJhZG1pbmlzdHJhdGl2ZS5jb3VudHJ5JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJsYWJlbHMlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIybGFuZHNjYXBlLm5hdHVyYWwubGFuZGNvdmVyJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyY29sb3IlMjIlM0ElMjAlMjIlMjNlYmU3ZDMlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMmxhbmRzY2FwZS5tYW5fbWFkZSUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJmZWF0dXJlVHlwZSUyMiUzQSUyMCUyMndhdGVyJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJnZW9tZXRyeS5maWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmNvbG9yJTIyJTNBJTIwJTIyJTIzODY5M2EzJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJyb2FkLmFydGVyaWFsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIycm9hZC5sb2NhbCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJjb2xvciUyMiUzQSUyMCUyMiUyM2ViZTdkMyUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIyYWRtaW5pc3RyYXRpdmUubmVpZ2hib3Job29kJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9uJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJwb2klMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJlbGVtZW50VHlwZSUyMiUzQSUyMCUyMmFsbCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnN0eWxlcnMlMjIlM0ElMjAlNUIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0IlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJ2aXNpYmlsaXR5JTIyJTNBJTIwJTIyb2ZmJTIyJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdEJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTVEJTBBJTIwJTIwJTIwJTIwJTdEJTJDJTBBJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZmVhdHVyZVR5cGUlMjIlM0ElMjAlMjJ0cmFuc2l0JTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyZWxlbWVudFR5cGUlMjIlM0ElMjAlMjJhbGwlMjIlMkMlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjJzdHlsZXJzJTIyJTNBJTIwJTVCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTdCJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIydmlzaWJpbGl0eSUyMiUzQSUyMCUyMm9mZiUyMiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3RCUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU1RCUwQSUyMCUyMCUyMCUyMCU3RCUyQyUwQSUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmZlYXR1cmVUeXBlJTIyJTNBJTIwJTIycm9hZCUyMiUyQyUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMmVsZW1lbnRUeXBlJTIyJTNBJTIwJTIyYWxsJTIyJTJDJTBBJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIwJTIyc3R5bGVycyUyMiUzQSUyMCU1QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCU3QiUwQSUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMCUyMnZpc2liaWxpdHklMjIlM0ElMjAlMjJvZmYlMjIlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlN0QlMEElMjAlMjAlMjAlMjAlMjAlMjAlMjAlMjAlNUQlMEElMjAlMjAlMjAlMjAlN0QlMEElNUQ=",
						"dependency" => array('element' => 'style', 'value' => array('custom_color')),
						"description"	=> sprintf( esc_html__('You can get Map style JSON data in %1$sMapStylr%2$s', 'theshopier'), '<a target="_blank" href="http://www.mapstylr.com/showcase/">', '</a>' )
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Zoom", 'theshopier' ),
						"param_name" => "zoom",
						"value" => "16",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Height", 'theshopier' ),
						"param_name" => "height",
						"value" => "450px",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__( "Marker icon", 'theshopier' ),
						"param_name" => "mk_icon",
						"value" => "",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "textarea_html",
						"heading" => esc_html__( "Widget content", 'theshopier' ),
						"param_name" => "content",
						"value" => "Your description!",
					),
					Theshopier_VC_Autocomplete::getVars('css_editor')
				)
			);
		}
		
		public static function theshopier_table(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Table", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"as_parent" => array('only' => 'theshopier_table_row'),
				"content_element" => true,
				"show_settings_on_create" => false,
				"params"	=> array(
					array(
						'type' 			=> 'textfield',
						'heading' 		=> esc_html__( 'Heading', 'theshopier' ),
						'param_name' 	=> 'title',
					),
				),
				"js_view" => 'VcColumnView'
			);
		}
		
		public static function theshopier_table_row(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Table row", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"as_child"					=> array('only' => 'theshopier_table'),
				"content_element"			=> true,
				"params"	=> array(
					array(
						'type'			=> 'checkbox',
						'heading' 		=> esc_html__( 'Table heading', 'theshopier' ),
						'param_name' 	=> 'heading',
						'value'			=> array( esc_html__('Use this row as table heading?', 'theshopier') => '1' ),
						'admin_label'	=> true
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Row style', 'theshopier' ),
						'param_name' => 'color',
						'value' => array(
							esc_html__('-None-', 'theshopier' ) 	=> '',
							esc_html__('Active', 'theshopier' )		=> 'active',
							esc_html__('Success', 'theshopier' ) 	=> 'success',
							esc_html__('Info', 'theshopier' ) 		=> 'info',
							esc_html__('Warning', 'theshopier' ) 	=> 'warning',
							esc_html__('Danger', 'theshopier' ) 	=> 'danger'
						),
						'param_holder_class' => 'vc_colored-dropdown'
					),
					array(
						'type' 			=> 'param_group',
						'heading' 		=> esc_html__( 'Cells', 'theshopier' ),
						'param_name' 	=> 'cells',
						'value'			=> urlencode( json_encode( array(
							array(
								'colspan'	=> '1',
								'value'		=> esc_attr__('Pack feature here...', 'theshopier')
							)
						))),
						'params'		=> array(
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Colspan', 'theshopier' ),
								'param_name' 	=> 'colspan',
								'admin_label'	=> true,
								'value'			=> '1',
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Value', 'theshopier' ),
								'param_name' 	=> 'value',
								'admin_label'	=> true
							)
						),
					),
				)
			);
		}
		
		public static function theshopier_features(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Features", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"admin_label"	=> true,
						"value" => ""
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
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
						"type" => "dropdown",
						"heading" => esc_html__( "Features style", 'theshopier' ),
						"param_name" => "style",
						"value" => array(
							'Normal'	=> '',
							'Center'	=> 'text-center',
							'Icon left' => 'icon-left'
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Inside style", 'theshopier' ),
						"param_name" => "use_boxed",
						"value" => array(
							'No'	=> '0',
							'Yes'	=> '1'
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Simple features", 'theshopier' ),
						"param_name" => "simple",
						"value" => array(
							'No'	=> '0',
							'Yes'	=> '1'
						),
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Per Row", 'theshopier' ),
						"param_name" => "per_row",
						"admin_label"	=> true,
						"edit_field_class"	=> 'vc_col-sm-4 vc_column',
						"value" => "3"
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Limit", 'theshopier' ),
						"param_name" => "limit",
						"admin_label"	=> true,
						"value" => "5",
						"edit_field_class"	=> 'vc_col-sm-4 vc_column',
						"dependency"	=> array('element' => 'simple', 'value' => array('0'))
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Features id', 'theshopier' ),
						'param_name' => 'id',
						'admin_label'	=> true,
						'settings' => array(
							'multiple' => false,
							'sortable' => false,
						),
						'description' => esc_html__( 'Please type [name], [slug] or [id] of Fatures.', 'theshopier' ),
						"dependency"	=> array('element' => 'simple', 'value' => array('1'))
					),

					array(
						"type" => "textfield",
						"heading" => esc_html__( "Excerpt limit", 'theshopier' ),
						"param_name" => "w_limit",
						"admin_label"	=> true,
						"value" => "-1"
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Icon Size", 'theshopier' ),
						"param_name" => "size",
						"admin_label"	=> true,
						"value" => "150",
					),
					array(
						"type" 			=> "checkbox",
						"heading" 		=> esc_html__( "Show the excerpt?", 'theshopier' ),
						"param_name" 	=> "s_excerpt",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column',
					),
					array(
						"type" 			=> "checkbox",
						"heading" 		=> esc_html__( "Show learn more link?", 'theshopier' ),
						"param_name" 	=> "learn_more",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column',
					),

					array(
						"type" 		=> "colorpicker",
						"heading" 	=> esc_html__( "Title Color", 'theshopier' ),
						"param_name" => "t_color",
						"value" 	=> "",
						"group"		=> esc_attr__('Color & filter', 'theshopier')
					),
					array(
						"type" 				=> "colorpicker",
						"heading" 			=> esc_html__( "Excerpt Color", 'theshopier' ),
						"param_name" 		=> "color",
						"value" 			=> "",
						"dependency"		=> array('element' => 's_excerpt', 'value' => array('true')),
						"group"				=> esc_attr__('Color & filter', 'theshopier'),
					),
					array(
						"type" 		=> "colorpicker",
						"heading" 	=> esc_html__( "Link Color", 'theshopier' ),
						"param_name" => "l_color",
						"dependency" => array('element' => 'learn_more', 'value' => array('true')),
						"group"		=> esc_attr__('Color & filter', 'theshopier'),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column',
					),
					array(
						"type" 		=> "textfield",
						"heading" 	=> esc_html__( "Link text", 'theshopier' ),
						"param_name" => "l_text",
						"value"		=> "Learn more",
						"dependency" => array('element' => 'learn_more', 'value' => array('true')),
						"group"		=> esc_attr__('Color & filter', 'theshopier'),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column',
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon', 'theshopier' ),
						'param_name' => 'icon',
						'value' => 'fa fa-long-arrow-right',
						'settings' => array(
							'emptyIcon' => false,
							'iconsPerPage' => 4000,
						),
						"dependency" => array('element' => 'learn_more', 'value' => array('true')),
						'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
						"group"		=> esc_attr__('Color & filter', 'theshopier')
					),
				)
			);
		}

		public static function theshopier_button(){
			$params = array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Button text', 'theshopier' ),
					'param_name' 	=> 'text',
					"admin_label"	=> true,
					"value" 		=> esc_html__('Button text', 'theshopier')
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button style', 'theshopier' ),
					'param_name' 	=> 'style',
					'value' 		=> array(
						'Default'		=> '',
						'Effect'		=> 'effect',
						'Outline'		=> 'outline',
						'Gradient'		=> 'gradient',
						'3D Style'		=> 'threed'
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Background color style', 'theshopier' ),
					'param_name' 	=> 'bgcl_style',
					'value' 		=> array(
						'Default'		=> '',
						'Primary'		=> 'primary',
						'Success'		=> 'success',
						'Error'			=> 'danger',
						'Custom Color'	=> 'custom_color'
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Custom Color', 'theshopier' ),
					'param_name' => 'bg_color',
					'value'		=> '#cccccc',
					'dependency' => array(
						'element' => 'bgcl_style',
						'value' => 'custom_color',
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Button color', 'theshopier' ),
					'param_name' => 'color',
					'value'		=> '',
					'dependency' => array(
						'element' => 'bgcl_style',
						'value' => 'custom_color',
					)
				),
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Border color', 'theshopier' ),
					'param_name' => 'border_color',
					'value'		=> '#cccccc',
					'dependency' => array(
						'element' => 'style',
						'value' => 'outline',
					)
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button size', 'theshopier' ),
					'param_name' 	=> 'size',
					'value' 		=> array(
						'Small size'		=> '',
						'Medium size'		=> 'medium',
						'Large size'		=> 'large'
					)
				),
				array(
					"type" => "checkbox",
					"heading" => esc_html__( "Use icon", 'theshopier' ),
					"param_name" => "use_icon",
					"value" => array( esc_html__('Button with icon.', 'theshopier') => '1' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'theshopier' ),
					'param_name' => 'icon_fontawesome',
					'value' => 'fa fa-adjust',
					'settings' => array(
						'emptyIcon' => false,
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'use_icon',
						'not_empty' => true,
					),
					'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
				),
			);
			array_push($params, parent::getVars('el_class'));
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Button", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> $params
			);
		}

		public static function theshopier_social(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Social network", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"admin_label"	=> true,
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
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
						'heading' 		=> esc_html__( 'Social', 'theshopier' ),
						'param_name' 	=> 'item',
						'value'			=> urlencode( json_encode( array(
							array(
								'icon'		=> 'fa fa-facebook-square',
								'link'		=> '#',
								'title'		=> 'facebook'
							),
							array(
								'icon'		=> 'fa fa-google-plus-square',
								'link'		=> '#',
								'title'		=> 'Google plug'
							),
						))),
						'params'		=> array(
							array(
								'type' => 'iconpicker',
								'heading' => esc_html__( 'Icon', 'theshopier' ),
								'param_name' => 'icon',
								'value' => 'fa fa-adjust',
								'settings' => array(
									'emptyIcon' => false,
									'iconsPerPage' => 4000,
								),
								'description' => esc_html__( 'Select icon from library.', 'theshopier' ),
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Title', 'theshopier' ),
								'param_name' 	=> 'title',
								'admin_label'	=> true,
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Link', 'theshopier' ),
								'param_name' 	=> 'link'
							),
							array(
								'type' 			=> 'colorpicker',
								'heading' 		=> esc_html__( 'Color', 'theshopier' ),
								'param_name' 	=> 'color',
								'value'			=> '#ff0000'
							),
						),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Apply color hover", 'theshopier' ),
						"param_name" => "color_hover",
						"value" => array(
							'No'		=> '0',
							'Yes' 		=> '1',
						),
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__( "Icon size", 'theshopier' ),
						"param_name" => "ic_size",
						"value" => array(
							'Normal'		 => '',
							'1x' 		=> 'fa-1x',
							'2x' 		=> 'fa-2x',
							'3x' 		=> 'fa-3x',
							'4x'		=> 'fa-4x'
						),
					),
					array(
						"type" => "textfield",
						"admin_label"	=> true,
						"heading" => esc_html__( "Extra class name", 'theshopier' ),
						"param_name" => "class",
					),
				)
			);
		}

		public static function theshopier_instagram(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Instagram", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"admin_label"	=> true,
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "title",
						"value" => "",
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Heading style", 'theshopier' ),
						"param_name" 	=> "h_style",
						"value" 		=> array(
							"Default"			=> "",
							"Underline"	=> "ud-line",
							"Border bottom"		=> "border-bottom",
							"Border bottom Solid"	=> "border-bottom-solid",
							"Border bottom Solid (4px)" 	=> "border-bottom-solid line-4",
							"Top line"	=> "top-line",
						),
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Limit", 'theshopier' ),
						"param_name" => "limit",
						"value" => '6'
					),
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Columns", 'theshopier' ),
						"param_name" => "columns",
						"value" => '6'
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Image size", 'theshopier' ),
						"param_name" 	=> "image_size",
						"value" 		=> array(
							"Thumbnail"			=> "thumbnail",
							"Low resolution"	=> "low_resolution",
							"Standard resolution"	=> "standard_resolution",
						)
					)
				)
			);
		}

		public static function theshopier_qrcode(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("QR_Code", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" 			=> "textfield",
						"admin_label"	=> true,
						"heading" 		=> esc_html__( "Data", 'theshopier' ),
						"param_name" 	=> "data",
						"value" 		=> "",
					),
					array(
						"type" 			=> "textfield",
						"admin_label"	=> true,
						"heading" 		=> esc_html__( "Data", 'theshopier' ),
						"param_name" 	=> "size",
						"value" 		=> "270x270",
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),
					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "ecc",
						"value" 		=> array(
							"L"			=> "L",
							"M"			=> "M",
							"Q"			=> "Q",
							"H"			=> "H",
						),
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),
					array(
						"type" 			=> "textfield",
						"admin_label"	=> true,
						"heading" 		=> esc_html__( "Margin", 'theshopier' ),
						"param_name" 	=> "margin",
						"value" 		=> "0",
						"edit_field_class"	=> 'vc_col-sm-4 vc_column'
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Color', 'theshopier' ),
						'param_name' 	=> 'color',
						'value'			=> '000000',
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Bg Color', 'theshopier' ),
						'param_name' 	=> 'bgcolor',
						'value'			=> 'ffffff',
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
				)
			);
		}

		public static function theshopier_store_location(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Store Location", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" 			=> "textfield",
						"heading" 		=> esc_html__( "Heading", 'theshopier' ),
						"param_name" 	=> "heading",
						"value" 		=> "",
						"admin_label" 	=> true
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
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
						'heading' 		=> esc_html__( 'Store', 'theshopier' ),
						'param_name' 	=> 'stores',
						'params'		=> array(
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Store Name', 'theshopier' ),
								'param_name' 	=> 'name',
								'admin_label' 	=> true
							),
							array(
								'type' 			=> 'place_autocomplete',
								'heading' 		=> esc_html__( 'Store address', 'theshopier' ),
								'param_name' 	=> 'address',
							),
							array(
								'type' => 'vc_link',
								'heading' => esc_html__( "Store link", 'theshopier' ),
								'param_name' => 'link',
								'value' => 'url:#|title:' . esc_attr('More infomation', 'theshopier'),
								'edit_field_class'	=> 'vc_col-sm-8 vc_column'
							),
							array(
								'type' 			=> 'textfield',
								'heading' 		=> esc_html__( 'Zoom', 'theshopier' ),
								'param_name' 	=> 'zoom',
								'edit_field_class'	=> 'vc_col-sm-4 vc_column',
								'value'			=> '15'
							),
							array(
								'type' 			=> 'param_group',
								'heading' 		=> esc_html__( 'Store infomation', 'theshopier' ),
								'param_name' 	=> 'infos',
								'params'		=> array(
									array(
										'type' 			=> 'textfield',
										'heading' 		=> esc_html__( 'Line', 'theshopier' ),
										'param_name' 	=> 'line',
										'admin_label' 	=> true
									),
								),
							),
						),
					),
					array(
						"type" 				=> "textfield",
						"heading" 			=> esc_html__( "Map image size", 'theshopier' ),
						"param_name" 		=> "map_size",
						"value" 			=> "270x170",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
					array(
						"type" 				=> "textfield",
						"heading" 			=> esc_html__( "Columns", 'theshopier' ),
						"param_name" 		=> "columns",
						"value" 			=> "4",
						"edit_field_class"	=> 'vc_col-sm-6 vc_column'
					),
				)
			);
		}

		public static function theshopier_tag_cloud(){
			return array(
				"name" 		=> parent::getVars('rf') . esc_html__("Tag Cloud", 'theshopier' ),
				"base" 		=> __FUNCTION__,
				"icon" 		=> "nth-icon",
				"category" 	=> parent::getVars('c2'),
				"params"	=> array(
					array(
						"type" => "textfield",
						"heading" => esc_html__( "Heading", 'theshopier' ),
						"param_name" => "heading",
					),

					array(
						"type" 			=> "dropdown",
						"heading" 		=> esc_html__( "Box Style", 'theshopier' ),
						"param_name" 	=> "box_style",
						"value" 		=> array(
							"Default"			=> "",
							"Header center"	=> "heading_center",
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
						'type' => 'dropdown',
						'heading' => __( 'Taxonomy', 'theshopier' ),
						'param_name' => 'taxonomy',
						'value' => parent::list_taxonomies(),
						'description' => __( 'Select source for tag cloud.', 'js_composer' ),
						'admin_label' => true,
						'save_always' => true,
					),
				)
			);
		}
	}

	new Theshopier_VC_Elements();

}

