<?php


remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Single post
 */
add_action( 'woocommerce_share', 'theshopier_single_post_meta_bottom_sharing', 10 );
if( !function_exists( 'theshopier_single_post_meta_bottom_sharing' ) ) {
    function theshopier_single_post_meta_bottom_sharing(){
        $image_link = '';
        $image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
        $fa_url_pars = add_query_arg(array(
            'utm_campaign'  => 'shareaholic',
            'utm_medium'    => 'facebook',
            'utm_source'    => 'socialnetwork'
        ), esc_url(get_permalink()));

        $social_args = array(
            array(
                'class'     => 'facebook',
                'icon'      => 'fa fa-facebook',
                'title'     => __('Share on Facebook', 'theshopier'),
                'url'       => add_query_arg( array(
                    'u' => urlencode($fa_url_pars)
                ),'http://www.facebook.com/sharer.php')
            ),
            array(
                'class'     => 'twitter',
                'icon'      => 'fa fa-twitter',
                'title'     => __('Share on Twitter', 'theshopier'),
                'url'       => add_query_arg( array(
                    'url' => esc_url(get_permalink()),
                    'text' => get_the_title()
                ), 'https://twitter.com/intent/tweet')
            ),
            array(
                'class'     => 'google_plus',
                'icon'      => 'fa fa-google-plus',
                'title'     => __('Share on Google plus', 'theshopier'),
                'url'       => add_query_arg( array(
                    'url' => urlencode(esc_url(get_permalink()))),
                    'https://plus.google.com/share'
                )
            ),
            array(
                'class'     => 'pinterest',
                'icon'      => 'fa fa-pinterest-p',
                'title'     => __('Share on Pinterest', 'theshopier'),
                'url'       => add_query_arg( array(
                    'url' => urlencode(esc_url(get_the_permalink())),
                    'media' => urlencode(esc_url($image_link)),
                    'description'   => urlencode(get_the_title())
                ), 'https://pinterest.com/pin/create/button/')
            )
        );

        echo '<div class="nth-social-share"><ul class="nth-social-share-link">';

        foreach($social_args as $social) {
            printf('<li class="%s"><a href="%s" title="%s"><i class="%s"></i></a></li>', esc_attr($social['class']), esc_url($social['url']), esc_attr($social['title']), esc_attr($social['icon']));
        }

        echo '</ul></div>';
    }
}

/**
 * SHOP PER PAGE
 **/
add_filter('loop_shop_per_page', 'theshopier_loop_shop_per_page' );
function theshopier_loop_shop_per_page(){
    global $theshopier_datas;
    if( is_archive('product') ){
        if( !empty($_GET['per_show']) && absint($_GET['per_show']) > 0 ) {
            return absint($_GET['per_show']);
        } elseif( isset($theshopier_datas["shop_per_page"]) && (int)$theshopier_datas["shop_per_page"] > 0){
            return absint($theshopier_datas["shop_per_page"]);
        } else {
            return 12;
        }
    }
}

/**
 * SHOP BREADCRUMB.
 *
 **/
add_filter( 'woocommerce_breadcrumb_defaults', 'theshopier_woocommerce_breadcrumbs' );

function theshopier_woocommerce_breadcrumbs( $defaults ) {
    global $theshopier_datas;

    if( isset($theshopier_datas['breadcrum-style']) ) {
        switch($theshopier_datas['breadcrum-style']){
            case 'transparent':
                $defaults["delimiter"] = '<span class="delimiter">&rarr;</span>';
                $defaults["home"] = 'home';
                break;
            default:
                $defaults["wrap_before"] = "<nav id=\"crumbs\" class=\"woocommerce-breadcrumb\"><ul>";
                $defaults["wrap_after"] = "</ul></nav>";
                $defaults["before"] = "<li>";
                $defaults["after"] = "</li>";
                $defaults["delimiter"] = '';
                $defaults["home"] = 'home';
        }
    }
    return $defaults;
}


if (!function_exists('theshopier_loop_columns')) {
    add_filter('loop_shop_columns', 'theshopier_loop_columns');
    function theshopier_loop_columns() {
        global $theshopier_datas;
        if( isset( $theshopier_datas["shop_columns"] ) && absint( $theshopier_datas["shop_columns"] ) > 0 )
            return absint($theshopier_datas['shop_columns']);
        else return 4;
    }
}

add_filter( 'woocommerce_cross_sells_total', 'theshopier_woocommerce_cross_sells_total', 10 );

function theshopier_woocommerce_cross_sells_total(){ return 9; }

add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 10 );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

add_action( 'woocommerce_after_shop_loop_item_title', 'theshopier_shop_loop_relative_div_start', 1 );
add_action( 'woocommerce_after_shop_loop_item_title', 'theshopier_shop_loop_relative_div_end', 100000 );
add_action( 'woocommerce_after_shop_loop_item_title', 'theshopier_shop_loop_title', 1 );
remove_action( 'woocommerce_after_shop_loop_item_title', "woocommerce_template_loop_price", 10);

if( function_exists("is_product") && function_exists('wc_yotpo_show_buttomline') ) {
    if(!is_product()) remove_action('woocommerce_after_shop_loop_item_title', 'wc_yotpo_show_buttomline',7);
    add_action('woocommerce_after_shop_loop_item_title', 'wc_yotpo_show_buttomline',7);
}

add_action( 'woocommerce_after_shop_loop_item', 'theshopier_shop_loop_hover_div_start', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'theshopier_woocommerce_template_single_excerpt', 5);
add_action( 'woocommerce_after_shop_loop_item', 'theshopier_product_label_price_start', 7 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
add_action( 'woocommerce_after_shop_loop_item', 'theshopier_product_label_price_end', 8 );
add_action( 'woocommerce_after_shop_loop_item', 'theshopier_shop_loop_hover_div_end', 99 );

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'theshopier_product_labels', 10 );


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action('woocommerce_after_single_product_summary', 'theshopier_single_product_summary_footer_block', 30);

add_filter( 'woocommerce_output_related_products_args', 'theshopier_woocommerce_output_related_products_args', 10, 1 );

// Fix woocommerce 3.3 by Robert
remove_action('woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories');


if( !function_exists('theshopier_woocommerce_template_single_excerpt') ) {
    function theshopier_woocommerce_template_single_excerpt(){
        global $post;

        if ( ! $post->post_excerpt ) {
            return;
        }

        //CUSTOM
        $count = apply_filters( "theshopier_woocommerce_short_description_count", -1 );

        $excerpt = wp_strip_all_tags( apply_filters( 'woocommerce_short_description', $post->post_excerpt ) );

        if( $count > 0 ) {
            $words = explode(' ', $excerpt, ($count + 1));
            if(count($words) > $count) array_pop($words);
            $excerpt = implode(' ', $words);
        }

        echo '<div class="loop-description">';
        echo esc_html($excerpt);
        echo '</div>';
    }
}

if( !function_exists( "theshopier_shop_loop_title" ) ) {
    function theshopier_shop_loop_title(){
        printf('<h3 class="product-title"><a href="%1$s" title="%2$s">%2$s</a></h3>', esc_url(get_the_permalink()), esc_attr(get_the_title()));
    }
}



if( !function_exists( "theshopier_get_product_categories" ) ) {
    function theshopier_get_product_categories(){
        global $product;
        $cats = wp_get_post_terms( $product->get_id(),'product_cat');
        if( count($cats) > 0 ):
            echo '<div class="product-cats">';
            $i = 0;
            foreach ( $cats as $term ) {
                printf('<a href="%1$s" title="%2$s">%2$s</a>', esc_url(get_term_link($term->slug,$term->taxonomy)), esc_attr($term->name));
                if( ++$i < count($cats) ) echo ", ";
            }
            echo '</div>';
        endif;
    }
}

function theshopier_filter_woocommerce_product_get_rating_html( $rating_html, $rating ) {
    global $product;
    $rating_html = '';
    if ( ! is_numeric( $rating ) ) {
        $rating = $product->get_average_rating();
    }
    if ( $rating > 0 ) {
        $rating_html  = '<div class="star-rating" data-count="'.$product->get_rating_count().'" title="' . sprintf( esc_html__( 'Rated %s out of 5', 'theshopier' ), $rating ) . '">';
        $rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_html__( 'out of 5', 'theshopier' ) . '</span>';

        $rating_html .= '</div>';
    }
    return $rating_html;
}
add_filter( 'woocommerce_product_get_rating_html', 'theshopier_filter_woocommerce_product_get_rating_html', 10, 2 );


add_action( 'woocommerce_after_shop_loop_item', "theshopier_shop_buttons_div_start", 9);
add_action( 'woocommerce_after_shop_loop_item', "theshopier_shop_buttons_div_end", 21);
function theshopier_shop_buttons_div_start(){
    echo '<div class="product_buttons"><div class="product_buttons_inner">';
}
function theshopier_shop_buttons_div_end(){
    echo '</div></div>';
}

/**
 * CUSTOM WISHLIST
 */

if( class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL') ){
    add_action( 'woocommerce_after_shop_loop_item', "theshopier_add_to_wishlist", 11);

    function theshopier_add_to_wishlist(){
        echo str_replace('<div class="clear"></div>', '', do_shortcode('[yith_wcwl_add_to_wishlist]'));
    }

    add_filter( "yith_wcwl_positions", "theshopier_custom_yith_wishlist_position" );

    function theshopier_custom_yith_wishlist_position( $yith_position ){
        $yith_position["add-to-cart"] = array( 'hook'	=> 'woocommerce_after_add_to_cart_button', 'priority'	=> 31 );
        return $yith_position;
    }
}

if( class_exists( 'YITH_Woocompare_Frontend' ) && class_exists( 'YITH_Woocompare' ) ) {

    add_action( 'woocommerce_after_shop_loop_item', 'theshopier_add_compare_link', 20 );
    if(!is_ajax()) add_action( 'woocommerce_after_add_to_cart_button', 'theshopier_add_compare_link', 35 );

    add_action( 'init', 'theshopier_remove_compare_link', 20 );
    function theshopier_remove_compare_link(){
        global $yith_woocompare;
        $fontend = $yith_woocompare->obj;
        remove_action( 'woocommerce_after_shop_loop_item', array($fontend, 'add_compare_link'), 20 );
        remove_action( 'woocommerce_single_product_summary', array($fontend, 'add_compare_link'), 35 );
    }

    function theshopier_add_compare_link(){
        global $yith_woocompare, $product;
        $fontend = $yith_woocompare->obj;

        $is_button = ! isset( $button_or_link ) || ! $button_or_link ?
            get_option( 'yith_woocompare_is_button' ) : $button_or_link;

        if ( ! isset( $button_text ) || $button_text == 'default' ) {
            $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'theshopier' ) );
            $button_text = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_compare_button_text', $button_text ) : $button_text;
        }

        printf( '<a href="%s" class="%s" data-product_id="%d">%s</a>', $fontend->add_product_url( $product->get_id() ), 'nth-compare' . ( $is_button == 'button' ? ' button' : '' ), $product->get_id(), $button_text );
    }
}


function theshopier_shop_loop_relative_div_start(){
    echo '<div class="prod-meta-relative">';
    echo '<div class="prod-meta-relative-wrapper">';
    echo '<div class="prod-meta-relative-inner">';
}

function theshopier_shop_loop_relative_div_end(){
    echo '</div><!--prod-meta-relative-inner-->';
    echo '</div><!--prod-meta-relative-wrapper-->';
    echo '</div><!--prod-meta-relative-->';
}

function theshopier_product_label_price_start(){
    global $product;
    if( $product->is_on_sale() )
        echo "<div class=\"onsale-wrapper\">";
}

function theshopier_product_label_price_end(){
    global $product;
    if( $product->is_on_sale() )
        echo '</div><!--.onsale-wrapper-->';
}

function theshopier_shop_loop_hover_div_start(){
    echo '<div class="prod-meta-hover">';
    echo '<div class="prod-meta-hover-wrapper">';
    echo '<div class="prod-meta-hover-inner">';
}

function theshopier_shop_loop_hover_div_end(){
    echo '</div><!--prod-meta-hover-inner-->';
    echo '</div><!--prod-meta-hover-wrapper-->';
    echo '</div><!--prod-meta-hover-->';
}

function theshopier_shop_loop_div_end(){
    echo '</div><!-- theshopier_shop_loop_div_end -->';
}

if( !function_exists( "theshopier_template_redirect" ) ) {

    add_action( 'template_redirect', 'theshopier_template_redirect' );

    function theshopier_template_redirect(){
        if( is_tax( 'product_cat' ) ){
            global $wp_query, $theshopier_datas;

            $term = $wp_query->queried_object;
            $datas = get_woocommerce_term_meta( $term->term_id, "nth_cat_config", true );
            if( strlen($datas) > 0 ){
                $datas = unserialize($datas);
                if( is_array($datas) && count($datas) > 0 && !empty( $datas['nth_cat_infomation'] ) ){
                    $theshopier_datas['nth-cat-infomation'] = $datas['nth_cat_infomation'];
                }
            }
        }
    }

}

remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );

if( !function_exists( "theshopier_woocommerce_subcategory_thumbnail" ) ) {
    add_action( 'woocommerce_before_subcategory_title', 'theshopier_woocommerce_subcategory_thumbnail', 10 );

    function theshopier_woocommerce_subcategory_thumbnail( $category ){
        $small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'theshopier_shop_subcat' );
        $dimensions = wc_get_image_size( $small_thumbnail_size );
        $thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
        if ( $thumbnail_id ) {
            $image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
            $dimensions = array(
                "width"		=> $image[1],
                "height"	=> $image[2]
            );
            $image = $image[0];
        } else {
            $image = wc_placeholder_img_src();
        }

        if ( $image ) {
            $image = str_replace( ' ', '%20', $image );
            echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
        }
    }
}

if( !function_exists( "theshopier_product_labels" ) ) {
    function theshopier_product_labels(){
        global $product;
        $resq = false;
        $sale_classes = array( 'product-labels' );
        $output = '';

        if($product->is_on_sale()) {
            $output .= "<span class=\"onsale show_off product_label\">";
            if( $product->get_regular_price() > 0 && $product->get_type() !== 'variable' ) {
                $_off_percent = (round((int)$product->get_price() / $product->get_regular_price(), 2) - 1)*100;
                $output .= esc_attr($_off_percent) . "&#37;";
            } else {
                $output .= esc_html__( "Save", 'theshopier' );
            }
            $output .= "</span>";
            $sale_classes[] = "onsale";
            $resq = true;
        }

        if( $product->is_featured() ) {
            $output .= "<span class=\"featured product_label\">". esc_html__( "New", 'theshopier' )."</span>";
            $sale_classes[] = "featured";
            $resq = true;
        }

        if( $resq ) {
            echo "<div class='" . esc_attr(implode(' ', $sale_classes)) . "'>".$output."</div>";
        }

    }
}

/**
 * SINGLE PRODUCT
 */

remove_action( "woocommerce_before_single_product_summary", "woocommerce_show_product_sale_flash", 10 );
remove_action( "woocommerce_single_product_summary", "woocommerce_template_single_price", 10 );
remove_action( "woocommerce_single_product_summary", "woocommerce_template_single_meta", 40 );

add_action( "woocommerce_single_product_summary", "theshopier_single_product_summary_div_start", 22 );
add_action( "woocommerce_single_product_summary", "theshopier_share_product", 21 );
add_action( "woocommerce_single_product_summary", "woocommerce_template_single_meta", 21 );
add_action( "woocommerce_product_meta_end", "theshopier_woocommerce_template_single_stock", 21 );
add_action( "woocommerce_single_product_summary", "theshopier_product_label_price_start", 22 );
add_action( "woocommerce_single_product_summary", "woocommerce_template_single_price", 23 );
add_action( "woocommerce_single_product_summary", "theshopier_product_label_price_end", 24 );
add_action( "woocommerce_single_product_summary", "theshopier_single_product_summary_div_end", 39 );

//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
//add_action( 'theshopier_woocommerce_after_single_product_summary', 'woocommerce_template_single_sharing', 10 );


function theshopier_single_product_summary_div_start(){
    echo '<div class="woocommerce-product-box-wrapper">';
}

function theshopier_single_product_summary_div_end(){
    echo '</div><!--End class woocommerce-product-box-wrapper-->';
}

function theshopier_woocommerce_template_single_stock(){
    global $product;
    if( strcmp( $product->get_type(), 'simple' ) == 0 ) {

        $availability      = $product->get_availability();

        $availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

        echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
    }
}

function theshopier_share_product(){
    $mail_link = "mailto:?subject="
                . rawurlencode( esc_html__("I want you see this site", 'theshopier' ) )
                . "&body="
                . rawurlencode( esc_html__("Check out this site ", 'theshopier' ) )
                . urlencode(get_permalink());
    $title_link_text = esc_html_x("Send to friends", "Share by mailTo & Print in product page.", 'theshopier' );
    $title_link_text2 = esc_html_x("Print", "Share by mailTo & Print in product page.", 'theshopier' );

    echo '<ul class="nth-single-product-share">';
    printf('<li><a href="%1$s" title="%2$s"><i class="fa fa-envelope-o"></i>%2$s</a></li>', esc_url( $mail_link ), esc_attr( $title_link_text ));
    printf('<li><a href="%1$s" title="%2$s"><i class="fa fa-print"></i>%2$s</a></li>', esc_js('javascript:window.print();'), esc_attr( $title_link_text2 ));
    echo '</ul>';
}


/** CUSTOM PRICE **/

//add_filter( 'woocommerce_variable_sale_price_html', 'theshopier_custom_variable_sale_prices', 10, 2 );
/*add_filter('woocommerce_variable_price_html','theshopier_custom_variable_sale_prices',10, 2);*/

function theshopier_custom_variable_sale_prices( $price, $product ){
    /*if(is_product()) return $price;*/

    // Main price
    $prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
    $price  = $prices[0] !== $prices[1] ? sprintf( '%1$s - %2$s', wc_price( $prices[0] ), wc_price( $prices[1] ) ) : wc_price( $prices[0] );

    // Sale
    $prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
    sort( $prices );
    $saleprice = $prices[0] !== $prices[1] ? sprintf( '%1$s - %2$s', wc_price( $prices[0] ), wc_price( $prices[1] ) ) : wc_price( $prices[0] );

    if ( $price !== $saleprice ) {
        $price = $product->get_price_html_from_to( $saleprice, $price ) . $product->get_price_suffix();
    }

    return $price;
}

function theshopier_woocommerce_output_related_products_args( $args ){
    $args['posts_per_page'] = 10;
    return $args;
}

if( !function_exists( 'theshopier_woocommerce_cart_item_remove_link_callback' ) ) {

    add_filter('woocommerce_cart_item_remove_link', 'theshopier_woocommerce_cart_item_remove_link_callback', 10, 2);

    function theshopier_woocommerce_cart_item_remove_link_callback( $res, $cart_item_key ){
        $nonce = wp_create_nonce('nth_remove_cart_item');
        return sprintf( '<a href="%s" class="remove nth_remove_cart" title="%s" data-key="%s" data-nonce="%s">'. esc_html__('Remove', 'theshopier').'</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr__( 'Remove this item', 'theshopier' ), $cart_item_key, $nonce );
    }
}

add_action('theshopier_toolbar_wishlist', 'theshopier_toolbar_wishlist_callback', 10);

if( !function_exists('theshopier_toolbar_wishlist_callback') ) {

    function theshopier_toolbar_wishlist_callback(){
        add_filter( 'yith_wcwl_wishlist_params', 'theshopier_yith_wcwl_wishlist_params_callback', 10, 1 );
        echo do_shortcode('[yith_wcwl_wishlist]');
        remove_filter( 'yith_wcwl_wishlist_params', 'theshopier_yith_wcwl_wishlist_params_callback', 10, 1 );
    }

    function theshopier_yith_wcwl_wishlist_params_callback( $additional_params ){
        $additional_params['template_part'] = 'toolbar';
        return $additional_params;
    }
}

add_action('theshopier_toolbar_compare', 'theshopier_toolbar_compare_callback', 10);

if( !function_exists('theshopier_toolbar_compare_callback') ) {

    function theshopier_toolbar_compare_callback(){
        if( !class_exists( 'YITH_Woocompare' ) ) return;
        wc_get_template( 'compare-toolbar.php' );
    }
}


add_action( 'theshopier_woocommerce_before_grid_box', 'theshopier_woocommerce_before_grid_box_callback', 10 );
add_action( 'theshopier_woocommerce_after_grid_box', 'theshopier_woocommerce_after_grid_box_callback', 10 );
add_filter( 'woocommerce_account_menu_items', 'theshopier_woocommerce_account_menu_items_filter', 10, 1 );


function theshopier_woocommerce_account_menu_items_filter($items){
    $wl_id = get_option( 'yith_wcwl_wishlist_page_id', false );
    if(is_array($items) && $wl_id) {
        $wl_arr = array(
            'wishlist' => array(
                'label' => esc_attr__("My Wishlist", 'theshopier'),
                'url'   => get_permalink($wl_id)
            )
        );
        array_splice($items, 2, 0, $wl_arr);
    }
    return $items;
}

function theshopier_woocommerce_before_grid_box_callback(){
    global $theshopier_datas;
    echo '<div class="row">';
    if(is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $wl_id = get_option( 'yith_wcwl_wishlist_page_id', false );
        $shop_myaccount_id = get_option( 'woocommerce_myaccount_page_id', false );

        echo '<div class="col-sm-6">';
        echo '<div class="nth-row-grid">';
        echo '<div class="col-sm-24">';
        echo '<div class="gavatar-box clearfix">';
        echo get_avatar($current_user->user_email, 70, '', null, array('class'=> 'img-circle'));
        echo '<div class="meta">';
        echo '<h3>' . esc_html($current_user->display_name) . '</h3>';
        printf('<a href="%1$s" title="%2$s">%2$s</a>', esc_url(wp_logout_url()), esc_html__("Logout", 'theshopier'));
        echo '</div></div><!--end class gavatar-box clearfix-->';
        echo '<ul>';
        if($shop_myaccount_id) {
            printf('<li><a title="%1$s" href="%2$s">%1$s</a></li>', esc_attr__("My Order", 'theshopier'), esc_url(get_permalink($shop_myaccount_id)));
        }
        if($wl_id) {
            printf('<li><a title="%1$s" href="%2$s">%1$s</a></li>', esc_attr__("My Wishlist", 'theshopier'), esc_url(get_permalink($wl_id)));
        }
        if( !empty($theshopier_datas['nth-my-account-track-order']) ) {
            printf('<li><a title="%1$s" href="%2$s">%1$s</a></li>', esc_attr__("Track my order", 'theshopier'), esc_url(get_permalink($theshopier_datas['nth-my-account-track-order'])));
        }
        printf('<li><a title="%1$s" href="%2$s">%1$s</a></li>', esc_attr__("Custom account page", 'theshopier'), esc_url(wc_customer_edit_account_url()));
        printf('<li><a title="%1$s" href="%2$s">%1$s</a></li>', esc_attr__("Log Out", 'theshopier'), esc_url(wp_logout_url()));

        echo '</ul>';
        echo '</div></div></div>';

        echo '<div class="col-sm-18">';
    } else {
        echo "<div class=\"col-sm-24\">";
    }

}


function theshopier_woocommerce_after_grid_box_callback(){
    echo '</div></div>';
}

add_filter( 'body_class', 'theshopier_bodyClass', 10, 1 );
function theshopier_bodyClass( $classes ){
    global $detect, $theshopier_datas;

    if( $detect->isMobile() ) {
        $classes[] = 'touch_device';
        if( $detect->isTablet() ) $classes[] = 'tablet_device';
        else $classes[] = 'mobile_device';
    } else {
        $classes[] = 'notouch_device';
    }

    if( isset($theshopier_datas['pace-loader']) && absint($theshopier_datas['pace-loader']) !== 0 ) {
        $classes[] = 'pace-loading';
    }

    if(!empty($theshopier_datas['layout-main'])) {
        if(strcmp('container', trim($theshopier_datas['layout-main'])) == 0) {
            $classes[] = 'boxed';
        } else {
            $classes[] = esc_attr($theshopier_datas['layout-main']);
        }
    }

    if(isset($theshopier_datas['shop-product-style'])) {
        switch($theshopier_datas['shop-product-style']) {
            case '5':
            case '3':
                $classes[] = 'no_border_radius';
                break;
            case '6':
                $classes[] = 'border_no_padding';
                break;
        }
    }

    if(function_exists('is_store_notice_showing') && is_store_notice_showing()) {
        $classes[] = 'woocommerce_demo_store';
    }

    return $classes;
}


add_action("theshopier_before_main_content", "theshopier_pace_loading_function");
function theshopier_pace_loading_function(){
    global $theshopier_datas;

    if( !isset($theshopier_datas['pace-loader']) || absint($theshopier_datas['pace-loader']) == 0 ) return;

    if( isset( $theshopier_datas['nth-pace-logo'] ) && !empty( $theshopier_datas['nth-pace-logo']['url'] ) ){
        $def_logo = esc_url( $theshopier_datas['nth-pace-logo']['url'] );
    } else {
        $def_logo = THEME_IMG_URI . "logo_pace.png";
    }
    echo '<div class="nth-loader-wrapper" id="nth_loader_wrapper">';
    echo '<div class="loader_inner">';
    theshopier_getImage(array(
        'alt'   => get_bloginfo('name'),
        'src'   => $def_logo
    ));

    echo '<div class="nth_loading"></div>';
    echo '</div></div>';

}

//add_filter('body_class', 'theshopier_pace_loading_body_class', 20, 1);
function theshopier_pace_loading_body_class( $classes ){
    global $theshopier_datas;
    if( isset($theshopier_datas['pace-loader']) && absint($theshopier_datas['pace-loader']) > 0 )
        $classes[] = 'pace-loading';
    return $classes;
}


/*  CUSTOM CART PAGE  */

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
add_action( 'theshopier_woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

add_action( 'woocommerce_proceed_to_checkout', 'theshopier_update_shopping_cart_button', 1 );
add_action( 'woocommerce_proceed_to_checkout', 'theshopier_coupons_form', 20 );

add_action( 'theshopier_shopping_progress', 'theshopier_shopping_progress', 10);

if( ! function_exists('theshopier_update_shopping_cart_button') ) {

    function theshopier_update_shopping_cart_button() {
       echo '<input type="submit" class="button" name="update_cart" value="' . esc_html__( 'Update Cart', 'theshopier' ) . '" />';
    }

}
if( ! function_exists('theshopier_coupons_form') ) {

    function theshopier_coupons_form(){
        if ( wc_coupons_enabled() ) {
            echo '<div class="coupon">';
            printf('<label for="coupon_code">%1$s:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="%2$s" /> <input type="submit" class="button" name="apply_coupon" value="%3$s" />', esc_html__( 'Coupon', 'theshopier' ), esc_html__( 'Coupon code', 'theshopier' ), esc_html__( 'Apply Coupon', 'theshopier' ));
            do_action( 'woocommerce_cart_coupon' );
            echo '</div>';
        }
    }

}

if( class_exists( 'WooCommerce' ) ) {

    if( ! function_exists('theshopier_shopping_progress') ) {

        function theshopier_shopping_progress(){
            $shop_class = $checkout_class = $complete_class = array('progress-item');
            if( is_cart() ) $shop_class[] = 'active current-item';
            elseif( is_checkout() ) {
                if( ! is_order_received_page() ) {
                    $shop_class[] = 'active';
                    $checkout_class[] = 'active current-item';
                } else {
                    $shop_class[] = 'active';
                    $checkout_class[] = 'active';
                    $complete_class[] = 'active current-item';
                }
            }

            echo '<div class="nth-shopping-progress-wrapper">';
            echo '<ul class="list-inline">';
            printf('<li class="%1$s">%2$s</li>', esc_attr(implode(' ', $shop_class)), esc_html__("Shopping cart", "theshopier"));
            printf('<li class="%1$s">%2$s</li>', esc_attr(implode(' ', $checkout_class)), esc_html__("Checkout", "theshopier"));
            printf('<li class="%1$s">%2$s</li>', esc_attr(implode(' ', $complete_class)), esc_html__("Order Complete", "theshopier"));
            echo '</ul>';
            echo '</div>';
        }

    }

    if( !function_exists('theshopier_custom_thankyou_title') ) {
        add_filter('theshopier_page_title', 'theshopier_custom_thankyou_title', 10, 1);

        function theshopier_custom_thankyou_title( $title ) {
            if( is_checkout() && is_order_received_page() ) {
                return esc_html__('Thank you. Your order has been received.', 'theshopier');
            } else {
                return $title;
            }
        }
    }
}

add_filter('woocommerce_cart_item_name', 'theshopier_woocommerce_cart_item_name', 10, 1);
add_filter('woocommerce_checkout_cart_item_quantity', 'theshopier_woocommerce_checkout_cart_item_quantity', 10, 3);

if( !function_exists('theshopier_woocommerce_cart_item_name') ) {
    function theshopier_woocommerce_cart_item_name( $title ){
        return '<span class="product-title">' . $title . '</span>';
    }
}

if( !function_exists('theshopier_woocommerce_checkout_cart_item_quantity') ) {
    function theshopier_woocommerce_checkout_cart_item_quantity( $html, $cart_item, $cart_item_key ) {
        $car_quant = $cart_item['quantity'];
        return '<p><strong class="product-quantity">' . sprintf(_n( '%s item', '%s items', $car_quant, 'theshopier' ), $car_quant ) . '</strong></p>';
    }
}

add_filter('login_form_middle', 'theshopier_woo_lost_your_pass', 10, 1);

function theshopier_woo_lost_your_pass($html){
    $html .= '<p class="lost_password">';
    $html .= sprintf('<a href="%1$s" title="%2$s">%2$s</a>', esc_url( wp_lostpassword_url() ), esc_html__( 'Lost your password?', 'theshopier' ));
    $html .= '</p>';
    return $html;
}

add_filter( 'comments_open', 'theshopier_comments_open', 10, 2 );

add_filter('theshopier_shop_loop_res_classes', 'theshopier_woo_head_template_loop', 10, 1);

if( !function_exists('theshopier_woo_head_template_loop') ) {
    function theshopier_woo_head_template_loop($resp){
        global $theshopier_datas;
        if(empty($theshopier_datas['shop-product-style'])) $theshopier_datas['shop-product-style'] = 1;
        $resp[] = "prod_style_". esc_attr($theshopier_datas['shop-product-style']);
        return $resp;
    }
}

add_action('theshopier_woocommerce_orderby_select_after', 'theshopier_woocommerce_orderby_form_extra', 10);
if( !function_exists('theshopier_woocommerce_orderby_form_extra') ) {
    function theshopier_woocommerce_orderby_form_extra(){
        global $theshopier_datas;

        echo '<label for="per_show">' . esc_html__("Item per page", "theshopier") . '</label>';
        echo '<select name="per_show" id="per_show" class="per_show">';

        $default = !empty($theshopier_datas["shop_per_page"]) && absint($theshopier_datas["shop_per_page"]) > 0 ?
            absint($theshopier_datas["shop_per_page"]) : 12;
        $def_col = !empty($theshopier_datas["shop_columns"]) && absint($theshopier_datas["shop_columns"]) > 0 ?
            absint($theshopier_datas["shop_columns"]) : 3;
        $n = round($default / $def_col);
        $n = $n > 3? $n : 3;
        $per_show_args = array();
        for( $i = ($n - 2); $i < ($n + 3); $i++ ) {
            $per_show_args[] = $i*$def_col;
        }
        $current_per_show = !empty( $_GET['per_show'] )? $_GET['per_show']: $default;
        foreach( $per_show_args as $id ) {
            printf('<option value="%1$s" %2$s>%1$s</option>', esc_attr($id), selected( absint($current_per_show), absint($id), false));
        }
        echo '</select>';
    }
}


add_filter('theshopier_woocommerce_add_to_cart_button_classes', 'theshopier_woocommerce_add_to_cart_button_style', 10, 1);

if( !function_exists('theshopier_woocommerce_add_to_cart_button_style') ) {
    function theshopier_woocommerce_add_to_cart_button_style($class){
        global $theshopier_datas;
        if(!empty($theshopier_datas['shop-product-style']) && absint($theshopier_datas['shop-product-style']) == 2) {
            $class .= ' outline';
        }
        return $class;
    }
}

remove_all_actions('theshopier_breadcrumb', 1000);

add_filter('theshopier_header_sticky_class', 'theshopier_header_sticky_class_func', 10, 1);

function theshopier_header_sticky_class_func($class = array()){
    global $theshopier_datas;
    if(isset($theshopier_datas['sticky-menu']) && absint($theshopier_datas['sticky-menu']) > 0) {
        $class[] = 'nth-sticky';
    }
    return $class;
}

remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10 );

add_filter('woocommerce_product_get_gallery_image_ids', 'theshopier_woocommerce_product_gallery_attachment_ids', 10, 2);

function theshopier_woocommerce_product_gallery_attachment_ids($attachment_ids, $product){
    array_unshift($attachment_ids, get_post_thumbnail_id($product->get_id()));
    if($product->is_type('variable')) {
        $_variations = $product->get_available_variations();
        foreach($_variations as $data){
            $_id = get_post_thumbnail_id($data['variation_id']);
            if($_id && absint($_id) > 0) array_push($attachment_ids, get_post_thumbnail_id($data['variation_id']));
        }
    }
    return array_unique($attachment_ids);
}

add_action('woocommerce_product_meta_end', 'theshopier_woocommerce_product_meta_end_brand', 20);

function theshopier_woocommerce_product_meta_end_brand(){
    global $post;

    $terms = get_the_terms( $post->ID, 'product_brand' );

    if ( is_wp_error( $terms ) )
        return $terms;

    if ( empty( $terms ) )
        return false;

    $links = array();

    foreach ( $terms as $term ) {
        $link = get_term_link( $term, 'product_brand' );
        if ( is_wp_error( $link ) ) {
            return $link;
        }
        $links[] = '<a href="' . esc_url( $link ) . '" rel="tag"><span itemprop="name">' . $term->name . '</span></a>';
    }

    echo '<div itemprop="brand" itemscope itemtype="http://schema.org/Brand">' . esc_html__('Brand', 'theshopier') . ': ' . join( ',', $links ) . '</div>';
}

add_action( 'wp_print_scripts', 'theshopier_dequeue_script', 100 );

function theshopier_dequeue_script(){
    wp_dequeue_script( 'modaljs' );
}

/*add_action( 'woocommerce_archive_description', 'theshopier_taxonomy_archive_description', 10 );
function theshopier_taxonomy_archive_description(){
    if ( is_tax( array( 'product_brand' ) ) && 0 === absint( get_query_var( 'paged' ) ) ) {
        $description = wc_format_content( term_description() );
        if ( $description ) {
            echo '<div class="term-description">' . $description . '</div>';
        }
    }
}*/
