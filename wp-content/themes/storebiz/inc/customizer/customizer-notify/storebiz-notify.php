<?php

class Storebiz_Customizer_Notify {

	private $recommended_actions;

	
	private $recommended_plugins;

	
	private static $instance;

	
	private $recommended_actions_title;

	
	private $recommended_plugins_title;

	
	private $dismiss_button;

	
	private $install_button_label;

	
	private $activate_button_label;

	
	private $storebiz_deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Storebiz_Customizer_Notify ) ) {
			self::$instance = new Storebiz_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $storebiz_customizer_notify_recommended_plugins;
		global $storebiz_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $storebiz_deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$storebiz_customizer_notify_recommended_plugins = array();
		$storebiz_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$storebiz_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$storebiz_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$storebiz_deactivate_button_label = isset( $this->config['storebiz_deactivate_button_label'] ) ? $this->config['storebiz_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'storebiz_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'storebiz_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'storebiz_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'storebiz_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function storebiz_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'storebiz-customizer-notify-css', STOREBIZ_PARENT_INC_URI . '/customizer/customizer-notify/css/storebiz-customizer-notify.css', array());

		wp_enqueue_style( 'storebiz-plugin-install' );
		wp_enqueue_script( 'storebiz-plugin-install' );
		wp_add_inline_script( 'storebiz-plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'storebiz-updates' );

		wp_enqueue_script( 'storebiz-customizer-notify-js', STOREBIZ_PARENT_INC_URI . '/customizer/customizer-notify/js/storebiz-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'storebiz-customizer-notify-js', 'StorebizCustomizercompanionObject', array(
				'storebiz_ajaxurl'            => esc_url(admin_url( 'admin-ajax.php' )),
				'storebiz_template_directory' => esc_url(get_template_directory_uri()),
				'storebiz_base_path'          => esc_url(admin_url()),
				'storebiz_activating_string'  => __( 'Activating', 'storebiz' ),
			)
		);

	}

	
	public function storebiz_plugin_notification_customize_register( $wp_customize ) {

		
		require STOREBIZ_PARENT_INC_DIR . '/customizer/customizer-notify/storebiz-notify-section.php';

		$wp_customize->register_section_type( 'Storebiz_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new Storebiz_Customizer_Notify_Section(
				$wp_customize,
				'Storebiz-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}

	
	public function storebiz_customizer_notify_dismiss_recommended_action_callback() {

		global $storebiz_customizer_notify_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			
			if ( get_theme_mod( 'storebiz_customizer_notify_show' ) ) {

				$storebiz_customizer_notify_show_recommended_actions = get_theme_mod( 'storebiz_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$storebiz_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$storebiz_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				echo esc_html($storebiz_customizer_notify_show_recommended_actions);
				
			} else {
				$storebiz_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $storebiz_customizer_notify_recommended_actions ) ) {
					foreach ( $storebiz_customizer_notify_recommended_actions as $storebiz_lite_customizer_notify_recommended_action ) {
						if ( $storebiz_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$storebiz_customizer_notify_show_recommended_actions[ $storebiz_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$storebiz_customizer_notify_show_recommended_actions[ $storebiz_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					echo esc_html($storebiz_customizer_notify_show_recommended_actions);
				}
			}
		}
		die(); 
	}

	
	public function storebiz_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			$storebiz_lite_customizer_notify_show_recommended_plugins = get_theme_mod( 'storebiz_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$storebiz_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$storebiz_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			echo esc_html($storebiz_customizer_notify_show_recommended_actions);
		}
		die(); 
	}

}
