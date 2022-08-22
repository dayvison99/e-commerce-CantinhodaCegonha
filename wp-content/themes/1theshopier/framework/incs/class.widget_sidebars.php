<?php 

if( !class_exists( "Theshopier_Sidebar" ) ) {
	class Theshopier_Sidebar {
		
		private $sidebar_opts = array();
		
		function __construct(){
			
		}
		
		public function setOptions( $options ){
			$data = $this->get_customSidebar();
			if(count($data) > 0) {
				$options = array_merge( $options, $data );
			}
			$this->sidebar_opts = $options;
			
			$this->completeOptions();
		}
		
		private function completeOptions(){
			foreach( $this->sidebar_opts as $k => $sidebar ){
				if( is_array( $sidebar ) ) {
					if( empty( $sidebar['before_widget'] ) ) $this->sidebar_opts[$k]['before_widget'] = '<li id="%1$s" class="widget %2$s">';
					if( empty( $sidebar['after_widget'] ) ) $this->sidebar_opts[$k]['after_widget'] = '</li>';
					if( empty( $sidebar['before_title'] ) ) $this->sidebar_opts[$k]['before_title'] = '<div class="widget-heading"><h3 class="widget-title heading-title">';
					if( empty( $sidebar['after_title'] ) ) $this->sidebar_opts[$k]['after_title'] = '</h3></div>';
					if( empty( $sidebar['id'] ) && isset( $sidebar['name'] ) ) $this->sidebar_opts[$k]['id'] = sanitize_title( $sidebar['name'] );
				}
			}
		}
		
		public function registerSidebar(){
			add_action( 'widgets_init', array($this, 'widget_init') );
		}
		
		public function widget_init(){
			foreach( $this->sidebar_opts as $sidebar ) {
				register_sidebar( $sidebar );
			}
		}
		
		public function get_customSidebar(){
			$option_name = 'theshopier_custom_sidebars';
			
			if($data = get_option($option_name)) {
				$data = unserialize($data);
				$result = array();
				foreach( $data as $k => $v ){
					$result[] = array(
						'name' => $v['name'],
						'description' => $v['desc'],
						'class'	=> 'nth-custom-sidebar-arrow',
					);
				}
				return $result;
			}
			return array();
		}
		
	}
	
	$theshopier_sidebar = new Theshopier_Sidebar();
	$theshopier_sidebar->setOptions(array(
		array(
			'name' => esc_html__( 'Main Widget Area', 'theshopier' ),
			'description' => esc_html__( 'The Main sidebar widget area', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Header Top Widget Area', 'theshopier' ),
			'description' => esc_html__( 'The header top widget area', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Header Top Widget Area (MB)', 'theshopier' ),
			'description' => esc_html__( 'The header top widget area on mobile', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Header Middle Widget Area', 'theshopier' ),
			'description' => esc_html__( 'The header middle widget area', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Blog Page Widget Area &mdash; Left', 'theshopier' ),
			'description' => esc_html__( 'The blog left widget area', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Blog Page Widget Area &mdash; Right', 'theshopier' ),
			'description' => esc_html__( 'The blog right widget area', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Shop Widget Area &mdash; Left', 'theshopier' ),
			'description' => esc_html__( 'The Shop page left widget area', 'theshopier' ),
		),
		array(
			'name' => esc_html__( 'Shop Widget Area &mdash; Right', 'theshopier' ),
			'description' => esc_html__( 'The Shop page right widget area', 'theshopier' ),
		),
	));
	$theshopier_sidebar->registerSidebar();
}
