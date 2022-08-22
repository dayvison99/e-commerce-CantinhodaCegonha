<?php

// Replace {$redux_opt_name} with your opt_name.
// Also be sure to change this function name!

if(!function_exists('theshopier_redux_register_custom_extension_loader')) {
	
    function theshopier_redux_register_custom_extension_loader($ReduxFramework) {

        $path    = get_template_directory() . '/framework/incs/redux-framework/extensions/';
        $folders = array('import_font', 'custom_field');
			
        foreach ( $folders as $folder ) {

            $extension_class = 'ReduxFramework_Extension_' . $folder;
            if ( ! class_exists( $extension_class ) ) {
                // In case you wanted override your override, hah.
                $class_file = $path . $folder . '/extension_' . $folder . '.php';
                $class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder, $class_file );
                if ( $class_file ) {
                    require_once( $class_file );
                }
            }
            if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
                $ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
            }
        }
    }
    // Modify {$redux_opt_name} to match your opt_name
    add_action("redux/extensions/".OPS_THEME."/before", 'theshopier_redux_register_custom_extension_loader', 0);
	
	
	
	
	add_action('wp_ajax_theshopier_import_font_xml', 'theshopier_ajax_import_font',10);
	function theshopier_ajax_import_font(){
		$uploadedfile = $_FILES['file_upload'];
        $filename = $_REQUEST['filename'];
		$xml_dir = THEME_FRAMEWORK_INCS . "redux-framework/xml/";
		$target_dir  = THEME_FRAMEWORK_INCS . "redux-framework/xml/tmp";
		$up_file = $xml_dir . $filename .'.xml';
		if( file_exists($up_file) ) unlink($up_file);
		$return = array(
			'status' => 'failed'
		);
		
		if($_FILES["file_upload"]["type"] === 'text/xml') {
			if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $up_file)) {
				$return['status'] = 'success';
			}
		}
		echo json_encode($return);
		die();
	}

}
