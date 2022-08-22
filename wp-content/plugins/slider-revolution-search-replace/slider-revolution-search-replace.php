<?php
/**
 * Plugin Name:       Slider Revolution Search Replace
 * Description:       Replace url of old domain to new domain for revolution slider only.
 * Version:           1.0
 * Requires at least: 5.0
 * Requires PHP:      5.6
 * Author:            Dhaval Kasavala
 * Author URI:        http://dhavalkasavala.wodpress.com/
 * License:           GPLv3 or later
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       slider-revolution-search-replace
 */


if ( ! defined( 'ABSPATH' ) ) {
	return;
}

if ( is_admin() ) {
	if ( ! function_exists( 'is_plugin_active' ) ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	if ( ! is_plugin_active( 'revslider/revslider.php' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		function srsr_requires_plugin() {
			echo '<div class="notice notice-warning is-dismissible"><p><strong>' . sprintf( __( '%1$s requires to install the %2$sRevolution slider%3$s plugin.', 'slider-revolution-search-replace' ), 'Slider Revolution - Search And Replace', '<a href="https://revolution.themepunch.com/" target="_blank">', '</a>' ) . '</strong></p></div>';
		}
		add_action( 'admin_notices', 'srsr_requires_plugin' );
		return;
	}
}


if ( ! defined( 'SRSR_VERSION' ) ) {
	define( 'SRSR_VERSION', '1.0' );
}

if ( ! defined( 'SRSR_PATH' ) ) {
	define( 'SRSR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'SRSR_FILE' ) ) {
	define( 'SRSR_FILE', __FILE__ );
}

if ( ! defined( 'SRSR_PLUGIN_URL' ) ) {
	define( 'SRSR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

require_once SRSR_PATH . '/admin/class-search-replace.php';

function srsr_init() {
		global $slider_revolution_search_replace;
		$slider_revolution_search_replacess = SRSR_Search_Replace::instance();
}
add_action( 'plugins_loaded', 'srsr_init' );
