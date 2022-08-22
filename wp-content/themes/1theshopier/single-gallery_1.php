<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/17/2015
 * Vertion: 1.0
 */

$galleries = Nexthemes_Gallery::get_galleries_data(get_the_ID());

$k = 25;
?>

<div class="nth-fullwidth gallery-content" data-max="<?php echo absint(count($galleries['thumb_ids']))?>" data-k="<?php echo esc_attr($k)?>" data-number="16" data-post_id="<?php echo absint(get_the_ID())?>">


    <div class="nth-isotope-1">

        <?php
        if(!empty($galleries['att_img']) || !empty($galleries['v_link'])):

            $thumb_ids = $galleries['thumb_ids'];
            array_splice($thumb_ids, $k);

            foreach( $thumb_ids as $att_el ):
                $class = array('gallery-image-item');

                if( is_array($att_el) ) {
                    $attachment_id = $att_el[1];
                    $class[] = 'gallery-video';
                    $image_link = $att_el[0];
                    $img_icon = true;
                } else {
                    $attachment_id = $att_el;
                    $image_link = wp_get_attachment_url( $attachment_id );
                    $img_icon = false;
                }

                if ( ! $image_link )
                    continue;

                $image_title 	= esc_attr( get_the_title( $attachment_id ) );

                ?>

                <div class="<?php echo esc_attr(implode(' ', $class));?>">
                    <a href="<?php echo esc_url($image_link);?>" class="nth-pretty-photo" title="<?php echo esc_attr($image_title);?>" data-rel="nth_prettyPhoto[gallery-image]">
                        <?php if($img_icon) :
                            theshopier_getImage(array(
                                'alt'   => esc_attr__( 'Media icon image', 'theshopier' ),
                                'src'   => esc_url(THEME_IMG_URI . 'media_icon.png'),
                                'class' => 'media_icon'
                            ));
                            ?>
                        <?php endif;?>
                        <?php echo wp_get_attachment_image( $attachment_id, 'gallery_thumb_auto', 0, $attr = array(
                            'title'	=> $image_title,
                            'alt'	=> $image_title
                        ) );?>
                    </a>
                </div>

                <?php

            endforeach;
        endif;
        ?>

    </div>

    <?php if(absint(count($galleries['thumb_ids'])) >= $k):?>

    <div class="text-center">
        <?php
        theshopier_loadmore_btn('fa fa-refresh', 'button', array(
            'class'     => 'nth_gallery_load_more button'
        ));
        ?>
    </div>

    <?php endif;?>

</div>