<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header();
$datas = array(
	'show_bcrumb'	=> 1,
);

do_action( 'theshopier_breadcrumb', $datas );

?>

<div id="container" class="content-wrapper page-404 container">
	<div class="nth-content-main">
		
		<h1 class="page-heading page-title"><?php esc_html_e("404 Page Not Found", 'theshopier' );?></h1>
		
		<div class="page-404-content-inner col-sm-24">

			<?php
			theshopier_get_404_content();
			?>

		</div>
		
	</div>
</div>

<?php get_footer(); ?>