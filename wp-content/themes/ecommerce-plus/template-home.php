<?php
/**
 * Template Name: Home - Page
 */

	get_header();
	$ecommerce_plus_options = ecommerce_plus_get_theme_options();

	//2 sections before content
	?>
	<div>
	<?php
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_1']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_2']);
	?>
	<div>

<div class="inner-content-wrapper">
	<div class="container">
		<div class="row">
		<?php 
		while ( have_posts() ) : the_post();
			the_content();
		endwhile; // End of the loop.
		?>
		</div>
	</div>
</div>

<div class="home-template-wrapper">
	<?php
	//other sections after content
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_3']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_4']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_5']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_6']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_7']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_8']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_9']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_10']);
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_11']);	
	ecommerce_plus_do_action($ecommerce_plus_options['home_section_12']);					
	?>
</div>

<?php
get_footer();
