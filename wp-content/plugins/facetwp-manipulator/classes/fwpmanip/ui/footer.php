<?php
/**
 * FWPMANIP Footer
 *
 * @package   ui
 * @author    David Cramer
 * @license   GPL-2.0+
 * @link
 * @copyright 2016 David Cramer
 */
namespace fwpmanip\ui;

/**
 * Footer type used for creating footer based sections. Mainly used in modals and pages
 *
 * @package fwpmanip\ui
 * @author  David Cramer
 */
class footer extends section {

	/**
	 * The type of object
	 *
	 * @since 1.0.0
	 * @access public
	 * @var      string
	 */
	public $type = 'footer';


	/**
	 * Render the Control
	 *
	 * @since 1.0.0
	 * @see \fwpmanip\ui\fwpmanip
	 * @access public
	 * @return string HTML of rendered box
	 */
	public function render() {

		$output = $this->render_template();
		if ( ! empty( $this->child ) ) {
			$output .= $this->render_children();
		}

		return $output;
	}

}
