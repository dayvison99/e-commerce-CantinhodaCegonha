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
 * Template Name: Page 1790 template
 */

get_header();

$sidebar_data = theshopier_pages_sidebar_act();
extract( $sidebar_data );

$datas = array(
	'show_title'	=> $_show_title,
	'show_bcrumb'	=> $_show_breadcrumb
); 
do_action( 'theshopier_breadcrumb', $datas );

?>
<div id="container" class="content-wrapper page-content container container-1790">
	<div class="row">
		
		<?php if( strlen(trim($_left_class)) ):?>
		<div class="nth-content-left nth-sidebar<?php echo esc_attr( $_left_class );?>">
			<?php if( is_active_sidebar( $_left_sidebar ) ):?>
			<ul class="widgets-sidebar">
				<?php dynamic_sidebar( $_left_sidebar ); ?>
			</ul>
			<?php else:
				esc_html_e( "Please add some widgets here!", 'theshopier' );
			endif;?>
		</div><!-- .nth-content-left -->
		<?php endif;?>
		
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
		
		<?php if( strlen(trim($_right_class)) ):?>
		<div class="nth-content-right nth-sidebar<?php echo esc_attr( $_right_class );?>">
			<?php if( is_active_sidebar( $_right_sidebar ) ):?>
			<ul class="widgets-sidebar">
				<?php dynamic_sidebar( $_right_sidebar ); ?>
			</ul>
			<?php else:
				esc_html_e( "Please add some widgets here!", 'theshopier' );
			endif;?>
		</div><!-- .nth-content-right -->
		<?php endif;?>
		
	</div>
</div><!--.content-wrapper-->
<?php 

get_footer();
