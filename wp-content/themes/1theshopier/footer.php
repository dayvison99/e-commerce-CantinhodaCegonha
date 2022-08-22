<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package NexThemes
 * @subpackage nth-theme
 * @since nth-theme
 */

$classes = array(
	'_row_class' => array('footer-wrapper'),
	'_class_cont' => array()
);
$classes = apply_filters('theshopier_main_footer_class',$classes);
?>
				</div><!--.body-wrapper-->
			</div><!--.main-content-->
			
			<footer id="footer" class="<?php echo esc_attr(implode(' ', $classes['_class_cont']))?>">
				<div class="<?php echo esc_attr(implode(' ', $classes['_row_class']))?>">
					<?php do_action( 'theshopier_footer_init' ); ?>
				</div>
			</footer>
			
		</div><!--#main-content-wrapper-->
		<!--div id="main-right-sidebar"></div--><!--#main-right-sidebar-->
	</div><!--#body-wrapper-->

<?php do_action('theshopier_footer_before_body_endtag');?>

<?php wp_footer(); ?>

</body>
</html>