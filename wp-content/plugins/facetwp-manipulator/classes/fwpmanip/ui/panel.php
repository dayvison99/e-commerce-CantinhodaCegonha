<?php
/**
 * FWPMANIP Panel
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace fwpmanip\ui;

/**
 * FWPMANIP panel. a holder to contain sections. a panel with multiple sections creates a tabbed interface to switch between sections areas.
 *
 * @package fwpmanip\ui
 * @author  David Cramer
 */
class panel extends \fwpmanip\data\data {

	/**
	 * The type of object
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      string
	 */
	public $type = 'panel';

	/**
	 * Define core panel styles ans scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_assets() {

		$this->assets['script']['panel'] = $this->url . 'assets/js/panel' . FWPMANIP_ASSET_DEBUG . '.js';
		$this->assets['style']['panel']  = $this->url . 'assets/css/panel' . FWPMANIP_ASSET_DEBUG . '.css';

		parent::set_assets();

	}

	/**
	 * Get Data from all controls of this section
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\load
	 * @return array|null Array of sections data structured by the controls or null if none.
	 */
	public function get_data() {

		if ( empty( $this->data ) ) {
			$this->data = array(
				$this->slug => $this->get_child_data(),
			);
		}

		return $this->data;
	}

	/**
	 * Sets the data for all children
	 *
	 * @since 1.0.0
	 * @access protected
	 * @return array data of the child objects.
	 */
	protected function get_child_data() {

		$data = array();
		foreach ( $this->child as $child ) {
			if ( null !== $child->get_data() ) {
				$data += $child->get_data();
			}
		}
		if ( ! empty( $this->struct['data'] ) ) {
			$data = array_merge( $this->struct['data'], $data );
		}

		return $data;
	}


	/**
	 * Sets the data for all children
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function set_data( $data ) {

		if ( ! empty( $data[ $this->slug ] ) ) {
			foreach ( $this->child as $child ) {
				if ( method_exists( $child, 'set_data' ) ) {
					$child->set_data( $data[ $this->slug ] );
				}
			}
			$this->data = $data[ $this->slug ];
		}

	}

	/**
	 * Render the panel
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function render() {
		$output = null;

		if ( $this->child_count() > 0 ) {

			$output .= '<div id="panel-' . esc_attr( $this->id() ) . '" class="fwpmanip-' . esc_attr( $this->type ) . '-inside ' . esc_attr( $this->wrapper_class_names() ) . '">';
			// render a lable
			$output .= $this->label();
			// render a desciption
			$output .= $this->description();
			// render navigation tabs
			$output .= $this->navigation();
			// sections
			$output .= $this->panel_section();

			$output .= '</div>';
		} else {
			// sections
			$output .= $this->panel_section();
		}

		$output .= $this->render_template();

		return $output;
	}

	/**
	 * Determines the number of useable children for tab display
	 *
	 * @since 1.0.0
	 * @access public
	 * @return int Number of tabable children
	 */
	public function child_count() {

		$count = 0;
		if ( ! empty( $this->child ) ) {
			foreach ( $this->child as $child ) {
				if ( $this->is_section_object( $child ) ) {
					$count ++;
				}
			}
		}

		return $count;
	}

	/**
	 * Check if child is a section object
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param fwpmanip Object to test if it is to be rendered in a section
	 *
	 * @return string|null HTML of rendered description
	 */
	public function is_section_object( $section ) {
		$types = explode( '\\', get_class( $section ) );
		$excl = array( 'help', 'header', 'footer', 'control' );
		$merge = array_merge( $types, $excl );
		$unique = array_unique( $merge );
		return count( $merge ) === count( $unique );
	}

	/**
	 * Check if child is a control object
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param fwpmanip Object to test if it is to be rendered in a section
	 *
	 * @return string|null HTML of rendered description
	 */
	public function is_control_object( $object ) {

		return (bool) strpos( get_class( $object ), 'control' );
	}

	/**
	 * Returns the class names for the tab wrapper
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function wrapper_class_names() {

		$wrapper_class_names = array(
			'fwpmanip-panel-inside',
		);

		if ( $this->child_count() > 1 ) {
			$wrapper_class_names[] = 'fwpmanip-has-tabs';

			if ( ! empty( $this->struct['top_tabs'] ) ) {
				$wrapper_class_names[] = 'fwpmanip-top-tabs';
			}
		}

		return implode( ' ', $wrapper_class_names );
	}

	/**
	 * Render the panels label
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string|null rendered html of label
	 */
	public function label() {
		$output = null;
		if ( ! empty( $this->struct['label'] ) ) {
			$output .= '<div class="fwpmanip-' . esc_attr( $this->type ) . '-heading"><h3 class="fwpmanip-' . esc_attr( $this->type ) . '-title">' . esc_html( $this->struct['label'] ) . '</h3></div>';
		}

		return $output;
	}

	/**
	 * Render the panels Description
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string|null HTML of rendered description
	 */
	public function description() {
		$output = null;
		if ( ! empty( $this->struct['description'] ) ) {
			$output .= '<div class="fwpmanip-' . esc_attr( $this->type ) . '-heading"><p class="fwpmanip-' . esc_attr( $this->type ) . '-subtitle description">' . esc_html( $this->struct['description'] ) . '</p></div>';
		}

		return $output;
	}

	/**
	 * Render the panels navigation tabs
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string|null Html of rendered navigation tabs
	 */
	public function navigation() {
		$output = null;

		if ( $this->child_count() > 1 ) {

			$output .= '<ul class="fwpmanip-' . esc_attr( $this->type ) . '-tabs fwpmanip-panel-tabs">';
			$active = 'true';
			foreach ( $this->child as $child ) {
				if ( $this->is_section_object( $child ) ) {
					$output .= $this->tab_label( $child, $active );
					$active = 'false';
				}
			}
			$output .= '</ul>';
		}

		return $output;
	}

	/**
	 * Render the tabs label
	 *
	 * @since 1.0.0
	 *
	 * @param object $child Child object to render tab for.
	 * @param string $active Set the tabactive or not.
	 *
	 * @access private
	 * @return string|null html of rendered label
	 */
	private function tab_label( $child, $active ) {

		$output = null;

		$label = esc_html( $child->struct['label'] );

		if ( ! empty( $child->struct['icon'] ) ) {
			$label = '<i class="dashicons ' . $child->struct['icon'] . '"></i><span class="label">' . esc_html( $child->struct['label'] ) . '</span>';
		}

		$output .= '<li aria-selected="' . esc_attr( $active ) . '">';
		$output .= '<a href="#' . esc_attr( $child->id() ) . '" data-parent="' . esc_attr( $this->id() ) . '" class="fwpmanip-tab-trigger">' . $label . '</a>';
		$output .= '</li>';

		return $output;
	}

	/**
	 * Render the panels Description
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string|null HTML of rendered description
	 */
	public function panel_section() {
		$output = null;

		// render the section wrapper
		$output .= '<div class="fwpmanip-' . esc_attr( $this->type ) . '-sections fwpmanip-sections">';

		$hidden = 'false';
		foreach ( $this->child as $section ) {

			if ( ! $this->is_section_object( $section ) && ! $this->is_control_object( $section ) ) {
				continue;
			}

			$section->struct['active'] = $hidden;
			$output .= $section->render();
			$hidden = 'true';
		}

		$output .= '</div>';

		return $output;
	}

	/**
	 * Render a template based object
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string|null HTML of rendered template
	 */
	public function render_template() {
		// template
		$_output = null;

		if ( ! empty( $this->struct['template'] ) ) {
			ob_start();
			include $this->struct['template'];
			$_output .= ob_get_clean();
		}

		return $_output;
	}

	/**
	 * Enqueues specific tabs assets for the active pages
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function set_active_styles() {
		$style = '#panel-' . $this->id() . ' > .fwpmanip-panel-tabs > li[aria-selected="true"] a {box-shadow: 3px 0 0 ' . $this->base_color() . ' inset;}';
		$style .= '#panel-' . $this->id() . '.fwpmanip-top-tabs > .fwpmanip-panel-tabs > li[aria-selected="true"] a {	box-shadow: 0 3px 0 ' . $this->base_color() . ' inset;}';
		fwpmanip_share()->set_active_styles( $style );
	}
}
