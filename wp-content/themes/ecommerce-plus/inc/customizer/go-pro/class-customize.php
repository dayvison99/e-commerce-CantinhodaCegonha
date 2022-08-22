<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  eCommerce Plus1.0.0
 * @access public
 */
final class ecommerce_plus_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		require trailingslashit( get_template_directory()) . 'inc/customizer/go-pro/section-pro.php' ;

		// Register custom section types.
		$manager->register_section_type( 'ecommerce_plus_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new ecommerce_plus_Customize_Section_Pro(
				$manager,
				'ecommerce-plus',
				array(
					'title'    => esc_html__( 'eCommerce Pro Plugin','ecommerce-plus' ),
					'pro_text' => ecommerce_plus_activated(),
					'pro_url'  => esc_url( 'https://www.ceylonthemes.com/product/wordpress-ecommerce-theme/' )
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'ecommerce-plus-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/go-pro/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'ecommerce-plus-customize-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/go-pro/customize-controls.css' );
	}
}

// Doing this customizer thang!
ecommerce_plus_Customize::get_instance();
