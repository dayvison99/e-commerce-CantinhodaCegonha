<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package StoreBiz
 */

get_header();
?>
<section id="post-section" class="post-section st-py-default">
	<div class="container">
		<div class="row gy-lg-0 gy-5 wow fadeInUp">
			<div class="<?php esc_attr(storebiz_post_layout()); ?>">
				<div class="row row-cols-1 row-cols-md-2 g-5">
					<?php if( have_posts() ): ?>
				
						<?php while( have_posts() ) : the_post();
						
								get_template_part('template-parts/content/content','search'); 
								
						endwhile; 
						the_posts_navigation();
						?>
						
					<?php else: ?>
					
						<?php get_template_part('template-parts/content/content','none'); ?>
						
					<?php endif; ?>
				</div>
			</div>
			<?php  get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
