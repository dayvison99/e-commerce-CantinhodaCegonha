<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 1/29/2016
 * Vertion: 1.0
 */

add_action('theshopier_footer_init', 'theshopier_preview_block', 99);

if( !function_exists('theshopier_preview_block') ) {
    function theshopier_preview_block(){
        $server_args = array('127.0.0.1', 'demo.nexthemes.com');
        //if(!in_array( $_SERVER['SERVER_NAME'], $server_args )) return null;

        /*$_preview_link = "http://demo.nexthemes.com/wordpress/images/theshopier/previews/";*/
        $_preview_link = get_template_directory_uri() . '/images/preview/';
        $gg_link = add_query_arg('key', 'AIzaSyASE5lr3VjImcJu6zjCMS91QK63zVSlcrk', 'https://www.googleapis.com/webfonts/v1/webfonts');
        $gg_font = @wp_remote_get($gg_link, array('sslverify' => false));
        $gg_fonts_data = array( '' => __('--Select a font--', 'theshopier'));
        if ( ! is_wp_error( $gg_font ) && $gg_font['response']['code'] == 200 ) {
            $gg_font = json_decode( $gg_font['body'] );
            foreach ( $gg_font->items as $font ) {
                $gg_fonts_data[ esc_attr($font->family) ] = esc_attr($font->family);
            }
        }

        ?>
        <div class="nth-preview-wrapper hidden-sm hidden-xs nth-close">
            <div class="button-wrapper">
                <div class="button-item preview-toggle"><i class="fa fa-cogs" aria-hidden="true"></i></div>
            </div>
            <div class="nth-preview-inner">
                <div class="nth-preview-container">
                    <div class="nth-preview-section layout-section">
                        <h3>LAYOUT</h3>
                        <div class="layout-button text-center">
                            <?php
                            $bg_color = get_theme_mod('background_color', 'ffffff');
                            ?>
                            <button class="button wide active" data-color="<?php echo esc_attr($bg_color)?>" data-action="wide">Wide</button>
                            <button class="button boxed" data-color="<?php echo esc_attr($bg_color)?>" data-action="boxed">Boxed</button>
                        </div>
                        <div class="layout-background">
                            <h3>BOXED BACKGROUNDS</h3>
                            <?php
                            $bg_args = array(
                                'bg_full1' => array(
                                    'background-repeat'  => 'no-repeat',
                                    'background-position'   => 'center top',
                                    'background-size'       => 'cover',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_full2' => array(
                                    'background-repeat'  => 'no-repeat',
                                    'background-position'   => 'center bottom',
                                    'background-size'       => 'cover',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_full3' => array(
                                    'background-repeat'  => 'no-repeat',
                                    'background-position'   => 'center bottom',
                                    'background-size'       => 'cover',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_full4' => array(
                                    'background-repeat'  => 'no-repeat',
                                    'background-position'   => 'center top',
                                    'background-size'       => 'cover',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat1' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat2' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat3' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat4' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat5' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat6' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat7' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat8' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat9' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat10' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat11' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat12' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat13' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat14' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat15' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat16' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat17' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat18' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat19' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),
                                'bg_repeat20' => array(
                                    'background-repeat'  => 'repeat',
                                    'background-position'   => 'left top',
                                    'background-size'       => 'inherit',
                                    'background-attachment' => 'fixed',
                                ),

                            );
                            foreach($bg_args as $k => $v) :
                                $bg_url = $_preview_link . "{$k}.jpg";
                                $bg_json = $v;
                                $bg_json['background-image'] = 'url('.esc_url($bg_url).')';
                                ?>
                                <a href="#" class="bg-item <?php echo esc_attr($k);?>" data-bg="<?php echo esc_attr(wp_json_encode($bg_json));?>"></a>
                            <?php endforeach;?>
                        </div>
                        <div class="layout-font">
                            <h3>FONT</h3>
                            <?php
                            if(!empty($gg_fonts_data)) {
                                echo '<select name="theshopier_preview_font" id="theshopier_preview_font">';
                                foreach($gg_fonts_data as $k => $v){
                                    printf('<option value="%s">%s</option>', esc_attr($k), esc_html($v));
                                }
                                echo '</select>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="nth-preview-section homes-preview-wrapper">

                        <div class="homepage-title">
                            <h3>HOMEPAGES</h3>
                        </div>

                        <?php
                        $home_k = array(
                            15 => 'Electrics Market',
                            14 => 'The Bussiness',
                            13 => 'Fashion Shop 2',
                            12 => 'Baby Shop',
                            11 => 'Fashion Shop',
                            10 => 'Furniture Shop',
                            9 => 'Lingerie Shop',
                            8 => 'Jewelry Shop',
                            7 => 'Bike Shop',
                            6 => 'Computer Peripherals Shop',
                            5 => 'Deals Market',
                            4 => 'Overflowed Market',
                            3 => 'Sidebared Market',
                            2 => 'Parallax Market',
                            1 => 'Classic Market'
                        );
                        ?>
                        <div class="row">
                            <style type="text/css" scoped>
                                <?php foreach($home_k as $k => $title) : ?>
                                .nth-preview-wrapper .nth-preview-inner .nth-preview-section .home-item .image-wrap.homepage-<?php echo absint($k);?> {
                                    background-position: 0 <?php echo ($k-1)/20*100;?>%;
                                }
                                <?php endforeach;?>
                            </style>

                            <?php
                        foreach($home_k as $k => $title) :
                            $href = "http://demo.nexthemes.com/wordpress/theshopier/home{$k}/";
                            $src = THEME_IMG_URI . "preview/preview-{$k}.jpg";
                            $class = array('home-item');
                            if(absint($k) > 13) $class[] = 'home-new';
                            $class[] = "col-lg-6 col-md-8 col-sm-12";
                            ?>
                            <div class="<?php echo esc_attr(implode(' ', $class))?>">
                                <a target="_blank" title="<?php echo esc_attr($title)?>" href="<?php echo esc_url($href)?>" class="<?php echo esc_attr('home-'. $k)?>">
                                    <div class="image-wrap homepage-<?php echo absint($k)?>">
                                        <img width="330" height="220" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUoAAADcCAYAAAAWYejvAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MzhDNTI0QUMzQUZBMTFFNjhGQjJFNDk2ODY2NzExRjYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MzhDNTI0QUQzQUZBMTFFNjhGQjJFNDk2ODY2NzExRjYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozOEM1MjRBQTNBRkExMUU2OEZCMkU0OTY4NjY3MTFGNiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozOEM1MjRBQjNBRkExMUU2OEZCMkU0OTY4NjY3MTFGNiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Ph393BsAAAJMSURBVHja7NQxAQAACMMwwL/noYCPM5HQo52kALiNBABGCWCUAEYJYJQARglglABGCWCUABglgFECGCWAUQIYJYBRAhglgFECYJQARglglABGCWCUAEYJYJQARgmAUQIYJYBRAhglgFECGCWAUQIYJYBRAmCUAEYJYJQARglglABGCWCUAEYJgFECGCWAUQIYJYBRAhglgFECGCUARglglABGCWCUAEYJYJQARglglABGCYBRAhglgFECGCWAUQIYJYBRAhglAEYJYJQARglglABGCWCUAEYJYJQAGCWAUQIYJYBRAhglgFECGCWAUQIYJQBGCWCUAEYJYJQARglglABGCWCUABglgFECGCWAUQIYJYBRAhglgFECYJQARglglABGCWCUAEYJYJQARglglAAYJYBRAhglgFECGCWAUQIYJYBRAmCUAEYJYJQARglglABGCWCUAEYJgFECGCWAUQIYJYBRAhglgFECGCWAUQJglABGCWCUAEYJYJQARglglABGCYBRAhglgFECGCWAUQIYJYBRAhglAEYJYJQARglglABGCWCUAEYJYJQARgmAUQIYJYBRAhglgFECGCWAUQIYJQBGCWCUAEYJYJQARglglABGCWCUABglgFECGCWAUQIYJYBRAhglgFECGCUARglglABGCWCUAEYJYJQARglglAAYJYBRAhglgFECGCWAUQIYJYBRAmCUAEYJYJQARglglABGCWCUAEYJYJQAGCWAUQIYJYBRAhglgFECGCWAUQJglABGCfBtBRgAZ1kEtc6g8PoAAAAASUVORK5CYII=" alt="Preview home page">
                                    </div>
                                </a>
                            </div>
                        <?php endforeach;?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script type="text/javascript">
            /* <![CDATA[ */
            (function($) {
                "use strict";
                var __nth_time = 300;
                $(document).ready(function(){
                    if (typeof $.cookie !== 'undefined' && typeof $.cookie( 'nth_previewcookie' ) !== 'undefined') {
                        $('.nth-preview-wrapper.nth-close').removeClass('nth-close');
                        $('.nth-preview-wrapper').addClass($.cookie( 'nth_previewcookie' ));
                        if($.cookie( 'nth_previewcookie' ) == 'nth-open') {
                            $('.nth-preview-wrapper .nth-preview-inner').slideDown(__nth_time);
                        }
                    }

                    $('.nth-preview-wrapper').on('click', '.layout-section .layout-button .button', function (e) {
                        e.preventDefault();
                        var act = $(this).data('action');
                        var color = $(this).data('color');
                        $(this).parent().find('.active').removeClass('active');
                        $(this).addClass('active');
                        if(act === 'boxed') {
                            $('.nth-preview-wrapper .layout-background .bg-item.bg_repeat1').trigger('click');
                            $('body').addClass('boxed').find('#body-wrapper').css({'background-color': '#'+color});

                        } else {
                            $('body.boxed').removeClass('boxed');
                        }

                    })

                    $('.nth-preview-wrapper').on('click', '.layout-section .layout-background .bg-item', function (e) {
                        e.preventDefault();
                        if($('.nth-preview-wrapper .layout-section .layout-button .button.boxed').hasClass('active')) {
                            $(this).parent().find('.bg-item.active').removeClass('active');
                            $(this).addClass('active')
                            var json = $(this).data('bg');
                            console.log(json);
                            $('body').css(json);
                        }
                    });

                    $('.nth-preview-wrapper').on('click', '.button-wrapper .preview-toggle', function (e) {
                        e.preventDefault();
                        $('.nth-preview-wrapper').toggleClass('nth-close');

                        if( typeof $.cookie === 'function' ) {
                            var act = 'nth-open';
                            if( $('.nth-preview-wrapper.nth-close').length > 0 ) {
                                act = 'nth-close';
                                $('.nth-preview-wrapper .nth-preview-inner').slideUp(__nth_time);
                            } else {
                                $('.nth-preview-wrapper .nth-preview-inner').slideDown(__nth_time);
                            }
                            $.cookie('nth_previewcookie', act, { path: '/' });
                        }
                    });

                    $('.nth-preview-wrapper').on('change', '#theshopier_preview_font', function (e) {
                        var __val = $(this).val();
                        var __gg_link = 'https://fonts.googleapis.com/css?family=' + $(this).val();
                        if( $('#theshopier_heading_font').length ) {
                            $('#theshopier_heading_font').attr('href', __gg_link);
                        } else {
                            var __gg_scr = document.createElement('link');
                            __gg_scr.rel = "stylesheet";
                            __gg_scr.type = "text/css";
                            __gg_scr.id = "theshopier_heading_font";
                            __gg_scr.href = __gg_link;
                            $("head").append(__gg_scr);
                        }

                        $.ajax({
                            type: 'GET',
                            dataType: 'json',
                            url: theshopier_data['templ_url'] + '/js/preview_font.json',
                            success: function (data) {
                                $(data.font_1).css({'font-family': __val});
                            }
                        });

                    });

                });
            })(jQuery);
            /* ]]> */
        </script>
        <?php
    }

}