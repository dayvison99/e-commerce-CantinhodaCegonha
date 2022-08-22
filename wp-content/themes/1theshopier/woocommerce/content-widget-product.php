<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<li>
    <?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<a class="product-image" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
		
	</a>
	<div class="product-detail">
		<a class="product-title" href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>"><?php echo $product->get_title(); ?></a>
		<?php echo $product->get_price_html(); ?>
		<?php
		if ( ! empty( $show_rating ) ){
			if(Theshopier::checkPlugin("yotpo-social-reviews-for-woocommerce/wc_yotpo.php")) {
				add_action("theshopier_yotpo_reviews_render", "wc_yotpo_show_buttomline", 10);
				do_action("theshopier_yotpo_reviews_render");
			} else {
				echo wc_get_rating_html( $product->get_average_rating() );
			}
		} ?>
	</div>

    <?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>