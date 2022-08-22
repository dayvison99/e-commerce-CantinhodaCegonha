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
    </div>
</div>
<div class="nth_header_middle hidden-xs hidden-sm header-1">
    <div class="container">
        <div class="row">
            <!--<div class="visible-xs nth-phone-menu-icon"><i class="fa fa-bars"></i></div>-->
            <div class="col-sm-12 col-md-6"><?php theshopier_getLogo();?></div>
            <div class="col-sm-12 col-md-18">
                <div class="row">
                    <div class="hidden-xs hidden-sm col-md-14 col-lg-16"><?php theshopier_search_form(); ?></div>
                    <div class="col-sm-24 col-md-10 col-lg-8 text-right">
                        <?php
                        if( $shipping_text = theshopier_get_themeoptions_by_key('header-shipping-text') ) {
                            $html_al = wp_kses_allowed_html( 'post' );
                            echo do_shortcode( wp_kses(stripslashes(htmlspecialchars_decode( $shipping_text )), $html_al) );
                        }
                        ?>
                    </div>
                </div>
            </div><!-- .col-sm-18 -->
        </div>
    </div>
</div>

<div class="<?php echo esc_attr(implode(' ', $sticky_class));?>">
    <div class="container">
        <div class="row">
            <?php $toggle_class = "toggle";?>
            <div class="col-sm-8 col-md-6 nth-menu-vertical">
                <div class="vertical-menu-wrapper hidden-xs hidden-sm <?php echo esc_attr($toggle_class);?>">
                    <div class="vertical-menu-dropdown">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        <?php
                        if ( has_nav_menu( 'vertical-menu' )) {
                            $locations = get_nav_menu_locations();
                            $__menu = wp_get_nav_menu_object($locations['vertical-menu']);
                            if($__menu) {
                                echo esc_html($__menu->name);
                            } else {
                                esc_html_e( "Shop By Departments", 'theshopier' );
                            }
                        } else {
                            echo esc_html_e( "Set your vertical menu", 'theshopier' );
                        }
                        ?>
                    </div>
                    <?php if ( has_nav_menu( 'vertical-menu' )) {
                        wp_nav_menu( array( 'container_class' => "vertical-menu-inner submenu_height_fixed pc-menu",'theme_location' => 'vertical-menu', 'walker' => new Theshopier_Mega_Menu_Frontend() ) );
                    }?>
                </div>
            </div>
            <div class="col-sm-16 col-md-18">
                <div class="row">

                    <div class="col-md-18 col-sm-24 nth-sale-policy">
                        <?php if ( has_nav_menu( 'primary-menu' )) {
                            wp_nav_menu( array(
                                'container_class' => 'main-menu text-right pc-menu animated',
                                'theme_location' => 'primary-menu',
                                'walker' => new Theshopier_Mega_Menu_Frontend(),
                                'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
                            ) );
                        }?>
                    </div>

                    <div class="col-md-6 col-sm-24 nth-menu-wrapper">
                        <div class="nth-tini-wrapper"><?php theshopier_shoppingCart(5);?></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>