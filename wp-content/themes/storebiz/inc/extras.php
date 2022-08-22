<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package StoreBiz
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function storebiz_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'storebiz_body_classes' );

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Backward compatibility for wp_body_open hook.
	 *
	 * @since 1.0.0
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

if (!function_exists('storebiz_str_replace_assoc')) {

    /**
     * storebiz_str_replace_assoc
     * @param  array $replace
     * @param  array $subject
     * @return array
     */
    function storebiz_str_replace_assoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
}

 /**
 * Add WooCommerce Cart Icon With Cart Count (https://isabelcastillo.com/woocommerce-cart-icon-count-theme-header)
 */
function storebiz_add_to_cart_fragment( $fragments ) {
	
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?> 
	<div class="cart-main">
		<button type="button" class="cart-icon-wrap header-cart">
			<svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"><path data-name="Cart Icon" d="M20.04 18.422h-9.55m-1.12-.024c-.45 0-.76.009-1.08 0a2.246 2.246 0 01-2.06-1.526 2.213 2.213 0 01.79-2.593.669.669 0 00.31-.855C6.45 9.497 5.59 5.566 4.72 1.56H2.3c-.51 0-1.01.024-1.51-.011A.752.752 0 010 .778.721.721 0 01.78.012c1.49-.019 2.98-.013 4.47 0a.814.814 0 01.84.74c.16.76.34 1.516.52 2.327h18.07c.18 0 .35-.01.52.006a.777.777 0 01.76 1.048c-.99 3.517-2 7.031-3 10.545a.962.962 0 01-1.13.676q-6.465-.013-12.95 0c-.19 0-.39 0-.58.014a.675.675 0 00-.66.685.7.7 0 00.6.8 3.061 3.061 0 00.63.031H22.06a.8.8 0 01.89.78.779.779 0 01-.88.741h-.91m-12.18-4.61c.15.015.23.03.3.03 3.97 0 7.93 0 11.9.012a.518.518 0 00.58-.481c.63-2.284 1.29-4.563 1.93-6.845.18-.611.35-1.222.53-1.865H6.96c.67 3.054 1.34 6.086 2.02 9.145zm11.16 6.2c1.49.7 2.05 1.693 1.81 3.011a2.336 2.336 0 01-2.21 1.987 2.39 2.39 0 01-2.41-1.827c-.34-1.253.19-2.285 1.64-3.149m-8.98 0c1.45.752 1.98 1.741 1.69 3.07a2.356 2.356 0 01-2.34 1.914 2.423 2.423 0 01-2.29-1.91c-.29-1.228.29-2.32 1.77-3.1m.5 3.318a.81.81 0 00.06-1.618.78.78 0 00-.78.853.73.73 0 00.72.765zm11.07-.761a.74.74 0 00-.75-.847.726.726 0 00-.78.769.752.752 0 00.78.836.717.717 0 00.75-.758z" fill-rule="evenodd"/></svg>
			<?php 	
				if ( $count > 0 ) {
				?>
					 <span><?php echo esc_html( $count ); ?></span>
				<?php 
				}
				else {
					?>
					<span><?php esc_html_e('0','storebiz'); ?></span>
					<?php 
				}
			?>
		</button>
		<span class="cart-label">
			<?php 	
				if ( $count > 0 ) {
				?>
					 <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
				<?php 
				}
				else {
					?>
					<span><?php esc_html_e('0','storebiz'); ?></span>
					<?php 
				}
			?>
		</span>
	</div>
	<?php
 
    $fragments['.cart-main'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'storebiz_add_to_cart_fragment' );



if ( ! function_exists( 'storebiz_breadcrumb_title' ) ) {
	function storebiz_breadcrumb_title() {
		
		if ( is_home() || is_front_page()):
			
			single_post_title();
			
		elseif ( is_day() ) : 
										
			printf( __( 'Daily Archives: %s', 'storebiz' ), get_the_date() );
		
		elseif ( is_month() ) :
		
			printf( __( 'Monthly Archives: %s', 'storebiz' ), (get_the_date( 'F Y' ) ));
			
		elseif ( is_year() ) :
		
			printf( __( 'Yearly Archives: %s', 'storebiz' ), (get_the_date( 'Y' ) ) );
			
		elseif ( is_category() ) :
		
			printf( __( 'Category Archives: %s', 'storebiz' ), (single_cat_title( '', false ) ));

		elseif ( is_tag() ) :
		
			printf( __( 'Tag Archives: %s', 'storebiz' ), (single_tag_title( '', false ) ));
			
		elseif ( is_404() ) :

			printf( __( 'Error 404', 'storebiz' ));
			
		elseif ( is_author() ) :
		
			printf( __( 'Author: %s', 'storebiz' ), (get_the_author( '', false ) ));			
			
		elseif ( class_exists( 'woocommerce' ) ) : 
			
			if ( is_shop() ) {
				woocommerce_page_title();
			}
			
			elseif ( is_cart() ) {
				the_title();
			}
			
			elseif ( is_checkout() ) {
				the_title();
			}
			
			else {
				the_title();
			}
		else :
				the_title();
				
		endif;
	}
}

/**
 * StoreBiz Breadcrumb Content
*/

function storebiz_breadcrumbs() {
	
	$showOnHome	= esc_html__('1','storebiz'); 	// 1 - Show breadcrumbs on the homepage, 0 - don't show
	$delimiter 	= '';   // Delimiter between breadcrumb
	$home 		= esc_html__('Home','storebiz'); 	// Text for the 'Home' link
	$showCurrent= esc_html__('1','storebiz'); // Current post/page title in breadcrumb in use 1, Use 0 for don't show
	$before		= '<li class="active">'; // Tag before the current Breadcrumb
	$after 		= '</li>'; // Tag after the current Breadcrumb
	$seprator	= get_theme_mod('seprator','>');
	global $post;
	$homeLink = home_url();

	if (is_home() || is_front_page()) {
 
	if ($showOnHome == 1) echo '<li><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a></li>';
 
	} else {
 
    echo '<li><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a> ' . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
 
    if ( is_category() ) 
	{
		$thisCat = get_category(get_query_var('cat'), false);
		if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . ' ');
		echo $before . esc_html__('Archive by category','storebiz').' "' . esc_html(single_cat_title('', false)) . '"' .$after;
		
	} 
	
	elseif ( is_search() ) 
	{
		echo $before . esc_html__('Search results for ','storebiz').' "' . esc_html(get_search_query()) . '"' . $after;
	} 
	
	elseif ( is_day() )
	{
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ' . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		echo '<a href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . esc_html(get_the_time('F')) . '</a> '. '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		echo $before . esc_html(get_the_time('d')) . $after;
	} 
	
	elseif ( is_month() )
	{
		echo '<a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . esc_html(get_the_time('Y')) . '</a> ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		echo $before . esc_html(get_the_time('F')) . $after;
	} 
	
	elseif ( is_year() )
	{
		echo $before . esc_html(get_the_time('Y')) . $after;
	} 
	
	elseif ( is_single() && !is_attachment() )
	{
		if ( get_post_type() != 'post' )
		{
			if ( class_exists( 'WooCommerce' ) ) {
				if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . '&nbsp&nbsp' . $before . wp_kses_post(get_the_title()) . $after;
			}else{	
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
			echo '<a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
			if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp' . $before . wp_kses_post(get_the_title()) . $after;
			}
		}
		else
		{
			if ($showCurrent == 1) echo $before . esc_html(get_the_title()) . $after;
		}
 
    }
		
	elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_shop() ) {
				$thisshop = woocommerce_page_title();
			}
		}	
		else  {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		}	
	} 
	
	elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) 
	{
		$post_type = get_post_type_object(get_post_type());
		echo $before . $post_type->labels->singular_name . $after;
	} 
	
	elseif ( is_attachment() ) 
	{
		$parent = get_post($post->post_parent);
		$cat = get_the_category($parent->ID); 
		if(!empty($cat)){
		$cat = $cat[0];
		echo get_category_parents($cat, TRUE, ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp');
		}
		echo '<a href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a>';
		if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . ' ' . $before . esc_html(get_the_title()) . $after;
 
    } 
	
	elseif ( is_page() && !$post->post_parent ) 
	{
		if ($showCurrent == 1) echo $before . esc_html(get_the_title()) . $after;
	} 
	
	elseif ( is_page() && $post->post_parent ) 
	{
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ($parent_id) 
		{
			$page = get_page($parent_id);
			$breadcrumbs[] = '<a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a>' . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
			$parent_id  = $page->post_parent;
		}
		
		$breadcrumbs = array_reverse($breadcrumbs);
		for ($i = 0; $i < count($breadcrumbs); $i++) 
		{
			echo $breadcrumbs[$i];
			if ($i != count($breadcrumbs)-1) echo ' ' . esc_attr($delimiter) . '&nbsp' . wp_kses_post($seprator) . '&nbsp';
		}
		if ($showCurrent == 1) echo ' ' . esc_attr($delimiter) . ' ' . $before . esc_html(get_the_title()) . $after;
 
    } 
	elseif ( is_tag() ) 
	{
		echo $before . esc_html__('Posts tagged ','storebiz').' "' . esc_html(single_tag_title('', false)) . '"' . $after;
	} 
	
	elseif ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo $before . esc_html__('Articles posted by ','storebiz').'' . $userdata->display_name . $after;
	} 
	
	elseif ( is_404() ) {
		echo $before . esc_html__('Error 404 ','storebiz'). $after;
    }
	
    if ( get_query_var('paged') ) {
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
		echo ' ( ' . esc_html__('Page','storebiz') . '' . esc_html(get_query_var('paged')). ' )';
		if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo '';
    }
 
    echo '</li>';
 
  }
}




/*******************************************************************************
 *  Get Started Notice
 *******************************************************************************/

add_action( 'wp_ajax_storebiz_dismissed_notice_handler', 'storebiz_ajax_notice_handler' );

/**
 * AJAX handler to store the state of dismissible notices.
 */
function storebiz_ajax_notice_handler() {
    if ( isset( $_POST['type'] ) ) {
        // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
        $type = sanitize_text_field( wp_unslash( $_POST['type'] ) );
        // Store it in the options table
        update_option( 'dismissed-' . $type, TRUE );
    }
}

function storebiz_deprecated_hook_admin_notice() {
        // Check if it's been dismissed...
        if ( ! get_option('dismissed-get_started', FALSE ) ) {
            // Added the class "notice-get-started-class" so jQuery pick it up and pass via AJAX,
            // and added "data-notice" attribute in order to track multiple / different notices
            // multiple dismissible notice states ?>
            <div class="updated notice notice-get-started-class is-dismissible" data-notice="get_started">
                <div class="storebiz-getting-started-notice clearfix">
                    <div class="storebiz-theme-screenshot">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/screenshot.jpg" class="screenshot" alt="<?php esc_attr_e( 'Theme Screenshot', 'storebiz' ); ?>" />
                    </div><!-- /.storebiz-theme-screenshot -->
                    <div class="storebiz-theme-notice-content">
                        <h2 class="storebiz-notice-h2">
                            <?php
                        printf(
                        /* translators: 1: welcome page link starting html tag, 2: welcome page link ending html tag. */
                            esc_html__( 'Welcome! Thank you for choosing %1$s!', 'storebiz' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>' );
                        ?>
                        </h2>

                        <p class="plugin-install-notice"><?php echo sprintf(__('Install and activate <strong>Burger Companion</strong> plugin for taking full advantage of all the features this theme has to offer.', 'storebiz')) ?></p>

                        <a class="storebiz-btn-get-started button button-primary button-hero storebiz-button-padding" href="#" data-name="" data-slug=""><?php esc_html_e( 'Get started with StoreBiz', 'storebiz' ) ?></a><span class="storebiz-push-down">
                        <?php
                            /* translators: %1$s: Anchor link start %2$s: Anchor link end */
                            printf(
                                'or %1$sCustomize theme%2$s</a></span>',
                                '<a target="_blank" href="' . esc_url( admin_url( 'customize.php' ) ) . '">',
                                '</a>'
                            );
                        ?>
                    </div><!-- /.storebiz-theme-notice-content -->
                </div>
            </div>
        <?php }
}

add_action( 'admin_notices', 'storebiz_deprecated_hook_admin_notice' );

/*******************************************************************************
 *  Plugin Installer
 *******************************************************************************/

add_action( 'wp_ajax_install_act_plugin', 'storebiz_admin_install_plugin' );

function storebiz_admin_install_plugin() {
    /**
     * Install Plugin.
     */
    include_once ABSPATH . '/wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

    if ( ! file_exists( WP_PLUGIN_DIR . '/burger-companion' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'burger-companion' ) ),
            'fields' => array(
                'sections' => false,
            ),
        ) );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );
    }

    // Activate plugin.
    if ( current_user_can( 'activate_plugin' ) ) {
        $result = activate_plugin( 'burger-companion/burger-companion.php' );
    }
}