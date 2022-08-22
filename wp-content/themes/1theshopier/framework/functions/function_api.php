<?php
/**
 * Package: TheShopier.
 * User: kinhdon
 * Date: 11/28/2015
 * Vertion: 1.0
 *
 *
 * I - HEADER FUNCTION
 */


/* I - HEADER FUNCTION */

if( !function_exists('theshopier_getLogo') ) {
    function theshopier_getLogo( $type="" ){
        global $theshopier_datas;
        switch( $type ) {
            case 'sticky':
                break;
            default:
                $title = !empty($theshopier_datas['logo-text'])? esc_attr($theshopier_datas['logo-text']): get_bloginfo('name');
                $logo_arg = array(
                    'title'	=> esc_attr($title),
                    'alt'	=> esc_attr($title)
                );

                if( isset( $theshopier_datas['nth-logo'] ) && strlen(trim($theshopier_datas['nth-logo']['url'])) > 0 ){
                    $logo_arg['src'] = esc_url( $theshopier_datas['nth-logo']['url'] );
                    $logo_arg['width'] = absint($theshopier_datas['nth-logo']['width']);
                    $logo_arg['height'] = absint($theshopier_datas['nth-logo']['height']);
                } else {
                    $logo_arg['src'] = esc_url( THEME_IMG_URI . "logo.png" );
                    $logo_arg['width'] = 530;
                    $logo_arg['height'] = 104;
                }

                echo '<div class="logo">';
                echo '<a href="'.esc_attr(home_url()).'">';
                theshopier_getImage($logo_arg);
                echo '</a>';
                echo '</div>';
        }
    }
}

if( !function_exists('theshopier_header_body') ){
    function theshopier_header_body( $style = 1 ){
        if( strlen( $style ) == 0 || !file_exists(THEME_DIR . 'framework/header_tpl/header-'.$style.'.php') ) $style = 1;
        get_template_part('framework/header_tpl/header', $style);
    }
}

if( !function_exists('theshopier_fonts_url') ) {
    function theshopier_fonts_url(){
        $fonts_url = '';
        $roboto = esc_attr_x( 'on', 'Roboto font: on or off', 'theshopier' );
        $roboto_condensed = esc_attr_x( 'on', 'Roboto Condensed font: on or off', 'theshopier' );

        if( 'off' !== $roboto || 'off' !== $roboto_condensed ) {
            $font_families = array();
            if( 'off' !== $roboto ) {
                $font_families[] = 'Roboto:900,400italic,100,300,700,300italic,400';
            }
            if( 'off' !== $roboto_condensed ) {
                $font_families[] = 'Roboto Condensed:400,300italic,400italic,700italic,300,700';
            }

            $query_args = array(
                'family' => urlencode(implode('|', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );

            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }

        return esc_url_raw($fonts_url);
    }
}

if( !function_exists( 'theshopier_search_form' ) ) {
    function theshopier_search_form(){
        $rand_id = wp_rand();
        $check_woo = Theshopier::checkPlugin('woocommerce/woocommerce.php');
        if($check_woo) {
            $_placeholder = esc_attr__("Search product...", 'theshopier' );
        } else {
            $_placeholder = esc_attr__("Search anything...", 'theshopier' );
        }
        ?>
        <form id="form_<?php echo esc_attr($rand_id)?>" method="get" class="searchform nth-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="nth-search-wrapper">
                <label class="screen-reader-text" for="s_<?php echo esc_attr($rand_id)?>"><?php esc_html_e( 'Search for:', 'theshopier' ); ?></label>
                <input type="text" placeholder="<?php echo esc_attr($_placeholder);?>" value="<?php echo get_search_query() ?>" name="s" id="s_<?php echo esc_attr($rand_id)?>" />
                <?php if($check_woo): ?>
                    <input type="hidden" name="post_type" value="product" />
                <?php endif;?>
                <?php if ( defined( 'ICL_LANGUAGE_CODE' ) ): ?>
                    <input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>" />
                <?php endif ?>
                <button type="submit" class="icon-nth-search searchsubmit"><?php echo esc_attr_x( 'Search', 'submit button', 'theshopier' ); ?></button>
            </div>
        </form>
        <?php
    }
}

if( !function_exists('theshopier_header_tablet') ) {
    function theshopier_header_tablet(){
        if( file_exists(THEME_DIR . 'framework/header_tpl/header-tablet.php') )
            get_template_part('framework/header_tpl/header', 'tablet');
    }
}

if( !function_exists( 'theshopier_login_form' ) ) {

    function theshopier_login_form( $style = 1 ){
        if( !Theshopier::checkPlugin('woocommerce/woocommerce.php') ) return ;

        $shop_myaccount_id = get_option( 'woocommerce_myaccount_page_id' );
        if( isset( $shop_myaccount_id ) && absint( $shop_myaccount_id ) > 0 ) {
            $myaccount_url = get_permalink( $shop_myaccount_id );
            $ac_link_title = esc_html__( "My Account", 'theshopier' );
        } else return 'Woocommerce account page was not found!';

        $mini_popup_meta = '<p>%s</p>';
        $mini_popup_icon = true;
        if($style == 2) $mini_popup_meta = '';
        switch($style){
            case 2:
                $mini_popup_meta = '';
                break;
            case 3:
                $mini_popup_meta = '<span>%s</span>';
                $mini_popup_icon = false;
                break;
        }


        if( is_user_logged_in() ) {
            $current_user = wp_get_current_user();
            ?>
            <div class="nth-mini-popup nth-mini-login nth-mini-nodropdown">
                <div class="mini-popup-hover nth-login-hover">
                    <?php if($mini_popup_icon): ?>
                    <a href="<?php echo esc_url($myaccount_url);?>" title="<?php echo esc_attr($ac_link_title);?>"><span class="nth-icon icon-nth-user"></span></a>
                    <?php endif;?>

                    <div class="mini-popup-meta hidden-xs">
                        <?php printf($mini_popup_meta, esc_html__("Welcome!", 'theshopier' ));?>
                        <a href="<?php echo esc_url($myaccount_url);?>" title="<?php echo esc_attr($ac_link_title);?>"><?php echo isset( $current_user->display_name ) && strlen( $current_user->display_name ) > 0? $current_user->display_name: $current_user->user_login;?></a>
                    </div>
                </div>
            </div><!--nth-mini-popup nth-mini-login-->
            <?php

        } else {
            $rand_id = wp_rand();
            $args = array(
                'echo'		=> true,
                'form_id'   => 'nth_header_loginform' . $rand_id,
                'label_username' => esc_html__( 'Username', 'theshopier' ),
                'label_password' => esc_html__( 'Password', 'theshopier' ),
                'label_remember' => esc_html__( 'Remember Me', 'theshopier' ),
                'label_log_in'   => esc_html__( 'Log In', 'theshopier' ),
                'id_username'    => 'nth_user_login' . $rand_id,
                'id_password'    => 'nth_user_pass' . $rand_id,
                'id_remember'    => 'nth_rememberme' . $rand_id,
                'id_submit'      => 'nth_submit' . $rand_id,
                'remember'       => true,
                'value_username' => '',
                'value_remember' => false
            );

            ?>
            <div class="nth-mini-popup nth-mini-login">
                <div class="mini-popup-hover nth-login-hover">
                    <?php if($mini_popup_icon): ?>
                    <a href="javascript:void(0)" title="<?php echo esc_attr($ac_link_title);?>"><span class="nth-icon icon-nth-user"></span></a>
                    <?php endif;?>

                    <div class="mini-popup-meta hidden-xs">
                        <?php printf($mini_popup_meta,  esc_html__("Welcome!", 'theshopier' )) ;?>
                        <a class="arrow_down" href="<?php echo esc_url($myaccount_url);?>" title="<?php echo esc_attr($ac_link_title);?>"><?php esc_html_e( "Sign In", 'theshopier' )?></a>
                    </div>

                </div>

                <div class="nth-mini-popup-cotent nth-mini-login-content">
                    <div class="nth-ajax-login-wrapper">
                        <?php wp_login_form( $args );?>
                    </div>

                    <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ):?>
                    <div class="nth-mini-popup-footer">
                        <p class="create_account"><?php printf( wp_kses(__('New to our store? <a href="%1$s" title="Create an Account">Create an Account</a>', 'theshopier'), array('a'=>array('href'=>array(), 'title'=>array()))), esc_url($myaccount_url) )?></p>
                    </div>
                    <?php endif;?>
                </div>
            </div><!--nth-mini-popup nth-mini-login-->
            <?php

        }

    }

}

if( !function_exists( 'theshopier_shoppingCart' ) ) {

    function theshopier_shoppingCart($style = 1){
        if( !Theshopier::checkPlugin('woocommerce/woocommerce.php') ) return;
        global $woocommerce;

        $mini_popup_meta = '<p class="hidden-xs">%s</p>';
        $mini_popup_icon = true;
        $mini_popup_price = true;
        switch($style) {
            case 2:
                $mini_popup_meta = '';
                break;
            case 3:
                $mini_popup_meta = '<span>%s</span>';
                $mini_popup_icon = false;
                break;
            case 4:
                $mini_popup_meta = '<span class="arrow_down">%s</span>';
                $mini_popup_icon = false;
                $mini_popup_price = false;
                break;
            case 5:
                break;
        }

        ?>
        <div class="nth-mini-popup nth-shopping-cart">
            <div class="mini-popup-hover nth-shopping-hover">
                <?php if(absint($style) !== 5) : ?>
                    <?php if($mini_popup_icon):?>
                    <a href="javascript:void(0)" title="<?php esc_attr_e('My Cart','theshopier');?>">
                        <span class="nth-icon icon-nth-cart" data-count="<?php echo absint($woocommerce->cart->cart_contents_count);?>"></span>
                    </a>
                    <?php endif;?>
                    <div class="mini-popup-meta">
                        <?php
                        printf($mini_popup_meta, esc_html__("My Cart", 'theshopier' ));
                        if($mini_popup_price) {
                            printf('<span class="cart-total hidden-xs">%s</span>', $woocommerce->cart->get_cart_total());
                        }
                        ?>
                    </div>
                <?php else: ?>
                    <a href="javascript:void(0)" title="<?php esc_attr_e('My Cart','theshopier');?>">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span class="cart-meta-st5"><?php printf(__('Cart: %s item(s)', 'theshopier'), absint($woocommerce->cart->cart_contents_count));?> </span>
                    </a>
                <?php endif;?>
            </div>

            <div class="nth-mini-popup-cotent nth-shopping-cart-content">
                <div class="widget_shopping_cart_content"></div>
            </div>
        </div>
        <?php
    }

}

if( !function_exists( 'theshopier_header_toolbar' ) ) {

    function theshopier_header_toolbar(){
        if( !Theshopier::checkPlugin('woocommerce/woocommerce.php') ) return;
        global $woocommerce, $theshopier_datas;

        if( isset($theshopier_datas['main-right-toolbar']) && absint($theshopier_datas['main-right-toolbar']) == 0 ) return;

        $args_search = array(
            'echo'		=> true,
            'form_id' 			=> 'nth_sidebar_tool_loginform',
            'label_username' 	=> esc_html__( 'Username', 'theshopier' ),
            'label_password' 	=> esc_html__( 'Password', 'theshopier' ),
            'label_remember' 	=> esc_html__( 'Remember Me', 'theshopier' ),
            'label_log_in'   	=> esc_html__( 'Log In', 'theshopier' ),
            'id_username'    	=> 'nth_sbtool_user_login',
            'id_password'    	=> 'nth_sbtool_user_pass',
            'id_remember'    	=> 'nth_sbtool_rememberme',
            'id_submit'      	=> 'nth_sbtool_submit',
            'remember'       	=> true,
            'value_username' 	=> '',
            'value_remember' 	=> false
        );

        $show_social = isset($theshopier_datas['show-social-icons'])? absint($theshopier_datas['show-social-icons']): 1;

        $show_qrcode = isset($theshopier_datas['show-qrcode-icon'])? absint($theshopier_datas['show-qrcode-icon']): 1;

        ?>
        <div class="nth_header_toolbar visible-lg">

            <div class="top-group-items">

                <div class="toolbar_item nth-account-item">
                    <?php
                    $shop_myaccount_id = get_option( 'woocommerce_myaccount_page_id' );
                    if( isset( $shop_myaccount_id ) && absint( $shop_myaccount_id ) > 0 )
                        $myaccount_url = get_permalink( $shop_myaccount_id );
                    else $myaccount_url = home_url('/');
                    ?>
                    <?php if( is_user_logged_in() ) : ?>
                        <?php
                        $current_user = wp_get_current_user();
                        ?>
                        <a href="<?php echo esc_url($myaccount_url);?>" title="<?php esc_attr_e( "My Account", 'theshopier' );?>">
                            <span class="nth-icon icon-nth-user"></span>
                        </a>
                        <div class="nth-toolbar-popup-cotent nth-mini-login-content">
                            <h3 class="heading-title ud-line"><?php esc_html_e("My Account", 'theshopier' );?></h3>
                            <p><?php printf( wp_kses(__( 'Welcome, <strong>%s</strong>', 'theshopier' ), array('strong'=>array())), isset( $current_user->display_name ) && strlen( $current_user->display_name ) > 0? $current_user->display_name: $current_user->user_login);?></p>
                            <a href="<?php echo esc_url($myaccount_url);?>" class="btn btn-primary" title="<?php esc_attr_e( "My Account", 'theshopier' );?>"><?php esc_html_e("Visit Account Page", 'theshopier' );?></a> <br />
                            <a href="<?php echo wp_logout_url(get_permalink());?>" title="<?php esc_attr_e("Log out", 'theshopier' );?>"><?php esc_html_e("Log out", 'theshopier' );?></a>
                        </div>
                    <?php else : ?>
                        <a href="javascript:void(0);" title="<?php esc_attr_e( "My Account", 'theshopier' );?>">
                            <span class="nth-icon icon-nth-user"></span>
                        </a>
                        <div class="nth-toolbar-popup-cotent nth-mini-login-content">
                            <div class="nth-ajax-login-wrapper">
                                <?php wp_login_form( $args_search );?>
                            </div>

                            <?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ):?>
                            <div class="nth-mini-popup-footer">
                                <p class="create_account"><?php printf( wp_kses(__('New to our store? <a href="%1$s" title="Create an Account">Create an Account</a>', 'theshopier'), array('a'=>array('href'=>array(), 'title'=>array()))), esc_url($myaccount_url) )?></p>
                            </div>
                            <?php endif;?>
                        </div>
                    <?php endif;?>

                </div>

                <?php if( class_exists( 'YITH_Woocompare_Frontend' ) && class_exists( 'YITH_Woocompare' ) ):
                    global $yith_woocompare;
                    $fontend = $yith_woocompare->obj;
                    $compare_count = count($fontend->products_list);
                    $table_url = add_query_arg( array(
                        'action' => $fontend->action_view,
                        'iframe' => 'true',
                        'ver' => time()
                    ), site_url() )?>

                    <div class="toolbar_item nth-compare-item">
                        <a class="nth-ajax-compare-popup" href="<?php echo esc_url($table_url);?>" title="<?php esc_attr_e( "View compare", 'theshopier' );?>">
                            <span class="nth-icon icon-nth-exchange" data-count="<?php echo absint($compare_count);?>"></span>
                        </a>
                        <div class="nth-toolbar-popup-cotent nth-wishlist-content"><?php do_action('theshopier_toolbar_compare');?></div>
                    </div>
                <?php endif;/* end check class YITH_Woocompare_Frontend */?>

                <?php if( class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL') ): ?>
                    <?php $wishlist_count = yith_wcwl_count_products();?>
                    <?php $wishlist_page_url = get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) );?>
                    <div class="toolbar_item nth-wishlist-item">
                        <a href="<?php echo esc_url($wishlist_page_url);?>" title="<?php esc_attr_e( "Browse Wishlist", 'theshopier' );?>">
                            <span class="nth-icon icon-nth-heart" data-count="<?php echo absint($wishlist_count);?>"></span>
                        </a>
                        <div class="nth-toolbar-popup-cotent nth-wishlist-content"><?php do_action('theshopier_toolbar_wishlist');?></div>
                    </div>
                <?php endif; /*end check class YITH_WCWL_UI*/?>

                <?php if( Theshopier::checkPlugin('woocommerce/woocommerce.php') ):?>

                    <div class="toolbar_item nth-shopping-cart-item">
                        <a href="<?php echo esc_url( wc_get_cart_url() );?>" title="<?php esc_attr_e( "Browse Shopping cart", 'theshopier' );?>">
                            <span class="nth-icon icon-nth-cart" data-count="<?php echo absint($woocommerce->cart->cart_contents_count);?>"></span>
                        </a>
                        <div class="nth-toolbar-popup-cotent nth-shopping-cart-content">
                            <div class="wishlist-heading">
                                <h3 class="heading-title ud-line"><?php esc_html_e("My Cart", 'theshopier' );?></h3>
                            </div>
                            <?php do_action("theshopier_after_shop_cart_toolbar_icon");?>
                            <div class="widget_shopping_cart_content"></div>
                        </div>
                        <div class="current-product-added-to-cart animated fadeInRight">no product</div>
                    </div>

                <?php endif;?>

            </div>

            <div class="bottom-group-items">

                <?php if( $show_social && isset( $theshopier_datas['social-network'] ) && is_array($theshopier_datas['social-network']) ): ?>
                    <div class="toolbar_item social-network-arrow">
                        <a href="javascript:void(0);" >
                            <span class="nth-icon icon-nth-angle-left"></span>
                        </a>
                        <?php echo theshopier_redux_social();?>
                    </div>

                <?php endif;?>

                <div class="toolbar_item" id="back_to_top">
                    <a href="javascript:void(0);">
                        <span class="nth-icon icon-nth-arrow-top"><?php esc_attr_e('Top', 'theshopier');?></span>
                    </a>
                </div>

                <?php if( isset( $theshopier_datas['toolbar-feedback-url'] ) && strlen($theshopier_datas['toolbar-feedback-url']) > 0 ): ?>
                    <div class="toolbar_item nth_feedback">
                        <a href="<?php echo esc_url( get_page_link($theshopier_datas['toolbar-feedback-url']) );?>" title="<?php esc_attr_e( "Question us!", 'theshopier' );?>" target="_blank">
                            <span class="nth-icon icon-nth-envelope"></span>
                        </a>
                    </div>
                <?php endif;?>

                <?php if($show_qrcode):
                    $_qr_url = !empty($theshopier_datas['qrcode-url'])? $theshopier_datas['qrcode-url']: ''; ?>

                    <div class="toolbar_item nth_qrcode">
                        <a href="javascript:void(0);">
                            <span class="nth-icon icon-nth-barcode"></span>
                        </a>

                        <div class="nth-toolbar-popup-cotent">
                            <?php echo do_shortcode('[theshopier_qrcode data="'.esc_url($_qr_url).'" size="270x270"]'); ?>
                        </div>
                    </div>
                <?php endif;?>

            </div>

        </div>
        <?php
    }

}

if( !function_exists('theshopier_redux_social') ) {
    function theshopier_redux_social($class = ''){
        if( ! Theshopier::checkPlugin('redux-framework/redux-framework.php') ) return;
        global $theshopier_datas;
        $output = '';
        if( isset( $theshopier_datas['social-network'] ) && is_array($theshopier_datas['social-network']) ) {
            $color_css = '';
            $_class = array('toolbar_item nth-social-network');
            if(!empty($class)) $_class[] = $class;
            $output .= '<ul class="'.esc_attr(implode(' ', $_class)).'">';
            foreach( $theshopier_datas['social-network'] as $k => $social ){
                $color = !empty( $social['color'] )? esc_attr("color: {$social['color']}"): '';
                $color_css .= '.nth_header_toolbar .bottom-group-items .social-network-arrow .nth-social-network li.sc-item-'.$k.' a:hover {'.$color.'}';
                $links = explode('|', $social['link']);
                $links[1] = !empty($links[1])? $links[1]: esc_html__("Follow me", 'theshopier');
                $output .= "<li class=\"sc-item-{$k}\" >";
                $output .= sprintf('<a href="%1$s" target="_blank" title="%2$s"><span class="%3$s fa-2x"></span></a>', esc_url( $links[0]), esc_attr($links[1]), esc_attr($social['icon']));
                $output .= '</li>';
            }
            $output .= '</ul>';
        }
        $style = '<div class="nth-toolbar-cotent-wrapper"><style type="text/css" scoped>' . $color_css . '</style></div>';
        $output = $style.$output;
        return $output;
    }
}


if(!function_exists('theshopier_getImage')) {
    function theshopier_getImage($atts){
        $atts = wp_parse_args($atts, array(
            'alt'   => esc_attr__('image alt', 'theshopier'),
            'width' => '',
            'height' => '',
            'src'  => '',
            'class' => 'theshopier-image'
        ));

        $src = esc_url($atts['src']);

        if(strlen(trim($src)) > 0) {
            $_img = '<img';
            foreach($atts as $k => $v) {
                if(empty($v)) continue;
                $_img .= " {$k}=\"{$v}\"";
            }
            $_img .= '>';
            echo wp_kses($_img, array(
                'img' => array('alt' => array(), 'width' => array(), 'height' => array(), 'src' => array(), 'class' => array())
            ));
        }
    }
}


/**
 * BLOG FUNCTION
 */


if( !function_exists( 'theshopier_vimeo_id' ) ) {
    function theshopier_vimeo_id( $link ){
        if (preg_match('/^https:\/\/(?:www\.)?vimeo\.com\/(?:clip:)?(\d+)/', $link, $match)) {
            return $match[1];
        }
    }
}

if( !function_exists( 'theshopier_youtube_id' ) ) {
    function theshopier_youtube_id( $link ){
        if( preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $link, $matches) ) {
            return $matches[1];
        }
    }
}

if( !function_exists( 'theshopier_video_player' ) ) {
    function theshopier_video_player( $params ){
        $defaults = array(
            'url' 	=> "",
            'width' => 870,
            'height'=> 560
        );
        $atts = wp_parse_args( $params, $defaults );
        if( strstr( $atts['url'], 'youtu' ) ) {
            $v_id = theshopier_youtube_id( $atts['url'] );
            printf( '<iframe width="%s" height="%s" src="%s" allowfullscreen></iframe>', esc_attr( $atts['width'] ), esc_attr( $atts['height'] ), esc_url('https://www.youtube.com/embed/' .$v_id. '?autoplay=0&rel=0&enablejsapi=1&playerapiid=ytplayer&wmode=transparent') );
        } elseif( strstr( $atts['url'], 'vimeo.com' ) ) {
            $v_id = theshopier_vimeo_id( $atts['url'] );
            printf('<iframe width="%s" height="%s" src="%s" allowfullscreen></iframe>', esc_attr( $atts['width'] ), esc_attr( $atts['height'] ), esc_url( 'https://player.vimeo.com/video/' . $v_id ));
        }
    }
}

if( !function_exists( 'theshopier_video_local_player' ) ) {
    function theshopier_video_local_player( $params ){
        $defaults = array(
            'mp4' 	=> "",
            'ogg' 	=> "",
            'webm' 	=> "",
            'width' => 830,
            'height'=> 525
        );
        $atts = wp_parse_args( $params, $defaults );
        if( strlen( $atts['mp4'] ) > 0 || strlen( $atts['ogg'] ) > 0 || strlen( $atts['webm'] ) > 0 ): ?>
            <video width="<?php echo absint($atts['width']);?>" height="<?php echo absint($atts['height']);?>" controls>
                <?php if( strlen( $atts['mp4'] ) > 0 ):?>
                    <source src="<?php echo esc_url( $atts['mp4'] );?>" type="video/mp4">
                <?php endif;?>
                <?php if( strlen( $atts['ogg'] ) > 0 ):?>
                    <source src="<?php echo esc_url( $atts['ogg'] );?>" type="video/ogg">
                <?php endif;?>
                <?php if( strlen( $atts['webm'] ) > 0 ):?>
                    <source src="<?php echo esc_url( $atts['webm'] );?>" type="video/webm">
                <?php endif;?>
                <?php esc_html_e( "Your browser does not support the video tag.", 'theshopier' );?>
            </video>
        <?php endif;
    }
}

if( !function_exists( 'theshopier_getAnimatedList' ) ) {

    function theshopier_getAnimatedList(){
        return array(
            esc_html__('- No animate -', 'theshopier')          => '',
            esc_html__("Bounce", 'theshopier')              => 'bounce',
            esc_html__("Pulse", 'theshopier')               => 'pulse',
            esc_html__("RubberBand", 'theshopier')          => 'rubberBand',
            esc_html__("Shake", 'theshopier')               => 'shake',
            esc_html__("Swing", 'theshopier')               => 'swing',
            esc_html__("Tada", 'theshopier')                => 'tada',
            esc_html__("Wobble", 'theshopier')              => 'wobble',
            esc_html__("Jello", 'theshopier')               => 'jello',
            esc_html__("BounceIn", 'theshopier')            => 'bounceIn',
            esc_html__("BounceInDown", 'theshopier')        => 'bounceInDown',
            esc_html__("BounceInLeft", 'theshopier')        => 'bounceInLeft',
            esc_html__("BounceInRight", 'theshopier')       => 'bounceInRight',
            esc_html__("BounceInUp", 'theshopier')          => 'bounceInUp',
            esc_html__("FadeIn", 'theshopier')              => 'fadeIn',
            esc_html__("FadeInDown", 'theshopier')          => 'fadeInDown',
            esc_html__("FadeInDownBig", 'theshopier')       => 'fadeInDownBig',
            esc_html__("FadeInLeft", 'theshopier')          => 'fadeInLeft',
            esc_html__("FadeInLeftBig", 'theshopier')       => 'fadeInLeftBig',
            esc_html__("FadeInRight", 'theshopier')         => 'fadeInRight',
            esc_html__("FadeInRightBig", 'theshopier')      => 'fadeInRightBig',
            esc_html__("FadeInUp", 'theshopier')            => 'fadeInUp',
            esc_html__("FadeInUpBig", 'theshopier')         => 'fadeInUpBig',
            esc_html__("Flip", 'theshopier')                => 'flip',
            esc_html__("FlipInX", 'theshopier')             => 'flipInX',
            esc_html__("FlipInY", 'theshopier')             => 'flipInY',
            esc_html__("LightSpeedIn", 'theshopier')        => 'lightSpeedIn',
            esc_html__("RotateIn", 'theshopier')            => 'rotateIn',
            esc_html__("RotateInDownLeft", 'theshopier')    => 'rotateInDownLeft',
            esc_html__("RotateInDownRight", 'theshopier')   => 'rotateInDownRight',
            esc_html__("RotateInUpLeft", 'theshopier')      => 'rotateInUpLeft',
            esc_html__("RotateInUpRight", 'theshopier')     => 'rotateInUpRight',
            esc_html__("SlideInUp", 'theshopier')           => 'slideInUp',
            esc_html__("SlideInDown", 'theshopier')         => 'slideInDown',
            esc_html__("SlideInLeft", 'theshopier')         => 'slideInLeft',
            esc_html__("SlideInRight", 'theshopier')        => 'slideInRight',
            esc_html__("ZoomIn", 'theshopier')              => 'zoomIn',
            esc_html__("ZoomInDown", 'theshopier')          => 'zoomInDown',
            esc_html__("ZoomInLeft", 'theshopier')          => 'zoomInLeft',
            esc_html__("ZoomInRight", 'theshopier')         => 'zoomInRight',
            esc_html__("ZoomInUp", 'theshopier')            => 'zoomInUp',
            esc_html__("Hinge", 'theshopier')               => 'hinge',
            esc_html__("RollIn", 'theshopier')              => 'rollIn',
        );
    }

}

if( class_exists('woocommerce') ) {

    if( !function_exists('theshopier_single_product_summary_footer_block') ) {
        function theshopier_single_product_summary_footer_block(){
            global $theshopier_datas;
            if( class_exists('Nexthemes_StaticBlock') && !empty($theshopier_datas['product-page-footer-block']) ) {
                Nexthemes_StaticBlock::getSticBlockContent( $theshopier_datas['product-page-footer-block'] );
            }
        }
    }


    if( !function_exists('theshopier_variable_option_html') ) {
        function theshopier_variable_option_html( $attribute_name, $options, $selected_attributes, $is_color = false ){
            global $product, $post;

            if ( is_array( $options ) ) {

                $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( stripslashes( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) ) : $product->get_variation_default_attribute( $attribute_name );

                ob_start();
                ?><div class="nth-variable-attr-swapper<?php if($is_color) echo " attr-color";?>"><?php
                if ( taxonomy_exists( $attribute_name ) ) {
                    $terms = wc_get_product_terms( $post->ID, $attribute_name, array( 'fields' => 'all' ) );

                    foreach ( $terms as $term ) {
                        if ( ! in_array( $term->slug, $options ) ) continue;
                        $_selected = strcmp( sanitize_title( $selected ), sanitize_title( $term->slug ) ) == 0? " selected": '';
                        if( $is_color ) {
                            $datas = get_term_meta( $term->term_id, "nth_pa_color", true );
                            $_style = isset( $datas ) && strlen( $datas ) > 0? "background-color: {$datas};": "background-color: #aaa";
                        } else {
                            $_style = '';
                        }
                        ?>
                        <div class="select-option<?php echo esc_attr($_selected);?>" style="<?php echo esc_attr($_style);?>" data-value="<?php echo esc_attr( $term->slug );?>"><?php echo apply_filters( 'woocommerce_variation_option_name', $term->name );?></div>
                        <?php
                    }

                } else {

                    foreach ( $options as $option ) {
                        $_selected = strcmp( sanitize_title( $selected ), sanitize_title( $option ) ) == 0? " selected": '';
                        ?>
                        <div class="select-option<?php echo esc_attr($_selected);?>" data-value="<?php echo esc_attr( sanitize_title( $option ) );?>"><?php echo esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) );?></div>
                        <?php
                    }

                }
                ?></div><?php
                return ob_get_clean();
            }
        }
    }

}

if( !function_exists('theshopier_comments_open') ) {
    function theshopier_comments_open( $open, $post_id ){
        $theshopier_pages = Theshopier::theshopier_getOption('page_options');
        $post = get_post( $post_id );
        if ( 'page' == $post->post_type ) {
            if( isset($theshopier_pages['nth_page_show_comments']) && absint($theshopier_pages['nth_page_show_comments']) ) $open = true;
            else $open = false;
        }

        return $open;
    }
}

if( !function_exists('theshopier_getSlideshow') ) {
    function theshopier_getSlideshow(){
        if(!is_page()) return '';
        $theshopier_pages = Theshopier::theshopier_getOption('page_options');
        switch( trim( $theshopier_pages['nth_slider_type'] ) ) {
            case 'metaslider':
                echo do_shortcode("[metaslider id=".absint($theshopier_pages['nth_meta_slider'])."]");
                break;
            case "revolution":
                echo do_shortcode("[rev_slider alias=".esc_attr($theshopier_pages['nth_rev_slider'])."]");
                break;
        }
    }
}

if( !function_exists('theshopier_get_post_options') ) {
    function theshopier_get_post_options($post_id, $slug = 'theshopier_post_options'){
        if( $post_options = get_post_meta( $post_id, $slug, true ) ) {
            $res = unserialize($post_options);
        } else $res = array('null');
        return $res;
    }
}


if( !function_exists('theshopier_pages_sidebar') ) {
    function theshopier_pages_sidebar_act($file = 'archive'){
        global $theshopier_datas;
        $theshopier_pages = Theshopier::theshopier_getOption('page_options');

        $_left = $_right = false;
        $_cont_class = ' col-sm-24';
        $_left_class = $_right_class = '';

        $_show_breadcrumb = !isset($theshopier_pages['nth_page_show_breadcrumb']) || absint($theshopier_pages['nth_page_show_breadcrumb']) == 1? 1:0;
        $_show_title = !isset($theshopier_pages['nth_page_show_title']) || absint($theshopier_pages['nth_page_show_title']) == 1? 1:0;

        if(!is_page()) {
            $_show_breadcrumb = 1;
            $_show_title = 1;
        }

        $res = array();
        switch($file){
            case 'shop':
                $_left_sidebar = isset($theshopier_datas['shop-left-sidebar'])? $theshopier_datas['shop-left-sidebar']: '';
                $_right_sidebar = isset($theshopier_datas['shop-right-sidebar'])? $theshopier_datas['shop-right-sidebar']: '';
                $_layout = !empty( $theshopier_datas['shop-layout'] )? explode( '-', $theshopier_datas['shop-layout'] ): false;
                $res['_prod_cat_infomation'] = !empty($theshopier_datas['nth-cat-infomation'])? $theshopier_datas['nth-cat-infomation']: '';
                break;
            case 'single_prod':
                $_left_sidebar = isset($theshopier_datas['product-page-left-sidebar'])? $theshopier_datas['product-page-left-sidebar']: '';
                $_right_sidebar = isset($theshopier_datas['product-page-right-sidebar'])? $theshopier_datas['product-page-right-sidebar']: '';
                $_layout = !empty( $theshopier_datas['product-page-layout'] )? explode( '-', $theshopier_datas['product-page-layout'] ): false;
                break;
            case 'blog':
                if(isset($theshopier_pages['nth_page_leftsidebar'])) {
                    $_left_sidebar = $theshopier_pages['nth_page_leftsidebar'];
                } elseif(isset($theshopier_datas['blog-left-sidebar'])){
                    $_left_sidebar = $theshopier_datas['blog-left-sidebar'];
                } else $_left_sidebar = '';

                if(isset($theshopier_pages['nth_page_rightsidebar'])) {
                    $_right_sidebar = $theshopier_pages['nth_page_rightsidebar'];
                } elseif(isset($theshopier_datas['blog-right-sidebar'])){
                    $_right_sidebar = $theshopier_datas['blog-right-sidebar'];
                } else $_right_sidebar = '';

                if(!empty( $theshopier_pages['nth_page_layout'] ) && is_page()) {
                    $_layout_str = $theshopier_pages['nth_page_layout'];
                } elseif(!empty($theshopier_datas['blog-layout'])) {
                    $_layout_str = $theshopier_datas['blog-layout'];
                } else $_layout_str = '';

                $_layout = strlen($_layout_str) > 0? explode( '-', $_layout_str ): false;

                $res['_blog_cols'] = !empty($theshopier_pages['nth_blog_columns'])? absint($theshopier_pages['nth_blog_columns']): 3;
                break;
            default:
                $_left_sidebar = isset($theshopier_pages['nth_page_leftsidebar'])? $theshopier_pages['nth_page_leftsidebar']: '';
                $_right_sidebar = isset($theshopier_pages['nth_page_rightsidebar'])? $theshopier_pages['nth_page_rightsidebar']: '';
                $_layout = !empty( $theshopier_pages['nth_page_layout'] )? explode( '-', $theshopier_pages['nth_page_layout'] ): false;

        }

        if( $_layout ) {
            if( absint( $_layout[0] ) ) {
                $_left = true;
                $_left_class = " col-sm-7 col-lg-6";
                $_cont_class = " col-sm-17 col-lg-18";
            }
            if( absint( $_layout[1] ) ) {
                $_right = true;
                $_right_class = " col-sm-7 col-lg-6";
                $_cont_class = " col-sm-17 col-lg-18";
            }
            if( $_right && $_left ) $_cont_class = " col-sm-10 col-lg-12";
        }
        $res['_left_class']     = $_left_class;
        $res['_cont_class']     = $_cont_class;
        $res['_right_class']    = $_right_class;
        $res['_left_sidebar']   = $_left_sidebar;
        $res['_right_sidebar']  = $_right_sidebar;
        $res['_show_breadcrumb'] = $_show_breadcrumb;
        $res['_show_title']     = $_show_title;

        if( !empty( $theshopier_pages["page_temp_per_page"] ) ) {
            $res['_per_page'] = absint($theshopier_pages["page_temp_per_page"]);
        }
        if(!empty($theshopier_pages["nth_album_style"])) $res['_album_style'] = $theshopier_pages["nth_album_style"];

        return $res;
    }
}

function theshopier_content_before_title_action(){
    global $theshopier_datas;

    $_thumb_size = apply_filters( "theshopier_post_content_loop_thumbnail",'theshopier_blog_thumb' ) ;
    $_use_thumb = apply_filters("theshopier_post_content_loop_show_thumbnail", false);
    $_use_meta_author = apply_filters("theshopier_post_content_loop_show_author", true);
    $class = apply_filters("theshopier_post_content_loop_class", array( 'post-item' ));
    $_use_cats = apply_filters("theshopier_post_content_loop_show_cats", true);
    $_use_button = !isset($theshopier_datas['blog-readmore-button']) || absint($theshopier_datas['blog-readmore-button'])? true: false;
    $_use_button = apply_filters("theshopier_post_content_loop_show_button", $_use_button);
    $_use_excerpt = apply_filters("theshopier_post_content_loop_show_excerpt", true);
    $columns = apply_filters("theshopier_post_content_loop_columns", 1);

    if(is_sticky()) $class[] = 'nth-sticky-post';

    return array(
        '_class'        => $class,
        '_thumb_size'  => $_thumb_size,
        '_use_thumb'  => $_use_thumb,
        '_use_meta_author'  => $_use_meta_author,
        '_use_cats'  => $_use_cats,
        '_use_button'  => $_use_button,
        '_use_excerpt'  => $_use_excerpt,
        '_blog_cols'  => $columns,
        '_excerpt_lenght'   => !empty($theshopier_datas['blog-excerpt-length'])? absint($theshopier_datas['blog-excerpt-length']): 0,
    );
}

if( !function_exists('theshopier_check_device') ) {
    function theshopier_check_device($act = 'arr'){
        if( class_exists('Mobile_Detect') ) {
            global $detect;
            switch($act){
                case 'xs':
                    $res = ($detect->isMobile() && !$detect->isTablet())? true: false;
                    break;
                case 'md':
                    $res = $detect->isMobile()? true: false;
                    break;
                case 'lg':
                    $res = $detect->isMobile()? false: true;
                    break;
                default:
                    $res = array(
                        'xs' => ($detect->isMobile() && !$detect->isTablet()),
                        'md' => $detect->isMobile(),
                        'lg' => !$detect->isMobile()
                    );

            }
            return $res;
        } else return false;

    }
}

function theshopier_get_404_content(){
    global $theshopier_datas;
    if(!empty( $theshopier_datas['404page-stblock'] ) && class_exists('Nexthemes_StaticBlock')) {
        Nexthemes_StaticBlock::getSticBlockContent( $theshopier_datas['404page-stblock'] );
    }
}

function theshopier_custom_video_size( $data ){
    $theshopier_pages = Theshopier::theshopier_getOption('page_options');
    $data['width'] =  !empty($theshopier_pages['nth_blog_v_size']['width'])? absint($theshopier_pages['nth_blog_v_size']['width']) : 370;
    $data['height'] = !empty($theshopier_pages['nth_blog_v_size']['height'])? absint($theshopier_pages['nth_blog_v_size']['height']) : 225;
    return $data;
}

function theshopier_main_footer_class_action( $classes = array() ){
    global $theshopier_datas;
    if( isset($theshopier_datas['layout-footer']) ) {
        if( strcmp(trim($theshopier_datas['layout-footer']), 'container') == 0 ) $classes['_row_class'][] = 'row';
        $classes['_class_cont'][] = esc_attr($theshopier_datas['layout-footer']);
    }
    return $classes;
}

add_filter('theshopier_main_footer_class', 'theshopier_main_footer_class_action', 1, 1);

function theshopier_main_header_class_action( $classes = array() ){
    global $theshopier_datas;
    if(!empty($theshopier_datas['layout-main'])) $classes['main_content_wrap_class'][] = esc_attr($theshopier_datas['layout-main']);
    $header_style = isset( $theshopier_datas['header-style'] )? esc_attr( $theshopier_datas['header-style'] ): "1";
    $classes['header_class'][] = 'header-'. $header_style;
    if( isset($theshopier_datas['layout-header']) ) {
        if(strcmp('container', $theshopier_datas['layout-header']) == 0) $classes['header_row_class'][] = 'row';
        $classes['header_class'][] = esc_attr($theshopier_datas['layout-header']);
    }
    $classes['header_style'] = $header_style;

    if( isset($theshopier_datas['layout-body']) ) {
        if( strcmp(trim($theshopier_datas['layout-body']), 'container') == 0 ) $classes['main_content_row_class'][] = 'row';
        $classes['main_content_class'][] = esc_attr($theshopier_datas['layout-body']);
    }

    return $classes;
}
add_filter('theshopier_main_header_class', 'theshopier_main_header_class_action', 10, 1);

function theshopier_get_themeoptions_by_key($k = ''){
    global $theshopier_datas;
    if(strlen(trim($k)) > 0 && !empty($theshopier_datas[$k])) return $theshopier_datas[$k];
    else return false;
}

/***** COMPARE ****/

if( !function_exists('theshopier_compare_object') ) {
    function theshopier_compare_object(){
        $fontend = array();
        if( class_exists( 'YITH_Woocompare' ) ) {
            global $yith_woocompare;
            $fontend = $yith_woocompare->obj;
        }
        return $fontend;
    }
}

if( !function_exists('theshopier_wp_kses_data') ) {
    function theshopier_wp_kses_data(){
        $html_tags = array('strong', 'span', 'a', 'img', 'i', 'div');
        $html_al = array();
        foreach($html_tags as $k){
            $html_al[$k] = array('class' => array(), 'style' => array());
            switch($k) {
                case 'a':
                    $html_al[$k]['title'] = array();
                    $html_al[$k]['href'] = array();
                    break;
                case 'img':
                    $html_al[$k]['alt'] = array();
                    $html_al[$k]['src'] = array();
                    $html_al[$k]['width'] = array();
                    $html_al[$k]['height'] = array();
                    break;
            }
        }
        return $html_al;
    }
}