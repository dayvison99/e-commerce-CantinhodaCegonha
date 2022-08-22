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

$ecommerce_plus_options = ecommerce_plus_get_theme_options();
$ecommerce_plus_class = has_post_thumbnail() ? 'col-sm-6 col-lg-6 col-xs-12' : 'no-post-thumbnail col-sm-6 col-lg-6 col-xs-12';
$ecommerce_plus_readmore = ! empty( $ecommerce_plus_options['read_more_text'] ) ? $ecommerce_plus_options['read_more_text'] : esc_html__( 'Read More', 'ecommerce-plus' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $ecommerce_plus_class ); ?> >
    <div class="post-item-wrapper">
        <?php if ( has_post_thumbnail() ) : ?>		
            <div class="featured-image" >
               <img src="<?php the_post_thumbnail_url( 'post-thumbnail' ); ?>" /> <a href="<?php the_permalink(); ?>" class="post-thumbnail-link"></a></img>
            </div><!-- .featured-image -->
        <?php endif; ?>

        <div class="entry-container">
            <div class="entry-meta">
                <?php if ( ! $ecommerce_plus_options['hide_category'] ) : ?>
                    <span class="cat-links">
                        <?php the_category(); ?>
                    </span><!-- .cat-links -->
                <?php endif;

                if ( ! $ecommerce_plus_options['hide_date'] ) :
                    ecommerce_plus_posted_on();
                endif; ?>
            </div><!-- .entry-meta -->

            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div><!-- .entry-content -->

            <div class="read-more">
                <a href="<?php the_permalink(); ?>" class="btn">
                    <span class="screen-reader-text"><?php the_title(); ?></span>
                    <?php echo esc_html( $ecommerce_plus_readmore ); ?>
                </a>
            </div><!-- .read-more -->
        </div><!-- .entry-container -->
    </div><!-- .post-item-wrapper -->
</article><!-- #post-## -->
