<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$classes = array('products_loop');
$item_style = isset($item_style)? ' '.$item_style: '';
$classes[] = $item_style;
$classes = apply_filters( 'theshopier_woocommerce_product_loop_class_filter', $classes, $item_style );
?>

<div class="products <?php echo esc_attr( implode(' ', $classes) );?> columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">