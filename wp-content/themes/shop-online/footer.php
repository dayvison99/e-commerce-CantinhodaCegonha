<?php
/**
 * @since 1.0.0
 */
    $shop_online_options = ecommerce_plus_get_theme_options();
	$copyright_text = $shop_online_options['copyright_text'];

if (class_exists('WooCommerce') && is_shop()) {
?>

<section id="after-shop-page">
	<div>
		<?php
			
		$shop_online_args = array( 'post_type' => 'page', 'ignore_sticky_posts' => 1 , 'post__in' => array($shop_online_options['after_shop']));
		$shop_online_result = new WP_Query($shop_online_args);
		while ( $shop_online_result->have_posts() ) :
			$shop_online_result->the_post();
			the_content();
		endwhile;
		wp_reset_postdata();

		?>
	</div>
</section>

<?php
}
?>
</div><!-- #content -->
	
<footer id="colophon" class="site-footer" role="contentinfo" style="background-color:<?php echo esc_attr($shop_online_options['footer_bg_color']); ?>;background-image:url('<?php echo esc_attr($shop_online_options['footer_image']); ?>')" >

	<div class="container">
		<div class="row">
			<?php require get_template_directory() . '/inc/footer-widgets.php' ;?>		
		</div>		
	</div>


	<div class="site-info">
	
		<div class="container">
		
		<?php 
		if ($shop_online_options['social_whatsapp_link'] =='' && $shop_online_options['social_instagram_link'] =='' && $shop_online_options['social_youtube_link'] =='' && $shop_online_options['social_linkdin_link'] =='' && $shop_online_options['social_twitter_link'] =='' && $shop_online_options['social_facebook_link'] =='' ) {
		} else {
		?>
		
		<div class="row">
			<div class="col-sm-12 col-xs-12 footer-social-container">
				 
				<div id="top-social-right" class="footer_social_links">
				  <ul>
					<?php if ($shop_online_options['social_whatsapp_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_whatsapp_link']); ?>" class="social_links_header_4 whatsapp" target="_blank"> <span class="ts-icon"> <i class="fa fa-whatsapp"></i> </a></li> <?php } ?>
					<?php if ($shop_online_options['social_pinterest_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_pinterest_link']); ?>" class="social_links_header_6 pinterest" target="_blank"> <span class="ts-icon"> <i class="fa fa-pinterest"></i> </a></li> <?php } ?>            
					<?php if ($shop_online_options['social_instagram_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_instagram_link']); ?>" class="social_links_header_2 instagram" target="_blank"> <span class="ts-icon"> <i class="fa fa-instagram"></i> </a></li> <?php } ?>
					<?php if ($shop_online_options['social_youtube_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_youtube_link']); ?>" class="social_links_header_3 youtube" target="_blank"> <span class="ts-icon"> <i class="fa fa-youtube"></i> </a></li> <?php } ?>
					<?php if ($shop_online_options['social_linkdin_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_linkdin_link']); ?>" class="social_links_header_5 linkedin" target="_blank"> <span class="ts-icon"> <i class="fa fa-linkedin"></i> </a></li> <?php } ?>
					<?php if ($shop_online_options['social_twitter_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_twitter_link']); ?>" class="social_links_header_1 twitter" target="_blank"> <span class="ts-icon"> <i class="fa fa-twitter"></i> </a></li> <?php } ?>
					<?php if ($shop_online_options['social_facebook_link'] !='') { ?><li> <a href="<?php echo esc_url($shop_online_options['social_facebook_link']); ?>" class="social_links_header_0 facebook" target="_blank"> <span class="ts-icon"> <i class="fa fa-facebook"></i> </a></li> <?php } ?>
				  </ul>
				</div>
				
			</div>
		</div>
		
		<?php } ?>

		<div class="row">
		<div class="col-sm-12 col-xs-12"> 
        <span>
        	<?php 
        		echo '<a href="https://ceylonthemes.com">'.ecommerce_plus_santize_allowed_html( $copyright_text ).'</a>'; 
			?>
    	</span>
		</div>
		
		</div>
		
		</div><!-- .container -->
    </div><!-- .site-info -->

		<?php
		if ( true === $shop_online_options['scroll_top_visible'] ) :
		?><div class="backtotop"><?php echo ecommerce_plus_get_svg( array( 'icon' => 'up' ) ); ?></div>
		<?php endif; ?>

		</footer>
		<div class="popup-overlay"></div>
		
		
<?php wp_footer(); ?>

</body>
</html>
