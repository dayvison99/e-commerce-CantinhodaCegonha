<?php
/**
 * side bar template
 *
 * @package StoreBiz
*/
?>
<?php if ( ! is_active_sidebar( 'storebiz-woocommerce-sidebar' ) ) {	return; } ?>
<div class="col-lg-4 pl-lg-4 order-0">
	<div class="sidebar">
		<?php dynamic_sidebar('storebiz-woocommerce-sidebar'); ?>
	</div>
</div>