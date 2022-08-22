<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
    return;
}

global $post, $product;

$attachment_ids = $product->get_gallery_image_ids();

if ( count($attachment_ids) > 1 || ( class_exists('Nexthemes_WooProductOptions') && Nexthemes_WooProductOptions::has_video() ) ) {
	//$attachment_ids = apply_filters('theshopier_woocommerce_product_gallery', $attachment_ids, $post->ID);
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 4);
	//$columns = round( $columns * (6/2.5) );
	
	$options = array(
		"items"			=> $columns,
		"loop"			=> false,
		'responsive'	=> array(
			0	=> array(
				'items'	=> round( $columns * (768 / 1200) ),
			),
			480	=> array(
				'items'	=> round( $columns * (980 / 1200) ),
			),
			769	=> array(
				'items'	=> $columns
			),
			981	=> array(
				'items'	=> $columns
			),
		)
	);

	?>
	<div id="nth_prod_thumbnail" class="thumbnails <?php echo 'columns-' . $columns; ?> nth-owlCarousel loading" data-options="<?php echo esc_attr(json_encode($options));?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom', 'img_thumb' );

			if( $loop == 0 ) $classes[] = "first active";
			
			if ( $loop % $columns == 0 ) $classes[] = 'first';
			
			if ( ( $loop + 1 ) % $columns == 0 )
				$classes[] = 'last';
			
			$classes = apply_filters('theshopier_woocommerce_product_gallery_class', $classes, $attachment_id, $post->ID);

			$props       = wc_get_product_attachment_props( $attachment_id, $post );

			if ( ! $props['url'] ) {
				continue;
			}
			$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props );
			/////
			
			if( !is_singular('product') && false ) {
				$image_class = esc_attr( implode( ' ', $classes ) );
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', esc_url( $props['url'] ), $image_class, esc_attr( $props['caption'] ), $image ), $attachment_id, $post->ID, $image_class );
			} else {
				$k = array_search( 'zoom', $classes );
				if( isset($k) ) unset( $classes[$k] );
				$image_class = esc_attr( implode( ' ', $classes ) );

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="#product-item-%s" data-pos="%s" class="%s" title="%s">%s</a>', $loop, $loop, $image_class, esc_attr( $props['caption'] ), $image ), $attachment_id, $post->ID, $image_class );
			}
			

			$loop++;
		}
		
		do_action('theshopier_after_woocommerce_product_thumnail', $loop);
		

	?></div><?php
}
