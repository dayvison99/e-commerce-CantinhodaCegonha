<?php
/**
 * The sidebar containing the woocommerce widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ecommerce-plus
 * @since 1.0
 */
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

if ( $ecommerce_plus_options['woo_sidebar_position'] == 'no-sidebar' ) {
	return;
} 
if ( ! is_active_sidebar( 'sidebar-woocommerce' ) ) {
	return;
}
?>
<aside id="secondary" class="widget-area woocomemrce-widgets" role="complementary" aria-label="<?php esc_attr_e( 'Woocommerce Sidebar', 'ecommerce-plus' ); ?>">
	<?php dynamic_sidebar( 'sidebar-woocommerce' ); ?>
</aside><!-- #secondary -->