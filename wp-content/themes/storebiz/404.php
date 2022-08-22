<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Storebiz
 */

get_header();
?>
<section id="section-404" class="section-404 st-py-default">
	<div class="container">
		<div class="row wow fadeInUp">
			<div class="col-lg-6 col-12 text-center mx-auto">
				<div class="card-404">
					
					<h1><img src="<?php echo esc_url(get_template_directory_uri() .'/assets/images/icon404.png'); ?>" alt="image"></h1>
					
					<h4><?php esc_html_e('Page Not Found','storebiz'); ?></h4>
					
					<p><?php esc_html_e('The page you were looking for could not be found.','storebiz'); ?></p>
					
					<div class="card-404-btn mt-3">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary"><?php esc_html_e('Go to Home','storebiz'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>
