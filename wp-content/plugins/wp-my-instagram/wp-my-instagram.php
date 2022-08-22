<?php
/*
Plugin Name: WP Instant Feeds
Plugin URI: https://wordpress.org/plugins/wp-my-instagram
Description: Display Instagram feeds on your site from your Instagram account
Version: 1.3.4
Author: mnmlthms
Author URI: http://mnmlthms.com
Text Domain: wp-my-instagram
Domain Path: /assets/languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright © 2017 mnmlthms.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WP_MY_INSTAGRAM_VERSION', '1.3.4' );
define( 'WP_MY_INSTAGRAM_OPTION', 'wp_my_instagram' );

if( !class_exists( 'WP_My_Instagram' ) ):

    /**
     * class WP_My_Instagram
     */
    final class WP_My_Instagram {
        /**
         * Constructor
         *
         * @return    void
         *
         * @access    public
         * @since     1.0
         */
        public function __construct() {

            add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
            add_action( 'after_setup_theme', array( $this, 'hooks' ) );
        }

        /**
         * Include admin files
         *
         * These functions are included on admin pages only.
         *
         * @return    void
         *
         * @access    private
         * @since     1.0
         */
        private function admin_includes() {
          
            /* exit early if we're not on an admin page */
            if ( ! is_admin() )
                return false;

        }
        /**
         * Fire on plugins_loaded
         *
         * @return    void
         *
         * @access    public
         * @since     1.0
         */
        public function plugins_loaded(){

            load_plugin_textdomain( 'wp-my-instagram', false, self::get_dirname() . '/langs/' ); 
        }

        /**
         * Execute the Hooks
         *
         * @return    void
         *
         * @access    public
         * @since     1.0
         */
        public function hooks() {

            add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ), 16 );

            add_action( 'wp_ajax_wpmi-init-cache', array( $this, 'ajax_load_cache') );
            add_action( 'wp_ajax_nopriv_wpmi-init-cache', array( $this, 'ajax_load_cache') );

            add_action( 'wp_ajax_wpmi-request-cache', array( $this, 'ajax_load_cache_js') );
            add_action( 'wp_ajax_nopriv_wpmi-request-cache', array( $this, 'ajax_load_cache_js') );


        }

        /**
         * JS and CSS
         *
         * @return    void
         *
         * @access    public
         * @since     1.0
         */
        public function wp_enqueue_scripts(){
            $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
            
            if( !apply_filters( 'wpim_raw_style', false ) ){
                wp_enqueue_style( 'wp-my-instagram', WP_My_Instagram::get_url() . 'css/style.css', array(), '1.0' );

            }

            wp_register_script( 'wp-my-instagram', WP_My_Instagram::get_url() . 'js/script' . $suffix . '.js', array( 'jquery' ), '1.0' );
            wp_localize_script( 'wp-my-instagram', 'wpMyInstagramVars', array(
                'nonce'     => esc_js( wp_create_nonce( 'wpmi-init-cache-nonce' ) ),
                'ajaxurl'   => admin_url( 'admin-ajax.php' )
            ) );
        }

        public function ajax_load_cache_js(){

            $nonce_key = 'wpmi-init-cache-nonce';

            check_ajax_referer( $nonce_key, 'security' );

            $response = array(
                'success' => true
            );

            $data = $_REQUEST['data'];

            $output = array();

            if( !class_exists( 'WP_My_Instagram_Main' ) ){

                require_once( 'inc/public/main.php' );
                
            }

            if( !empty( $data['images'] ) ){
                $scrape_key = !empty( $data['args']['hashtag'] ) ? $data['args']['hashtag'] : $data['args']['username'];
                $scrape_key = strtolower( $scrape_key );
                $scrape_key = str_replace( '@', '', $scrape_key );
                $scrape_key = trim( $scrape_key );

                $cache_name = WP_My_Instagram_Main::get_cache_name( $scrape_key, $data['args']['limit'], (boolean) $data['args']['hashtag'] );
                $cache_time = apply_filters( 'wpmi_cache_time', HOUR_IN_SECONDS*2 );

                // do not set an empty transient - should help catch private or empty accounts
                if ( ! empty( $data['images'] ) ) {

                    WP_My_Instagram_Main::set_cache( $cache_name, $data['images'], $cache_time );
                }

                ob_start();
                // cache
                WP_My_Instagram_Main::make_items( $data['images'], $data['args'] );
                $items = ob_get_clean();
                $output[$data['id']] = $items;

                $response['data'] = $output;
            }else{
                $response['success'] = false;
                $response['data'] = esc_html( 'Something went wrong! Please try again' );
            }

            wp_send_json( $response );

            wp_die(1);
        }
        /**
         * Load cache via ajax
         *
         * @return    void
         *
         * @access    public
         * @since     1.0.2
         */
        public function ajax_load_cache(){

            $nonce_key = 'wpmi-init-cache-nonce';

            check_ajax_referer( $nonce_key, 'security' );

            $response = array(
                'success' => true
            );

            $_args = $_REQUEST['args'];

            $output = array();

            if( !class_exists( 'WP_My_Instagram_Main' ) ){

                require_once( 'inc/public/main.php' );
                
            }

            foreach ( $_args as $key => $args) {

                $scrape_key = !empty( $args['hashtag'] ) ? $args['hashtag'] : $args['username'];

                if( empty( $scrape_key ) )
                    continue;

                $use_hashtag = !empty( $args['hashtag'] ) ? true : false;
                $popular = $use_hashtag && !empty( $args['popular'] ) ? true : false;
                $media_array = WP_My_Instagram_Main::scrape_instagram( $scrape_key, (int) $args['limit'], $use_hashtag, $popular );
                $media_array = (array) $media_array;
                $media_array = array_slice( $media_array, 0, (int) $args['limit'] );
                if ( is_wp_error( $media_array ) ) {
                    $output[$key] = $media_array->get_error_message();
                } else {
                    $items = '';
                    ob_start();
                    WP_My_Instagram_Main::make_items( $media_array, $args );
                    $items = ob_get_clean();
                    $output[$key] = $items;
                }
            }

            $response['data'] = $output;

            wp_send_json( $response );

            wp_die(1);

        }
        /**
         * Helpers
         *
         * @return    void
         *
         * @access    public
         * @since     1.0
         */
        static function get_url() {
            return plugin_dir_url( __FILE__ );
        }

        static function get_dir() {
            return plugin_dir_path( __FILE__ );
        }

        static function plugin_basename() {
            return plugin_basename( __FILE__ );
        }
        
        static function get_dirname( $path = '' ) {
            return dirname( plugin_basename( __FILE__ ) );
        }

    }

    require_once( 'inc/public/main.php' );
    require_once( 'inc/public/shortcode.php' );
    require_once( 'inc/public/widget.php' );

endif;

// Kickstart it
$GLOBALS['wp_my_instagram'] = new WP_My_Instagram;