<?php
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
            <div class="col-sm-8 col-md-6"><?php theshopier_getLogo();?></div>
            <div class="col-sm-8 col-md-14">
                <div class="row">
                    <div class="col-md-15 col-sm-12"><?php theshopier_search_form(); ?></div>
                    <div class="col-md-9 col-sm-12">
                        <div class="shipping-text">
                            <?php
                            $shipping_text = theshopier_get_themeoptions_by_key('header-shipping-text');
                            echo do_shortcode( wp_kses(stripslashes(htmlspecialchars_decode( $shipping_text )), wp_kses_allowed_html( 'post' )) );
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-8 col-md-4">
                <div class="text-right">
                    <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
                </div>
            </div>
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
