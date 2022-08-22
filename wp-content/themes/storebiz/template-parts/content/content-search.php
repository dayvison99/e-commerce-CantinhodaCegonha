<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Storebiz
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-items post-grid post-single'); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="post-image">
			<div class="featured-image">
				<a href="javascript:void(0);" class="post-hover">
					<?php the_post_thumbnail(); ?>
				</a>
			</div>
		</figure>
	<?php endif; ?>		
	<div class="post-content">
		<div class="post-meta">
			<div>
				<span class="post-date">
					<a href="<?php echo esc_url(get_month_link(get_post_time('Y'),get_post_time('m'))); ?>"><span><?php echo esc_html(get_the_date('j')); ?></span> <?php echo esc_html(get_the_date('M')); ?></a>
				</span>
			</div>
		</div>
		<?php 
			if ( is_single() ) :
				
			the_title('<h5 class="post-title">', '</h5>' );
			
			else:
			
			the_title( sprintf( '<h5 class="post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' );
			
			endif; 
			
			the_content( 
					sprintf( 
						__( 'Read More', 'storebiz' ), 
						'<span class="screen-reader-text">  '.esc_html(get_the_title()).'</span>' 
					) 
				);
		?>
	</div>
	<div class="post-meta post-footer">
		<span class="author-name">
			<?php  $user = wp_get_current_user(); ?>
			<a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) ));?>" title="<?php esc_attr(the_author()); ?>" class="author meta-info"><i class="fa fa-user"></i> <span class="author-name"><?php esc_html(the_author()); ?></span></a>
		</span>
		<span class="post-list">
			<ul class="post-categories">
				<li><a href="<?php echo esc_url(get_permalink());?>"><i class="fa fa-copy"></i><?php the_category(', '); ?></a></li>
			</ul>
		</span>
	</div>
</article>