<?php
/**
 * The template used for displaying page content
 */

$post_options = theshopier_get_post_options(get_the_ID());

$content_datas = theshopier_content_before_title_action();
extract($content_datas);

$__columns = 1;
if(isset($theshopier_blog_cols) && absint($theshopier_blog_cols) > 1) {
	$__columns = absint($theshopier_blog_cols);
} elseif(isset($_blog_cols) && absint($_blog_cols) > 1) {
	$__columns = absint($_blog_cols);
}

if( (isset($__columns) && absint($__columns) > 1) ) {
	$_class[] = 'col-lg-' . round( 24 /$__columns );
	$_class[] = 'col-md-' . round( 24 / round( $__columns * 992 / 1200) );
	$_class[] = 'col-sm-' . round( 24 / round( $__columns * 768 / 1200) );
	$_class[] = 'col-xs-' . round( 24 / round( $__columns * 480 / 1200) );
	$_class[] = 'col-mb-24';
} else {
	if(!isset($shortcode_style)) {
		$_class[] = 'col-sm-24';
	}
}

?>
	
<li <?php post_class( implode( ' ', $_class ) );?>>
	<div class="post-item-content">

		<?php if( $_use_thumb ): ?>

			<?php if( has_post_thumbnail() ):?>
			<div class="post-thumbnail">
				<a class="nth-thumbnail" href="<?php the_permalink() ; ?>">
					<?php the_post_thumbnail( $_thumb_size, array('class' => 'thumbnail-blog')); //blog_thumb ?>
				</a>
			</div>
			<?php endif;?>

		<?php else: ?>

			<?php if( isset($post_options['nth_audio_embed']) ): ?>

			<div class="post-thumbnail">
				<?php echo stripslashes(htmlspecialchars_decode($post_options['nth_audio_embed']));?>
			</div>

			<?php endif; ?>

		<?php endif; ?>

		<div class="post-content">

			<?php if(is_sticky()): ?>

				<span class="nth-post-icon fa fa-thumb-tack"></span>

			<?php endif; ?>

			<div class="post-heading">
				<div class="entry-date">
					<span class="entry-month"><?php echo get_the_date('M')?></span>
					<span class="entry-day"><?php echo get_the_date('d')?></span>
				</div>

				<h3 class="post-title"><a class="post-title-a" href="<?php the_permalink() ; ?>"><?php the_title(); ?></a></h3>
				<?php edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>

				<div class="post-meta">
					<?php if( $_use_meta_author ): ?>
					<div class="author"><?php esc_html_e('By', 'theshopier' );?> <?php the_author_posts_link(); ?></div>
					<?php endif;?>

					<?php if( $_use_cats ): ?>
					<div class="categories"><?php echo get_the_category_list(', ');?></div>
					<?php endif;?>
				</div>
			</div>

			<?php if($_use_excerpt):?>
			<div class="short-content">
				<?php
				if( isset($excerpt_words) && absint($excerpt_words) > 0 ) {
					theshopier_the_excerpt(absint($excerpt_words));
				} elseif( isset($_excerpt_lenght) && absint($_excerpt_lenght) > 0 ){
					theshopier_the_excerpt(absint($_excerpt_lenght));
				} else {
					the_excerpt();
				}
				?>
			</div>
			<?php endif;?>

			<?php
			if( $_use_button ) {
				$read_more_str = '<div class="read-more"><a class="button" title="%1$s" href="%2$s">%1$s</a></div>';
				if(!empty($__post_data)) {
					$_styles = explode(' ', $__post_data['style']);
					if(in_array('bt_link_style', $_styles)) {
						$read_more_str = '<div class="read-more text-right"><a title="%1$s" href="%2$s">%1$s</a></div>';
					}
				}

				printf($read_more_str, esc_attr__('Read more','theshopier' ), esc_url(get_the_permalink()));
			}
			?>

		</div>
	</div>
</li>