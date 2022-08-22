<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */
$options = ecommerce_plus_get_theme_options();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clear' ); ?>>

	<?php if ( ! $options['single_post_hide_date'] ) :
	    ecommerce_plus_posted_on();
	endif; ?>

    <div class="entry-content">
		<div class="entry-title"><h2><?php echo esc_html(get_the_title()); ?></h2></div>
        <?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ecommerce-plus' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ecommerce-plus' ),
				'after'  => '</div>',
			) );
		?>
    </div><!-- .entry-content -->

    <div class="entry-meta">
        <?php if ( ! $options['single_post_hide_author'] ) :
            echo ecommerce_plus_author();
        endif;

        
		ecommerce_plus_single_categories();
		ecommerce_plus_entry_footer(); 
		?>
    </div><!-- .entry-meta -->

</article><!-- #post-## -->
