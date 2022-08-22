/*!
 * NexThemes Plugin v1.0.0
 * Copyright 2015 Nexthemes
 */

!function($) {
    $('#vc_properties-panel .nth_price_block .nth_price_field').on('change', function(){
		var val = $(this).val();
		var index = $(this).data('index');
		var data_s = $(this).parents('.nth_price_block').find('.nth_price_data').val();
		var data = data_s.split('|');
		data[index] = val;
		data_s = data.join('|');
		$(this).parents('.nth_price_block').find('.nth_price_data').val(data_s);
	});
	
	$('#vc_properties-panel .nth_price_block .nth_price_checkbox_isfree').on('click', function(){
		if( $(this).prop( "checked" ) ) {
			
		}
	});
	
	$('#vc_properties-panel .nth_textarea_exl').on('change', function(){
		var val = $(this).val().replace( /\n/g, "|" );
		console.log(val);
		$(this).parent().find('[type=hidden]').val(val);
	});
}(window.jQuery);