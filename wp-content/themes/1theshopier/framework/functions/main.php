<?php

if( !function_exists( 'theshopier_list_comments' ) ) {
	
	function theshopier_list_comments($comment, $args, $depth){
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) {
			case '' :
				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
						
						<div class="comment-author vcard">
							<?php echo get_avatar( $comment, 70 ); ?>
						</div><!-- .comment-author .vcard -->
						
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation bg-warning"><?php esc_html_e( 'Your comment is awaiting moderation.', 'theshopier' ); ?></em>
						<br />
						<?php endif;?>
						
						<div class="comment-meta commentmetadata">
							<h3 class="comment-author"><span><?php echo get_comment_author_link();?></span></h3>
							<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php printf( esc_html__('%1$s at %2$s', 'theshopier'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'theshopier' ), '  ', '' );?>
							
							<div class="pull-right">
								<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fa fa-reply"></i> ' . esc_html__('Reply', 'theshopier') ) ) ); ?>
							</div>
						</div>
						
						<?php comment_text(); ?>
						
						<div class="clearfix"></div>
						
					</div><!-- #comment-##  -->
				<?php 
				break;
		}
	}
	
}

add_action('theshopier_footer_before_body_endtag', 'theshopier_newsletter_popup_callback', 10);

if( !function_exists('theshopier_newsletter_popup_callback') ) {

	function theshopier_newsletter_popup_callback(){
		global $theshopier_datas;

		if( !isset($theshopier_datas['newsletter-popup']) || absint($theshopier_datas['newsletter-popup']) == 0 ) return '';
		if( empty($theshopier_datas['newsletter-popup-content']) ) return '';
		if( !class_exists('Nexthemes_StaticBlock') ) return '';

		$options = array(
			'width' => '570'
		);

		?>
		<a href="#nth_newsletter_popup" title="Newsletter popup" data-pp_width="570" class="hidden" id="nth_newsletter_popup_open">open popup</a>
		<div style="position: fixed; visibility: hidden;" id="nth_newsletter_popup">
			<div class="animated flipInX nth-popup nth-newsletter popup-wrapper">
				<div class="popup-content">
					<?php echo Nexthemes_StaticBlock::getSticBlockContent(esc_attr($theshopier_datas['newsletter-popup-content']));?>
				</div>
				<div class="popup-footer">
					<a href="#" class="popup-cookie-close text-color2" title="<?php esc_attr_e("Don't show it again", 'theshopier')?>" data-time="1"><?php esc_html_e("Don't show it again", 'theshopier')?></a>
				</div>
			</div>
		</div>
		<?php

		/*$_link = admin_url('admin-ajax.php') . "?ajax=true&action=nth_get_newsletter_popup&slug=".esc_attr($theshopier_datas['newsletter-popup-content']);
		?>
		<a href="<?php echo esc_url($_link);?>" title="Newsletter popup" class="hidden" id="nth_newsletter_popup_open">open popup</a>
		<?php */

	}

}