<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 10/31/2015
 * Vertion: 1.0
 */

?>

<div class="nth_header_top hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="nth-menu-wrapper">
                    <?php if ( has_nav_menu( 'primary-menu' )) {
                        wp_nav_menu( array(
                            'container_class' => 'main-menu pc-menu animated',
                            'theme_location' => 'primary-menu',
                            'walker' => new Theshopier_Mega_Menu_Frontend(),
                            'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                        ) );
                    }?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="nth-header-top-wrapper pull-right">
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
                <div class="text-right pull-right">
                    <div class="nth-tini-wrapper"><?php theshopier_search_form();?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="nth_header_middle hidden-xs hidden-sm">
    <div class="container">

        <div class="col-sm-12 col-md-4 nth_header_middle_left"><?php theshopier_getLogo();?></div>
        <div class="col-sm-12 col-md-20  nth-right-block-wrapper">
            <div class="nth-menu-wrapper">
                <?php if ( has_nav_menu( 'vertical-menu' )) {
                    wp_nav_menu( array(
                        'container_class' => 'main-menu pc-menu animated',
                        'theme_location' => 'vertical-menu',
                        'walker' => new Theshopier_Mega_Menu_Frontend(),
                        'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                    ) );
                }?>
            </div>

            <div class="text-right nth-mini-popup-wrapper">
                <div class="nth-tini-wrapper"><?php theshopier_login_form();?></div>
                <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
            </div>
        </div>

    </div>
</div>