<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
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
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
do_action('theshopier_shopping_progress');
?>

<div class="clear"></div>
<div class="woocommerce-order">

	<?php if ( $order ) : ?>

		<div class="nth-row-grid">

			<div class="col-sm-24">

                <?php if ( $order->has_status( 'failed' ) ) : ?>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'theshopier' ); ?></p>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'theshopier' ) ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'theshopier' ); ?></a>
                    <?php endif; ?>
                </p>
            <?php else : ?>

                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                    <li class="woocommerce-order-overview__order order">
                        <span class="nth-label"><?php _e( 'Order number:', 'theshopier' ); ?></span>
                        <strong><?php echo $order->get_order_number(); ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__date date">
                        <span class="nth-label"><?php _e( 'Date:', 'theshopier' ); ?></span>
                        <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
                    </li>

                    <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                        <li class="woocommerce-order-overview__email email">
                             <span class="nth-label"><?php _e( 'Email:', 'theshopier' ); ?></span>
                            <strong><?php echo $order->get_billing_email(); ?></strong>
                        </li>
                    <?php endif; ?>

                    <li class="woocommerce-order-overview__total total">
                        <span class="nth-label"><?php _e( 'Total:', 'theshopier' ); ?></span>
                        <strong><?php echo $order->get_formatted_order_total(); ?></strong>
                    </li>

                    <?php if ( $order->get_payment_method_title() ) : ?>
                        <li class="woocommerce-order-overview__payment-method method">
                            <span class="nth-label"><?php _e( 'Payment method:', 'theshopier' ); ?></span>
                            <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                        </li>
                    <?php endif; ?>

                </ul>
                <div class="clear"></div>
            <?php endif; ?>

            <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>

            </div>

        </div>
        <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'theshopier' ), null ); ?></p>

	<?php endif; ?>

</div>
