<?php
class storebiz_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof storebiz_import_dummy_data ) ) {
			self::$instance = new storebiz_import_dummy_data;
			self::$instance->storebiz_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function storebiz_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'storebiz_import_customize_scripts' ), 0 );

	}
	
	

	public function storebiz_import_customize_scripts() {

	wp_enqueue_script( 'storebiz-import-customizer-js', STOREBIZ_PARENT_INC_URI . '/customizer/customizer-notify/js/storebiz-import-customizer-options.js', array( 'customize-controls' ) );
	}
}

$storebiz_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
storebiz_import_dummy_data::init( apply_filters( 'storebiz_import_customizer', $storebiz_import_customizers ) );