<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package StoreBiz
 */

get_header(); 
?>
<section id="post-section" class="post-section st-py-default">
	<div class="container">
		<div class="row gy-lg-0 gy-5 wow fadeInUp">
			<div class="<?php esc_attr(storebiz_post_layout()); ?>">
				<div class="row row-cols-1 row-cols-md-1 g-5">
						<?php 
							$storebiz_paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
							$args = array( 'post_type' => 'post','paged'=>$storebiz_paged );	
						?>
						<?php if( have_posts() ): ?>
							<?php while( have_posts() ) : the_post(); ?>
								<div class="col">
									<?php get_template_part('template-parts/content/content','page'); ?>
								</div>
							<?php endwhile; ?>
						<?php else: ?>
							<?php get_template_part('template-parts/content/content','none'); ?>
						<?php endif; ?>
				</div>
				<div class="row">
				<div class="col-12 text-center mt-5">
					<div class="sp-post-pagination">
						<!-- Pagination -->
							<?php								
							// Previous/next page navigation.
							the_posts_pagination( array(
							'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
							'next_text'          => '<i class="fa fa-angle-double-right"></i>',
							) ); ?>
						<!-- Pagination -->	
					</div>
				</div>
			</div>
			</div>
			<?php  get_sidebar(); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>
