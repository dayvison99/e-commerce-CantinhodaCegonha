<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $theshopier_datas;

do_action( 'woocommerce_before_account_navigation' );

if(is_user_logged_in()) {
	$current_user = wp_get_current_user();
}

?>

<nav class="col-lg-6 col-sm-8">
	<div class="nth-row-grid">
		<div class="col-sm-24">
			<div class="gavatar-box clearfix">
				<?php echo get_avatar($current_user->user_email, 70, '', null, array('class'=> 'img-circle'));?>
				<div class="meta">
					<h3><?php echo esc_html($current_user->display_name);?></h3>
					<?php printf('<a href="%1$s" title="%2$s">%2$s</a>', esc_url(wp_logout_url(get_permalink())), esc_html__("Logout", 'theshopier'));?>
				</div>
			</div>

			<ul>
				<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
					<?php
					$src = '#';
					if(is_array($label) && isset($label['label'])) {
						$src = $label['url'];
						$label = $label['label'];
					} else {
						$acc_url = wc_get_page_permalink( 'myaccount' );
						//$src = wc_get_endpoint_url( $endpoint, '', $acc_url );
						$src = wc_get_account_endpoint_url( $endpoint );
					}
					?>
					<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">

						<a href="<?php echo esc_url($src); ?>"><?php echo esc_html( $label ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>

</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
