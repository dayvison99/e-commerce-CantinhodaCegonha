<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header();

?>

	<div id="container" class="container content-area index-page">
		<div id="main" class="site-main row content" role="main">

			<div class="nth-content-main col-sm-17 col-md-18">

			<?php if ( have_posts() ) : ?>

				<?php if ( is_home() && ! is_front_page() ) : ?>
				<h1 class="heading-title page-title"><?php single_post_title();?></h1>
				<?php endif; ?>

				<ul class="list-posts row">
				<?php
				while( have_posts() ): the_post();
					get_template_part( 'content', get_post_format() );
				endwhile;
				?>
				</ul>

				<?php theshopier_paging_nav();?>

			<?php else :
				get_template_part( 'content', 'none' );

			endif;?>

			</div>

			<div class="nth-content-right nth-sidebar col-sm-7 col-md-6">
				<?php
				$_slidebar_id = is_active_sidebar('blog-page-widget-area-right')? 'blog-page-widget-area-right': 'main-widget-area';
				?>
				<?php if( is_active_sidebar( $_slidebar_id ) ):?>
					<ul class="widgets-sidebar">
						<?php dynamic_sidebar( $_slidebar_id ); ?>
					</ul>
				<?php else:
					esc_html_e( "Please add some widgets here!", 'theshopier' );
				endif;?>

			</div>


		</div><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>