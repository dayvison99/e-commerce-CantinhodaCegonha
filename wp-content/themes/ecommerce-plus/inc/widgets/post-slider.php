<?php
/* 
 * display product slider from given product category
 */

class ecommerce_plus_post_slider_widget extends WP_Widget {


function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'ecommerce_plus_post_slider_widget', 
		  
		// Widget name will appear in UI
		__('+ Post Slider', 'ecommerce-plus'), 
		  
		// Widget description
		array( 'description' => __( 'Display Post Slider.', 'ecommerce-plus' ), ) 
		);
}

public function widget( $args, $instance ) {

		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 6;
		$category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : 0;
		$product_meta = ( ! empty( $instance['product_meta'] ) ) ? wp_strip_all_tags( $instance['product_meta'] ) : '';
		$max_height = (!empty($instance['max_height'])) ?  absint($instance['max_height']) : 430;
		$speed = (!empty($instance['speed'])) ? absint($instance['speed']) : 4;
		$top = (!empty($instance['top'])) ? absint($instance['top']) : 25;
		$title_text = ( ! empty( $instance['title_text'] ) ) ? wp_strip_all_tags( $instance['title_text'] ) : '';
		$btn_label = ( ! empty( $instance['btn_label'] ) ) ? wp_strip_all_tags( $instance['btn_label'] ) : esc_html__('Read More', 'ecommerce-plus');
		$btn_url = ( ! empty( $instance['btn_url'] ) ) ? wp_strip_all_tags( $instance['btn_url'] ) : '';
		
		$slider_button = ( ! empty( $instance['slider_button'] ) ) ? wp_strip_all_tags( $instance['slider_button'] ) : '';
		
		$args = array();
		
		if (!ecommerce_plus_extra_plugin()) { $max_items = 3; }

		if( $category == -1 ){
			$args = array ( 'post_type' => 'post', 'posts_per_page'=> $max_items );
		} else {
			$args = array ( 'post_type' => 'post',	'posts_per_page'=> $max_items, 'cat' => $category );		
		}
		
		

		$loop = new WP_Query($args );

		$i = 1;
		
		$items = array();
		
		while( $loop->have_posts() ) : $loop->the_post();		  
			$thumb_id = get_post_thumbnail_id(get_the_ID());	
			$url = get_the_post_thumbnail_url(get_the_ID(), 'full');
			
			if(!$url) {
				$url = get_template_directory_uri().'/images/empty.png';
			}
						
			$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
			$link = get_permalink();
			$title = get_the_title();
			$content = get_the_excerpt();
			
			$item = array ( 'link' => $link , 
							'image_url' => $url , 
							'content' => $content , 
							'title' => $title,
							'alt' => $alt
							);
										
			array_push($items, $item);

			$i++; 
		endwhile;
		wp_reset_postdata();
		
		global $ecommerce_plus_uniqueue_id ;
		$ecommerce_plus_uniqueue_id += 1;		
		$carousal_id = 'product-carousal-'.$ecommerce_plus_uniqueue_id;
		
		//carousal begin
		echo '<div id="'.esc_attr($carousal_id).'" class="product-slider post-slider carousel slide" data-ride="carousel" data-interval="'.esc_attr($speed*1000).'" style="height:'.absint($max_height).'px" >';
		echo '<div class="carousel-inner">';
	
		$active = 'active';
		$item_count = count($items);
		
		foreach ($items as $slides) {
		
		$link = $btn_url;
		if ($btn_url=='') $link = $slides['link'];
			
		echo '<div class="item '.esc_attr($active).' ">';
		   echo '<a href="'.esc_url($link).'"><img class="img-responsive" src="'.esc_url($slides['image_url']).'"  style="width:100%;height:'.absint($max_height).'px"></a>';
	

		
		 if(!$slider_button || !$title_text ) {		
			echo '<div class="carousel-caption" style="top:'.absint($top).'%">';
			if(!$title_text){	
				echo  '<h1>'.esc_html($slides['title']).'</h1>
				      <p>'.wp_kses_post($slides['content']).'</p>';
			}
			if(!$slider_button){	  
				echo  '<a href='.esc_url($link).' class="call-to-action btn">'.esc_html($btn_label).'</a><p></p>';
			}
			echo  '</div>';
			
		}
						   
		 $active = '';
		 echo '</div>';
			//item end			
		}
		
		//indicators, navigation
		if($item_count>1) {	
	
			echo '<a class="left carousel-control" href="#'.esc_attr($carousal_id).'" data-slide="prev">
			<span class="glyphicon glyphicon-menu-left"></span>
			<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#'.esc_attr($carousal_id).'" data-slide="next">
			<span class="glyphicon glyphicon-menu-right"></span>
			<span class="sr-only">Next</span>
			</a>';	
		
			$active = 'active';		
			echo '<ol class="carousel-indicators">';	
			$s = 0;
			foreach ($items as $slides) {
				echo '<li data-target="#'.esc_attr($carousal_id).'" data-slide-to="'.esc_attr($s).'" class="'.esc_attr($active).'"></li>';
				$active = '';
				$s++;
			}	
			echo '</ol>';

		}//indicators, navigation
				
		 echo '</div>';
		echo '</div>';

}
		
public function form( $instance ) {

		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : '6';
		$category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : -1;
		$max_height = (!empty($instance['max_height'])) ?  absint($instance['max_height']) : 400;
		$speed = (!empty($instance['speed'])) ? absint($instance['speed']) : 4;
		$top = (!empty($instance['top'])) ? absint($instance['top']) : 25;
		$title_text = ( ! empty( $instance['title_text'] ) ) ? wp_strip_all_tags( $instance['title_text'] ) : '';
		$btn_label = ( ! empty( $instance['btn_label'] ) ) ? wp_strip_all_tags( $instance['btn_label'] ) : '';
		$btn_url = ( ! empty( $instance['btn_url'] ) ) ? esc_url( $instance['btn_url'] ) : '';
		
		$slider_button = ( ! empty( $instance['slider_button'] ) ) ? wp_strip_all_tags( $instance['slider_button'] ) : '';		
		
		$args = get_categories( array(
									'orderby' => 'name',
									'parent'  => 0
								));
		 
		$categories = get_categories( $args );
		$category_list = '';
		if(0 == $category){
			$category_list = $category_list.'<option value="-1" Selected=selected>'.__( 'All','ecommerce-plus').'</option>';
		} else{
			$category_list = $category_list.'<option value="-1">'.__( 'All','ecommerce-plus').'</option>';
		}
		foreach ( $categories as $cat ) {
			$selected ='';
			if(($cat->term_id) == $category){
				$selected ='Selected=selected';
			}
			$category_list = $category_list.'<option value="'.esc_attr($cat->term_id).'" '.esc_attr($selected).' >'.esc_html($cat->name).'</option>';
		}
		?>
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Post Category:','ecommerce-plus'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>" type="text">
		<?php echo $category_list; ?>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>"><?php esc_html_e( 'Number of Slides to Show:','ecommerce-plus'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_items' )); ?>" type="number" value="<?php echo esc_attr( $max_items ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('speed')); ?>">
			<?php esc_html_e( 'Slider Speed (seconds)', 'ecommerce-plus' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('speed')); ?>" id="<?php echo esc_attr($this->get_field_id('speed')); ?>" value="<?php if ($speed) : echo absint($speed); endif; ?>" class="widefat" />
		</p>
				
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('top')); ?>">
			<?php esc_html_e( 'Top %', 'ecommerce-plus' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('top')); ?>" id="<?php echo esc_attr($this->get_field_id('top')); ?>" value="<?php if ($speed) : echo absint($top); endif; ?>" class="widefat" />
		</p>
		
		<p>
		<input class="checkbox" type="checkbox" <?php if($title_text){echo " checked ";} ?> id="<?php echo esc_attr($this->get_field_id( 'title_text' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title_text' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'title_text' )); ?>"><?php esc_html_e( 'Hide Title & Description', 'ecommerce-plus' ); ?></label> 
		</p>		
		
		<p>
		<input class="checkbox" type="checkbox" <?php if($slider_button){echo " checked ";} ?> id="<?php echo esc_attr($this->get_field_id( 'slider_button' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'slider_button' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'slider_button' )); ?>"><?php esc_html_e( 'Hide Slider Button', 'ecommerce-plus' ); ?></label> 
		</p>
			
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('btn_label')); ?>">
			<?php esc_html_e( 'Button Label', 'ecommerce-plus' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('btn_label')); ?>" id="<?php echo esc_attr($this->get_field_id('btn_label')); ?>" value="<?php if ($btn_label) : echo esc_attr($btn_label); endif; ?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('btn_url')); ?>">
			<?php esc_html_e( 'Button Link', 'ecommerce-plus' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('btn_url')); ?>" id="<?php echo esc_attr($this->get_field_id('btn_url')); ?>" value="<?php if ($btn_url) : echo esc_attr($btn_url); endif; ?>" class="widefat" />
		</p>		
		
		<span><strong><?php esc_html_e('Custom Styles:', 'ecommerce-plus'); ?></strong></span><hr />

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('max_height')); ?>">
			<?php esc_html_e( 'Max Height:', 'ecommerce-plus' ); ?></label><br />
			<input type="number" name="<?php echo esc_attr($this->get_field_name('max_height')); ?>" id="<?php echo esc_attr($this->get_field_id('max_height')); ?>" value="<?php echo absint($max_height);?>" class="widefat" />
		</p>
		
		<p><strong><?php esc_html_e('Unlimited slides and more options, Go Pro...', 'ecommerce-plus'); ?></strong></p>

						
		<?php
		}

public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['max_items'] = ( ! empty( $new_instance['max_items'] ) ) ? absint( $new_instance['max_items'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? wp_strip_all_tags( $new_instance['category'] ) : '' ;
		$instance['max_height'] = ( ! empty( $new_instance['max_height'] ) ) ? absint( $new_instance['max_height'] ) : '';
		$instance['speed'] = (!empty($new_instance['speed'])) ? absint($new_instance['speed']): '';
		$instance['top'] = (!empty($new_instance['top'])) ? absint($new_instance['top']): '';
		$instance['title_text'] = ( ! empty( $new_instance['title_text'] ) ) ? wp_strip_all_tags( $new_instance['title_text'] ) : '';
		$instance['btn_label'] = ( ! empty( $new_instance['btn_label'] ) ) ? wp_strip_all_tags( $new_instance['btn_label'] ) : esc_html__('Read More', 'ecommerce-plus');
		$instance['btn_url'] = ( ! empty( $new_instance['btn_url'] ) ) ? wp_strip_all_tags( $new_instance['btn_url'] ) : '';
		
		$instance['slider_button'] = ( ! empty( $new_instance['slider_button'] ) ) ? wp_strip_all_tags( $new_instance['slider_button'] ) : '' ;
		
		return $instance;
	 }
}

function ecommerce_plus_post_slider_widget() {
		register_widget( 'ecommerce_plus_post_slider_widget' );
}
add_action( 'widgets_init', 'ecommerce_plus_post_slider_widget' );