<?php 

if( !class_exists( "Theshopier_VC_Autocomplete" ) && class_exists('Theshopier_VC_Autocomplete_Query') ) {
	
	class Theshopier_VC_Autocomplete extends Theshopier_VC_Autocomplete_Query {
		
		private $shortcode_base;
		private $param_args = array();
		
		public function __construct( $ops = array() ){
			if( count( $ops ) > 0 ) {
				if( isset( $ops['base'] ) ) $this->shortcode_base = $ops['base'];
				if( isset( $ops['params'] ) ) $this->param_args = $ops['params'];
				$this->add_autocompleteField();
			}
			
		}
		
		public function createAutoComplete( $ops = array() ){
			if( count( $ops ) > 0 ) {
				if( isset( $ops['base'] ) ) $this->shortcode_base = $ops['base'];
				if( isset( $ops['params'] ) ) $this->param_args = $ops['params'];
				$this->add_autocompleteField();
			}
		}
		
		public function add_autocompleteField(){
			if( !is_array( $this->param_args ) || count($this->param_args) == 0 ) return;
			foreach( $this->param_args as $param ) {
				if( method_exists( $this, "{$this->shortcode_base}_{$param}_callback" ) )
					add_filter( "vc_autocomplete_{$this->shortcode_base}_{$param}_callback", array( $this, "{$this->shortcode_base}_{$param}_callback" ), 10, 1 );
				if( method_exists( $this, "{$this->shortcode_base}_{$param}_render" ) )
					add_filter( "vc_autocomplete_{$this->shortcode_base}_{$param}_render", array( $this, "{$this->shortcode_base}_{$param}_render" ) );
			}
		}

		public function theshopier_sale_products_cats_callback( $query ){
			return $this->get_productCat_callback($query);
		}

		public function theshopier_sale_products_cats_render( $query ){
			return $this->get_productCat_render( $query );
		}
		
		public function theshopier_product_tags_tags_callback( $query ){
			return $this->get_term_by_callback( $query, 'product_tag', 'slug' );
		}
		
		public function theshopier_product_tags_tags_render( $query ){
			return $this->get_term_by_render( $query, 'product_tag', 'slug' );
		}
		
		public function theshopier_product_cats_cats_callback( $query ){
			return $this->get_productCat_callback($query);
		}
		
		public function theshopier_product_cats_cats_render( $query ){
			return $this->get_productCat_render( $query );
		}
		
		public function theshopier_products_category_category_callback( $query ){
			return $this->get_term_by_callback( $query, 'product_cat', 'slug' );
		}
		
		public function theshopier_products_category_category_render( $query ){
			return $this->get_term_by_render( $query, 'product_cat', 'slug' );
		}
		
		public function theshopier_teams_ids_callback( $query ){
			return $this->get_postType_id_callback( $query, 'team' );
		}
		
		public function theshopier_teams_ids_render( $query ){
			return $this->get_postType_id_render( $query, 'team' );
		}
		
		public function theshopier_testimonials_ids_callback( $query ){
			return $this->get_postType_id_callback( $query, 'testimonial' );
		}
		
		public function theshopier_testimonials_ids_render( $query ){
			return $this->get_postType_id_render( $query, 'testimonial' );
		}
		
		public function theshopier_products_cats_tabs_category_callback( $query ){
			return $this->get_productCat_callback($query);
		}
		
		public function theshopier_products_cats_tabs_category_render( $query ){
			return $this->get_productCat_render( $query );
		}
		
		public function theshopier_features_id_callback( $query ){
			return $this->get_postType_id_callback( $query, 'feature' );
		}
		
		public function theshopier_features_id_render( $query ){
			return $this->get_postType_id_render( $query, 'feature' );
		}
		 
		public function theshopier_products_ids_callback( $query ){
			return $this->get_postType_id_callback( $query, 'product' );
		}
		
		public function theshopier_products_ids_render( $query ){
			return $this->get_postType_id_render( $query, 'product' );
		}

		public function theshopier_product_subcaterories_cat_group_slug_callback( $query ){
			return $this->get_productCat_callback( $query );
		}

		public function theshopier_product_subcaterories_cat_group_slug_render( $query ){
			return $this->get_productCat_render( $query );
		}

		public function theshopier_product_subcaterories_slugs_callback( $query ){
			return $this->get_productCat_callback( $query );
		}

		public function theshopier_product_subcaterories_slugs_render( $query ){
			return $this->get_productCat_render( $query );
		}

		public function theshopier_featured_prod_cats_slugs_callback( $query ){
			return $this->get_productCat_callback( $query );
		}

		public function theshopier_featured_prod_cats_slugs_render( $query ){
			return $this->get_productCat_render( $query );
		}

		public function theshopier_woo_single_cat_slug_callback( $query ){
			return $this->get_productCat_callback( $query );
		}

		public function theshopier_woo_single_cat_slug_render( $query ){
			return $this->get_productCat_render( $query );
		}

		public function theshopier_product_brands_brand_group_slug_callback( $query ){
			return $this->get_term_by_callback( $query, 'product_brand', 'slug' );
		}

		public function theshopier_product_brands_brand_group_slug_render( $query ){
			return $this->get_term_by_render( $query, 'product_brand', 'slug' );
		}

		public function theshopier_woo_cats_cats_group_slug_callback( $query ){
			return $this->get_productCat_callback( $query );
		}

		public function theshopier_woo_cats_cats_group_slug_render( $query ){
			return $this->get_productCat_render( $query );
		}

		public function theshopier_portfolio_cats_callback( $query ){
			return $this->get_term_by_callback( $query, 'portfolio_cat', 'slug' );
		}

		public function theshopier_portfolio_cats_render( $query ){
			return $this->get_term_by_render($query, 'portfolio_cat', 'slug');
		}
		
		public static function getOrderBy( $unset = array() ){
			$orderBy = array(
				'',
				esc_html__( 'Date', 'theshopier' )          => 'date',
				esc_html__( 'ID', 'theshopier' )            => 'ID',
				esc_html__( 'Author', 'theshopier' )        => 'author',
				esc_html__( 'Title', 'theshopier' )         => 'title',
				esc_html__( 'Modified', 'theshopier' )      => 'modified',
				esc_html__( 'Random', 'theshopier' )        => 'rand',
				esc_html__( 'Comment count', 'theshopier' ) => 'comment_count',
				esc_html__( 'Menu order', 'theshopier' )    => 'menu_order',
			);
			if( count( $unset ) > 0 ) {
				foreach( $orderBy as $key => $val ) {
					if( in_array( $val, $unset ) ) unset( $orderBy[$key] );
				}
			}
			
			return $orderBy;
		}
		
		public static function getOrder(){
			return array(
				'',
				esc_html__( 'Descending', 'theshopier' )    => 'DESC',
				esc_html__( 'Ascending', 'theshopier' )     => 'ASC',
			);
		}
		
		public static function getColors( $custom = false ){
			$colors = array(
				esc_html__('Blue', 'theshopier' )            => 'blue',
				esc_html__('Turquoise', 'theshopier' )       => 'turquoise',
				esc_html__('Pink', 'theshopier' )            => 'pink',
				esc_html__('Violet', 'theshopier' )          => 'violet',
				esc_html__('Peacoc', 'theshopier' )          => 'peacoc',
				esc_html__('Chino', 'theshopier' )           => 'chino',
				esc_html__('Mulled Wine', 'theshopier' )     => 'mulled_wine',
				esc_html__('Vista Blue', 'theshopier' )      => 'vista_blue',
				esc_html__('Black', 'theshopier' )           => 'black',
				esc_html__('Grey', 'theshopier' )            => 'grey',
				esc_html__('Orange', 'theshopier' )          => 'orange',
				esc_html__('Sky', 'theshopier' )             => 'sky',
				esc_html__('Green', 'theshopier' )           => 'green',
				esc_html__('Juicy pink', 'theshopier' )      => 'juicy_pink',
				esc_html__('Sandy brown', 'theshopier' )     => 'sandy_brown',
				esc_html__('Purple', 'theshopier' )          => 'purple',
				esc_html__('White', 'theshopier' )           => 'white',
				esc_html__('Success', 'theshopier' )           => 'success'
			);
			
			if( $custom ) $colors = array_merge( $colors, array( esc_html__( 'Custom color', 'theshopier' ) => 'custom' ) );
			
			return $colors;
		}
		
		public static function getCategories(){
			$args = array(
				'type' => 'post',
				'child_of' => 0,
				'parent' => '',
				'orderby' => 'id',
				'order' => 'ASC',
				'hide_empty' => false,
				'hierarchical' => 1,
				'exclude' => '',
				'include' => '',
				'number' => '',
				'taxonomy' => 'product_cat',
				'pad_counts' => false,

			);
			$categories = get_categories( $args );

			$product_categories_dropdown = array();
			self::getCategoryChildsFull( 0, 0, $categories, 0, $product_categories_dropdown );

			return $product_categories_dropdown;
		}

		public static function getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {

			for ( $i = $pos; $i < count( $array ); $i ++ ) {
				if ( $array[ $i ]->category_parent == $parent_id ) {
					$name = str_repeat( '- ', $level ) . $array[ $i ]->name;
					$value = $array[ $i ]->slug;
					$dropdown[] = array(
						'label' => $name,
						'value' => $value,
					);
					self::getCategoryChildsFull( $array[ $i ]->term_id, 0, $array, $level + 1, $dropdown );
				}
			}
		}

		public static function list_taxonomies(){
			$tag_taxonomies = array();
			if ( 'vc_edit_form' === vc_post_param( 'action' ) && vc_verify_admin_nonce() ) {
				$taxonomies = get_taxonomies();
				if ( is_array( $taxonomies ) && ! empty( $taxonomies ) ) {
					foreach ( $taxonomies as $taxonomy ) {
						$tax = get_taxonomy( $taxonomy );
						if ( ( is_object( $tax ) && ( ! $tax->show_tagcloud || empty( $tax->labels->name ) ) ) || ! is_object( $tax ) ) {
							continue;
						}
						$tag_taxonomies[ $tax->labels->name ] = esc_attr( $taxonomy );
					}
				}
			}

			return $tag_taxonomies;
		}
		
		public static function getVars( $key = '' ){
			$_vars = array(
				'rf'	=> '',
				'c1'	=> 'Nexthemes - Woo',
				'c2'	=> 'Nexthemes',
				'c3'	=> 'Filters',
				'woo'	=> array(
					'columns_txt'	=> esc_html__('If you use slider, This column number will response respectively with 1200px', 'theshopier'),
					'autocomplete'	=> esc_html__('Type product name, slug or id.', 'theshopier')
				),
				'css_editor'	=> array(
					'type' => 'css_editor',
					'heading' => esc_html__( 'Css', 'theshopier' ),
					'param_name' => 'css',
					'group' => esc_html__( 'Design options', 'theshopier' ),
				),
				'el_class'		=> array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'theshopier' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'theshopier' ),
				)
			);

			if( strlen($key) > 0 )
				return $_vars[$key];
			else return $_vars;
		}
		
	}
	
}
