<?php
/**
 * The template for displaying product content within loops
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$terms = get_the_terms($post->ID,'product_cat');
if (is_array($terms) && count($terms)) {
	$count = count($terms);
}else{
	$count = 0;
}
$i=0;
if ($count > 0) {
    $term_list = '';
    foreach ($terms as $storebiz_product_term) {
        $i++;
        if ($storebiz_product_term->parent==0) {
			$term_list .= str_replace(' ', '-', strtolower($storebiz_product_term->name));
            if ($count != $i) $term_list .= ' ';
        }
    }
?>
<li <?php wc_product_class( strtolower($term_list).'', $product ); ?>>
<?php  } else { ?>
<li <?php wc_product_class( '', $product ); ?>>
<?php } ?>
	<div class="product">
		<div class="product-single">
			<div class="product-bg"></div>
			<div class="product-img">
				<?php
				/**
				 * Hook: woocommerce_before_shop_loop_item.
				 *
				 * @hooked woocommerce_template_loop_product_link_open - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item' );
				?>
				<a href="<?php echo esc_url(the_permalink()); ?>">
					<?php the_post_thumbnail(); ?>
				</a>
				<?php if ( $product->is_on_sale() ) : ?>

				<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sale-ribbon"><span class="tag-line">' . esc_html__( 'Sale', 'storebiz' ) . '</span></div>', $post, $product ); ?>
				<?php endif; ?>
			</div>
			<div class="product-content-outer">
				<div class="product-content">
					<div class="pro-rating">
						<?php if ($average = $product->get_average_rating()) : ?>
						<?php echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'storebiz' ), $average).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'storebiz' ).'</span></div>'; ?>
						<?php endif; ?>
					</div>
					<h3><a href="<?php echo esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h3>
					<div class="price">
						<?php echo $product->get_price_html(); ?>
					</div>
				</div>
				<div class="product-action">			
					<?php

					/**
					 * Hook: woocommerce_after_shop_loop_item.
					 *
					 * @hooked woocommerce_template_loop_product_link_close - 5
					 * @hooked woocommerce_template_loop_add_to_cart - 10
					 */
					 do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</div>
			</div>
		</div>
	</div>
</li>