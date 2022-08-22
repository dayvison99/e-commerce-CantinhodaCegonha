<?php
/**
 * The template for displaying all single posts
 *
 */

if( class_exists('Nexthemes_Gallery') ) :

get_header(); 

$datas = array(); 
do_action( 'theshopier_breadcrumb', $datas );

?>

	<div id="container" class="single-post single-gallery">
		<div id="content" class="site-content" role="main">

			<div class="nth-content-main">
				<?php
				if(have_posts()) {
					while( have_posts() ) { the_post();

						$galleries = Nexthemes_Gallery::get_galleries_data(get_the_ID());

						?>
				<div <?php post_class("single-post");?>>

					<div class="container gallery-header">

						<h1 class="post-title heading-title"><?php the_title(); ?></h1>

						<div class="post-content">
							<?php the_content(); ?>
						</div><!-- .post-content -->

					</div>

					<?php
					$style = isset($galleries['g_style'])? $galleries['g_style']: '1';
					get_template_part('single','gallery_'.$style);
					?>

				</div>
						<?php
					}
				}
				?>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); endif;?>