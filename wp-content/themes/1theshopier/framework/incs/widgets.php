<?php 
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************//

add_action( 'widgets_init', 'theshopier_register_widgets' );
function theshopier_register_widgets() {
    register_widget('Theshopier_StaticBlock_Widget');
	register_widget('Theshopier_Banner_Widget');
	register_widget('Theshopier_RecentPosts_Widget');
	register_widget('Theshopier_RecentComments_Widget');
	
	if( Theshopier::checkPlugin('woocommerce/woocommerce.php') ){
		register_widget('Theshopier_ProductFilter_Widget');
		register_widget('Theshopier_WoocommerceProducts_Widget');
		register_widget('Theshopier_ProductCategory_Widget');
	}
}


if( !function_exists( "theshopier_layered_nav_init" ) ) {
	function theshopier_layered_nav_init(){
		if ( !is_active_widget( false, false, 'woocommerce_layered_nav', true ) && ! is_admin() ) {
			global $_chosen_attributes;
			$_chosen_attributes = array();

			$attribute_taxonomies = wc_get_attribute_taxonomies();
			if ( $attribute_taxonomies ) {
				foreach ( $attribute_taxonomies as $tax ) {

					$attribute       = wc_sanitize_taxonomy_name( $tax->attribute_name );
					$taxonomy        = wc_attribute_taxonomy_name( $attribute );
					$name            = 'filter_' . $attribute;
					$query_type_name = 'query_type_' . $attribute;

			    	if ( ! empty( $_GET[ $name ] ) && taxonomy_exists( $taxonomy ) ) {

			    		$_chosen_attributes[ $taxonomy ]['terms'] = explode( ',', $_GET[ $name ] );

			    		if ( empty( $_GET[ $query_type_name ] ) || ! in_array( strtolower( $_GET[ $query_type_name ] ), array( 'and', 'or' ) ) )
			    			$_chosen_attributes[ $taxonomy ]['query_type'] = apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
			    		else
			    			$_chosen_attributes[ $taxonomy ]['query_type'] = strtolower( $_GET[ $query_type_name ] );

					}
				}
		    }
		}
	}
}



if( !function_exists( 'theshopier_add_sidebar' ) ) {
	
	add_action( 'sidebar_admin_page', 'theshopier_add_sidebar', 10 );
	
	function theshopier_add_sidebar(){
		?>
		<form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="nth_add_sidebar_form">
			<h2>Custom Sidebar</h2>
			<?php wp_nonce_field( 'nth-add-sidebar-widgets', '_wpnonce_nth_add_sidebar', false ); ?>
			
			<div class="nth-form-row">
				<label><?php esc_html_e("Sidebar name", 'theshopier' );?> <abbr class="required" title="<?php esc_attr_e('required', 'theshopier' )?>">*</abbr></label>
				<input type="text" name="sidebar_name" id="sidebar_name" />
			</div>
			<div class="nth-form-row">
				<label><?php esc_html_e("Sidebar description", 'theshopier' );?></label>
				<input type="text" name="sidebar_desc" id="sidebar_desc" />
			</div>
			
			<button type="submit" class="button-primary">Add Sidebar</button>
			<p class="mesg-form"></p>
		</form>

		<?php 
	}
}

/////////

add_action('in_widget_form', 'theshopier_customfield_widget_form',5,3);

if( ! function_exists('theshopier_customfield_widget_form') ) {

	function theshopier_customfield_widget_form($widget,$return,$instance){
		$instance = wp_parse_args( (array) $instance, array( 'hidden_mb' => 0) );
		if ( !isset($instance['hidden_mb']) ) $instance['hidden_mb'] = 0;
		if ( !isset($instance['hidden_sm']) ) $instance['hidden_sm'] = 0;
		if ( !isset($instance['css_classes']) ) $instance['css_classes'] = '';
		?>
		<p>
			<input id="<?php echo esc_attr( $widget->get_field_id( 'hidden_mb' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'hidden_mb' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['hidden_mb'], 1 ); ?> />
			<label for="<?php echo esc_attr($widget->get_field_id( 'hidden_mb' )); ?>"><?php esc_html_e("Hidden on mobile", 'theshopier'); ?></label>
		</p>
		<p>
			<input id="<?php echo esc_attr( $widget->get_field_id( 'hidden_sm' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'hidden_sm' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['hidden_sm'], 1 ); ?> />
			<label for="<?php echo esc_attr($widget->get_field_id( 'hidden_sm' )); ?>"><?php esc_html_e("Hidden on Tablet", 'theshopier'); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr($widget->get_field_id( 'css_classes' )); ?>"><?php esc_html_e("Css Classes", 'theshopier'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $widget->get_field_id( 'css_classes' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'css_classes' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['css_classes'] ); ?>"/>
		</p>
		<?php
		return array($widget,$return,$instance);
	}

}


add_filter('widget_update_callback', 'theshopier_customfield_widget_form_update',5,3);

if( ! function_exists('theshopier_customfield_widget_form_update') ) {

	function theshopier_customfield_widget_form_update( $instance, $new_instance, $old_instance ){
		$instance['hidden_mb'] = $new_instance['hidden_mb'];
		$instance['hidden_sm'] = $new_instance['hidden_sm'];
		$instance['css_classes'] = $new_instance['css_classes'];
		return $instance;
	}

}

add_filter('dynamic_sidebar_params', 'theshopier_customfield_dynamic_sidebar_params');

if( ! function_exists('theshopier_customfield_dynamic_sidebar_params') ) {

	function theshopier_customfield_dynamic_sidebar_params( $params ){
		global $wp_registered_widgets, $theshopier_datas;

		$widget_id = $params[0]['widget_id'];
		$widget_obj = $wp_registered_widgets[$widget_id];
		$widget_opt = get_option($widget_obj['callback'][0]->option_name);
		$widget_num = $widget_obj['params'][0]['number'];

		$rex_class = array();
		if (isset($widget_opt[$widget_num]['hidden_mb'])){
			$rex_class[] = absint($widget_opt[$widget_num]['hidden_mb'])? "hidden-xs": '';
		}
		if (isset($widget_opt[$widget_num]['hidden_sm'])){
			$rex_class[] = absint($widget_opt[$widget_num]['hidden_sm'])? "hidden-sm": '';
		}

		if (isset($widget_opt[$widget_num]['css_classes'])){
			$rex_class[] = isset($widget_opt[$widget_num]['css_classes'])? esc_attr($widget_opt[$widget_num]['css_classes']): '';
		}

		if(!empty($theshopier_datas['sidebar-widget-style']) && strcmp('default', trim($theshopier_datas['sidebar-widget-style'])) !== 0 ) {
			$rex_class[] = esc_attr($theshopier_datas['sidebar-widget-style']);
		}

		$params[0]['before_widget'] = preg_replace('/class="/', 'class="'. implode(' ', $rex_class) . ' ',  $params[0]['before_widget'], 1);

		return $params;
	}

}
