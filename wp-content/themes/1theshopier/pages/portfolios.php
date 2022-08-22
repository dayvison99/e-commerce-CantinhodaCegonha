<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/11/2015
 * Vertion: 1.0
 */

/**
 *	Template Name: Portfolios full-width
 */

if( class_exists('Nexthemes_Portfolio_Front') ):

    /* Nexthemes Portfolio plugin */
    $nexthemes_portfolio = new Nexthemes_Portfolio_Front();

    get_header();

    $sidebar_data = theshopier_pages_sidebar_act();
    extract( $sidebar_data );

    $datas = array(
        'show_bcrumb'	=> $_show_breadcrumb,
    );

    do_action( 'theshopier_breadcrumb', $datas );

?>
<div id="container" class="portfolio-template">

    <div class="nth-content-main">

        <div class="container">
            <?php if($_show_title):?>
                <h1 class="page-title"><?php the_title();?></h1>
            <?php endif;?>
        </div>

        <div class="nth-portfolios-wrapper">

            <div class="nth-portfolio-container">

                <div class="nth-portfolio-filters-wrap container">

                    <?php $nexthemes_portfolio->get_filters();?>

                </div>

                <div class="nth-portfolio-content row">

                    <?php
                    $atts = array(
                        'columns' 				=>  4
                        ,'limit' 				=>  '-1'
                    );
                    $nexthemes_portfolio->get_content( $atts );
                    ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>

<?php endif;?>
