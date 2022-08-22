<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

$post_options = theshopier_get_post_options(get_the_ID());

$_thumb_size = 'theshopier_blog_thumb_widget';
$__post_data = isset($__post_data)? $__post_data: array(
	'hidden_date'	=> 0
);
extract($__post_data);
if( !isset($w_style) || absint($w_style) == 1 ){
	$is_thumb = true;
	$_is_excerpt = false;
} else {
	$is_thumb = false;
	$_is_excerpt = true;
}
?>

<li <?php post_class("post-item");?>>

	<?php if( has_post_thumbnail() && $is_thumb ) : ?>
	<div class="post-thumbnail">
		<a class="nth-thumbnail" title="<?php the_title();?>" href="<?php the_permalink() ; ?>">
			<?php the_post_thumbnail( $_thumb_size, array('class' => 'thumbnail-blog')); ?>
		</a>
	</div>
	<?php endif;?>

	<h3 class="post-title"><a title="<?php the_title();?>" href="<?php echo get_permalink();?>"><?php the_title();?></a></h3>

	<?php if( $_is_excerpt ) :?><p class="short-content"><?php theshopier_the_excerpt($excerpt_words); ?></p><?php endif;?>

	<div class="post-meta">
		<span class="author"><?php esc_html_e('By', 'theshopier' );?> <?php the_author_posts_link(); ?></span>
		<?php if( !isset($hidden_date) || !absint($hidden_date) ):?>
		<span class="date"><?php echo get_the_date();?></span>
		<?php endif;?>
	</div>

</li>