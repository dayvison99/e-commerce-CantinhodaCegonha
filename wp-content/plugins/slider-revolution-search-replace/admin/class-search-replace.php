<?php

class SRSR_Search_Replace {

	private static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'srsr_register_sub_menu' ) );
		add_action( 'admin_post_slider_revolution_search_replace', array( $this, 'rsrs_page_save_options' ) );
		session_start();
		if ( isset( $_SESSION['rev_status'] ) && $_SESSION['rev_status'] === 'true' && ! empty( $_SESSION['rev_status'] ) ) {
			add_action( 'admin_notices', array( $this, 'srsr_success' ) );
			unset( $_SESSION['rev_status'] );
		} elseif ( isset( $_SESSION['rev_status'] ) && $_SESSION['rev_status'] === 'false' && ! empty( $_SESSION['rev_status'] ) ) {
			add_action( 'admin_notices', array( $this, 'srsr_error' ) );
			unset( $_SESSION['rev_status'] );
		}
	}

	/**
	 * Register submenu
	 *
	 * @return void
	 */
	public function srsr_register_sub_menu() {
		add_submenu_page(
			'tools.php',
			'Revolution Slider Search Replace',
			'Revolution Slider Search Replace',
			'manage_options',
			'revsearch-replace-page',
			array( $this, 'srsr_submenu_page' )
		);
	}

	/**
	 * Render submenu
	 *
	 * @return void
	 */
	public function srsr_submenu_page() {
		?>

		<div class="wrap">
		
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		
		<form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">

			<table class="form-table">
				<tr>
					<th>
						<label><?php esc_html_e( 'Old Url ', 'slider-revolution-search-replace' ); ?></label>
					</th>
					<td>
						<input type="text" name="old_url" required class="regular-text" />
					</td>
				</tr>
				<tr>
					<th>
						<label><?php esc_html_e( 'New Url ', 'slider-revolution-search-replace' ); ?></label>
					</th>
					<td>
						<input type="text" name="new_url" required class="regular-text" />
					</td>
				</tr>
			</table>
			<input type="hidden" name="action" value="slider_revolution_search_replace">
			<?php
				wp_nonce_field( 'slider_revolution_search_replace_nonce', 'slider_revolution_search_replace' );
				submit_button( 'Replace URL' );
			?>
		</form>
		</div><!-- .wrap -->
		<?php
	}

	public function rsrs_page_save_options() {
		if ( isset( $_POST['slider_revolution_search_replace'] ) && wp_verify_nonce( $_POST['slider_revolution_search_replace'], 'slider_revolution_search_replace_nonce' ) ) {

			$old_url = sanitize_text_field( $_POST['old_url'] );
			$new_url = sanitize_text_field( $_POST['new_url'] );

			global $wpdb;

			$slides = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}revslider_slides", ARRAY_A );

			foreach ( $slides as $rs ) {
				$params = json_decode( $rs['params'], true );
				foreach ( json_decode( $rs['params'], true ) as $key => $param ) {
					if ( isset( $param['image'] ) ) {
						$params['bg']['image'] = str_replace( $old_url, $new_url, $param['image'] );
					}
				}
				$rs['params'] = json_encode( $params, false );

				$layers = json_decode( $rs['layers'], true );
				foreach ( json_decode( $rs['layers'], true ) as $key => $layer ) {
					if ( isset( $layer['actions']['action'][0]['image_link'] ) ) {
						$layers[ $key ]['actions']['action'][0]['image_link'] = str_replace( $old_url, $new_url, $layer['actions']['action'][0]['image_link'] );
					}
					if ( isset( $layer['media']['imageUrl'] ) ) {
						$layers[ $key ]['media']['imageUrl'] = str_replace( $old_url, $new_url, $layer['media']['imageUrl'] );
					}
				}

				$rs['layers'] = json_encode( $layers, false );

				$data         = array(
					'params' => $rs['params'],
					'layers' => $rs['layers'],
				);
				$format       = array( '%s', '%s' );
				$where        = array( 'id' => $rs['id'] );
				$where_format = array( '%d' );

				$updates = $wpdb->update( $wpdb->prefix . 'revslider_slides', $data, $where, $format, $where_format );
				if ( $updates ) {
					$_SESSION['rev_status'] = 'true';
					if ( $_SESSION['rev_status'] === 'true' ) {
						$location = get_site_url() . '/wp-admin/tools.php?page=revsearch-replace-page';
						wp_redirect( $location );
					}
				} else {
					$_SESSION['rev_status'] = 'false';
					if ( $_SESSION['rev_status'] === 'false' ) {
						$location = get_site_url() . '/wp-admin/tools.php?page=revsearch-replace-page';
						wp_redirect( $location );
					}
				}
			}
		}
	}

	public function srsr_success() {
		?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e( 'URLs are replace successfully.', 'slider-revolution-search-replace' ); ?></p>
		</div>
		<?php
	}

	public function srsr_error() {
		$class   = 'notice notice-error is-dismissible';
		$message = __( 'Something went wrong!', 'slider-revolution-search-replace' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
	}
}
