<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */

define ('ECOMMERCE_PLUS_URI', 'https://www.ceylonthemes.com/product/wordpress-ecommerce-theme/');

if ( ! function_exists( 'ecommerce_plus_setup' ) ) :

	function ecommerce_plus_setup() {

		load_theme_textdomain( 'ecommerce-plus' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		// Enable support for footer widgets.
		add_theme_support( 'footer-widgets');

		
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 600, 450, true );

		// Set the default content width.
		$GLOBALS['content_width'] = 525;
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' 	=> esc_html__( 'Primary', 'ecommerce-plus' ),
			'social' 	=> esc_html__( 'Social', 'ecommerce-plus' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ecommerce_plus_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// This setup supports logo, site-title & site-description
		add_theme_support( 'custom-logo', array(
			'height'      => 70,
			'width'       => 120,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'site-title', 'site-description' ),
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, icons, and column width.
		 */
		add_editor_style( array( '/css/editor-style.css', ecommerce_plus_fonts_url() ) );
		
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-font-sizes', array(
		   	array(
		       	'name' => esc_html__( 'small', 'ecommerce-plus' ),
		       	'shortName' => esc_html__( 'S', 'ecommerce-plus' ),
		       	'size' => 12,
		       	'slug' => 'small'
		   	),
		   	array(
		       	'name' => esc_html__( 'regular', 'ecommerce-plus' ),
		       	'shortName' => esc_html__( 'M', 'ecommerce-plus' ),
		       	'size' => 16,
		       	'slug' => 'regular'
		   	),
		   	array(
		       	'name' => esc_html__( 'larger', 'ecommerce-plus' ),
		       	'shortName' => esc_html__( 'L', 'ecommerce-plus' ),
		       	'size' => 36,
		       	'slug' => 'larger'
		   	),
		   	array(
		       	'name' => esc_html__( 'huge', 'ecommerce-plus' ),
		       	'shortName' => esc_html__( 'XL', 'ecommerce-plus' ),
		       	'size' => 48,
		       	'slug' => 'huge'
		   	)
		));
		add_theme_support('editor-styles');

		// Gutenberg support
		add_theme_support( 'editor-color-palette', array(
	       	array(
				'name' => esc_html__( 'Blue', 'ecommerce-plus' ),
				'slug' => 'blue',
				'color' => '#2c7dfa',
	       	),
	       	array(
	           	'name' => esc_html__( 'Green', 'ecommerce-plus' ),
	           	'slug' => 'green',
	           	'color' => '#07d79c',
	       	),
	       	array(
	           	'name' => esc_html__( 'Orange', 'ecommerce-plus' ),
	           	'slug' => 'orange',
	           	'color' => '#ff8737',
	       	),
	       	array(
	           	'name' => esc_html__( 'Black', 'ecommerce-plus' ),
	           	'slug' => 'black',
	           	'color' => '#2f3633',
	       	),
	       	array(
	           	'name' => esc_html__( 'Grey', 'ecommerce-plus' ),
	           	'slug' => 'grey',
	           	'color' => '#82868b',
	       	),
	   	));

		add_theme_support( 'wp-block-styles' );
		
		
	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets'     => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'footer-sidebar-1' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'footer-sidebar-2' => array(
				'text_about',
			),
			// Put two core-defined widgets in the footer 2 area.
			'footer-sidebar-3' => array(
				'text_about',
			),
			// Put two core-defined widgets in the footer 2 area.
			'footer-sidebar-4' => array(
				'search',
			),					
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts'       => array(
				'home-page',
				'about' ,
				'contact' ,
				'blog',
		),


		// Default to a static front page and assign the front and posts pages.
		'options'     => array(
			'show_on_front'  => 'home-page',
			'page_on_front'  => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods'  => array(
			'panel_1' => '{{home-page}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus'   => array(
			// Assign a menu to the "top" location.
			'primary'   => array(
				'name'  => __( 'Top Menu', 'ecommerce-plus' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

		));

 	add_theme_support( 'starter-content', $starter_content);
		
		
	}
endif;
add_action( 'after_setup_theme', 'ecommerce_plus_setup' );

//used to name html elements
$ecommerce_plus_uniqueue_id = 999;
$ecommerce_plus_product_categories = '' ;

$ecommerce_plus_options = '';
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ecommerce_plus_widgets_init() {


	register_sidebar(
		array(
			'name'          => esc_html__( 'Woocommerce Sidebar', 'ecommerce-plus' ),
			'id'            => 'sidebar-woocommerce',
			'description'   => esc_html__( 'Add widgets here to appear in your woocommerce pages.', 'ecommerce-plus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ecommerce-plus' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ecommerce-plus' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
	
	/* footer widgets */
	register_sidebar(
		array(
			'name'          => __( 'Footer 1', 'ecommerce-plus' ),
			'id'            => 'footer-sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'ecommerce-plus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Footer 2', 'ecommerce-plus' ),
			'id'            => 'footer-sidebar-2',
			'description'   => __( 'Add widgets here to appear in your footer.', 'ecommerce-plus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => __( 'Footer 3', 'ecommerce-plus' ),
			'id'            => 'footer-sidebar-3',
			'description'   => __( 'Add widgets here to appear in your footer.', 'ecommerce-plus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);	
	
	register_sidebar(
		array(
			'name'          => __( 'Footer 4', 'ecommerce-plus' ),
			'id'            => 'footer-sidebar-4',
			'description'   => __( 'Add widgets here to appear in your footer.', 'ecommerce-plus' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	

}
add_action( 'widgets_init', 'ecommerce_plus_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ecommerce_plus_content_width() {

	$content_width = $GLOBALS['content_width'];

	$sidebar_position = ecommerce_plus_layout();
		
	switch ( $sidebar_position ) {

	  case 'no-sidebar':
	    $content_width = 1170;
	    break;

	  case 'left-sidebar':
	  case 'right-sidebar':
	    $content_width = 820;
	    break;

	  default:
	    break;
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) || !is_active_sidebar( 'sidebar-woocommerce' ) ) {
		$content_width = 1170;
	}

	/**
	 * Filter eCommerce Plus content width of the theme.
	 *
	 * @since 1.0.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'ecommerce_plus_content_width', $content_width );
}
add_action( 'template_redirect', 'ecommerce_plus_content_width', 0 );


if ( ! function_exists( 'ecommerce_plus_fonts_url' ) ) :
/**
 * Register Google fonts
 * @package twentyseventeen
 * @return string Google fonts URL for the theme.
 */
function ecommerce_plus_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by "PT Sans", sans-serif;, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$typography = _x( 'on', 'PT Sans font: on or off', 'ecommerce-plus' );

	if ( 'off' !== $typography ) {
	
		$fontface = ecommerce_plus_get_theme_options();  
		
		$fonts[] = $fontface['heading_font'].':400,600,700';
		$fonts[] = $fontface['body_font'].'Muli:300,400,600,700';
	}


	$query_args = array(
		'family' => urlencode( implode( '|', $fonts ) ),
		'subset' => urlencode( $subsets ),
	);

	if ( $fonts ) {
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}
endif;

/**
 * Add preconnect for Google Fonts.
 *
 * @since 1.0.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function ecommerce_plus_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'ecommerce-plus-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'ecommerce_plus_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function ecommerce_plus_scripts() {
	$options = ecommerce_plus_get_theme_options();
	
	
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'ecommerce-plus-fonts', ecommerce_plus_fonts_url(), array(), null );

	// font-awesome
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.css' );
	
	// bootstrap
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' , array() );
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ) , true );


	wp_enqueue_style( 'ecommerce-plus-style', get_stylesheet_uri() );
	
	// Load the html5 shiv.
	wp_enqueue_script( 'ecommerce-plus-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'ecommerce-plus-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'ecommerce-plus-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20201201', true );

	wp_enqueue_script( 'ecommerce-plus-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20201202', true );
	
	$ecommerce_plus_l10n = array(
		'quote'          => ecommerce_plus_get_svg( array( 'icon' => 'quote-right' ) ),
		'expand'         => esc_html__( 'Expand child menu', 'ecommerce-plus' ),
		'collapse'       => esc_html__( 'Collapse child menu', 'ecommerce-plus' ),
		'icon'           => ecommerce_plus_get_svg( array( 'icon' => 'down', 'fallback' => true ) ),
	);
	
	wp_localize_script( 'ecommerce-plus-navigation', 'ecommerce_plus_l10n', $ecommerce_plus_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	wp_enqueue_script( 'jquery-matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', array( 'jquery' ), '', true );

	wp_enqueue_script( 'ecommerce-plus-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20201203', true );

}
add_action( 'wp_enqueue_scripts', 'ecommerce_plus_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 *
 * @since 1.0.0
 */
function ecommerce_plus_block_editor_styles() {
	// Add custom fonts.
	wp_enqueue_style( 'ecommerce-plus-fonts', ecommerce_plus_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'ecommerce_plus_block_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



/*** Load core file ***/


// Load customizer defaults values
require get_template_directory() . '/inc/settings.php';


/**
 * Merge values from default options array and values from customizer
 * @return array Values returned from customizer
 * @since 1.0.0
 */
function ecommerce_plus_get_theme_options() {
 	global $ecommerce_plus_options;	
	if ( class_exists( 'WP_Customize_Control' ) ||  $ecommerce_plus_options == '') {
	     $ecommerce_plus_options = wp_parse_args( get_option( 'ecommerce_plus_options', array() ), ecommerce_plus_get_default_theme_options()) ;
	}
	return $ecommerce_plus_options;
}


/**
 * Load admin custom styles
 * 
 */
function ecommerce_plus_load_admin_style() {
    wp_register_style( 'ecommerce_plus_admin_css', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
    wp_enqueue_style( 'ecommerce_plus_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'ecommerce_plus_load_admin_style' );



/**
 * Add woocommerce theme support
 */
if (class_exists('WooCommerce')) {

	add_action( 'after_setup_theme', 'ecommerce_plus_woocommerce_support' );
	function ecommerce_plus_woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );	
	}

}

/**
 *
 */
require get_template_directory() . '/inc/woo-functions.php';

/**
 *
 */
require get_template_directory() . '/inc/actions.php';

/**
 * Add breadcrumb functions.
 */
require get_template_directory() . '/inc/breadcrumb-class.php';


/**
 * Add metabox
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';



/**
* TGM plugin additions.
*/
require get_template_directory() . '/inc/tgm-plugin/plugin-activation.php';



/*
 * Custom widgets
 */
require get_template_directory() . '/inc/widgets/product-search.php';

require get_template_directory() . '/inc/widgets/cart-wishlist-acc.php';

require get_template_directory() . '/inc/widgets/post-slider.php';

require get_template_directory() . '/inc/widgets/product-categories.php';

require get_template_directory() . '/inc/widgets/product-navigation.php';

require get_template_directory() . '/inc/widgets/product-slider.php';

require get_template_directory() . '/inc/widgets/products-by-featured.php';

require get_template_directory() . '/inc/widgets/featured-category.php';


if ( class_exists( 'WP_Customize_Control' ) ) {
	
	// Inlcude the Alpha Color Picker control file.
	require get_template_directory().'/inc/color-picker/alpha-color-picker.php';
	 
}

/**
 * Do Action
 */
function ecommerce_plus_do_action ($action) {
	if(has_action($action)) {
		do_action($action);
	}
}

/**
 * Display custom color CSS.
 */
function ecommerce_plus_colors_css_container() {

	require_once get_template_directory().'/inc/styles.php';

?>
	<style type="text/css" id="custom-theme-colors" >
		<?php echo wp_strip_all_tags(ecommerce_plus_custom_css()); ?>
	</style>
<?php
}
add_action( 'wp_head', 'ecommerce_plus_colors_css_container' );


if (!function_exists('ecommerce_plus_cart_link')) {

    function ecommerce_plus_cart_link() {
        ?>	
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" data-tooltip="<?php esc_attr_e('Cart', 'ecommerce-plus'); ?>" title="<?php esc_attr_e('Cart', 'ecommerce-plus'); ?>">
            <i class="fa fa-shopping-bag"><span class="count"><?php if(WC()->cart) { echo wp_kses_data(WC()->cart->get_cart_contents_count()); } ?></span></i>
            <div class="amount-cart hidden-xs"><?php if(WC()->cart) { echo wp_kses_data(WC()->cart->get_cart_subtotal()); }; ?></div> 
        </a>
        <?php
    }

}

if (!function_exists('ecommerce_plus_header_add_to_cart_fragment')) {
    add_filter('woocommerce_add_to_cart_fragments', 'ecommerce_plus_header_add_to_cart_fragment');

    function ecommerce_plus_header_add_to_cart_fragment($fragments) {
        ob_start();

        ecommerce_plus_cart_link();

        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }

}



function ecommerce_plus_site_branding() {

			$options  = ecommerce_plus_get_theme_options();

			$header_txt_logo_extra = $options['header_txt_logo_extra'];	
			?>
		
			
			<div class="site-branding <?php echo esc_attr($header_txt_logo_extra); ?>">
				<?php if ( in_array( $header_txt_logo_extra, array( 'show-all', 'logo-title', 'logo-only' ) )  ) { ?>
				 	<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
						<?php the_custom_logo(); ?>
					</div>
					<?php endif; ?>
				<?php } 
				if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'title-tagline', 'show-all') ) ) : ?>
					<div id="site-identity">
						<?php
						if( in_array( $header_txt_logo_extra, array( 'show-all', 'title-only', 'title-tagline', 'logo-title' ) )  ) {
							
							if ( ecommerce_plus_is_latest_posts() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
							endif;
							
						} 
						if ( in_array( $header_txt_logo_extra, array( 'show-all', 'title-tagline', 'show-all') ) ) : 
							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
							<?php
							endif; 					
									
						endif; ?>
					</div>
				<?php endif; ?>
			</div><!-- .site-branding -->
<?php
}

add_action('ecommerce_plus_branding', 'ecommerce_plus_site_branding');


function ecommerce_plus_site_navigation() {
			
			$options  = ecommerce_plus_get_theme_options(); 
?>
			<div id="site-menu">
			

			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Menu">
			
					<?php 
					$login = '';
					if ( $options['topbar_login_register_enable'] ) :
						$login .= '<li class="login-register-item">';
						$login .= '<div class="login-register">';
						$login .= '<ul>';
						$login .= '<li><a href="' . esc_url( $options['topbar_login_url'] ) . '">' . esc_html( $options['topbar_login_label'] ) . '</a></li>';
						$login .= '</ul>';
						$login .= '</div><!-- .social-icons -->';
						$login .= '</li>';
					endif;
					if ( $options['topbar_login_register_enable'] ) {
						wp_nav_menu( 
							array(
								'theme_location' => 'primary',
								'container' => 'div',
								'menu_class' => 'menu nav-menu',
								'menu_id' => 'primary-menu',
								'echo' => true,
								'fallback_cb' => 'ecommerce_plus_menu_fallback_cb',
								'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $login . '</ul>',
								)
							);
					} else {
						wp_nav_menu( 
							array(
								'theme_location' => 'primary',
								'container' => 'div',
								'menu_class' => 'menu nav-menu',
								'menu_id' => 'primary-menu',
								'echo' => true,
								'fallback_cb' => 'ecommerce_plus_menu_fallback_cb',
								)
							);
					}
				?>
			</nav><!-- #site-navigation -->
		</div><!-- #site-menu -->
<?php
}

add_action('ecommerce_plus_navigation', 'ecommerce_plus_site_navigation');


function ecommerce_plus_toggle_menu() {
?>
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<?php
				echo ecommerce_plus_get_svg( array( 'icon' => 'menu' ) );
				echo ecommerce_plus_get_svg( array( 'icon' => 'close' ) );
				?>					
				<span class="menu-label"><?php esc_html_e( 'Menu', 'ecommerce-plus' ); ?></span>
			</button>
<?php
}

add_action('ecommerce_plus_toggle', 'ecommerce_plus_toggle_menu');


function ecommerce_plus_topbar_content(){
$options  = ecommerce_plus_get_theme_options();

if ($options['contact_section_phone'] =='' && $options['contact_section_email'] =='' && $options['contact_section_address'] =='' && $options['contact_section_hours'] =='' &&
$options['social_whatsapp_link'] =='' && $options['social_instagram_link'] =='' && $options['social_youtube_link'] =='' && $options['social_linkdin_link'] =='' 
&& $options['social_twitter_link'] =='' && $options['social_facebook_link'] =='' ) return;

?>
<div class="top_bar_wrapper">
  <div class="container">
  	<div class="row">
	  
      <div class="col-sm-8 col-xs-12">
        <div class="top-bar-left">
          <ul class="infobox_header_wrapper">
            <?php if ($options['contact_section_phone'] !='') { ?><li> <i class="fa fa-phone"></i><?php echo esc_html($options['contact_section_phone']); ?></li> <?php } ?>
            <?php if ($options['contact_section_email'] !='') { ?><li> <i class="fa fa-envelope"></i><?php echo esc_html($options['contact_section_email']); ?></li> <?php } ?>
            <?php if ($options['contact_section_address'] !='') { ?><li> <i class="fa fa-map-marker"></i><?php echo esc_html($options['contact_section_address']); ?></li> <?php } ?>
			<?php if ($options['contact_section_hours'] !='') { ?><li> <i class="fa fa-clock-o"></i><?php echo esc_html($options['contact_section_hours']); ?></li> <?php } ?>
          </ul>
        </div>
      </div>	
	  
	  
      <div class="col-sm-4 col-xs-12">
        <div id="top-social-right" class="header_social_links">
          <ul>
			<?php if ($options['social_whatsapp_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_whatsapp_link']); ?>" class="social_links_header_4 whatsapp" target="_blank"> <span class="ts-icon"> <i class="fa fa-whatsapp"></i> </a></li> <?php } ?>
            <?php if ($options['social_pinterest_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_pinterest_link']); ?>" class="social_links_header_6 pinterest" target="_blank"> <span class="ts-icon"> <i class="fa fa-pinterest"></i> </a></li> <?php } ?>            
			<?php if ($options['social_instagram_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_instagram_link']); ?>" class="social_links_header_2 instagram" target="_blank"> <span class="ts-icon"> <i class="fa fa-instagram"></i> </a></li> <?php } ?>
            <?php if ($options['social_youtube_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_youtube_link']); ?>" class="social_links_header_3 youtube" target="_blank"> <span class="ts-icon"> <i class="fa fa-youtube"></i> </a></li> <?php } ?>
			<?php if ($options['social_linkdin_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_linkdin_link']); ?>" class="social_links_header_5 linkedin" target="_blank"> <span class="ts-icon"> <i class="fa fa-linkedin"></i> </a></li> <?php } ?>
            <?php if ($options['social_twitter_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_twitter_link']); ?>" class="social_links_header_1 twitter" target="_blank"> <span class="ts-icon"> <i class="fa fa-twitter"></i> </a></li> <?php } ?>
            <?php if ($options['social_facebook_link'] !='') { ?><li> <a href="<?php echo esc_url($options['social_facebook_link']); ?>" class="social_links_header_0 facebook" target="_blank"> <span class="ts-icon"> <i class="fa fa-facebook"></i> </a></li> <?php } ?>
		  </ul>
        </div>
      </div>
	  
    </div>	
  </div>
</div>

<?php
}
add_action('ecommerce_plus_top_bar', 'ecommerce_plus_topbar_content');



function ecommerce_plus_get_header_layout(){

	global $post;
	$layout = '';
	
	if ($post){	
		$layout = get_post_meta( $post->ID, 'ecommerce-plus-header-layout', true );	
	} 
	
return $layout;

}

if (!function_exists('ecommerce_plus_get_header_style')):

function ecommerce_plus_get_header_style(){

	global $post;
	
	if ($post){
		$style = get_post_meta( $post->ID, 'ecommerce-plus-header-style', true );	
		if ($style == 'shadow') {
			return "box-shadow";
		} elseif ($style == 'border'){
			return "header-border";
		} elseif ($style == 'transparent'){
			return "header-transparent";
		} elseif ($style == 'none'){
			return "header-style-none";	
		} else {
			return "box-shadow";
		}
	} else {
		return "box-shadow";
	}

}

endif;

define('ecommerce_plus_tutorial_link','https://www.ceylonthemes.com/product/wordpress-ecommerce-theme');
/**
 * Help notice 
 **/
function ecommerce_plus_general_admin_notice(){

		$pro_msg = esc_html__('Theme Tutorials - Go Pro', 'ecommerce-plus');
		if( ecommerce_plus_activated() ) {
			$pro_msg = esc_html__('Theme Tutorials', 'ecommerce-plus');
		}
         $msg = sprintf('<div data-dismissible="disable-done-notice-forever" class="notice notice-info" >
		 		<h3>%1$s</h3>
				<p>%2$s</p><p>
				<a class="avril-btn-get-started button button-primary button-hero avril-button-padding" href="#" data-name="" data-slug="">%3$s</a>				
				<a href="%4$s" target="new" class="button">%5$s</a>
				<a href="%6$s" class="button">%7$s</a>
				<a href="?ecommerce_plus_notice_dismissed" style="text-decoration: none; float: right;" >%8$s</a></p></div>',
				esc_html__('Get Most out of the theme','ecommerce-plus'),
				esc_html__('1. Create a page using home page template, Goto appearance -> Customize to edit sections. 2. Page builder users:- Use widgets with prefix (+) to create post sliders, product sliders, carousels, grids etc.','ecommerce-plus'),		
				esc_html__('Getting Started with Demos...', 'ecommerce-plus'),
				esc_url(ecommerce_plus_tutorial_link),	
				$pro_msg,
				esc_url(admin_url()."customize.php"),	
				esc_html__('Go to Customizer', 'ecommerce-plus'),								
				esc_html__('Dismiss Notice', 'ecommerce-plus'));
		 echo wp_kses_post($msg);
		 
}

if ( isset( $_GET['ecommerce_plus_notice_dismissed'] ) ){
	//set notice value false
	update_option('ecommerce_plus_help_notice', 'notice--dismissed');
}

$ecommerce_plus_help_notice = get_option('ecommerce_plus_help_notice', false);

if (($ecommerce_plus_help_notice != 'notice--dismissed' || $ecommerce_plus_help_notice == '') ){
	add_action('admin_notices', 'ecommerce_plus_general_admin_notice');	
}



/**************************
 *   Plugin Installer
 **************************/
 
 //Admin Enqueue for Admin
function ecommerce_plus_admin_enqueue_scripts(){	
	wp_enqueue_script( 'avril-admin-script', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ), '', true );
    wp_localize_script( 'avril-admin-script', 'avril_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
add_action( 'admin_enqueue_scripts', 'ecommerce_plus_admin_enqueue_scripts' );

add_action( 'wp_ajax_install_act_plugin', 'ecommerce_plus_admin_install_plugin' );

function ecommerce_plus_admin_install_plugin() {
    /**
     * Install Plugin.
     */
    include_once ABSPATH . '/wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

    if ( ! file_exists( WP_PLUGIN_DIR . '/ceylon-demo-installer' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'ceylon-demo-installer' ) ),
            'fields' => array(
                'sections' => false,
            ),
        ) );

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );
    }
	
    if ( ! file_exists( WP_PLUGIN_DIR . '/advanced-import' ) ) {
        $api = plugins_api( 'plugin_information', array(
            'slug'   => sanitize_key( wp_unslash( 'advanced-import' ) ),
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
        $result = activate_plugin( 'ceylon-demo-installer/ceylon-demo-installer.php' );
		
        $result = activate_plugin( 'advanced-import/advanced-import.php' );
		
    }
}


add_action('advanced_export_include_options','ecommerce_plus_include_my_options');
 function ecommerce_plus_include_my_options( $included_options ){
     $my_options = array(
         'ecommerce_plus_options',
     );
     return array_unique (array_merge( $included_options, $my_options));
 }
 
 
/* Preloader */
function ecommerce_plus_preloader() {


	$style[] = '<div class="spinner"></div>';
	
	$style[] = '<div class="spinner-dots">
			  <div class="bounce1"></div>
			  <div class="bounce2"></div>
			  <div class="bounce3"></div>
			</div>';
			
	$style[] = '<div class="spinner-rect">
			  <div class="rect1"></div>
			  <div class="rect2"></div>
			  <div class="rect3"></div>
			  <div class="rect4"></div>
			  <div class="rect5"></div>
			</div>';
			
			
	$style[] = '<div class="spinner-dbl">
			  <div class="double-bounce1"></div>
			  <div class="double-bounce2"></div>
			</div>';	
					
	$style[] = '<div class="sk-chase">
			  <div class="sk-chase-dot"></div>
			  <div class="sk-chase-dot"></div>
			  <div class="sk-chase-dot"></div>
			  <div class="sk-chase-dot"></div>
			  <div class="sk-chase-dot"></div>
			  <div class="sk-chase-dot"></div>
			</div>';
			
	$style[] = '<div class="sk-folding-cube">
			  <div class="sk-cube1 sk-cube"></div>
			  <div class="sk-cube2 sk-cube"></div>
			  <div class="sk-cube4 sk-cube"></div>
			  <div class="sk-cube3 sk-cube"></div>
			</div>';
			
				
	$style[] = '<div class="sk-fading-circle">
				  <div class="sk-circle1 sk-circle"></div>
				  <div class="sk-circle2 sk-circle"></div>
				  <div class="sk-circle3 sk-circle"></div>
				  <div class="sk-circle4 sk-circle"></div>
				  <div class="sk-circle5 sk-circle"></div>
				  <div class="sk-circle6 sk-circle"></div>
				  <div class="sk-circle7 sk-circle"></div>
				  <div class="sk-circle8 sk-circle"></div>
				  <div class="sk-circle9 sk-circle"></div>
				  <div class="sk-circle10 sk-circle"></div>
				  <div class="sk-circle11 sk-circle"></div>
				  <div class="sk-circle12 sk-circle"></div>
			 </div>';
			 
	$options = ecommerce_plus_get_theme_options();
	
	if ($options['prealoader_style'] != '') {
		echo '<div class="preloader-wrap">'.$style[$options['prealoader_style']].'</div>';
	}

}
add_action( 'wp_body_open', 'ecommerce_plus_preloader' );



/* code to add cart, account wishist popup */
add_action('wp_footer', 'ecommerce_plus_popup_cart');


function ecommerce_plus_popup_cart(){

$options = ecommerce_plus_get_theme_options();

	if(class_exists('woocommerce') && $options['popup_cart_visible']== true ) { 
	?>
	<div id="scroll-cart" class="topcorner">	
			<ul>
				<li class="my-cart"><?php ecommerce_plus_cart_link(); ?></li>
				<li>
					<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" data-tooltip="<?php esc_attr_e('My Account', 'ecommerce-plus'); ?>" title="<?php esc_attr_e('My Account', 'ecommerce-plus'); ?>">
						<i class="fa fa-user-circle-o"></i>
					</a>			
				</li>
				<?php if ( is_product() ): ?>
				<li class="my-add-to-cart">
				<?php 
					ecommerce_plus_add_to_cart(); 
				?>
				</li>
				<?php endif; ?>	
			</ul>					
	</div>
	<?php
	}
} 


// Disables the block editor from widget areas.
add_filter( 'use_widgets_block_editor', '__return_false' );