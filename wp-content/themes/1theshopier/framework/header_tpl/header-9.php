<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 10/31/2015
 * Vertion: 1.0
 */

$sticky_class = apply_filters('theshopier_header_sticky_class', array('nth_header_bottom hidden-xs hidden-sm'));
?>
<div class="nth_header_middle hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 nth_header_middle_left"><?php theshopier_getLogo();?></div>
            <div class="col-sm-12 col-md-18  nth-right-block-wrapper">
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

                <div class="tb-search-wrapper">
                    <div class="tb-search-inner"><?php theshopier_search_form(); ?></div>
                </div>
                <div class="text-right nth-mini-popup-wrapper">
                    <div class="nth-tini-wrapper"><?php theshopier_login_form();?></div>
                    <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="<?php echo esc_attr(implode(' ', $sticky_class));?>">
    <div class="container">
        <div class="row">
            <div class="hidden-xs nth-menu-wrapper">
                <?php if ( has_nav_menu( 'vertical-menu' )) {
                    wp_nav_menu( array(
                        'container_class' => 'main-menu vertical-menu-hol text-center pc-menu animated',
                        'theme_location' => 'vertical-menu',
                        'walker' => new Theshopier_Mega_Menu_Frontend(),
                        'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                    ) );
                }?>
            </div>
        </div>
    </div>
</div>