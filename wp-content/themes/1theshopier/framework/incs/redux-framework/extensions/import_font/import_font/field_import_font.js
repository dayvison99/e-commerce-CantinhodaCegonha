/* global confirm, redux, redux_change */

jQuery(document).ready(function() {
	
	jQuery('.nth-redux-import-export .nth-import-btn').on('click', function(e){
		e.preventDefault();
		var assign = jQuery(this).data('assign');
		jQuery("#"+assign).trigger('click');
	});
	
	jQuery('.nth-redux-import-export .nth-import-input-file').live('change',function(e){
		if(jQuery(this).data('file_exists') == 1) {
			if( !confirm('NOTE: this file will overwrite existing file, are you sure?') ) {
				jQuery(this).val('').clone(true);
				return false;
			}
		}
		var files = e.target.files;
		var data = new FormData();
		var $this = jQuery(this);
		var action = jQuery(this).data('action');
		var filename = jQuery(this).data('filename');
		data.append('action', action);
		data.append('filename', filename);
		data.append('file_upload', files[0]);
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			data: data,
			dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			success: function(o){
				redux_change( $this );
				if(o['status'] == 'success') {
					jQuery( 'input[name="' + redux.args.opt_name + '[defaults-section]"]' ).first().trigger('click');
				}
				
				//if(o['status'] == 'success') location.reload();
			}
		});
	});

});
