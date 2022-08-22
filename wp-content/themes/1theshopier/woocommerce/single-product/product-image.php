<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.2
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . $placeholder,
    'woocommerce-product-gallery--columns-' . absint( $columns ),
    'images',
) );

$attachment_ids = $product->get_gallery_image_ids();

$_slider_wrap = array('p_image');
if(count($attachment_ids) > 1 || (class_exists('Nexthemes_WooProductOptions') && Nexthemes_WooProductOptions::has_video())) {
    $_slider_wrap[] = 'nth-owlCarousel';
    $_slider_wrap[] = 'loading';
}

$options = array(
    "items"			=> 1,
    "loop"			=> false,
    "autoHeight"		=> true,
    "video"				=> true,
    "videoHeight"		=> 300
);

?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

    <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $_slider_wrap ) ) ); ?>" data-slider=".yeti-owl-slider" data-options="<?php echo esc_attr(wp_json_encode($options))?>">

        <figure class="woocommerce-product-gallery__wrapper yeti-owl-slider">

            <?php

            if ( has_post_thumbnail() && $attachment_ids ) {

                /**
                 * @See: wc_get_gallery_image_html
                 */
                $main_image = true;
                $flexslider        = (bool) apply_filters( 'woocommerce_single_product_flexslider_enabled', get_theme_support( 'wc-product-gallery-slider' ) );
                $gallery_thumbnail = wc_get_image_size( 'gallery_thumbnail' );
                $thumbnail_size    = apply_filters( 'woocommerce_gallery_thumbnail_size', array( $gallery_thumbnail['width'], $gallery_thumbnail['height'] ) );
                $image_size        = apply_filters( 'woocommerce_gallery_image_size', $flexslider || $main_image ? 'woocommerce_single': $thumbnail_size );
                $full_size         = apply_filters( 'woocommerce_gallery_full_size', apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' ) );

                foreach ( $attachment_ids as $attachment_id ) {
                    /**
                     * Replace wc_get_gallery_image_html by below code @since woocommerce 3.3
                     */
                    $html = '';
                    $thumbnail_src     = wp_get_attachment_image_src( $attachment_id, $thumbnail_size );
                    $full_src          = wp_get_attachment_image_src( $attachment_id, $full_size );
                    $image             = wp_get_attachment_image( $attachment_id, $image_size, false, array(
                        'title'                   => get_post_field( 'post_title', $attachment_id ),
                        'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
                        'data-src'                => $full_src[0],
                        'data-large_image'        => $full_src[0],
                        'data-large_image_width'  => $full_src[1],
                        'data-large_image_height' => $full_src[2],
                        'class'                   => $main_image ? 'wp-post-image' : '',
                    ) );

                    $html  .= '<div data-id="'.esc_attr($attachment_id).'" data-thumb="' . esc_url( $thumbnail_src[0] ) . '" class="woocommerce-product-gallery__image"><a class="product-image zoom1" href="' . esc_url( $full_src[0] ) . '">';
                    $html .= $image;
                    $html .= '</a></div>';
                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                }

                do_action('theshopier_after_woocommerce_product_image');

            } else {
                $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'theshopier' ) );
                $html .= '</div>';

                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );
            }
            ?>

        </figure>

    </div>

    <?php do_action( 'woocommerce_product_thumbnails' );?>

</div>

