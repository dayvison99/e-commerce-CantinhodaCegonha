<?php
function theme_enqueue_styles() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css');
}
add_action( 'theshopier_child_style', 'theme_enqueue_styles', 99);

function theme_lang_setup() {
    load_child_theme_textdomain( 'theshopier-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'theme_lang_setup' );