<?php

$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
if ( in_array( "woocommerce/woocommerce.php", $_actived ) ) :

if( !function_exists( "theshopier_product_cat_add_form_fields" ) ) {
	add_action( 'product_cat_add_form_fields', 'theshopier_product_cat_add_form_fields', 10 );
	
	function theshopier_product_cat_add_form_fields(){
		$image_src = THEME_BACKEND_URI . "images/placeholder.png";
	?>
		<div class="form-field">
			<label for="display_type"><?php esc_html_e( 'Category Informations', 'theshopier' ); ?></label>
			<hr />
			<?php wp_editor( stripslashes(htmlspecialchars_decode('')), 'nth_cat_infomation' );	?>
			<p><?php esc_html_e('The Category Informations will show as category description.', 'theshopier');?></p>
		</div>
	<?php 
	}
}


if( !function_exists( "theshopier_product_cat_edit_form_fields" ) ) {
	
	add_action( 'product_cat_edit_form_fields', 'theshopier_product_cat_edit_form_fields', 10,2 );
	
	function theshopier_product_cat_edit_form_fields( $term, $taxonomy ){
		$datas = get_woocommerce_term_meta( $term->term_id, "nth_cat_config", true );
		if( strlen( $datas ) > 0 ) {
			$datas = unserialize($datas);
		} else {
			$datas = array();
			$datas = wp_parse_args( array(),
				array(
					'nth_cat_infomation' => ''
				)
			);
		}
		
	?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Category Informations', 'theshopier' ); ?></label></th>
			<td>
				<?php wp_editor( stripslashes(htmlspecialchars_decode($datas['nth_cat_infomation'])), 'nth_cat_infomation' );	?>
				<p class="description"><?php esc_html_e('The Category Informations will show as category description.', 'theshopier');?></p>
			</td>
		</tr>
	<?php 
	}
}

if( !function_exists( "theshopier_category_form_save" ) ) {
	
	add_action( 'created_term', 'theshopier_category_form_save', 10, 3 );
	add_action( 'edit_term', 'theshopier_category_form_save', 10, 3 );
	
	function theshopier_category_form_save( $term_id, $tt_id, $taxonomy ){
		
		if( isset($_POST['_inline_edit']) ) return $term_id;
		if( strcmp( trim( $taxonomy ), "product_cat" ) !== 0 ) return $term_id;
		
		$default = array(
			"nth_cat_infomation"	=> '',
		);
		$datas = array();
		if( isset( $_POST['nth_cat_infomation'] ) && strlen( trim( $_POST['nth_cat_infomation'] ) ) > 0 )
			$datas['nth_cat_infomation'] = esc_html( $_POST['nth_cat_infomation'] );
		$datas = wp_parse_args( $datas, $default );
		$result = update_woocommerce_term_meta( $term_id, "nth_cat_config", wp_slash(serialize( $datas )) );
	}
	
}

if( !function_exists( "theshopier_category_form_remove" ) ) {
	
	add_action( 'delete_term', 'theshopier_category_form_remove', 10,3 );
	
	function theshopier_category_form_remove( $term_id, $tt_id, $taxonomy ){
		if( strcmp( trim( $taxonomy ), "product_cat" ) !== 0 ) return $term_id;
		delete_woocommerce_term_meta( $term_id, "nth_cat_config" );
	}
}

endif;// check woocommerce;

