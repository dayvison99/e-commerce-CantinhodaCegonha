<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Main Class
 */
if( !class_exists( 'WP_My_Instagram_Main') ):
	
	class WP_My_Instagram_Main{

		static $max = 12;

		/**
		 * Display Feed
		 * @since 1.0.0
		 */
		public function images_only( $media_item ) {

			if ( $media_item['type'] == 'image' )
				return true;

			return false;
		}
		/**
		 * Feed args normalizer
		 * @since 1.1.4
		 * @version 1.0.0
		 */
		static function normalize_args( $args ){
			$args = wp_parse_args( $args, array(
				'template'	=> false,
	 			'username' 	=> '',
	 			'hashtag' 	=> '', //If hashtag entered, use hashtag
				'limit' 	=> 6,
				'size'		=> 'large', //thumbnail, small, large, original
				'layout'	=> '3', // default, 2, 3, 4, 5, 6, 8, 10
				'target'	=> '_blank',
				'link'		=> '',
				'popular'		=> false
			) );

			if( $args['limit'] > self::$max ){
				$args['limit'] = self::$max;
			}

			$args['layout'] = !in_array( $args['layout'], array( 'default', '2', '3', '4', '5', '6', '8', '10' ) ) ? 'default' : $args['layout'];
			$args['username'] = (string) $args['username'];
			$args['hashtag'] = (string) $args['hashtag'];

			return $args;
		}

		/**
		 * Display Feed
		 * @since 1.0.0
		 * @version 1.1.1
		 */
		static function display_feed( $args = array() ){
			$args = self::normalize_args( $args );
			$media_array = self::get_feeds( $args );

			$cached = false;
			$use_hashtag = !empty( $args['hashtag'] ) ? true : false;

			$scrape_key = $args['hashtag'] ? $args['hashtag'] : $args['username'];

			if ( is_wp_error( $media_array ) ) {

				echo wp_kses_post( $media_array->get_error_message() );

			} else {
				// filter for images only?
				if ( $images_only = apply_filters( 'wpmi_images_only', false ) ) {
					$media_array = array_filter( $media_array, array( __CLASS__, 'images_only' ) );
				}
				// slice list down to required limit
				$media_array = array_slice( $media_array, 0, (int) $args['limit'] );

				if( !empty( $media_array ) ){
					$cached = true;
				}
				
				if( !$cached ){
					wp_enqueue_script( 'wp-my-instagram' );
				}
				?>
				<div id="wpmi-<?php echo esc_attr( uniqid() );?>" class="wp-my-instagram wpmi" data-args="<?php echo esc_attr( json_encode($args) );?>" data-cached="<?php echo esc_attr( $cached ? 'true' : 'false' );?>">
					<ul class="wpmi-list wpmi-layout-<?php echo esc_attr( $args['layout'] );?>">
						<?php
							if( !empty( $media_array ) ){

								self::make_items( $media_array, $args );
								
							}
						?>
					</ul>
					<?php 

					if( $args['link'] ){
						$url_instagram = '//instagram.com/';
						$url = $use_hashtag ? $url_instagram . 'explore/tags/' . $args['hashtag'] : $url_instagram . $args['username'];
						$rel = $use_hashtag ? '' : ' rel="me"';
					?>
					<div class="wpmi-me"><a href="<?php echo esc_url( trailingslashit( $url ) ); ?>" target="<?php echo esc_attr( $args['target'] ); ?>"<?php echo !empty( $rel) ? $rel : '';?>><?php echo wp_kses_post( $args['link'] ); ?></a></div>
					<?php
					}?>
				</div>
				<?php
			}
		}
		/**
		 * Display Feed
		 * @since 1.1.4
		 * @version 1.0.0
		 */
		static function get_feeds( $args = array() ){

			$args = self::normalize_args( $args );
			$scrape_key = !empty( $args['hashtag'] ) ? $args['hashtag'] : $args['username'];
			$use_hashtag = !empty( $args['hashtag'] ) ? true : false;
			$prefix = $use_hashtag ? 'tag' : 'user';

			if( empty( $args['username'] ) && empty( $args['hashtag'] ) )
				echo esc_html__( 'You need to input your username or hashtag.', 'wp-my-instagram' );

			// Test Drive
			// $a = self::_get_batch('https://www.instagram.com/instagram/', false);
			// print_r($a);
			// $a = self::_get_batch('https://www.instagram.com/explore/tags/snkr/', true);
			
			$output = '';

			$media_array = array();

			if( self::get_cache( $scrape_key, (int) $args['limit'], $use_hashtag ) ){

				$feeds = self::scrape_instagram( $scrape_key, (int) $args['limit'], $use_hashtag, $args['popular'] );
				
				if ( !is_wp_error( $feeds ) ) {
					$media_array = (array) $feeds;
				}
				
			}

			return $media_array;
		}
		/**
		 * Get item Template
		 * @since 1.1.4
		 * @version 1.0.0
		 */
		static function get_template_item(){
			return apply_filters( 'wpmi_item_template', WP_My_Instagram::get_dir() . "inc/templates/item.php" );
		}
		/**
		 * Make items
		 * @since 1.0.2
		 * @version 1.2.1
		 */
		static function make_items( $media_array = array(), $args = array() ){

			$use_template = self::get_template_item();

			if( !is_array( $media_array ) ){
				return;
			}

			if( empty( $media_array ) )
				return;

			foreach ( $media_array as $item ) {
				
				$item = wp_parse_args( $item, array(
					'url' => '',
					'type' => '',
					'description' => '',
					'time' => '',
					'comments' => '',
					'likes' => '',
					'thumbnail' => '',
					'xsmall' => '',
					'small' => '',
					'medium' => '',
					'large' => '',
					'original' => '',

				) );

				$item['thumbnail'] = rawurldecode($item['thumbnail']);
				$item['xsmall'] = rawurldecode($item['xsmall']);
				$item['small'] = rawurldecode($item['small']);
				$item['medium'] = rawurldecode($item['medium']);
				$item['large'] = rawurldecode($item['large']);
				$item['original'] = rawurldecode($item['original']);

				include( $use_template );
			}
		}
        /**
		 * Get cache name
		 * @var $key 	string username or hashtag
		 * @var $limit 	int
		 * @var $prefix 	string
		 * @since 1.0
		 * @version 1.1.0
		 */
		static function get_cache_name( $key, $limit, $use_hashtag = false ){
			$prefix = $use_hashtag ? 'tag' : 'user';
			$key = strtolower( $key );
			$key = strtr( $key, array( '@' => '', '#' => '' ) );
			$count = ceil( $limit/self::$max );
			return 'wpmi-' . sanitize_title_with_dashes( $prefix . '-' . $key . '-' . $count );
		}
		/**
		 * Get cache
		 * @since 1.0.2
		 * @version 1.1.0
		 */
		static function get_cache( $username, $limit, $use_hashtag = false){

			return get_transient( self::get_cache_name( $username, $limit, $use_hashtag ) );
		}
		/**
		 * Set Cache
		 * @since 1.0
		 * @version 1.1.0
		 */
		static function set_cache( $name, $value, $expiration ){
			if( empty( $name ) && empty( $value ) ){
				return;
			}

			$value = base64_encode( serialize( $value ) );

			set_transient( $name, $value, $expiration );

		}
		/**
		 * Delete Cache
		 * @since 1.0
		 * @version 1.1.0
		 */
		static function delete_cache( $username, $limit, $use_hashtag = false ){

			$transient_name = self::get_cache_name( $username, $limit, $use_hashtag );

			delete_transient( $transient_name );

		}
		/**
		 * Get Batch
		 * @since 1.0
		 * @version 1.1.2
		 */
		private static function _get_batch( $url, $use_hashtag = false, $popular = false ){

			if( empty( $url ) )
				return false;

			$remote = wp_remote_get( $url, array( 
				'user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1', 
				'timeout' => 120, 
				'sslverify' => false
			) );

			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'wp-my-instagram' ) );

			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'wp-my-instagram' ) );

			$shared_data = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shared_data[1] );
			$insta_array = json_decode( $insta_json[0], TRUE );
			// print_r( $insta_array['entry_data']);
			// print_r( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] );
			if ( ! $insta_array )
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'wp-my-instagram' ) );

			$hash_tag_media = 'edge_hashtag_to_media';
			if( $popular && $use_hashtag ){
				$hash_tag_media = 'edge_hashtag_to_top_posts';
			}

			// Username
			// old node: $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes']
			// new node 2018: $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges']
			if ( !$use_hashtag && isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			}

			// Hashtag
			// Old node: $insta_array['entry_data']['TagPage'][0]['tag']['media']['nodes']
			// New node 2018: $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges']
			
			// top posts: edge_hashtag_to_top_posts
			// latest: edge_hashtag_to_media
			elseif( $use_hashtag && isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag'][$hash_tag_media]['edges'] ) ){
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag'][$hash_tag_media]['edges'];
			}else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'wp-my-instagram' ) );
			}

			if ( ! is_array( $images ) )
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'wp-my-instagram' ) );

			$instagram = array();

			foreach ( $images as $_image ) {

				$image = $_image['node'];
				
				// Sizes:

				// 150x150
				$image_args['thumbnail'] = !empty( $image['thumbnail_resources'][0]['src']) ? preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][0]['src'] ) : '';
				// 240x240
				$image_args['xsmall'] = !empty( $image['thumbnail_resources'][1]['src']) ? preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][1]['src'] ) : '';
				// 320x320
				$image_args['small'] = !empty( $image['thumbnail_resources'][2]['src']) ? preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][2]['src'] ) : '';
				// 480x480
				$image_args['medium'] = !empty( $image['thumbnail_resources'][3]['src']) ? preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][3]['src'] ) : '';
				// 480x480
				$image_args['large'] = !empty( $image['thumbnail_src']) ? preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] ) : '';

				$image_args['original'] = !empty( $image['display_url']) ? preg_replace( '/^https?\:/i', '', $image['display_url'] ) : '';

				
				// Link:
				$image_args['url'] = trailingslashit( '//instagram.com/p/' . $image['shortcode'] );
				// Type:
				$image_args['type'] = !empty( $image['is_video'] ) ? 'video' : 'image';
				// Desc:
				$image_args['description'] = !empty( $image['edge_media_to_caption']['edges'][0]['node']['text'] ) ? trim($image['edge_media_to_caption']['edges'][0]['node']['text']) :'';
				// Time
				$image_args['time'] = !empty( $image['taken_at_timestamp'] ) ? $image['taken_at_timestamp'] : '';
				// Comments:
				$image_args['comments'] = !empty( $image['edge_media_to_comment']['count'] ) ? $image['edge_media_to_comment']['count'] : '';
				// Likes
				$image_args['likes'] = !empty( $image['edge_liked_by']['count'] ) ? $image['edge_liked_by']['count'] : '';

				$instagram[] = $image_args;
			}

			return $instagram;
		}	
		/**
		 * Get Instagram
		 * 
		 * @var 
		 * @since 1.0
		 * @version 1.1.0
		 * Special Thanks to Scott Evans - wp-instagram-widget
		 */
		// based on https://gist.github.com/cosmocatalano/4544576

		static function scrape_instagram( $_scrape_key, $_limit = 12, $_use_hashtag = false, $_popular = false ) {

			$base_url = 'https://instagram.com/';
			$_scrape_key = strtolower( $_scrape_key );
			$_scrape_key = str_replace( '@', '', $_scrape_key );
			$_scrape_key = trim( $_scrape_key );
			// 2018dec24
			// Maximum items can get now 24

			$url = $base_url . $_scrape_key;
			// If use hashtag
			if( $_use_hashtag ){
				$url = $base_url . 'explore/tags/' . $_scrape_key;
			}

			// Get cache
			$cache_name = self::get_cache_name( $_scrape_key, $_limit, $_use_hashtag );
			$cache_time = apply_filters( 'wpmi_cache_time', HOUR_IN_SECONDS*2 );


			// no caching on customizer
			$customizer = ( function_exists( 'is_customize_preview') && is_customize_preview() );
			$_debug = defined( 'WP_DEBUG' ) && WP_DEBUG ? true : false;

			// flush cache is debug mode is on
		    if( $_debug || $customizer ){
		    	self::delete_cache( $_scrape_key, $_limit, $_use_hashtag );
		    }

			$feed = self::get_cache( $_scrape_key, $_limit, $_use_hashtag );

			if ( false === $feed ) {
				$feed = array();	
				$batches = ceil( $_limit/self::$max );

				$last_id = false;

				for ( $i=0; $i < $batches; $i++ ) {

					// Trick facebook pagination :P
					$batch = $last_id ? $url . "/?max_id={$last_id}" : $url;

					$instagram = self::_get_batch( $batch, $_use_hashtag, $_popular );

					if( is_array( $instagram ) ){
						$last_image = end( $instagram );
						$last_id = !empty( $last_image['id'] ) ? $last_image['id'] : 0;
						$feed = array_merge( $feed, $instagram );
					}
				}

				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $feed ) ) {

					self::set_cache( $cache_name, $feed, $cache_time );
				}
			}


			if ( ! empty( $feed ) ) {

				if( !is_array( $feed ) ){
					$feed = unserialize( base64_decode( $feed ) );
					
				}
							
				return $feed;

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wp-my-instagram' ) );

			}
		}
	}
endif;

if( !function_exists( 'wp_my_instagram') ){
	function wp_my_instagram( $args = array()){

		if( !is_array( $args ) ){
			esc_html_e( 'This param must be an array.', 'wp-my-instagram' );
			return;
		}

		WP_My_Instagram_Main::display_feed( $args );

	}
}