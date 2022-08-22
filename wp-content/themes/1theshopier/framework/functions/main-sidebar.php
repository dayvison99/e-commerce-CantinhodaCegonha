<?php

add_action("theshopier_main_left_sidebar", "theshopier_main_left_sidebar1", 10);

if( !function_exists('theshopier_main_left_sidebar1') ) {
    function theshopier_main_left_sidebar1(){
        if(has_nav_menu('primary-menu')) {
            wp_nav_menu( array(
                'container_class' => 'main-menu pc-menu',
                'theme_location' => 'primary-menu',
                'walker' => new Theshopier_Mega_Menu_Frontend(),
                'items_wrap' => '<ul class="%1$s %2$s">%3$s</ul>'
            ) );
        }
    }
}