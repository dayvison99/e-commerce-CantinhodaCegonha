<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section, slideshow, header menu ...
 *
 * @package WordPress
 * @subpackage Nexthemes
 * @since WP Nexthemes
 */
?><!DOCTYPE html>
<!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1627667070581307",
    enable_page_level_ads: true
  });
</script>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php
	wp_head(); 
	?>

</head>

<body <?php body_class(); ?>>

	<?php do_action('theshopier_before_main_content');?>
	<!-- Slide Menu Elemnt -->
	<div id="c-mask" class="c-mask"></div><!-- /c-mask -->
	<?php
	$mb_menu_class = "c-menu--push-left";
	if(is_rtl()) {
		$mb_menu_class = 'c-menu--push-right';
	}
	?>
	<div id="<?php echo esc_attr($mb_menu_class);?>" class="visible-xs visible-sm mobile-menu-wrapper slide-out-region c-menu <?php echo esc_attr($mb_menu_class);?>">
		<button class="c-menu__close"></button>
		<?php do_action("theshopier_main_left_sidebar");?>
		<!-- Mobile menu -->
		<div class="mobile-menu">
			<?php 
				if ( function_exists('has_nav_menu') && has_nav_menu('mobile-menu') ) {
				    wp_nav_menu( array(
				      'depth' => 6,
				      'sort_column' => 'menu_order',
				      'container' => 'ul',
				      'menu_id' => 'categories-mobi-nav',
				      'menu_class' => 'nav categories-menu',
				      'theme_location' => 'mobile-menu'
				    ) );
			    } 
			?>
		</div>
		
	</div><!--#main-left-sidebar-->
	<div id="body-wrapper" class="o-wrapper">

		<?php
		$classes = array(
			'main_content_wrap_class' => array('main-content-wrapper'),
			'main_content_class' => array('main-content'),
			'main_content_row_class' => array('body-wrapper'),
			'header_class' => array(),
			'header_row_class' => array('header-wrapper')
		);

		$classes = apply_filters('theshopier_main_header_class', $classes);
		?>

		<div id="main-content-wrapper" class="<?php echo esc_attr(implode(' ', $classes['main_content_wrap_class']))?>">

			<header id="header" class="<?php echo esc_attr(implode(' ', $classes['header_class']))?>">
				<div class="<?php echo esc_attr(implode(' ', $classes['header_row_class']))?>">
					<?php do_action( 'theshopier_header_init', $classes['header_style'] );?>
				</div>
			</header>

			<div class="<?php echo esc_attr(implode(' ', $classes['main_content_class']))?>">
				<div class="<?php echo esc_attr(implode(' ', $classes['main_content_row_class']))?>">
				<?php 
				$theshopier_pages = Theshopier::theshopier_getOption('page_options');
				if( isset($theshopier_pages['nth_slider_type']) && strlen($theshopier_pages['nth_slider_type']) > 0 ):
					
				?>
				<div class="slideshow-wrapper<?php if(absint($classes['header_style']) == 2) echo ' container';?>">
					<?php
					if($classes['header_style'] == '2') {
						?>
						<div class="row">
							<div class="col-sm-6"></div>
							<div class="col-sm-18" style="padding-left: 0;padding-right: 30px;">
								<div class="row">
								<?php theshopier_getSlideshow();?>
								</div>
							</div>
						</div>
						<?php 
					} else {
						theshopier_getSlideshow();
					}
					?>
				</div>
				<?php endif;?>
			