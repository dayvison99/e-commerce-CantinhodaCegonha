<?php
/**
 * Wishlist page template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.7
 */
?>

    <!-- TITLE -->
    <?php
	
    if( ! empty( $page_title ) ) :
		$wishlist_page_url = get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) );
    ?>
        <div class="wishlist-heading">
			<h2 class="heading-title ud-line"><?php printf( esc_html__("My Wishlist (%d)", 'theshopier' ), $count );?></h2>
			<a class="heading-links" href="<?php echo esc_url($wishlist_page_url);?>" title="<?php esc_attr_e( "Browse to Wishlist", 'theshopier' );?>"><?php esc_html_e("Wishlist", 'theshopier' );?></a>
		</div>
    <?php endif;?>
	
    <!-- WISHLIST TABLE -->
	<ul class="product_list_widget list">
		<?php
        if( count( $wishlist_items ) > 0 ) : $i = 0;
            foreach( $wishlist_items as $item ) :
                global $product;
	            if( function_exists( 'wc_get_product' ) ) {
		            $product = wc_get_product( $item['prod_id'] );
	            }
	            else{
		            $product = get_product( $item['prod_id'] );
	            }

                if( $product !== false && $product->exists() ) :
	                $availability = $product->get_availability();
	                $stock_status = $availability['class'];
	                ?>
                    <li data-row-id="<?php echo $item['prod_id'] ?>">
	                    
                        <?php if( $is_user_owner ):?>
                        <a href="javascript:void(0);" class="remove nth_remove_from_wishlist" title="<?php esc_attr_e( 'Remove this product', 'theshopier' ) ?>" data-prod_id="<?php echo absint($item['prod_id']);?>" data-pagination="<?php echo esc_attr( $pagination )?>" data-pagination="<?php echo esc_attr( $pagination )?>" data-per-page="<?php echo esc_attr( $per_page )?>" data-page="<?php echo esc_attr( $current_page )?>" data-id="<?php echo ( is_user_logged_in() ) ? esc_attr( $wishlist_meta['ID'] ) : '' ?>" data-token="<?php echo ( ! empty( $wishlist_meta['wishlist_token'] ) && is_user_logged_in() ) ? esc_attr( $wishlist_meta['wishlist_token'] ) : '' ?>">&times;</a>
                        <?php endif; ?>
						<a class="product-image" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ) ?>">
							<?php echo $product->get_image() ?>
						</a>
                        <div class="product-detail">
                            <a class="product-title" href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item['prod_id'] ) ) ) ?>" title="<?php echo esc_attr( $product->get_title() ); ?>"><?php echo $product->get_title(); ?></a>

                            <?php
                            if( is_a( $product, 'WC_Product_Bundle' ) ){
                                if( $product->min_price != $product->max_price ){
                                    echo sprintf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
                                }
                                else{
                                    echo wc_price( $product->min_price );
                                }
                            }
                            elseif( $product->get_price() != '0' ) {
                                echo $product->get_price_html();
                            }
                            else {
                                echo apply_filters( 'yith_free_text', esc_html__( 'Free!', 'theshopier' ) );
                            }
                            ?>

                        </div>
								
                    </li>
                <?php
                endif;
            endforeach;
        else: ?>
            <li class="empty">
                <?php esc_html_e( 'No products were added to the wishlist', 'theshopier' ) ?>
            </li>
        <?php
        endif;

        if( ! empty( $page_links ) ) : ?>
            <li class="pagination-row">
				<?php echo $page_links ?>
            </li>
        <?php endif ?>
	</ul>
