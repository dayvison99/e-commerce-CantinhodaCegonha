<!--===// Start: Footer
    =================================-->
</div>
</div>
<?php 
	$footer_bg_img			= get_theme_mod('footer_bg_img',esc_url(get_template_directory_uri() .'/assets/images/bg/footer_bg.jpg')); 
	$footer_back_attach		= get_theme_mod('footer_back_attach','scroll');
?>
<footer id="footer-section" class="footer-section main-footer" style="background:url('<?php echo esc_url($footer_bg_img); ?>') no-repeat <?php echo esc_attr($footer_back_attach); ?> center center / cover rgb(0 0 0 / 0.75);background-blend-mode:multiply;">
	<?php  if ( is_active_sidebar( 'storebiz-footer-widget-area' ) ) { ?>		
		<div class="footer-main">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 g-4">
					<?php  dynamic_sidebar( 'storebiz-footer-widget-area' ); ?>
				</div>
			</div>
		</div>
	<?php } 
		$footer_copyright	= get_theme_mod('footer_copyright','Copyright &copy; [current_year] [site_title] | Powered by [theme_author]');
	?>	
	<div class="footer-bottom">
		<div class="footer-copyright">
			<div class="container">
				<div class="row">
					<div class="col-12 text-center">
						<div class="copyright-text">
							<?php 	
								$storebiz_copyright_allowed_tags = array(
									'[current_year]' => date_i18n('Y'),
									'[site_title]'   => get_bloginfo('name'),
									'[theme_author]' => sprintf(__('<a href="#">StoreBiz</a>', 'storebiz')),
								);
							?>        
							<p>
								<?php
									echo apply_filters('storebiz_footer_copyright', wp_kses_post(storebiz_str_replace_assoc($storebiz_copyright_allowed_tags, $footer_copyright)));
								?>
							</p>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</footer>

<!-- Scrolling Up -->
<button type="button" class="scrollingUp scrolling-btn" aria-label="scrollingUp"><i class="fa fa-angle-up"></i></button>
	
<?php wp_footer(); ?>
</body>
</html>
