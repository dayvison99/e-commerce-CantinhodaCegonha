<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 10/31/2015
 * Vertion: 1.0
 */

?>
<div class="nth_header_top hidden-xs hidden-sm">
    <div class="container text-center">
        <div class="nth-menu-wrapper">
            <?php if ( has_nav_menu( 'primary-menu' )) {
                wp_nav_menu( array(
                    'container_class' => 'main-menu text-center pc-menu animated',
                    'theme_location' => 'primary-menu',
                    'walker' => new Theshopier_Mega_Menu_Frontend(),
                    'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                ) );
            }?>
        </div>
    </div>
</div>
<div class="nth_header_middle hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-8 text-center"><?php theshopier_getLogo();?></div>
            <div class="col-sm-8 text-right">
                <div>
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
                <div class="nth-tini-wrapper"><?php theshopier_search_form();?></div>
                <div class="text-right">
                    <div class="nth-tini-wrapper"><?php theshopier_login_form(3);?></div>
                    <div class="nth-tini-wrapper"><?php theshopier_shoppingCart(3);?></div>
                </div>
            </div>
        </div>
    </div>
</div>