<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'wp_my_instagram_shortcode') ){

	function wp_my_instagram_shortcode( $atts ){

		ob_start();

		WP_My_Instagram_Main::display_feed( $atts );

		$output = ob_get_clean();

		return $output;
	}

	add_shortcode( 'wp_my_instagram', 'wp_my_instagram_shortcode' );

}