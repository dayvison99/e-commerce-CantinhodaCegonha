<?php 
// **********************************************************************// 
// ! Register Nexthemes Widgets
// **********************************************************************// 

class Theshopier_RecentComments_Widget extends Theshopier_Widget {

    public function __construct() {
        $this->widget_cssclass    = 'nth-widgets nth-recent-comments-widget';
		$this->widget_description = esc_html__( "Your site's most recent comments.", 'theshopier' );
		$this->widget_id          = 'theshopier_recent_comments';
		$this->widget_name        = esc_html__('Recent Comments', 'theshopier' );
		
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Recent Comments', 'theshopier' ),
				'label' => esc_html__( 'Title', 'theshopier' )
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
			)
		);
		
		parent::__construct();
    }
	
    public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) return;

		$instance['number'] = isset($instance['number'])? $instance['number']: 5;
		$instance['excerpt_words'] = isset($instance['excerpt_words'])? $instance['excerpt_words']: 15;

		ob_start();

		$this->widget_start( $args, $instance );
		
		echo do_shortcode( '[theshopier_recent_comments limit="'.absint( $instance['number'] ).'" excerpt_words="'.esc_attr( $instance['excerpt_words'] ).'" as_widget="1"]' );
		
		$this->widget_end( $args );
		
		echo $this->cache_widget( $args, ob_get_clean() );
	}
}
