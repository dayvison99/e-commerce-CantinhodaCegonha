<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/17/2015
 * Vertion: 1.0
 */

if( class_exists('Nexthemes_Gallery') ):
$galleries = Nexthemes_Gallery::get_galleries_data(get_the_ID());
?>

<div class="container">

    <div class="gallery-content gallery-style-2">

        <?php if(!empty($galleries['att_img']) || !empty($galleries['v_link'])): ?>
            <?php
            $class = array('gallery-image-item');
            $thumb_ids = $galleries['thumb_ids'];

            $rol_options = Nexthemes_Gallery::get_royalOptions();
            ?>

            <div id="nth_galleries" class="galleries-wrapper royalSlider rsDefault" data-options="<?php echo esc_attr(wp_json_encode($rol_options))?>">

                <?php Nexthemes_Gallery::renderRoyol_Images($thumb_ids);?>

            </div>

        <?php endif;?>

    </div>

</div>

<?php endif;?>