<?php
if( strlen( trim( $heading ) ) > 0 ) {
	$heading_class = array('heading-title');
	if( strlen(trim($h_style)) > 0 ) $heading_class[] = esc_attr($h_style);
	echo '<div class="nth-shortcode-header"><h3 class="'.esc_attr(implode(' ', $heading_class)).'">'. esc_html($heading) .'</h3></div>';
}

if ( $products->have_posts() ) :

	while ( $products->have_posts() ) : $products->the_post();

		$rating_product = '';
		if( class_exists('WooCommerce') ) {
			$product_id = esc_attr( get_post_meta( get_the_ID(), '_products_id', true ) );
			if( isset($product_id) && $product_id !== '' && absint($product_id) > 0) {
				global $product;
				$product = wc_get_product($product_id);
				$rating_product = $product->get_rating_html();
			}
		}

		if(function_exists('woothemes_get_testimonials')) {
			$testimonial_id = esc_attr( get_post_meta( get_the_ID(), '_testimonials_id', true ) );
			$nexthemes_testimonial = woothemes_get_testimonials( array('id' => $testimonial_id,'limit' => 1, 'size' => '100'));
		}


?>
<div class="nth-shortcode-content">
	<h2><?php the_title()?></h2>
	<p class="description">
		<?php
		$excerpt = get_the_excerpt();

		$words = explode(' ', $excerpt, 55);
		if(count($words) > $limit) array_pop($words);

		echo implode(' ', $words);
		?>
	</p>

	<?php
	echo $rating_product;

	if(count($nexthemes_testimonial) > 0) : ?>

		<p class="project-testimonial"><?php echo $nexthemes_testimonial[0]->post_content;?></p>

	<?php endif;?>

</div>

<?php
	endwhile;

endif;
?>