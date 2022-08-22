<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/28/2015
 * Vertion: 1.0
 *
 * HEADER STYLE 6
 */

$sticky_class = apply_filters('theshopier_header_sticky_class', array('nth_header_bottom container hidden-xs hidden-sm'));
?>

<div class="nth_header_top hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-24">
                <?php
                $sidebar_name = "header-top-widget-area";
                if( is_active_sidebar( $sidebar_name ) ):?>
                    <ul class="widgets-sidebar">
                        <?php dynamic_sidebar( $sidebar_name ); ?>
                    </ul>
                <?php else:
                    esc_html_e( "Please add some widgets here!", 'theshopier' );
                endif;?>
            </div>
        </div>
    </div>
</div>

<div class="nth_header_middle container hidden-xs hidden-sm">
    <div class="row nth_header_middle_inner">
        <div class="col-sm-12 col-md-6 col-lg-6"><?php theshopier_getLogo();?></div>
        <div class="col-sm-12 col-md-10 col-lg-12 text-center"><?php theshopier_search_form(); ?></div>
        <div class="col-sm-12 col-md-8 col-lg-6 text-right fix-over-right-100">
            <div class="nth-tini-wrapper"><?php theshopier_login_form();?></div>
            <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
        </div>
    </div>
</div>

<div class="<?php echo esc_attr(implode(' ', $sticky_class));?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-24 hidden-xs nth-menu-wrapper">
                <?php if ( has_nav_menu( 'vertical-menu' )) {
                    wp_nav_menu( array(
                        'container_class' => 'main-menu vertical-menu-hol text-left pc-menu animated',
                        'theme_location' => 'vertical-menu',
                        'walker' => new Theshopier_Mega_Menu_Frontend(),
                        'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                    ) );
                }?>
            </div>
        </div>
    </div>
</div>
