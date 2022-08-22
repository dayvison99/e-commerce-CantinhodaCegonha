<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage ctheme
 * @since Ctheme
 *
 * Template Name: Page Full-width
 */

get_header();

$sidebar_data = theshopier_pages_sidebar_act('blog');
extract( $sidebar_data );

$datas = array(
	'show_title'	=> $_show_title,
	'show_bcrumb'	=> $_show_breadcrumb
); 
do_action( 'theshopier_breadcrumb', $datas );

?>
<div id="container" class="content-wrapper page-content">
	<div class="row">
		
		<div class="nth-content-main <?php echo esc_attr( $_cont_class );?>">

			<?php if(!is_home() && !is_front_page() && absint($datas['show_title'])): ?>
				<h1 class="page-title">
					<?php
					echo apply_filters( 'theshopier_page_title', get_the_title() );
					?>
				</h1>
			<?php endif;?>
			
			<?php 
			if( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );	
			endif;
			?>
		</div><!-- .nth-content-main -->
		
	</div>
</div><!--.content-wrapper-->
<?php 

get_footer();
