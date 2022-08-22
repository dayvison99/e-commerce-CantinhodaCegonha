<?php
// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

vc_add_shortcode_param('place_autocomplete', 'theshopier_place_autocomplete_settings_field');

function theshopier_place_autocomplete_settings_field( $settings, $value ){
	global $theshopier_datas;
	ob_start();
	$_rand = rand();
	$id_rand = 'place_autocomplete_'.$_rand;
	$maps_js = 'https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete_'.esc_js($_rand);
	if(!empty($theshopier_datas['google-map-api'])) {
		$maps_js .= "&key=".esc_attr($theshopier_datas['google-map-api']);
	}
	?>
	<div class="place_autocomplete_block">
		<input id="<?php echo esc_attr($id_rand);?>" name="<?php echo esc_attr( $settings['param_name'] )?>" class="wpb_vc_param_value wpb-textinput <?php echo esc_attr( $settings['param_name'] )?> <?php echo esc_attr( $settings['type'] )?>_field" type="text" value="<?php echo esc_attr( $value );?>" placeholder="" />
    </div>
	
	<script>
		function initAutocomplete_<?php echo esc_js($_rand)?>(){
			var input = document.getElementById('<?php echo esc_js($id_rand);?>');
			var searchBox = new google.maps.places.SearchBox(input);
		}
	</script>
	<script src="<?php echo esc_url($maps_js)?>"
         async defer></script>
	<?php 
	
	return ob_get_clean();
}