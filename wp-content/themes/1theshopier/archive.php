<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();

$sidebar_data = theshopier_pages_sidebar_act('blog');
extract( $sidebar_data );

$datas = array(
	'show_bcrumb'	=> $_show_breadcrumb,
); 
do_action( 'theshopier_breadcrumb', $datas );
?>	
<div id="container" class="content-wrapper archive-page container">
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

			<?php
			the_archive_title('<h1 class="heading-title page-title">', '</h1>');
			?>

			<?php if(have_posts()) : ?>
			
			<ul class="list-posts row">
			
				<?php while( have_posts() ): the_post();?>
				
				<?php get_template_part( 'content', get_post_format() );?>
				
				<?php endwhile;?>
			
			</ul>
			
			<?php endif;?>
			
			<?php theshopier_paging_nav();?>
			
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
</div><!-- .container -->
<?php get_footer(); ?>