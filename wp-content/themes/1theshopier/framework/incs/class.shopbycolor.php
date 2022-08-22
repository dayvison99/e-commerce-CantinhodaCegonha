<?php 

if( !class_exists( 'Theshopier_ShopByColor' ) ) {
	
	class Theshopier_ShopByColor{
		
		private $woo_ready = false;
		private $color_ready = false;
		private $err_msg, $color_slug = '';
		
		public function __construct(){
			$this->check_woo();
			add_action('init', array($this, 'init'));
		}
		
		public function check_woo(){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				$this->woo_ready = true;
			}else{
				$this->woo_ready = false;
			}
		}
		
		public function init(){
			if( $this->woo_ready == false ) return;
			
			$_color = 'color';
			$attribute_name = isset( $_color )? wc_sanitize_taxonomy_name( stripslashes( (string) $_color ) ) : '';
			$attribute_name  = wc_attribute_taxonomy_name( $attribute_name );
			$attribute_name_array = wc_get_attribute_taxonomy_names();
			$taxonomy_exists = in_array($attribute_name,$attribute_name_array);
			
			if( !$taxonomy_exists ){
				$this->color_ready = false;
				$this->err_msg = 'Color attribute not exist! Go to Products => Attributes,create new attibute with slug "color"';
				add_action( 'admin_notices', array( $this, 'err_messages' ) );
			} else {
				$this->color_ready = true;
				$this->color_slug = $attribute_name;
				add_action( 'admin_enqueue_scripts', array($this,'enqueue_script') );
				$this->be_custom();
			}
			
		}
		
		public function enqueue_script(){
			wp_enqueue_style( 'wp-color-picker' );
		}
		
		public function be_custom(){
			if( $this->color_ready && $this->woo_ready ) {
				$_edit_hook = $this->color_slug . '_edit_form_fields';
				$_add_hook = $this->color_slug.'_add_form_fields';
				/*Add template*/
				add_action( $_edit_hook, array($this,'pa_edit_attribute'), 100000, 2 );
				add_action( $_add_hook, array($this,'pa_add_attribute'), 100000 );
				
				add_action( 'created_term', array( $this, 'pa_color_fields_save'), 10,3 );
				add_action( 'edit_term', array( $this, 'pa_color_fields_save'), 10,3 );
				add_action( 'delete_term', array( $this, 'pa_color_fields_remove'), 10,3 );
				
				//table
				$_edit_table_hook = 'manage_edit-'. $this->color_slug .'_columns';
				$_edit_table_content_hook = 'manage_'. $this->color_slug .'_custom_column';
				
				add_filter( $_edit_table_hook, array($this, "pa_edit_color_table_columns") );
				add_filter( $_edit_table_content_hook , array($this,'pa_edit_color_table_content'), 10, 3 );
			}
		}
		
		public function pa_edit_attribute( $term, $taxonomy ){
			//$datas = get_metadata( 'woocommerce_term', $term->term_id, "nth_pa_color", true );
			$datas = get_woocommerce_term_meta( $term->term_id, "nth_pa_color", true );
			if( !isset( $datas ) || strlen( $datas ) == 0 ) $datas = "#aaaaaa";
			?>
			<tr class="form-field form-required">
				<th scope="row" valign="top"><label><?php esc_html_e( 'Color', 'theshopier' ); ?></label></th>
				<td>
					<input name="nth_pa_color" id="hex-color" class="nth_colorpicker" data-default-color="<?php echo esc_attr($datas);?>" type="text" value="<?php echo esc_attr($datas);?>" size="40" aria-required="true">
					<span class="description">Use color picker to pick one color.</span>
				</td>
			</tr>
			<?php 
		}
		
		public function pa_add_attribute(){
			?>
			<div class="form-field form-required">
				<label for="display_type"><?php esc_html_e( 'Color', 'theshopier' ); ?></label>
				<input name="nth_pa_color" id="hex-color" class="nth_colorpicker" type="text" value="#aaaaaa" size="40" aria-required="true">
				<p>Use color picker to pick one color.</p>
			</div>
			<?php 
		}
		
		public function pa_color_fields_save( $term_id, $tt_id, $taxonomy ){
			$data = isset( $_REQUEST['nth_pa_color'] ) ? esc_attr( $_REQUEST['nth_pa_color'] ) : "#aaaaaa" ;
			//$result = update_metadata( 'woocommerce_term', $term_id, "nth_pa_color", $data );
			update_woocommerce_term_meta($term_id, "nth_pa_color", $data);
		}
		
		public function pa_color_fields_remove( $term_id, $tt_id, $taxonomy ){
			delete_woocommerce_term_meta($term_id, "nth_pa_color");
		}
		
		public function pa_edit_color_table_columns( $columns ){
			$new_args = array(
				"cb"	=> $columns['cb'],
				"color"	=> esc_html__( 'Color', 'theshopier' )
			);
			unset( $columns['cb'] );
			return array_merge( $new_args, $columns );
		}
		
		public function pa_edit_color_table_content( $columns, $column, $id ){
			if( strcmp( trim( $column ), 'color' ) == 0 ) {
				$color = get_woocommerce_term_meta( $id, "nth_pa_color", true );
				$color = ( isset( $color ) && strlen( $color ) > 0 )? $color: "#aaaaaa";
				?>
				<div style="background-color: <?php echo esc_attr($color);?>; font-size: 0; line-height: 25px; width: 30px; border-radius: 3px; -webkit-border-radius: 3px; box-shadow: 0 1px 1px rgba(0,0,0,0.35); border: 1px solid #333333;">NTH</div>
				<?php 
			}
		}
		
		public function err_messages(){
			?>
			<div id="message" class="update-nag" style="padding: 1px 15px; margin: 5px 15px 2px;">
				<p><?php echo esc_html($this->err_msg);?></p>
			</div>
			<?php 
		}
		
	}
	
	new Theshopier_ShopByColor();
	
}