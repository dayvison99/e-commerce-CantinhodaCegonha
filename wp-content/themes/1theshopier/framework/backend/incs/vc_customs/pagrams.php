<?php 

vc_add_param('vc_row', array(
	"type" 			=> "dropdown",
	"class" 		=> "",
	"heading" 		=> esc_html__("Row style", 'theshopier' ),
	"param_name" 	=> "theshopier_row_style",
	"std"			=> '',
	"value" => array(
		esc_html__("Normal", 'theshopier' ) 	=> "",
		esc_html__("Grid style", 'theshopier' )	=> "nth-row-grid",
		esc_html__("Shadow", 'theshopier' )	=> "nth-row-shadow"
	),
	"dependency" => Array('element' => "full_width", 'value' => array('')),
	//"group"		=> "Nexthemes"
));

vc_add_param('vc_row_inner', array(
	"type" 			=> "dropdown",
	"class" 		=> "",
	"heading" 		=> esc_html__("Row style", 'theshopier' ),
	"param_name" 	=> "theshopier_row_style",
	"std"			=> '',
	"value" => array(
		esc_html__("Normal", 'theshopier' ) 	=> "",
		esc_html__("Grid style", 'theshopier' )	=> "nth-row-grid",
		esc_html__("Shadow", 'theshopier' )	=> "nth-row-shadow"
	),
	//"group"		=> "Nexthemes"
));

$vc_wp_search_params = array(
	array(
		'type' => 'colorpicker',
		'heading' => esc_html__( 'Backround Color', 'theshopier' ),
		'param_name' => 'bg_color',
		'description' => esc_html__( 'Set background color.', 'theshopier' ),
		"group"		=> "Nexthemes"
	),
	array(
		"type" => "checkbox",
		"class" => "",
		"heading" => esc_html__("Hidden Label", 'theshopier' ),
		"param_name" => "hidden_label",
		"value" => array(
			"Hide Search Label" => "hide_label"
		),
		"group"		=> "Nexthemes"
	)
);
vc_add_params('vc_wp_search', $vc_wp_search_params);

$vc_tabs_pagrams = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__("Tabs style", 'theshopier' ),
		"param_name" => "theshopier_tabs_style",
		"value" => array(
			esc_html__("Normal", 'theshopier' ) 	=> '',
			esc_html__("Boxed", 'theshopier' )		=> 'nth-boxed'
		),
		"group"		=> "Nexthemes"
	),
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => esc_html__("Columns", 'theshopier' ),
		"param_name" => "nth_tabs_columns",
		"value" => '2',
		"group"		=> "Nexthemes",
		"dependency" => array('element' => "theshopier_tabs_style", 'value' => array('nth-boxed'))
	)
);
vc_add_params('vc_tabs', $vc_tabs_pagrams);


$vc_tta_tabs_pagrams = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__("Tabs style", 'theshopier' ),
		"param_name" => "theshopier_tabs_style",
		"value" => array(
			esc_html__("VC Defaule", 'theshopier' ) 	=> '',
			esc_html__("NTH Tab Style 1", 'theshopier' ) 	=> 'nth-tab-style1',
			esc_html__("NTH Tab Style 2", 'theshopier' )	=> 'nth-tab-style2',
			esc_html__("NTH Tab Style 3", 'theshopier' )	=> 'nth-tab-style3',
			esc_html__("NTH Tab Style 4", 'theshopier' )	=> 'nth-tab-style4',
			esc_html__("NTH Tab Style 5", 'theshopier' )	=> 'nth-tab-style5',
		),
		"group"		=> "Nexthemes",
		"dependency" => array('element' => "style", 'value' => array('classic'))
	),
	array(
		"type" => "textfield",
		"class" => "",
		"heading" => esc_html__("Columns", 'theshopier' ),
		"param_name" => "nth_tabs_columns",
		"value" => '2',
		"group"		=> "Nexthemes",
		"dependency" => array('element' => "theshopier_tabs_style", 'value' => array('nth-tab-style3'))
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__("Align", 'theshopier' ),
		"param_name" => "nth_tabs_align",
		"value" => array(
			esc_html__("Left", 'theshopier' ) 	=> 'text-left',
			esc_html__("Center", 'theshopier' ) => 'text-center',
			esc_html__("Right", 'theshopier' )	=> 'text-right',
		),
		"group"		=> "Nexthemes",
		"dependency" => array('element' => "style", 'value' => array('classic'))
	),
);
vc_add_params('vc_tta_tabs', $vc_tta_tabs_pagrams);

$vc_tta_section_pagrams = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__("Section style", 'theshopier' ),
		"param_name" => "theshopier_tabs_style",
		"value" => array(
			esc_html__("VC Defaule", 'theshopier' ) => '',
			esc_html__("NTH style", 'theshopier' ) 	=> 'nth-section-style1'
		),
		"dependency" => array('element' => "style", 'value' => array('classic'))
	)
);

vc_add_params('vc_tta_tour', $vc_tta_section_pagrams);


add_filter('vc-tta-get-params-tabs-list', 'theshopier_vc_tta_tabs_list', 10, 4);

function theshopier_vc_tta_tabs_list($html, $atts, $content, $shortcode){
	if(empty($atts['theshopier_tabs_style'])) return $html;

	$classes = array();
	if( isset($atts['nth_tabs_columns']) && absint($atts['nth_tabs_columns']) > 0 && strcmp($atts['theshopier_tabs_style'], 'nth-tab-style3') == 0 ){
		$columns = absint($atts['nth_tabs_columns']);
		$classes[] = 'col-lg-' . round( 24 /$columns );
		$classes[] = 'col-md-' . round( 24 / round( $columns * 992 / 1170) );
		$classes[] = 'col-sm-' . round( 24 / round( $columns * 768 / 1170) );
		$classes[] = 'col-xs-' . round( 24 / round( $columns * 480 / 1170) );
	}

	foreach($html as $k => $val){
		if(strpos($val, '<li') !== false && count($classes) > 0 ) {
			$html[$k] = str_replace('<li class="', '<li class="' . implode(' ', $classes). ' ' , $val);
		} elseif(strpos($val, '<ul') !== false && !empty($atts['nth_tabs_align'])) {
			$html[$k] = str_replace('<ul class="', '<ul class="' . $atts['nth_tabs_align'] . ' ' , $val);
		}
	}
	return $html;
}

add_filter('vc_shortcodes_css_class', 'theshopier_vc_shortcodes_css_class', 10, 3);

function theshopier_vc_shortcodes_css_class($class_to_filter, $base, $atts){
	$classes = array($class_to_filter);

	switch( $base ) {
		case 'vc_tta_tabs':
		case 'vc_tta_tour':
			if(!empty($atts['theshopier_tabs_style'])) $classes[] = esc_attr($atts['theshopier_tabs_style']);
			break;
		case 'vc_row':
		case 'vc_row_inner':
			if( !empty($atts['theshopier_row_style']) ) $classes[] = esc_attr($atts['theshopier_row_style']);
			break;
	}

	return implode(' ', $classes);
}


$vc_progress_bar = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__("Style", 'theshopier' ),
		"param_name" => "pb_style",
		"value" => array(
			esc_html__("VC Defaule", 'theshopier' ) 	=> '',
			esc_html__("NTH Style", 'theshopier' ) 	=> 'nth-pb-style',
		),
		"group"		=> "Nexthemes",
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => esc_html__("Border radius", 'theshopier' ),
		"param_name" => "pb_radius_style",
		"value" => array(
			esc_html__("VC Defaule", 'theshopier' ) 	=> '',
			esc_html__("NTH Style", 'theshopier' ) 	=> 'nth-pb-radius-style',
		),
		"group"		=> "Nexthemes",
	),

);

vc_add_params('vc_progress_bar', $vc_progress_bar);

if(defined('VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG')) {
	add_filter( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'theshopier_vc_shortcoe_custom_css', 10, 3);

	function theshopier_vc_shortcoe_custom_css( $class_to_filter, $base, $atts ){
		if(strcmp($base, 'vc_progress_bar') == 0) {
			if(isset($atts['pb_style']) && strlen($atts['pb_style']) > 0) {
				$class_to_filter .= ' '.esc_attr($atts['pb_style']);
			}
			if(isset($atts['pb_radius_style']) && strlen($atts['pb_radius_style']) > 0) {
				$class_to_filter .= ' '.esc_attr($atts['pb_radius_style']);
			}
		}

		return $class_to_filter;
	}
}