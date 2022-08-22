<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 10/31/2015
 * Vertion: 1.0
 */

?>
<?php
$sidebar_name = "header-top-widget-area";
if( is_active_sidebar( $sidebar_name ) ):?>

<div class="nth_header_top hidden-xs hidden-sm">
    <div>
        <ul class="widgets-sidebar">
            <?php dynamic_sidebar( $sidebar_name ); ?>
        </ul>
    </div>
</div>
<?php endif;?>

<div class="nth_header_middle header-2 hidden-xs hidden-sm">
    <div class="container">
        <div class="row">
            <div class="col-sm-6"><?php theshopier_getLogo();?></div>
            <div class="col-sm-12 col-lg-10">
                <?php if ( has_nav_menu( 'primary-menu' )) {
                    wp_nav_menu( array( 'container_class' => 'main-menu pc-menu','theme_location' => 'primary-menu', 'walker' => new Theshopier_Mega_Menu_Frontend() ) );
                } else { ?>
                    <div class="main-menu pc-menu">
                        <ul class="menu">
                            <li class="menu-item">
                                <h3><?php esc_html_e( "Set Primary Menu.", 'theshopier' )?></h3>
                            </li>
                        </ul>
                    </div>

                <?php }?>
            </div>
            <div class="col-sm-6 col-lg-8">
                <?php
                $sidebar_name = "header-middle-widget-area";
                if( is_active_sidebar( $sidebar_name ) ):?>
                    <ul class="widgets-sidebar">
                        <?php dynamic_sidebar( $sidebar_name ); ?>
                    </ul>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<div class="nth_header_bottom hidden-xs hidden-sm">
    <div class="container">
        <div class="header-bottom-boxed">
            <div class="row">
                <?php $toggle_class = ( is_front_page() )? "no_toggle active": "toggle";?>
                <div class="col-sm-6 nth-menu-vertical hidden-xs">
                    <div class="vertical-menu-wrapper <?php echo esc_attr($toggle_class);?>">
                        <div class="vertical-menu-dropdown">
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
                            $toggle_class = '';/*( is_front_page() )? "no_toggle": "toggle";*/
                            wp_nav_menu( array( 'container_class' => "vertical-menu-inner {$toggle_class} pc-menu",'theme_location' => 'vertical-menu', 'walker' => new Theshopier_Mega_Menu_Frontend() ) );
                        }?>
                    </div>
                </div>
                <div class="col-lg-12 col-sm-10">
                    <div class="nth-search-box"><?php theshopier_search_form(); ?></div>
                </div>
                <div class="col-lg-6 col-sm-8 text-right fix-over-right-100"><!-- Remove Space -->
                    <div class="nth-tini-wrapper"><?php theshopier_login_form();?></div>
                    <div class="nth-tini-wrapper"><?php theshopier_shoppingCart();?></div>
                </div>
            </div>
        </div>
    </div>
</div>