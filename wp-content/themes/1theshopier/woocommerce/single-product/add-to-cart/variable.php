<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $theshopier_datas;

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( htmlspecialchars( wp_json_encode( $available_variations ) ) )?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'theshopier' ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0">
			<tbody>
				<?php 
				if( class_exists( "Theshopier_ShopByColor" ) ) {
					$_color = 'color';
					$attribute_color = isset( $_color )? wc_sanitize_taxonomy_name( stripslashes( (string) $_color ) ) : '';
				} else {
					$attribute_color = "";
				}
				?>
				
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?></label></td>
						<td class="value">
							<?php
							$hide_class = '';
							if( !isset($theshopier_datas['product-page-variable-style']) || strcmp('section_button', trim($theshopier_datas['product-page-variable-style'])) == 0 ) {
								if( strlen( $attribute_color ) > 0 && is_array( $options ) && $attribute_name == wc_attribute_taxonomy_name( $attribute_color ) ){
									if ( taxonomy_exists( $attribute_name ) ) {
										echo theshopier_variable_option_html($attribute_name, $options, $selected_attributes, true);
										$hide_class = 'hide';
									}
								} else {
									if ( taxonomy_exists( $attribute_name ) ) {
										echo theshopier_variable_option_html($attribute_name, $options, $selected_attributes);
										$hide_class = 'hide';
									}
								}
							}
							?>

                            <?php
                            $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );
                            wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'class'  => $hide_class ) );
                            echo end( $attribute_keys ) === $attribute_name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'theshopier' ) . '</a>' ) : '';
                            ?>
						</td>
					</tr>
		        <?php endforeach;?>
					
				<?php do_action( 'woocommerce_before_single_variation' ); ?>
					
					<tr class="single_variation_wrap">
						<td><label><?php esc_attr_e('Quantity', 'theshopier')?></label></td>
						<td>
							<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) );?>
							<div class="woocommerce-variation single_variation"></div>
						</td>
					</tr>
					
				<?php do_action( 'woocommerce_after_single_variation' ); ?>
				
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" style="display:none;">
			<?php
				/**
				 * woocommerce_before_single_variation Hook
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
		
		<div class="single_variation_wrap" style="display:none;">
			<button type="submit" class="single_add_to_cart_button button alt icon-nth-cart"><?php echo $product->single_add_to_cart_text(); ?></button>
			<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $product->get_id() ); ?>" />
			<input type="hidden" name="variation_id" class="variation_id" value="" />
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>


