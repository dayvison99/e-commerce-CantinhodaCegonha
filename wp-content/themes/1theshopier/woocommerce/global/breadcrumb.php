<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $breadcrumb ) {

	print $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		print $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			if( strcmp( strtolower( $crumb[0] ), 'home' ) == 0 )
				print '<a href="' . esc_url( $crumb[1] ) . '"><i class="fa fa-home"></i></a>';
			else
				print '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			print esc_html( $crumb[0] );
		}

		print $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			print $delimiter;
		}

	}

	print $wrap_after;

}