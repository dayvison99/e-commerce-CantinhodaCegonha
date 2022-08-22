<?php
	if( class_exists( 'MetaSliderPlugin' ) ) {
		$metaslider = new MetaSliderPlugin();
	}
	
	$page_options = unserialize( get_post_meta( get_the_ID(), 'theshopier_page_options', true ) );
?>

<div class="page_config_wrapper">
	<div class="page_config_wrapper_inner">
		
		<div class="nth_be_tabs">
			<ul class="nth_be_tabs_head">
				<li class="nth_item_head current"><a href="#tab-1"><?php esc_html_e( 'General', 'theshopier' );?></a></li>
				<li class="nth_item_head"><a href="#tab-2"><?php esc_html_e( 'Layout', 'theshopier' );?></a></li>
				<li class="nth_item_head"><a href="#tab-slideshow"><?php esc_html_e( 'Slideshow', 'theshopier' );?></a></li>
			</ul>
			<div class="nth_be_tabs_content">
				<div id="tab-1" class="active nth_item_cont">content tab 1</div>
				<div id="tab-2" class="nth_item_cont">content tab 2</div>
				<div id="tab-slideshow" class="nth_item_cont">
					<ul class="list-options list-slider">
						<li>
							<p>
								<label><?php esc_html_e('Slider type','theshopier' );?> : </label>
								<select name="nth_slider_type" id="nth_slider_type">
									<option value="def" <?php if( strcmp($page_options['nth_slider_type'],'def') == 0 ) echo "selected";?>>Default</option>
									<option value="metaslider" <?php if( strcmp($page_options['nth_slider_type'],'metaslider') == 0 ) echo "selected";?>>Meta slider</option>
								</select>
							</p>
						</li>
						
						<li>
							<p>
								<label><?php esc_html_e('Meta Slider','theshopier' );?> : </label>
								<select name="nth_meta_slider" id="nth_meta_slider">
								<?php foreach( $metaslider->all_meta_sliders() as $item ){ ?>
									<option value="<?php echo absint( $item['id'] );?>" <?php selected(absint($page_options['nth_meta_slider']), absint($item->id)); ?>><?php echo esc_html($item['title']);?></option>
								<?php }?>
								</select>
								
							</p>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<?php wp_nonce_field( "_UPDATE_PAGE_OPTION_", "nth_nonce_page_options" ); ?>
	</div>
</div>
