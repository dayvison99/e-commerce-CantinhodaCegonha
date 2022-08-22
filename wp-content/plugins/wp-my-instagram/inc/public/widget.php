<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if( !class_exists('WP_My_Instagram_Widget') ):

	class WP_My_Instagram_Widget extends WP_Widget {
		/**
		 * Constructor
		 */
		public function __construct() {
			parent::__construct(
				'wp_my_instagram',
				esc_html__( 'WP Instant Feeds', 'wp-my-instagram' ),

				array(
					'classname' => 'wp-my-instagram',
					'description' => esc_html__( 'Displays your latest Instagram photos', 'wp-my-instagram' ),
					'customize_selective_refresh' => true
				)
			);
		}
		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {

			$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
			$username = empty( $instance['username'] ) ? '' : $instance['username'];
			$hashtag = empty( $instance['hashtag'] ) ? '' : $instance['hashtag'];
			$limit = empty( $instance['number'] ) ? 9 : $instance['number'];
			$size = empty( $instance['size'] ) ? 'large' : $instance['size'];
			$layout = empty( $instance['layout'] ) ? 'default' : $instance['layout'];
			$target = empty( $instance['target'] ) ? '_self' : $instance['target'];
			$link = empty( $instance['link'] ) ? '' : $instance['link'];

			$max = WP_My_Instagram_Main::$max;
			if( $limit > $max ){
				$limit = $max;
			}

			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
			}

			do_action( 'wpmiw_before_widget', $instance );

			if( empty( $username ) && empty( $hashtag ) ){
				if( current_user_can( 'edit_theme_options' ) ){
					esc_html_e( 'You need to input your username or hashtag!', 'wp-my-instagram' );
				}
			}else{
				WP_My_Instagram_Main::display_feed( $instance );
			}

			do_action( 'wpmiw_after_widget', $instance );

			echo $args['after_widget'];
		}
		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {

			$max = WP_My_Instagram_Main::$max;

			$instance = wp_parse_args( (array) $instance, 
				array( 
					'title' 	=> esc_html__( 'Instagram', 'wp-my-instagram' ), 
					'username' 	=> '', 
					'hashtag' 	=> '', 
					'size' 		=> 'large', 
					'layout' 	=> 'default', 
					'link' 		=> esc_html__( 'Follow Me!', 'wp-my-instagram' ), 
					'limit' 	=> 9, 
					'target' 	=> '_self' 
				) 
			);
			
			$title = $instance['title'];
			$username = $instance['username'];
			$hashtag = $instance['hashtag'];
			$limit = absint( $instance['limit'] );
			if( $limit > $max ){
				$limit = $max;
			}
			$size = $instance['size'];
			$layout = $instance['layout'];
			$target = $instance['target'];
			$link = $instance['link'];
			$preload = isset( $instance['preload'] ) ? $instance['preload'] : 0;
			?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wp-my-instagram' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', 'wp-my-instagram' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'hashtag' ) ); ?>"><?php esc_html_e( 'Hashtag', 'wp-my-instagram' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'hashtag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hashtag' ) ); ?>" type="text" value="<?php echo esc_attr( $hashtag ); ?>" /></label>
				<p><?php esc_html_e( 'If hashtag is entered, use hashtag instead.', 'wp-my-instagram'); ?></p>
			</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php echo wp_sprintf( esc_html__( 'Number of photos. Maximum %s', 'wp-my-instagram' ), $max ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" max="<?php echo esc_attr( $max );?>" value="<?php echo esc_attr( $limit ); ?>" /></label></p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Photo size', 'wp-my-instagram' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
					<option value="thumbnail" <?php selected( 'thumbnail', $size ) ?>><?php esc_html_e( 'Thumbnail', 'wp-my-instagram' ); ?></option>
					<option value="small" <?php selected( 'small', $size ) ?>><?php esc_html_e( 'Small', 'wp-my-instagram' ); ?></option>
					<option value="large" <?php selected( 'large', $size ) ?>><?php esc_html_e( 'Large', 'wp-my-instagram' ); ?></option>
					<option value="original" <?php selected( 'original', $size ) ?>><?php esc_html_e( 'Original', 'wp-my-instagram' ); ?></option>
				</select>
			</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>"><?php esc_html_e( 'Items per row', 'wp-my-instagram' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'layout' ) ); ?>" class="widefat">
					<option value="default" <?php selected( 'default', $layout ) ?>><?php esc_html_e( 'Default', 'wp-my-instagram' ); ?></option>
					<option value="2" <?php selected( '2', $layout ) ?>><?php esc_html_e( '2 items', 'wp-my-instagram' ); ?></option>
					<option value="3" <?php selected( '3', $layout ) ?>><?php esc_html_e( '3 items', 'wp-my-instagram' ); ?></option>
					<option value="4" <?php selected( '4', $layout ) ?>><?php esc_html_e( '4 items', 'wp-my-instagram' ); ?></option>
					<option value="5" <?php selected( '5', $layout ) ?>><?php esc_html_e( '5 items', 'wp-my-instagram' ); ?></option>
					<option value="6" <?php selected( '6', $layout ) ?>><?php esc_html_e( '6 items', 'wp-my-instagram' ); ?></option>
					<option value="8" <?php selected( '8', $layout ) ?>><?php esc_html_e( '8 items', 'wp-my-instagram' ); ?></option>
					<option value="10" <?php selected( '10', $layout ) ?>><?php esc_html_e( '10 items', 'wp-my-instagram' ); ?></option>
				</select>
			</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open links in', 'wp-my-instagram' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
					<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window (_self)', 'wp-my-instagram' ); ?></option>
					<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window (_blank)', 'wp-my-instagram' ); ?></option>
				</select>
			</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link text', 'wp-my-instagram' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></label></p>
			<p><input id="<?php echo $this->get_field_id('preload'); ?>" name="<?php echo $this->get_field_name('preload'); ?>" type="checkbox"<?php checked( $preload ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('preload'); ?>"><?php esc_html_e( 'Preload/Reload cache', 'wp-my-instagram'); ?></label></p>
			<p><?php esc_html_e( 'When you check "Preload/Reload cache", new cache will be generated after saving this widget, this might take a while to finish.', 'wp-my-instagram'); ?></p>
			<?php
		}
		/**
		 * Processing widget options on save
		 *
		 * @param array $new_instance The new options
		 * @param array $old_instance The previous options
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
			$instance['hashtag'] = trim( strip_tags( $new_instance['hashtag'] ) );
			$instance['limit'] = ! absint( $new_instance['limit'] ) ? 9 : sanitize_text_field( $new_instance['limit'] );;
			$instance['size'] = ( ( $new_instance['size'] == 'thumbnail' || $new_instance['size'] == 'large' || $new_instance['size'] == 'small' || $new_instance['size'] == 'original' ) ? $new_instance['size'] : 'large' );
			$instance['layout'] = in_array( $new_instance['layout'], array( 'default', '2', '3', '4', '5', '6', '8', '10' ) ) ? $new_instance['layout'] : 'default';
			$instance['target'] = ( ( $new_instance['target'] == '_self' || $new_instance['target'] == '_blank' ) ? $new_instance['target'] : '_self' );
			$instance['link'] = strip_tags( $new_instance['link'] );
			
			$max = WP_My_Instagram_Main::$max;

			if( $instance['limit'] > $max ){
				$instance['limit'] = $max;
			}

			if( !empty( $new_instance['preload'] ) ){
				$username = $instance['username'];
				$hashtag = $instance['hashtag'];
				$key = $hashtag ? $hashtag : $username;
				$limit = $instance['limit'];
				$use_hashtag = $hashtag ? true : false;
				WP_My_Instagram_Main::delete_cache( $key, $limit, $use_hashtag );
				WP_My_Instagram_Main::scrape_instagram( $key, $limit, $use_hashtag );
			}

			return $instance;
		}
		/**
		 * Helper
		 */
		public function images_only( $media_item ) {

			if ( $media_item['type'] == 'image' )
				return true;

			return false;
		}
	}

endif;

if( !function_exists( 'wpmi_register_wpmi_widget') ){
	function wpmi_register_wpmi_widget() {
	    register_widget( 'WP_My_Instagram_Widget' );
	}
}

add_action( 'widgets_init', 'wpmi_register_wpmi_widget' );
