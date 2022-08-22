<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

$btn_class = array('single_add_to_cart_button button alt icon-nth-cart');
if( $product->supports( 'ajax_add_to_cart' ) ) {
	$btn_class[] = 'add_to_cart_button ajax_add_to_cart';
}

?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>

        <?php
        /**
         * @since 2.1.0.
         */
        do_action( 'woocommerce_before_add_to_cart_button' );

        /**
         * @since 3.0.0.
         */
        do_action( 'woocommerce_before_add_to_cart_quantity' );

        ?>

		<?php if ( ! $product->is_sold_individually() ): ?>
		<table class="variations">
			<tr>
				<td><?php esc_html_e( "Quantity", 'theshopier' );?></td>
				<td class="value">
				<?php
                $_min = apply_filters( 'woocommerce_quantity_input_min', 1, $product );
                $qty_val = ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $_min );
	 			woocommerce_quantity_input( array(
	 				'min_value'   => $_min,
	 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
	 				'input_value' => $qty_val
	 			) );
				?>
				</td>
			</tr>
		
		</table>
		<?php endif; ?>

	 	<button type="submit" data-quantity="<?php echo esc_attr( $qty_val ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" class="<?php echo esc_attr(implode(' ', $btn_class));?>"><?php echo $product->single_add_to_cart_text(); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
