<?php 
$storebiz_hs_blog		 	 = get_theme_mod('hs_blog','1');
$storebiz_blog_title		 = get_theme_mod('blog_title');
$storebiz_blog_display_num	 = get_theme_mod('blog_display_num','3');
if($storebiz_hs_blog=='1'){
?>
<section id="post-section" class="post-section st-py-default post-front">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-12 mx-lg-auto mb-5 text-center">
				<div class="heading-default text-white wow fadeInUp">
					<div class="title">
						<?php if ( ! empty( $storebiz_blog_title ) ) : ?>		
							<h4><?php echo wp_kses_post($storebiz_blog_title); ?></h4>	
						<?php endif; ?>	
					</div>
					<div class="heading-right">
						<div class="blog-nav owl-nav">
							<button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>
							<button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
						</div>
					</div>
				</div>
			</div>
		</div>		
		<div class="row wow fadeInUp">
			<div class="col-12 blog-slider owl-carousel owl-theme">
				<?php 	
					$storebiz_blogs_args = array( 'post_type' => 'post', 'posts_per_page' => $storebiz_blog_display_num,'post__not_in'=>get_option("sticky_posts")) ; 	
					$storebiz_blog_wp_query = new WP_Query($storebiz_blogs_args);
					if($storebiz_blog_wp_query)
					{	
					while($storebiz_blog_wp_query->have_posts()):$storebiz_blog_wp_query->the_post(); ?>
						<div class="blog-item default-carousel">
							<?php get_template_part('template-parts/content/content','page'); ?>
						</div>
					<?php
					endwhile;
					}
					wp_reset_postdata();
				?>
			</div>
		</div>
	</div>
</section>
<?php } ?>