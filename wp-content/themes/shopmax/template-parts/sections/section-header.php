<?php 
if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" id="custom-header" rel="home">
		<img src="<?php esc_url(header_image()); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr(get_bloginfo( 'title' )); ?>">
	</a>	
<?php endif; 
$shopmax_hs_nav_search		=	get_theme_mod('hs_nav_search','1');
$shopmax_hs_nav_account		=	get_theme_mod('hs_nav_account','1');
?>
<!--===// Start: Main Header
=================================-->
<header id="main-header" class="main-header">
        <?php do_action('storebiz_above_header'); ?>
		<div class="navigation-middle">
			<div class="container">
				<div class="row navigation-middle-row">
					<div class="col-lg-3 col-12 text-lg-left text-center my-auto mb-lg-auto mt-lg-auto mt-3 mb-3">
						<div class="logo">
						   <?php 
								if(has_custom_logo())
								{	
									the_custom_logo();
								}
								else { 
								?>
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
									<h4 class="site-title">
										<?php 
											echo esc_html(get_bloginfo('name'));
										?>
									</h4>
								</a>	
							<?php 						
								}
							?>
							<?php
								$shopmax_site_desc = get_bloginfo( 'description');
								if ($shopmax_site_desc) : ?>
									<p class="site-description"><?php echo esc_html($shopmax_site_desc); ?></p>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-lg-6 col-12 text-center my-auto mb-lg-auto mb-2">
						<?php if (class_exists('WooCommerce') && ($shopmax_hs_nav_search =='1') ) { ?>
							<div class="header-search-form">
								<form method="get" action="<?php echo esc_url(home_url('/')); ?>">
									<select class="header-search-select" name="product_cat">
										<option value=""><?php esc_html_e('Select Category', 'shopmax'); ?></option> 
										<?php
										$shopmax_categories = get_categories('taxonomy=product_cat');
										foreach ($shopmax_categories as $shopmax_product_category) {
											$shopmax_option = '<option value="' . esc_attr($shopmax_product_category->category_nicename) . '">';
											$shopmax_option .= esc_html($shopmax_product_category->cat_name);
											$shopmax_option .= ' (' . absint($shopmax_product_category->category_count) . ')';
											$shopmax_option .= '</option>';
											echo $shopmax_option; // WPCS: XSS OK.
										}
										?>
									</select>
									<input type="hidden" name="post_type" value="product" />
									<input class="header-search-input" name="s" type="text" placeholder="<?php esc_attr_e('Find Your products...', 'shopmax'); ?>"/>
									<button class="header-search-button" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
								</form>
							</div>
						<?php } ?>
					</div>
					<div class="col-lg-3 col-12 text-lg-right text-center my-auto mb-lg-auto mb-2">
						<div class="main-menu-right">
							<ul class="menu-right-list">
								<?php 
								 if ( class_exists( 'WooCommerce' ) ) { 
								 if($shopmax_hs_nav_account =='1') { ?>
									<li class="user">
										<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="user-btn"><svg xmlns="http://www.w3.org/2000/svg" width="22.69" height="25.594"><path d="M22.68 23.327a12.112 12.112 0 00-.96-4.589 11.635 11.635 0 00-6.6-6.374 7.048 7.048 0 001.15-10.083 6.406 6.406 0 00-9.12-.736 6.525 6.525 0 00-2.31 4.453 6.943 6.943 0 002.75 6.359 11.718 11.718 0 00-5.5 4.327 12.014 12.014 0 00-2.08 6.643v1.026a1.217 1.217 0 001.19 1.233h20.06a1.452 1.452 0 001.42-1.476v-.783zM6.57 6.787a4.773 4.773 0 114.77 4.931 4.843 4.843 0 01-4.77-4.931zM4.29 16.804a9.176 9.176 0 016.19-3.192 8.932 8.932 0 016.15 1.622 9.953 9.953 0 014.29 8.093H1.78a10 10 0 012.51-6.523z" fill-rule="evenodd"/></svg></a>
									</li>
								<?php } ?>
								<?php
									$shopmax_hide_show_cart       = get_theme_mod( 'hide_show_cart','1'); 
									if($shopmax_hide_show_cart == '1') { ?>
										<li class="cart-wrapper">
											<div class="cart-main">
												<button type="button" class="cart-icon-wrap header-cart">
													<svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"><path data-name="Cart Icon" d="M20.04 18.422h-9.55m-1.12-.024c-.45 0-.76.009-1.08 0a2.246 2.246 0 01-2.06-1.526 2.213 2.213 0 01.79-2.593.669.669 0 00.31-.855C6.45 9.497 5.59 5.566 4.72 1.56H2.3c-.51 0-1.01.024-1.51-.011A.752.752 0 010 .778.721.721 0 01.78.012c1.49-.019 2.98-.013 4.47 0a.814.814 0 01.84.74c.16.76.34 1.516.52 2.327h18.07c.18 0 .35-.01.52.006a.777.777 0 01.76 1.048c-.99 3.517-2 7.031-3 10.545a.962.962 0 01-1.13.676q-6.465-.013-12.95 0c-.19 0-.39 0-.58.014a.675.675 0 00-.66.685.7.7 0 00.6.8 3.061 3.061 0 00.63.031H22.06a.8.8 0 01.89.78.779.779 0 01-.88.741h-.91m-12.18-4.61c.15.015.23.03.3.03 3.97 0 7.93 0 11.9.012a.518.518 0 00.58-.481c.63-2.284 1.29-4.563 1.93-6.845.18-.611.35-1.222.53-1.865H6.96c.67 3.054 1.34 6.086 2.02 9.145zm11.16 6.2c1.49.7 2.05 1.693 1.81 3.011a2.336 2.336 0 01-2.21 1.987 2.39 2.39 0 01-2.41-1.827c-.34-1.253.19-2.285 1.64-3.149m-8.98 0c1.45.752 1.98 1.741 1.69 3.07a2.356 2.356 0 01-2.34 1.914 2.423 2.423 0 01-2.29-1.91c-.29-1.228.29-2.32 1.77-3.1m.5 3.318a.81.81 0 00.06-1.618.78.78 0 00-.78.853.73.73 0 00.72.765zm11.07-.761a.74.74 0 00-.75-.847.726.726 0 00-.78.769.752.752 0 00.78.836.717.717 0 00.75-.758z" fill-rule="evenodd"/></svg>
													<?php 
														if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
															$shopmax_product_count = WC()->cart->cart_contents_count;
															$storebiz_cart_url = wc_get_cart_url();
															
															if ( $shopmax_product_count > 0 ) {
															?>
																 <span><?php echo esc_html( $shopmax_product_count ); ?></span>
															<?php 
															}
															else {
																?>
																<span><?php esc_html_e('0','shopmax'); ?></span>
																<?php 
															}
														}
													?>
												</button>
												<span class="cart-label">
													<?php 
														if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
															$shopmax_product_count = WC()->cart->cart_contents_count;
															$storebiz_cart_url = wc_get_cart_url();
															
															if ( $shopmax_product_count > 0 ) {
															?>
																 <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
															<?php 
															}
															else {
																?>
																<span><?php esc_html_e('0','shopmax'); ?></span>
																<?php 
															}
														}
													?>
												</span>
											</div>
											<!-- Shopping Cart -->
											<div class="shopping-cart">
												<ul class="shopping-cart-items">
													<?php get_template_part('woocommerce/cart/mini','cart'); ?>
												</ul>
											</div>
											<!--end shopping-cart -->
										</li>
									<?php } } ?>
							</ul>                            
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="navigation-wrapper">
            <!--===// Start: Main Desktop Navigation
            =================================-->
            <div class="main-navigation-area d-none d-lg-block">
	            <div class="main-navigation <?php echo esc_attr(storebiz_sticky_menu()); ?>">
	            	<div class="container">
		                <div class="row g-3">
		                    <div class="col-3">
		                    	<div class="main-menu-left w-full">
		                    		<div class="left-banner">
				                    	<div class="button-area">
											<?php do_action('storebiz_header_offer'); ?>
										</div>
									</div>
								</div>
		                    </div>
		                    <div class="col-9">
		                        <nav class="navbar-area">
		                            <div class="main-navbar">
		                               <?php 
											wp_nav_menu( 
											array(  
												'theme_location' => 'primary_menu',
												'container'  => '',
												'menu_class' => 'main-menu',
												'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
												'walker' => new WP_Bootstrap_Navwalker()
												 ) 
											);
									   ?>                            
		                            </div>
		                        </nav>
		        			</div>
		            	</div>
	    			</div>
	    		</div>
	    	</div>
	    	<!--===// Start: Main Mobile Navigation
            =================================-->
            <div class="main-mobile-nav <?php echo esc_attr(storebiz_sticky_menu()); ?>"> 
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="main-mobile-menu">
								<div class="main-menu-right main-mobile-left">
									<ul class="menu-right-list">
										<li class="button-area">
											<?php do_action('storebiz_header_offer'); ?>
										</li> 
									</ul>                            
								</div>
                                <div class="menu-collapse-wrap">
                                    <div class="hamburger-menu">
                                        <button type="button" class="menu-collapsed" aria-label="<?php esc_attr_e('Menu Collapsed','shopmax'); ?>">
                                            <div class="top-bun"></div>
                                            <div class="meat"></div>
                                            <div class="bottom-bun"></div>
                                        </button>
                                    </div>
                                </div>
                                <div class="main-mobile-wrapper">
                                    <div id="mobile-menu-build" class="main-mobile-build">
                                        <button type="button" class="header-close-menu close-style" aria-label="<?php esc_attr_e('Header Close Menu','shopmax'); ?>"></button>
                                    </div>
                                </div>
                                <div class="header-above-wrapper">
                                	<div class="header-above-index">
	                                	<div class="header-above-btn">
		                                    <button type="button" class="header-above-collapse" aria-label="<?php esc_attr_e('Header Above Collapse','shopmax'); ?>"><span></span></button>
		                                </div>
	                                    <div id="header-above-bar" class="header-above-bar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
            </div>
            <!--===// End: Main Mobile Navigation
            =================================-->
        </div>
    	<!--===// End:  Main Desktop Navigation
		=================================-->
</header>
<!-- End: Main Header
=================================-->