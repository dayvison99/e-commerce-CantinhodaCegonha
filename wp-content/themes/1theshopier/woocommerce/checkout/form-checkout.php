<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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
 * @version     2.3.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action('theshopier_shopping_progress');

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', esc_html__( 'You must be logged in to checkout.', 'theshopier' ) );
	return;
}

?>

<div class="row">

	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

		<div class="col-sm-14">

			<div class="nth-row-grid">

				<?php if ( !is_user_logged_in() && 'no' !== get_option( 'woocommerce_enable_checkout_login_reminder' ) ) : ?>
				<h3 class="nth-checkout-heading"><?php echo esc_html_e( 'Returning Customer?', 'theshopier' ) . ' <a href="#nth_checkout_login" class="nth-prettyPhoto">' . esc_html__( 'Click here to login', 'theshopier' ) . '</a>';?></h3>
				<?php endif;?>

				<?php if ( wc_coupons_enabled() ) : ?>
				<h3 class="nth-checkout-heading"><?php echo esc_html__( 'Have a coupon?', 'theshopier' ) . ' <a href="#nth_checkout_coupon" class="nth-prettyPhoto">' . esc_html__( 'Click here to enter your code', 'theshopier' ) . '</a>';?></h3>
				<?php endif; ?>

				<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div id="customer_details">
						<div class="col-1">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>

						<div>
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>

					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

				<?php endif; ?>

			</div>

		</div>


		<div class="col-sm-10 nth-sidebar">

			<div class="widget_boxed">

				<div class="widget-heading">
					<h3 id="order_review_heading" class="widget-title"><?php esc_html_e( 'Your order', 'theshopier' ); ?></h3>
				</div>

				<div class="content-inner">

					<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

					<div id="order_review" class="woocommerce-checkout-review-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div>

					<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

				</div>

			</div>

		</div>

	</form>

</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
