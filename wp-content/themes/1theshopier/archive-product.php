<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

$sidebar_data = theshopier_pages_sidebar_act('shop');

extract( $sidebar_data );

$check_mobile = theshopier_check_device('xs');

$datas = array(
	'show_bcrumb'	=> 1,
	'is_shop'		=> 1
); 
do_action( 'theshopier_breadcrumb', $datas );

?>
	
<div class="content-wrapper container">

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && $check_mobile ) {
		echo "<h1 class=\"page-title\">";
		woocommerce_page_title();
		echo "</h1>";
	}?>

	<div class="row">
	
		<?php if( strlen($_left_class) > 0 ):?>
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
		
		<div class="nth-content-main<?php echo esc_attr($_cont_class );?>">
			
			<?php
                /**
                 * Hook: woocommerce_before_main_content.
                 *
                 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                 * @hooked woocommerce_breadcrumb - 20
                 * @hooked WC_Structured_Data::generate_website_data() - 30
                 */
				do_action( 'woocommerce_before_main_content' );
			?>

			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && !$check_mobile ) : ?>

				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

			<?php endif; ?>
			
			<?php if( isset($_prod_cat_infomation) && strlen($_prod_cat_infomation) > 0 ): ?>
				<div class="category-infomation">
					<?php echo do_shortcode (stripslashes(htmlspecialchars_decode( $_prod_cat_infomation )) );?>
				</div>
			<?php endif;?>

			<?php
            /**
             * Hook: woocommerce_archive_description.
             *
             * @hooked woocommerce_taxonomy_archive_description - 10
             * @hooked woocommerce_product_archive_description - 10
             */
            do_action( 'woocommerce_archive_description' );
            ?>

			<?php

			if(
				(is_shop() && 'subcategories' !== get_option( 'woocommerce_shop_page_display' )) ||
				(is_product_category() && 'subcategories' !== get_option( 'woocommerce_category_archive_display' ))
			) {
				$sub_slider = true;
				$slide_ops = array(
					"items"				=> 4,
					"responsive"		=> array(
						0	=> array(
							'items'	=> 1,
						),
						480	=> array(
							'items'	=> 2,
						),
						769	=> array(
							'items'	=> 3,
						),
						981	=> array(
							'items'	=> 3,
						),
					)
				);
				$loop_html_start = sprintf('<div class="product-subcategories row"><div class="archive-product-subcategories nth-owlCarousel loading" data-options="%s" data-base="1">', esc_attr(json_encode($slide_ops)));
                $loop_html_end = '</div></div>';
                $loop_html = '';
			} else {
				$sub_slider = false;
				$loop_html_start = '<div class="product-subcategories row"><div class="archive-product-subcategories">';
				$loop_html_end = '</div></div>';
                $loop_html = '';
			}
			if($sub_slider)
            {
                echo $loop_html_start;
                echo woocommerce_maybe_show_product_subcategories($loop_html);
                echo $loop_html_end;
            }
			?>

			<?php if ( have_posts() ) :?>


				<div class="nth-shop-meta-controls col-sm-24">
				<?php

				if($sub_slider)
                {
                    /**
                     * woocommerce_before_shop_loop hook
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action( 'woocommerce_before_shop_loop' );
                }
				?>
				</div>

				<?php
                if(!$sub_slider)
                {
                    echo $loop_html_start;
                    echo woocommerce_maybe_show_product_subcategories($loop_html);
                    echo $loop_html_end;
                }
                ?>
				
				<div class="row">
				<?php
                /**
                 * Remove @hook woocommerce_maybe_show_product_subcategories in framework/functions/hook.php
                 */
                woocommerce_product_loop_start();
                ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				</div>
				<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				?>

			<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php wc_get_template( 'loop/no-products-found.php' ); ?>

			<?php endif; ?>

			<?php
				/**
				 * woocommerce_after_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
			?>
			
		</div><!-- .nth-content-main -->
		
		<?php if( strlen($_right_class) ):?>
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
<?php get_footer( 'shop' ); ?>
