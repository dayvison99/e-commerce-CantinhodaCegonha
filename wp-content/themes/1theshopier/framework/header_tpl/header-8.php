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
            <div class="col-sm-8">
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
            <div class="col-sm-16">
                <div class="text-right">
                    <div class="nth-tini-wrapper"><?php theshopier_search_form();?></div>
                    <div class="nth-tini-wrapper"><?php theshopier_login_form(2);?></div>
                    <div class="nth-tini-wrapper"><?php theshopier_shoppingCart(2);?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="nth_header_middle hidden-xs hidden-sm">
    <div class="container text-center">
        <?php theshopier_getLogo();?>
    </div>
</div>

<div class="<?php echo esc_attr(implode(' ', $sticky_class));?>">
    <div class="container">
        <div class="row">
            <div class="hidden-xs nth-menu-wrapper">
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
</div>