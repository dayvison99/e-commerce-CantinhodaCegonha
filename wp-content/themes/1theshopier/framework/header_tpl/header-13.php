<div class="nth-sticky">
    <div class="nth_header_top hidden-xs hidden-sm row">
        <div class="col-sm-12">
            <?php echo theshopier_redux_social('list-inline');?>
        </div>

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
    </div>

    <div class="nth_header_middle hidden-xs hidden-sm">
        <div class="row">
            <div class="col-md-6"><?php theshopier_getLogo();?></div>
            <div class="col-md-18 hidden-xs nth-menu-wrapper">
                <?php if ( has_nav_menu( 'vertical-menu' )) {
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
