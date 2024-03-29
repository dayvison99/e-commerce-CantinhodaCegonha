<?php
/**
 * FWPMANIP Modal
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace fwpmanip\ui;

/**
 * Same as the Box type, however it renders a button control that loads the modal via a template
 *
 * @package fwpmanip\ui
 * @author  David Cramer
 */
class modal extends panel {

	/**
	 * The type of object
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      string
	 */
	public $type = 'modal';

	/**
	 * footer object
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      footer
	 */
	public $footer;

	/**
	 * modal template
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      string
	 */
	public $templates = null;


	/**
	 * Sets the controls data
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\fwpmanip
	 * @access public
	 */
	public function is_submitted() {
		$data = fwpmanip()->request_vars( 'post' );

		return isset( $data[ 'fwpmanipNonce_' . $this->id() ] ) && wp_verify_nonce( $data[ 'fwpmanipNonce_' . $this->id() ], $this->id() );
	}

	/**
	 * Sets the wrappers attributes
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_attributes() {

		$this->attributes += array(
			'data-modal'   => $this->id(),
			'data-content' => '#' . $this->id() . '-tmpl',
			'data-margin'  => 12,
			'data-element' => 'form',
			'data-width'   => '480',
			'data-height'  => '550',
			'class'        => 'button',
		);
		$this->set_modal_size();
		$this->set_modal_config();
		if ( ! empty( $this->struct['description'] ) ) {
			$this->attributes['data-title'] = $this->struct['description'];
			unset( $this->struct['description'] );
		}
		if ( ! empty( $this->struct['attributes'] ) ) {
			$this->attributes = array_merge( $this->attributes, $this->struct['attributes'] );
		}
	}

	/**
	 * Sets the modals defined size
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function set_modal_size() {

		if ( ! empty( $this->struct['width'] ) ) {
			$this->attributes['data-width'] = $this->struct['width'];
		}
		if ( ! empty( $this->struct['height'] ) ) {
			$this->attributes['data-height'] = $this->struct['height'];
		}

	}


	/**
	 * Sets the wrappers data attributes
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function set_modal_config() {

		if ( ! empty( $this->struct['config'] ) ) {
			$attributes = array();
			foreach ( $this->struct['config'] as $att => $value ) {
				$attributes[ 'data-' . $att ] = $value;
			}
			$this->attributes['data-config'] = json_encode( $attributes );

		}
	}

	/**
	 * set assets
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 */
	public function set_assets() {

		$this->assets['script']['baldrick'] = array(
			'src'  => $this->url . 'assets/js/jquery.baldrick' . FWPMANIP_ASSET_DEBUG . '.js',
			'deps' => array( 'jquery' ),
		);
		$this->assets['script']['modals'] = array(
			'src'  => $this->url . 'assets/js/modals' . FWPMANIP_ASSET_DEBUG . '.js',
			'deps' => array( 'baldrick' ),
		);
		$this->assets['style']['modals']  = $this->url . 'assets/css/modals' . FWPMANIP_ASSET_DEBUG . '.css';

		parent::set_assets();
	}

	/**
	 * Render the Control
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string HTML of rendered box
	 */
	public function render() {

		$this->set_footers();

		add_action( 'admin_footer', array( $this, 'output_templates' ) );
		add_action( 'wp_footer', array( $this, 'output_templates' ) );

		$output = '<button ' . $this->build_attributes() . '>' . $this->struct['label'] . '</button>';

		$this->templates .= $this->render_modal_template();

		return $output;
	}

	/**
	 * Set the child footer objects
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 */
	public function set_footers() {

		if ( ! empty( $this->child ) ) {
			foreach ( $this->child as $child_slug => $child ) {
				if ( in_array( $child->type, array( 'footer' ) ) ) {
					$this->footer                    = $child;
					$this->attributes['data-footer'] = '#' . $this->id() . '-footer-tmpl';
				}
			}
		}
	}

	/**
	 * Render the template code in script tags
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string HTML of rendered template in script tags
	 */
	public function render_modal_template() {
		unset( $this->struct['label'] );
		$output = '<script data-height="' . esc_attr( $this->attributes['data-height'] ) . '" data-width="' . esc_attr( $this->attributes['data-width'] ) . '" type="text/html" id="' . esc_attr( $this->id() ) . '-tmpl">';
		$output .= $this->modal_template();
		$output .= '</script>';
		$output .= $this->render_footer_template();

		return $output;
	}

	/**
	 * Render the template code
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string HTML of rendered template
	 */
	public function modal_template() {
		$this->get_data(); // init data
		$output = wp_nonce_field( $this->id(), 'fwpmanipNonce_' . $this->id(), true, false );
		$output .= parent::render();

		return $output;
	}

	/**
	 * Render the footer template
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string HTML of rendered box
	 */
	public function render_footer_template() {
		$output = null;
		if ( ! empty( $this->footer ) ) {
			$output .= '<script type="text/html" id="' . esc_attr( $this->id() ) . '-footer-tmpl">';
			$output .= $this->footer->render();
			$output .= '</script>';
		}

		return $output;
	}

	/**
	 * Render templates to page
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 */
	public function output_templates() {
		echo $this->templates;
	}

	/**
	 * Enqueues specific tabs assets for the active pages
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_active_styles() {

		$style = 'h3#' . $this->id() . '_fwpmanipModalLable { background: ' . $this->base_color() . '; }';
		$style .= '#' . $this->id() . '_fwpmanipModal.fwpmanip-modal-wrap > .fwpmanip-modal-body:after {background: url(' . $this->url . 'assets/svg/loading.php?base_color=' . urlencode( str_replace( '#', '', $this->base_color() ) ) . ') no-repeat center center;}';

		fwpmanip_share()->set_active_styles( $style );
		parent::set_active_styles();
	}

}
