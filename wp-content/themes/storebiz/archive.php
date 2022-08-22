<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Storebiz
 */

get_header();
?>
<section id="post-section" class="post-section st-py-default">
	<div class="container">
		<div class="row gy-lg-0 gy-5 wow fadeInUp">
			<div class="<?php esc_attr(storebiz_post_layout()); ?>">
				<div class="row row-cols-1 row-cols-md-1 gx-5 gy-5">
					<?php if( have_posts() ): ?>
				
						<?php while( have_posts() ) : the_post(); ?>
						<div class="col">
							<?php get_template_part('template-parts/content/content','page');	?>
						</div>
						<?php endwhile; ?>
						
					<?php else: ?>
					
						<?php get_template_part('template-parts/content/content','none'); ?>
						
					<?php endif; ?>
				</div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>