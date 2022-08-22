<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/24/2015
 * Vertion: 1.0
 */

?>
<div class="nth_header_top hidden-xs hidden-sm">
    <div class="container container-1790">
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
                <div class="nth-sale-policy">
                    <?php
                    if( $shipping_text = theshopier_get_themeoptions_by_key('header-shipping-text') ) {
                        $html_al = array(
                            'strong' => array(
                                'class' => array(), 'style' => array()
                            ),
                            'span' => array(
                                'class' => array(), 'style' => array()
                            ),
                            'a' => array(
                                'class' => array(), 'title' => array(), 'href' => array()
                            )
                        );
                        echo do_shortcode ( wp_kses( stripslashes(htmlspecialchars_decode( $shipping_text )), $html_al) );
                    }
                    ?>
                </div>
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
    <div class="container container-1790">
        <div class="row">
            <div class="col-sm-24">
                <?php theshopier_getLogo();?>
                <div class="nth-right-block-wrapper">
                    <div class="tb-search-wrapper">
                        <span id="searchIconActiveIdDesktop" data-form=".nth-searchform" class="nth-icon icon-nth-search icon-search-toggle"></span>
                        <div class="tb-search-inner"><?php theshopier_search_form(); ?></div>
                    </div>
                    <div class="text-right nth-mini-popup-wrapper">
                        <div class="nth-tini-wrapper"><?php theshopier_login_form();?></div>
                        <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
                    </div>
                </div>
                <div class="nth-menu-wrapper">
                    <?php if ( has_nav_menu( 'primary-menu' )) {
                        wp_nav_menu( array(
                            'container_class' => 'main-menu pc-menu animated',
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
