<?php
/**
 * The Template for displaying all single projects.
 *
 * Override this template by copying it to yourtheme/projects/single-project.php
 *
 * @author 		WooThemes
 * @package 	Projects/Templates
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'projects' ); ?>

<?php
$sidebar_data = theshopier_pages_sidebar_act('blog');
extract( $sidebar_data );

$datas = array();
do_action( 'theshopier_breadcrumb', $datas );

?>

	<div id="container" class="container single-post">

		<div id="content" class="site-content row" role="main">

			<div class="nth-content-main col-sm-24">

					<?php
					/**
					 * projects_before_main_content hook
					 *
					 * @hooked projects_output_content_wrapper - 10 (outputs opening divs for the content)
					 */
					do_action( 'projects_before_main_content' );
					?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php projects_get_template_part( 'content', 'single-project' ); ?>

					<?php endwhile; // end of the loop. ?>

					<?php
					/**
					 * projects_after_main_content hook
					 *
					 * @hooked projects_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'projects_after_main_content' );
					?>

			</div>

		</div>
	</div>


<?php get_footer( 'projects' );