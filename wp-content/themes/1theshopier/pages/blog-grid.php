<?php
/**
 *	Template Name: Blog Grid
 */	
get_header();

$sidebar_data = theshopier_pages_sidebar_act('blog');
extract( $sidebar_data );

$datas = array(
	'show_bcrumb'	=> $_show_breadcrumb,
);

do_action( 'theshopier_breadcrumb', $datas );
?>

<div id="container" class="container blog-template">
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
		<div class="nth-content-main<?php echo esc_attr( $_cont_class );?>">

			<?php if($_show_title): ?>
			<h1 class="page-title"><?php the_title();?></h1>
			<?php endif;?>

			<?php
			$args = array(
				"post_type"	=> "post",
				"paged"		=> get_query_var('paged'),
				"posts_per_page"	=> -1
			);
			if( !empty($_per_page) && absint($_per_page) > 0 ) {
				$args['posts_per_page'] = absint($_per_page);
			}

			query_posts($args);
			if( have_posts() ) :

				$isotope_data = array(
					'itemSelector'	=> ".post-item",
					'layoutMode'	=> "masonry"
				);

			?>
			<ul class="list-posts blog-grid-style row nth-isotope-act" data-params="<?php echo esc_attr(json_encode($isotope_data))?>">
			<?php
				add_filter('theshopier_post_content_video_data', 'theshopier_custom_video_size', 10, 1);
				while( have_posts() ): the_post();
					set_query_var( 'theshopier_blog_cols', $_blog_cols );
					get_template_part( 'content', get_post_format() ); 
				endwhile;
				remove_filter('theshopier_post_content_video_data', 'theshopier_custom_video_size', 10);
			?></ul><?php

			endif;
			?>
			
			<?php theshopier_paging_nav(); wp_reset_query();?>
			
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
</div>

<?php get_footer(); ?>

