<?php
/**
 * The template for displaying all single posts
 *
 */

get_header();

$sidebar_data = theshopier_pages_sidebar_act('blog');
extract( $sidebar_data );

$datas = array();
do_action( 'theshopier_breadcrumb', $datas );

?>

	<div id="container" class="container single-post">
		<div id="content" class="site-content row" role="main">
			
			<?php if( strlen(trim($_left_class)) > 0 ):?>
			<div class="nth-content-left nth-sidebar<?php echo esc_attr( $_left_class );?>">
				<?php if( is_active_sidebar( $_left_sidebar ) ):?>
				<ul class="widgets-sidebar">
					<?php dynamic_sidebar( $_left_sidebar ); ?>
				</ul>
				<?php else:
					esc_html_e( "Please add some widgets here!", 'theshopier' );
				endif;?>
			</div><!-- .nth-content-left -->
			<?php endif;?>
			
			
			<div class="nth-content-main<?php echo esc_attr( $_cont_class );?>">
				
				<div class="content-inner">
			
				<?php if( have_posts() ):?>
				<?php while ( have_posts() ) : the_post(); ?>
					
					<div <?php post_class("single-post");?>>
					
						<?php 
						switch( get_post_format() ) {
							
							case "video":
								$post_options = Theshopier::theshopier_getOption('post_options');
								if( isset($post_options['nth_source_type']) ):
									if( strcmp( trim($post_options['nth_source_type']), 'online' ) == 0 ):?>
								<div class="post-thumbnail post-video">
								<?php theshopier_video_player( array('url'	=> trim($post_options['nth_onl_url'])) );?>
								</div>
								<?php else:?>
								<div class="post-thumbnail post-video">
								<?php 
									$local_args = array();
									if( isset( $post_options['nth_mp4_url'] ) ) $local_args['mp4'] = trim($post_options['nth_mp4_url']);
									if( isset( $post_options['nth_ogg_url'] ) ) $local_args['ogg'] = trim($post_options['nth_ogg_url']);
									if( isset( $post_options['nth_webm_url'] ) ) $local_args['webm'] = trim($post_options['nth_webm_url']);
									theshopier_video_local_player( $local_args );
								?>	
								</div>
								<?php 
									endif;
								endif;
								break;
							case "audio":
								$post_data = Theshopier::theshopier_getOption('post_options');

								if( isset($post_data['nth_audio_embed']) && strlen($post_data['nth_audio_embed']) > 0 ): ?>
								<div class="post-thumbnail post-audio">
									<?php echo stripslashes(htmlspecialchars_decode($post_data['nth_audio_embed']));?>
								</div>
								<?php endif;
								break;
							default:
								$post_data = Theshopier::theshopier_getOption('post_options');
								if(!empty($post_data['nth_post_shortcode'])) : ?>
								<div class="post-thumbnail">
									<?php echo do_shortcode(stripslashes(htmlspecialchars_decode($post_data['nth_post_shortcode'])));?>
								</div>
								<?php elseif(has_post_thumbnail()): ?>
									<div class="post-thumbnail">
										<?php the_post_thumbnail('theshopier_blog_single',array('class' => 'post-thumbnail'));?>
									</div>
								<?php endif;
						}
						?>
					
						<div class="post-heading">
							<div class="entry-date">
								<span class="entry-month"><?php echo get_the_date('M')?></span>
								<span class="entry-day"><?php echo get_the_date('d')?></span>
							</div>
							
							<h1 class="post-title"><?php the_title(); ?></h1>
							
							<!--div class="navi">
								<div class="navi-next"><?php next_post_link('%link', 'Next'); ?></div>
								<div class="navi-prev"><?php previous_post_link('%link', 'Previous'); ?> </div>
							</div-->
							<?php edit_post_link( esc_html__( 'Edit', 'theshopier' ), '<span class="nth-edit-link hidden-phone">', '</span>' ); ?>
							
							<div class="post-meta">
								<div class="author"><?php esc_html_e('By', 'theshopier' );?> <?php the_author_posts_link(); ?></div>
								<div class="categories"><?php echo get_the_category_list(', ');?></div>
							</div>
						</div>
					
						<div class="post-content">
							<?php the_content(); ?>
						</div><!-- .post-content -->
						
						<div class="post-meta-bottom">
							
							<?php if( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) :?>
								<?php $tags_list = get_the_tag_list( '', ', ', '' );?>
								<?php if ( $tags_list ):?>
								<div class="tags col-sm-12 row">
								<?php printf( wp_kses(__('<span class="%1$s">Tags:</span> %2$s', 'theshopier'), array('span'=> array('class' => array()))), 'post-tags tag-links', $tags_list );?>
								</div>
								<?php endif;?>
							<?php endif;?>
							
							<?php do_action('theshopier_single_post_meta_bottom');?>
						</div>
					
					</div><!-- .post class -->
					
					<div class="author-info">
						<div class="author-inner">
							<div id="author-avatar" class="author-avatar">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), 120, '', esc_html__('avatar image', 'theshopier' ) );?>
							</div>
							<div class="author-desc">
								<h3 class="author-detail"><?php the_author_posts_link();?></h3>
								<p><?php the_author_meta( 'description' ); ?></p>
							</div>
						</div>
					</div>
					
					<?php get_template_part( 'related_posts' );?>
					<?php //next_post_link();?>
					
				</div>
				
				<?php comments_template( '', true );?>

				<div class="navi">
					<div class="navi-next"><?php next_post_link('%link'); ?></div>
					<div class="navi-prev"><?php previous_post_link('%link'); ?> </div>
				</div>

				<?php endwhile; ?>
				<?php endif;?>
				
			</div><!-- .nth-content-main -->
			
			<?php if( strlen(trim($_right_class)) > 0 ):?>
			<div class="nth-content-right nth-sidebar<?php echo esc_attr( $_right_class );?>">
				<?php if( is_active_sidebar( $_right_sidebar ) ):?>
				<ul class="widgets-sidebar">
					<?php dynamic_sidebar( $_right_sidebar ); ?>
				</ul>
				<?php else:
					esc_html_e( "Please add some widgets here!", 'theshopier' );
				endif;?>
			</div><!-- .nth-content-right -->
			<?php endif;?>
			
		</div><!-- #content -->
	</div><!-- #primary -->
<?php get_footer(); ?>