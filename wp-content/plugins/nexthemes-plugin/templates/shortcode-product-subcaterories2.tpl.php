<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/23/2015
 * Vertion: 1.0
 */

$term = get_term_by( "slug", $ops, "product_cat" );

$classes = array('woo-subcat-item');
if( absint($columns) > 1 && absint($is_slider) == 0 ) {
    $classes[] = 'col-lg-' . round( 24 /$columns );
    $classes[] = 'col-md-' . round( 24 / round( $columns * 992 / 1200) );
    $classes[] = 'col-sm-' . round( 24 / round( $columns * 768 / 1200) );
    $classes[] = 'col-xs-' . round( 24 / round( $columns * 480 / 1200) );
    $classes[] = 'col-mb-24';
} else {
    $classes[] = 'col-sm-24';
}

$cat_thumb_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
if ( $cat_thumb_id ) {
    $image = wp_get_attachment_image( $cat_thumb_id, 'thumbnail'  );
} else {
    $image = '<img alt="Placeholder" src="'.wc_placeholder_img_src().'"/>';
}

$desc = '';
if( !empty($ops['desc']) ) $desc = '<p class="description">' . esc_html( sprintf($ops['desc'], $term->count) ) . '</p>';

$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
    'parent'       => $term->term_id,
    'menu_order'   => 'ASC',
    'hide_empty'   => 0,
    'hierarchical' => 1,
    'taxonomy'     => 'product_cat',
    'pad_counts'   => 1,
    'number'       => $per_page
) ) );

$_pres = absint($i) % 2;

if($_pres == 0) printf('<div class="%s">', esc_attr(implode(' ', $classes)));
?>

    <div class="woo-subcat-wrapper">

        <div class="image">
            <?php echo $image;?>
        </div>

        <div class="cat-detail">
            <h3 class="cat-title"><?php echo esc_html($term->name)?></h3>
            <ul class="sub-cat list">
            <?php
            foreach( $product_categories as $category ) :
                ?>
                <li>
                    <a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" title="<?php echo esc_attr( $category->name ); ?>">
                        <?php echo $category->name; ?>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>

    </div>


<?php if($_pres == 1) echo '</div><!-- END_TAG -->'?>
