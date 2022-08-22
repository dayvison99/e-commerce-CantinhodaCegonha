<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

if ( ! $post->post_excerpt ) {
	return;
}

//CUSTOM
$count = apply_filters( "theshopier_woocommerce_short_description_count", -1 );

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );
if( $count > 0 ) {
    $short_description = wp_strip_all_tags( $short_description );
	$words = explode(' ', $short_description, ($count + 1));
	if(count($words) > $count) array_pop($words);
    $short_description = implode(' ', $words);
}

?>
<div itemprop="description">
	<?php echo $short_description; // WPCS: XSS ok. ?>
</div>
