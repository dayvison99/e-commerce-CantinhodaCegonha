<?php
/**
 *	Template Name: Albums Grid
 */

if( !class_exists('Nexthemes_Gallery') ) return '';

get_header();

$sidebar_data = theshopier_pages_sidebar_act();
extract( $sidebar_data );

$datas = array(
    'show_bcrumb'	=> $_show_breadcrumb,
);

do_action( 'theshopier_breadcrumb', $datas );
?>

<div id="container" class="galleries-template">

    <div class="nth-content-main">

        <div class="container">
            <?php if($_show_title):?>
                <h1 class="page-title"><?php esc_html_e('Gallery', 'theshopier')?></h1>
            <?php endif;?>
        </div>

        <?php
        $class = array('nth-portfolio-container');
        if(!empty( $_album_style )) $class[] = $_album_style;
        ?>

        <div class="nth-portfolios-wrapper">
            <div class="<?php echo esc_attr(implode(' ', $class))?>">
                <div class="nth-portfolio-filters-wrap container">
                    <?php Nexthemes_Gallery::getFilters();?>
                </div>

                <div class="nth-fullwidth">
                    <div class="nth-portfolio-content">
                        <?php
                        Nexthemes_Gallery::getContent();?>
                    </div>
                </div>

            </div>

            <div class="container">
                <?php theshopier_paging_nav();?>
            </div>

        </div>

    </div>

</div>

<?php get_footer(); ?>
