<?php
/**
 *	Template Name: Contact Us
 */	
get_header();

$sidebar_data = theshopier_pages_sidebar_act();
extract( $sidebar_data );

$_left = $_right = false;
$_left_class = $_right_class = '';
$_cont_class = ' col-sm-24';


$datas = array(
	'show_bcrumb'	=> $_show_breadcrumb,
); 
do_action( 'theshopier_breadcrumb', $datas );

?>

<div id="container" class="content-wrapper contact-page container">
	<div class="row">
		
		<div class="nth-content-main col-sm-24">

			<?php if($_show_title):?>
			<h1 class="page-title"><?php the_title();?></h1>
			<?php endif;?>

			<?php 
			if( have_posts() ) : the_post();
				get_template_part( 'content', 'page' );	
			endif;
			?>
		</div><!-- .nth-content-main -->
		
	</div>
</div><!--.content-wrapper-->

<?php get_footer(); ?>