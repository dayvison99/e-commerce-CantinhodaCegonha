<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 10/31/2015
 * Vertion: 1.0
 */
$sticky_class = apply_filters('theshopier_header_sticky_class', array('nth_header_bottom hidden-xs hidden-sm'));

?>
<div class="nth_header_top hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
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
            <div class="col-sm-12">
                <?php if ( has_nav_menu( 'primary-menu' )) {
                    wp_nav_menu( array(
                        'container_class' => 'main-menu text-right pc-menu animated',
                        'theme_location' => 'primary-menu',
                        'walker' => new Theshopier_Mega_Menu_Frontend(),
                        'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                    ) );
                }?>
            </div>

        </div>
    </div>
</div>

<div class="nth_header_middle hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="visible-xs nth-phone-menu-icon"><i class="fa fa-bars"></i></div>
            <div class="col-sm-12 col-md-6 nth_header_middle_left"><?php theshopier_getLogo();?></div>
            <div class="col-sm-12 col-md-18 nth_header_middle_right">
                <div class="row">
                    <div class="hidden-xs hidden-sm col-md-18 col-lg-19"><?php theshopier_search_form(); ?></div>
                    <div class="col-sm-24 col-md-6 col-lg-5 text-center top-cart-wrapper">
                        <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
                    </div>
                </div>
            </div><!-- .col-sm-18 -->
        </div>
    </div>
</div>

<div class="<?php echo esc_attr(implode(' ', $sticky_class));?>">
    <div class="container">
        <div class="row">
            <div class="col-sm-24">
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
    </div>
</div>