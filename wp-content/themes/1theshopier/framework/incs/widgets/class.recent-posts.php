<?php 
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Theshopier_RecentPosts_Widget extends Theshopier_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'nth-widgets nth-recent-posts-widget';
		$this->widget_description = esc_html__( "Your site's most recent Posts.", 'theshopier' );
		$this->widget_id          = 'theshopier_recent_posts';
		$this->widget_name        = esc_html__('Recent Posts', 'theshopier' );
		
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Recent posts', 'theshopier' ),
				'label' => esc_html__( 'Title', 'theshopier' )
			),
			'w_style'  => array(
				'type'  => 'select',
				'std'   => '1',
				'label' => esc_html__( 'Display style', 'theshopier' ),
				'options'	=> array(
					'1'	=> esc_html__( 'Style 1', 'theshopier' ),
					'2'	=> esc_html__( 'Style 2', 'theshopier' ),
				)
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => 150,
				'std'   => 5,
				'label' => esc_html__( 'Number of post to show', 'theshopier' )
			),
			'excerpt_words' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => 255,
				'std'   => 15,
				'label' => esc_html__( 'Excerpt words', 'theshopier' )
			),
			'hidden_date'	=> array(
				'type'	=> 'checkbox',
				'std'	=> '0',
				'label' => esc_html__( 'Hidden posted time.', 'theshopier' ),
			)
			
		);
		
		parent::__construct();
    }
	
    public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) return;

		$number = isset($instance['number'])? absint($instance['number']): 5;
		$excerpt_words = isset($instance['excerpt_words'])? absint($instance['excerpt_words']): 15;
		$hidden_date = isset($instance['hidden_date'])? esc_attr($instance['hidden_date']) : 0;
		$w_style = isset($instance['w_style'])? absint($instance['w_style']): 1;

		ob_start();
		$this->widget_start( $args, $instance );
		
		echo do_shortcode( '[theshopier_recent_posts w_style="'.$w_style.'" limit="'.absint( $number ).'" excerpt_words="'.esc_attr( $excerpt_words ).'" as_widget="1" hidden_date="'.$hidden_date.'"]' );
		
		$this->widget_end( $args );
		
		echo $this->cache_widget( $args, ob_get_clean() );
	}
}
