<?php
/**
 * Wishlist page template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.7
 */


if( !class_exists( 'YITH_Woocompare' ) ) return;

$fontend = theshopier_compare_object();
if(empty($fontend)) return;

$products = $fontend->get_products_list();
?>

<div class="wishlist-heading">
    <h3 class="heading-title ud-line"><?php printf( esc_html__("My Compare", 'theshopier' ) );?></h3>
</div>

<ul class="product_list_widget list">
    <?php if ( count($products) > 0 ) :?>

        <?php foreach($products as $item):
            $product = wc_get_product( $item->get_id() );

            if( $product !== false && $product->exists() ) :

                $url_args = array(
                    'action' => $fontend->action_remove,
                    'id' => $product->get_id()
                );
                //$remove_link = wp_nonce_url( esc_url_raw( add_query_arg( $url_args, site_url() ) ), $fontend->action_remove )
                $remove_link = $fontend->remove_product_url( $product->get_id() );
            ?>

    <li data-row-id="<?php echo absint($product->get_id())?>">

        <a class="remove nth_remove_compare" href="<?php echo esc_url($remove_link);?>" data-product_id="<?php echo absint($product->get_id()); ?>"><?php esc_html_e( 'Remove', 'theshopier' ) ?> <span class="remove">x</span></a>

        <a class="product-image" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', absint($product->get_id()) ) ) ) ?>">
            <?php echo $product->get_image() ?>
        </a>

        <div class="product-detail">
            <a class="product-title" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', absint($product->get_id()) ) ) ) ?>" title="<?php echo esc_attr( $product->get_title() ); ?>"><?php echo esc_html($product->get_title()); ?></a>

            <?php
            if( is_a( $product, 'WC_Product_Bundle' ) ){
                if( $product->min_price != $product->max_price ){
                    echo sprintf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
                }
                else{
                    echo wc_price( $product->min_price );
                }
            }
            elseif( $product->get_price() != '' ) {
                echo $product->get_price_html();
            }
            else {
                echo apply_filters( 'yith_free_text', esc_html__( 'Free!', 'theshopier' ) );
            }
            ?>

        </div>

    </li>
            <?php endif; /** $product !== false && $product->exists() **/?>

        <?php endforeach;?>

    <?php else:?>

        <li class="empty">
            <?php esc_html_e( 'No products were added to Compare', 'theshopier' ) ?>
        </li>

    <?php endif;?>
</ul>

<?php if ( count($products) > 0 ) :?>

    <p class="buttons">

        <a class="button nth-ajax-compare-popup" href="<?php echo esc_url($fontend->view_table_url());?>" title="<?php esc_attr_e( "View compare", 'theshopier' );?>"><?php printf( esc_html__( "Compare (%s)", 'theshopier' ), count($products) ) ?></a>

    </p>

<?php endif;?>
