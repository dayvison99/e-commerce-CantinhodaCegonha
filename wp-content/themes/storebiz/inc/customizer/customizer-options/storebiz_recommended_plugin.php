<?php
/* Notifications in customizer */


require STOREBIZ_PARENT_INC_DIR . '/customizer/customizer-notify/storebiz-notify.php';
$storebiz_config_customizer = array(
	'recommended_plugins'       => array(
		'burger-companion' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>Burger Companion</strong> plugin for taking full advantage of all the features this theme has to offer StoreBiz.', 'storebiz')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'storebiz' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'storebiz' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'storebiz' ),
	'activate_button_label'     => esc_html__( 'Activate', 'storebiz' ),
	'storebiz_deactivate_button_label'   => esc_html__( 'Deactivate', 'storebiz' ),
);
Storebiz_Customizer_Notify::init( apply_filters( 'storebiz_customizer_notify_array', $storebiz_config_customizer ) );
