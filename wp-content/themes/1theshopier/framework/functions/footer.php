<?php 

add_action( 'theshopier_footer_init', 'theshopier_footer_1', 10 );

add_action( 'theshopier_footer_init', 'theshopier_footer_copyright', 10 );

function theshopier_footer_1(){
    global $theshopier_datas;

	if( isset( $theshopier_datas["footer-stblock"] ) && strlen( $theshopier_datas["footer-stblock"] ) > 0 && class_exists("Nexthemes_StaticBlock") ){
		$header_style = isset( $theshopier_datas['header-style'] )? esc_attr( $theshopier_datas['header-style'] ): "1";
		if( empty($theshopier_datas['footer-width']) ) $contai_class = 'container';
		else $contai_class = esc_attr($theshopier_datas['footer-width']);
	?>
	<div class="footer-1">
		<div class="<?php echo esc_attr($contai_class);?>">
	<?php 
		if( class_exists( 'Nexthemes_StaticBlock' ) ) {
            Nexthemes_StaticBlock::getSticBlockContent( $theshopier_datas["footer-stblock"] );
		} else {
            'Please enable "<strong>Static Block</strong>" on Nexthemes setting.';
		}
	?>
		</div>
	</div>
	<?php 
	}
}

function theshopier_footer_copyright(){
	global $theshopier_datas;

	if(isset($theshopier_datas['footer-copyright-switch']) && absint($theshopier_datas['footer-copyright-switch']) == 0) return;

	if( empty($theshopier_datas['footer-width']) ) $contai_class = 'container';
	else $contai_class = esc_attr($theshopier_datas['footer-width']);
	?>
	<div class="footer-copyright">
		<div class="<?php echo esc_attr($contai_class);?>">
			<div class="row">
				
				<?php
				if( isset($theshopier_datas["footer-copyright-text"]) && strlen( trim( $theshopier_datas["footer-copyright-text"] ) ) > 0 ) {
					echo do_shortcode( $theshopier_datas["footer-copyright-text"] );
				} else { ?>
					<div class="col-sm-12">
						<div class="display-table">
							<div class="table-cell" style="min-width: 61px;">
								<?php
								theshopier_getImage(array(
									'src'	=> 'http://demo.nexthemes.com/wordpress/theshopier/home1/wp-content/uploads/2015/11/footer-copyright-logo.png',
									'alt'	=> esc_attr__('footer copyright logo', 'theshopier'),
									'class'	=> 'size-full wp-image-227'
								));
								?>
							</div>
							<div class="table-cell"><strong>Theshopier</strong> &copy; 2015 powered by Wordpress &trade;. All rights reserved</div>
						</div>
					</div>
					<div class="col-sm-12" style="line-height: 51px; text-align: right;">
						<?php
						theshopier_getImage(array(
							'src'	=> 'http://demo.nexthemes.com/wordpress/theshopier/home1/wp-content/uploads/2015/11/footer-copyright-payment.png',
							'alt'	=> esc_attr__('footer copyright payment', 'theshopier'),
							'class'	=> 'size-full wp-image-227'
						));
						?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<a href="javascript:void(0);" class="back_to_top button hidden-sm hidden-md hidden-lg hidden"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
	<?php 
}

