<?php 

if( !class_exists( 'Theshopier_MetaBox' ) ) {
	class Theshopier_MetaBox extends Theshopier_MetaBox_Template{
		
		private $page_options = array();
		private $post_options = array();
		
		public function __construct(){
			add_action("admin_init", array($this,"register_metabox"));
			add_action('save_post', array($this,'save_options'));
		}
		
		public function register_metabox(){
			add_meta_box("nth_page_config", esc_attr__('NTH &mdash; Page Options', 'theshopier'), array($this,"page_options"), "page", "normal", "high");
			add_meta_box("nth_post_config", esc_attr__('NTH &mdash; Post Options', 'theshopier'), array($this,"post_options"), "post", "normal", "high");
			add_meta_box("nth_page_config", esc_attr__('NTH &mdash; STBlock position', 'theshopier'), array($this,"staticBlick_option"), "nth_stblock", "side", "default");
			
			add_meta_box("nth_team_config", esc_attr__('NTH &mdash; Member infomations', 'theshopier'), array($this,"member_options"), "team", "normal", "high");
		}
		
		private function get_allMetaSlider(){
			$res_args = array();
			if( class_exists( 'MetaSliderPlugin' ) ) {
				$args = array(
					'post_type' => 'ml-slider',
					'post_status' => 'publish',
					'orderby' => 'date',
					'suppress_filters' => 1, // wpml, ignore language filter
					'order' => 'ASC',
					'posts_per_page' => -1
				);
				$all_sliders = get_posts( $args );

				foreach( $all_sliders as $slideshow ) {
					$id = $slideshow->ID;
					$res_args[$id] = $slideshow->post_title;
				}
			}
			return $res_args;
		}
		
		private function get_revolutionSliders(){
			$arrShort = array();
			if( class_exists('RevSlider') && class_exists('UniteFunctionsRev') ){
				$slider = new RevSlider();
				$arrSliders = $slider->getArrSliders();
				if(!empty($arrSliders)){
					foreach($arrSliders as $slider){
						$title = $slider->getTitle();
						$alias = $slider->getAlias();
						$arrShort[$alias] = $title;
					}
				}
			}
			return $arrShort;
		}
		
		private function get_allSidebar($sidebar_options){
			global $wp_registered_sidebars;
			foreach( $wp_registered_sidebars as $sidebar ) {
				$sidebar_options[$sidebar['id']] = $sidebar['name'];
			}
			return $sidebar_options;
		}
		
		public function page_options(){
			global $post;
			$page_options = unserialize( get_post_meta( $post->ID, 'theshopier_page_options', true ) );
			
			$meta_slider_args = $this->get_allMetaSlider();
			
			$rev_slider_args = $this->get_revolutionSliders();
			
			$tmp_options = array(
				array(
					'type'		=> 'tabs',
					'pagram'	=> array(
						array(
							'id'		=> 'tab_general',
							'title'		=> esc_html__( 'General', 'theshopier' ),
							'class'		=> "dashicons-before dashicons-desktop",
							'pagram'	=> array(
								array(
									'type'	=> 'checkbox',
									'label'	=> esc_html__('Page Title','theshopier' ),
									'name'	=> 'nth_page_show_title',
									'ntd'	=> isset( $page_options['nth_page_show_title'] )? $page_options['nth_page_show_title']: 1,
								),
								array(
									'type'	=> 'checkbox',
									'label'	=> esc_html__('Page Breadcrumb','theshopier' ),
									'name'	=> 'nth_page_show_breadcrumb',
									'class'	=> 'nth-field-hr',
									'ntd'	=> isset( $page_options['nth_page_show_breadcrumb'] )? $page_options['nth_page_show_breadcrumb']: 1,
								),
								array(
									'type'	=> 'checkbox',
									'label'	=> esc_html__('Page comments','theshopier' ),
									'name'	=> 'nth_page_show_comments',
									'class'	=> 'nth-field-hr',
									'ntd'	=> isset( $page_options['nth_page_show_comments'] )? $page_options['nth_page_show_comments']: 0,
								)
							),
						),
						array(
							'id'		=> 'tab_layout',
							'title'		=> esc_html__( 'Layout', 'theshopier' ),
							'class'		=> "dashicons-before dashicons-align-right",
							'pagram'	=> array(
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Page Layout','theshopier' ),
									'name'	=> 'nth_page_layout',
									'ntd'	=> isset( $page_options['nth_page_layout'] )? $page_options['nth_page_layout']: '0-0',
									'class'	=> 'nth-field-hr',
									'value'	=> array(
										'0-0'	=> esc_attr__('Full width', 'theshopier'),
										'1-0'	=> esc_attr__('Left sidebar', 'theshopier'),
										'0-1'	=> esc_attr__('Right Sidebar', 'theshopier'),
										'1-1'	=> esc_attr__('Left & Right Sidebar', 'theshopier'),
									),
								),
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Left sidebar','theshopier' ),
									'name'	=> 'nth_page_leftsidebar',
									'ntd'	=> isset( $page_options['nth_page_leftsidebar'] )? $page_options['nth_page_leftsidebar']: '',
									'value'	=> $this->get_allSidebar(array(''=> __('--Select a sidebar--', 'theshopier'))),
									'request' => array(
										'element' => 'nth_page_layout',
										'values' => array('1-0', '1-1')
									)
								),
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Right sidebar','theshopier' ),
									'name'	=> 'nth_page_rightsidebar',
									'ntd'	=> isset( $page_options['nth_page_rightsidebar'] )? $page_options['nth_page_rightsidebar']: '',
									'value'	=> $this->get_allSidebar(array(''=> __('--Select a sidebar--', 'theshopier'))),
									'request' => array(
										'element' => 'nth_page_layout',
										'values' => array('0-1', '1-1')
									)
								),
							),
						),
						array(
							'id'		=> 'tab_slideshow',
							'title'		=> esc_html__( 'Slideshow', 'theshopier' ),
							'class'		=> "dashicons-before dashicons-images-alt2",
							'pagram'	=> array(
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Slider type','theshopier' ),
									'name'	=> 'nth_slider_type',
									'class'	=> 'nth-field-hr',
									'ntd'	=> isset( $page_options['nth_slider_type'] )? $page_options['nth_slider_type']: '',
									'value'	=> array(
										''				=> "No Slider",
										'metaslider'	=> "Meta slider",
										'revolution'	=> "Revolution slider",
									),
								),
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Meta Slider','theshopier' ),
									'name'	=> 'nth_meta_slider',
									'ntd'	=> isset( $page_options['nth_meta_slider'] )? $page_options['nth_meta_slider']: '',
									'value'	=> $meta_slider_args,
									'empty_mess' => esc_html__("Empty value or Meta Slider not exist!", 'theshopier' ),
									'request' => array(
										'element' => 'nth_slider_type',
										'values' => array('metaslider')
									)
								),
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Revolution Slider','theshopier' ),
									'name'	=> 'nth_rev_slider',
									'ntd'	=> isset( $page_options['nth_rev_slider'] )? $page_options['nth_rev_slider']: '',
									'value'	=> $rev_slider_args,
									'empty_mess' => esc_html__("Empty value or SliderRevolution not exist!", 'theshopier' ),
									'request' => array(
										'element' => 'nth_slider_type',
										'values' => array('revolution')
									)
								),
							),
						),
						array(
							'id'		=> 'tab_custom_template',
							'title'		=> esc_html__( 'Page template', 'theshopier' ),
							'class'		=> "dashicons-before dashicons-editor-quote",
							'pagram'	=> array(
								array(
									'type'		=> 'subtabs',
									'class'	=> 'nth-field-hr',
									'pagram'	=> array(
										array(
											'id'		=> 'subtab_blogtemplare',
											'title'		=> esc_html__( 'Blog Grid', 'theshopier' ),
											'pagram'	=> array(
												array(
													'type'	=> 'select',
													'label'	=> esc_html__('Blog Columns','theshopier' ),
													'name'	=> 'nth_blog_columns',
													'ntd'	=> isset( $page_options['nth_blog_columns'] )? $page_options['nth_blog_columns']: '',
													'value'	=> array(
														''	=> "Default",
														'2'	=> "2 Columns",
														'3'	=> "3 Columns",
														'4'	=> "4 Columns",
													),
													'desc'	=> esc_html__("This use only for Blog Grid page template", "theshopier")
												),
												array(
													'type'	=> 'size',
													'label'	=> esc_html__('Video size','theshopier' ),
													'name'	=> 'nth_blog_v_size',
													'ntd'	=> isset( $page_options['nth_blog_v_size'] )? $page_options['nth_blog_v_size']: '',
													'desc'	=> esc_html__("This use only for Blog Grid page template", "theshopier")
												),
												array(
													'type'	=> 'number',
													'label'	=> esc_html__('Post per page','theshopier' ),
													'name'	=> 'page_temp_per_page',
													'ntd'	=> isset( $page_options['page_temp_per_page'] )? $page_options['page_temp_per_page']: ''
												)
											)
										),
										array(
											'id'		=> 'subtab_albumtemplare',
											'title'		=> esc_html__( 'Album Grid', 'theshopier' ),
											'pagram'	=> array(
												array(
													'type'	=> 'select',
													'label'	=> esc_html__('Album Style','theshopier' ),
													'name'	=> 'nth_album_style',
													'ntd'	=> isset( $page_options['nth_album_style'] )? $page_options['nth_album_style']: '',
													'value'	=> array(
														''			=> esc_html__('Style 1', 'theshopier'),
														'style-2'	=> esc_html__('Style 2', 'theshopier'),
													)
												),

											)
										)
									)
								)
							),
						),
					),
				),
				array(
					'type'	=> 'wp_nonce_field',
					'key'	=> 'nth_nonce_page_options',
					'value'	=> '_UPDATE_PAGE_OPTION_',
				),
			);
			
			$this->set_TmpOptions( $tmp_options );
			$this->createTmp();
		}
		
		public function post_options(){
			global $post;
			$post_options = unserialize(get_post_meta( $post->ID, 'theshopier_post_options', true ));

			$tmp_options = array(
				array(
					'type'		=> 'tabs',
					'pagram'	=> array(
						array(
							'id'		=> 'tab-layout',
							'title'		=> esc_html__( 'Layout', 'theshopier' ),
							'class'		=> "dashicons-before dashicons-align-right",
							'pagram'	=> array(
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Layout','theshopier' ),
									'name'	=> 'nth_blog_layout',
									'class'	=> 'nth-field-hr',
									'ntd'	=> isset($post_options['nth_blog_layout'])? $post_options['nth_blog_layout']: 'def',
									'value'	=> array(
										''		=> esc_attr__('-- Inherit --', 'theshopier'),
										'0-0'	=> esc_attr__('Full width', 'theshopier'),
										'1-0'	=> esc_attr__('Left sidebar', 'theshopier'),
										'0-1'	=> esc_attr__('Right Sidebar', 'theshopier'),
										'1-1'	=> esc_attr__('Left & Right Sidebar', 'theshopier'),
									),
									'desc'	=> esc_attr__('By default, it will apply the choice from Theme Options', 'theshopier')
								),
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Left sidebar','theshopier' ),
									'name'	=> 'nth_post_leftsidebar',
									'ntd'	=> isset($post_options['nth_post_leftsidebar'])? $post_options['nth_post_leftsidebar']: '',
									'value'	=> $this->get_allSidebar(array( '' => esc_attr__('--Inherit--', 'theshopier') )),
									'desc'	=> esc_attr__('By default, it will apply the choice from Theme Options', 'theshopier')
								),
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Right sidebar','theshopier' ),
									'name'	=> 'nth_post_rightsidebar',
									'ntd'	=> isset($post_options['nth_post_rightsidebar'])? $post_options['nth_post_rightsidebar']: '',
									'value'	=> $this->get_allSidebar(array( '' => esc_attr__('--Inherit--', 'theshopier') )),
									'desc'	=> esc_attr__('By default, it will apply the choice from Theme Options', 'theshopier')
								),
							),
						),
						array(
							'id'		=> 'tab-shortcdoe',
							'class'		=> "dashicons-before dashicons-admin-post",
							'title'		=> esc_html__( 'Shortcode', 'theshopier' ),
							'pagram'	=> array(
								array(
									'type'	=> 'textarea',
									'label'	=> esc_html__('Thumbnail Shortcode','theshopier' ),
									'name'	=> 'nth_post_shortcode',
									'holder'=> "",
									'desc'	=> sprintf( esc_html__('Please enter your shortcode content as slider shortcode...','theshopier' ), '<a href="https://soundcloud.com/" target="_blank">', '</a>' ),
									'ntd'	=> isset($post_options['nth_post_shortcode'])?
										stripslashes(htmlspecialchars_decode($post_options['nth_post_shortcode'])): '',
								),

							),
						),
						array(
							'id'		=> 'tab-2',
							'class'		=> "dashicons-before dashicons-format-video",
							'title'		=> esc_html__( 'Video', 'theshopier' ),
							'pagram'	=> array(
								array(
									'type'	=> 'select',
									'label'	=> esc_html__('Source','theshopier' ),
									'name'	=> 'nth_source_type',
									'ntd'	=> isset($post_options['nth_source_type'])? $post_options['nth_source_type']: '',
									'class'	=> 'nth-field-hr',
									'value'	=> array(
										'local'		=> "Local",
										'online'	=> "Online",
									),
								),
								array(
									'type'	=> 'text',
									'label'	=> esc_html__('Url','theshopier' ),
									'name'	=> 'nth_onl_url',
									'class'	=> 'nth-field-hr',
									'holder'=> "https://www.youtube...",
									'desc'	=> esc_html__('Support youtube, vimeo.','theshopier' ),
									'ntd'	=> isset($post_options['nth_onl_url'])? $post_options['nth_onl_url']: '',
								),
								array(
									'type'	=> 'media',
									'label'	=> esc_html__('Mp4 Url','theshopier' ),
									'name'	=> 'nth_mp4_url',
									'ntd'	=> isset($post_options['nth_mp4_url'])? $post_options['nth_mp4_url']: '',
								),
								array(
									'type'	=> 'media',
									'label'	=> esc_html__('Ogg Url','theshopier' ),
									'name'	=> 'nth_ogg_url',
									'ntd'	=> isset($post_options['nth_ogg_url'])? $post_options['nth_ogg_url']: '',
								),
								array(
									'type'	=> 'media',
									'label'	=> esc_html__('Webm Url','theshopier' ),
									'name'	=> 'nth_webm_url',
									'ntd'	=> isset($post_options['nth_webm_url'])? $post_options['nth_webm_url']: '',
								),
							),
						),
						
						array(
							'id'		=> 'tab-audio',
							'class'		=> "dashicons-before dashicons-format-audio",
							'title'		=> esc_html__( 'Audio', 'theshopier' ),
							'pagram'	=> array(
								array(
									'type'	=> 'textarea',
									'label'	=> esc_html__('Audio Embed','theshopier' ),
									'name'	=> 'nth_audio_embed',
									'holder'=> "Soundclound iframe...",
									'desc'	=> sprintf( esc_html__('Please enter embed code for audio (you can use %1$ssoundcloud.com%2$s)','theshopier' ), '<a href="https://soundcloud.com/" target="_blank">', '</a>' ),
									'ntd'	=> isset($post_options['nth_audio_embed'])?
												stripslashes(htmlspecialchars_decode($post_options['nth_audio_embed'])): '',
								),
								
							),
						)
					),
				),
				array(
					'type'	=> 'wp_nonce_field',
					'key'	=> 'nth_nonce_post_options',
					'value'	=> '_UPDATE_POST_OPTION_',
				),
			);
			
			$this->set_TmpOptions($tmp_options);
			$this->createTmp();
			
		}
		
		public function staticBlick_option(){
			global $post;
			$page_options = get_post_meta( $post->ID, 'theshopier_nth_stblock_options', true );
			$tmp_options = array(
				array(
					'type'	=> 'radio',
					'label'	=> '',
					'name'	=> 'nth_stblock_position',
					'ntd'	=> isset($page_options) && $page_options !== ''? $page_options: 'all',
					'value'	=> array(
						'all'		=> esc_html__("Standard", 'theshopier' ),
						'widget'	=> esc_html__("Widget", 'theshopier' ),
						'menu'		=> esc_html__("Mega menu", 'theshopier' ),
					),
				),
				array(
					'type'	=> 'wp_nonce_field',
					'key'	=> 'nth_nonce_static_block',
					'value'	=> '_UPDATE_STATIC_BLOCK_',
				),
			);
			
			$this->set_TmpOptions($tmp_options);
			$this->createTmp();
		}
		
		public function product_options(){
			global $post;
			
			$page_options = unserialize( get_post_meta( $post->ID, 'theshopier_product_options', true ) );
			$page_options = wp_parse_args( $page_options, array(
				'nth_custom_tab_title' => '',
				'nth_custom_tab_content' => ''
			) );
			
			$tmp_options = array(
				array(
					'type'	=> 'text',
					'label'	=>  esc_html__( 'Tab Title', 'theshopier' ),
					'name'	=> 'nth_custom_tab_title',
					'holder'=> esc_html__( "Your custom tab title", 'theshopier' ),
					'ntd'	=> $page_options['nth_custom_tab_title'],
				),
				array(
					'type'	=> 'editor',
					'label'	=>  esc_html__( 'Tab Content', 'theshopier' ),
					'name'	=> 'nth_custom_tab_content',
					'ntd'	=> $page_options['nth_custom_tab_content'],
				),
				array(
					'type'	=> 'wp_nonce_field',
					'key'	=> 'nth_nonce_product_options',
					'value'	=> '_UPDATE_PRODUCT_OPTION_',
				),
			);
			
			$this->set_TmpOptions( $tmp_options );
			$this->createTmp();
		}
		
		public function member_options(){
			global $post;
			
			$team_options = unserialize( get_post_meta( $post->ID, 'nth_team_options', true ) );
			$tmp_options = array(
				array(
					'type'		=> 'tabs',
					'pagram'	=> array(
						array(
							'id'		=> 'tab-general',
							'title'		=> esc_html__( 'General', 'theshopier' ),
							'class'		=> "dashicons-before dashicons-admin-home",
							'pagram'	=> array(
								array(
									'type'	=> 'text',
									'label'	=> esc_html__('Role','theshopier' ),
									'name'	=> 'role',
									'class'	=> 'nth-field-hr',
									'holder'=> "administrator",
									'ntd'	=> isset($team_options['role'])? $team_options['role']: '',
								),
								array(
									'type'	=> 'email',
									'label'	=> esc_html__('Email','theshopier' ),
									'name'	=> 'email',
									'class'	=> '',
									'holder'=> "yourmail@example.com",
									'ntd'	=> isset($team_options['email'])? $team_options['email']: '',
								),
								array(
									'type'	=> 'text',
									'label'	=> esc_html__('Phone','theshopier' ),
									'name'	=> 'phone',
									'holder'=> "+(00) 123456789",
									'ntd'	=> isset($team_options['phone'])? $team_options['phone']: '',
								),
								array(
									'type'	=> 'text',
									'label'	=> esc_html__('Profile Link','theshopier' ),
									'name'	=> 'pr_link',
									'holder'=> "#",
									'ntd'	=> isset($team_options['pr_link'])? $team_options['pr_link']: '',
								),
							),
						),
						array(
							'id'		=> 'tab-social',
							'class'		=> "dashicons-before dashicons-admin-site",
							'title'		=> esc_html__( 'Social network', 'theshopier' ),
							'pagram'	=> array(
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('Facebook link','theshopier' ),
									'name'	=> 'fb_link',
									'class'	=> 'nth-field-hr',
									'holder'=> "",
									'ntd'	=> isset($team_options['fb_link'])? $team_options['fb_link']: '',
								),
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('Twitter link','theshopier' ),
									'name'	=> 'tw_link',
									'class'	=> 'nth-field-hr',
									'holder'=> "",
									'ntd'	=> isset($team_options['tw_link'])? $team_options['tw_link']: '',
								),
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('Google+ link','theshopier' ),
									'name'	=> 'goo_link',
									'class'	=> 'nth-field-hr',
									'holder'=> "",
									'ntd'	=> isset($team_options['goo_link'])? $team_options['goo_link']: '',
								),
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('Pinterest link','theshopier' ),
									'name'	=> 'pin_link',
									'class'	=> 'nth-field-hr',
									'holder'=> "",
									'ntd'	=> isset($team_options['pin_link'])? $team_options['pin_link']: '',
								),
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('Instagram link','theshopier' ),
									'name'	=> 'inst_link',
									'holder'=> "",
									'class'	=> 'nth-field-hr',
									'ntd'	=> isset($team_options['inst_link'])? $team_options['inst_link']: '',
								),
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('LinkedIn link','theshopier' ),
									'name'	=> 'in_link',
									'class'	=> 'nth-field-hr',
									'holder'=> "",
									'ntd'	=> isset($team_options['in_link'])? $team_options['in_link']: '',
								),
								array(
									'type'	=> 'url',
									'label'	=> esc_html__('Dribbble link','theshopier' ),
									'name'	=> 'drib_link',
									'class'	=> '',
									'holder'=> "",
									'ntd'	=> isset($team_options['drib_link'])? $team_options['drib_link']: '',
								),
							),
						),
						
					),
				),
				array(
					'type'	=> 'wp_nonce_field',
					'key'	=> 'nth_nonce_team_options',
					'value'	=> '_UPDATE_TEAM_OPTION_',
				),
			);
			
			$this->set_TmpOptions($tmp_options);
			$this->createTmp();
			
		}
		
		public function save_options( $post_id ){
			$post_type = get_post_type( $post_id );
			if(empty($post_type)) return;
			switch( $post_type ) {
				case 'page':
					if( isset( $_POST['nth_nonce_page_options'] ) && wp_verify_nonce($_POST['nth_nonce_page_options'],'_UPDATE_PAGE_OPTION_') ){
						$data = array(
							"nth_page_show_title"		=> isset( $_POST['nth_page_show_title'] )? $_POST['nth_page_show_title']: 0,
							"nth_page_show_breadcrumb"	=> isset( $_POST['nth_page_show_breadcrumb'] )? $_POST['nth_page_show_breadcrumb']: 0,
							"nth_page_show_comments"	=> isset( $_POST['nth_page_show_comments'] )? $_POST['nth_page_show_comments']: 0,
							"nth_page_layout"			=> isset( $_POST['nth_page_layout'] )? $_POST['nth_page_layout']: '0-0',
							"nth_page_leftsidebar"		=> isset( $_POST['nth_page_leftsidebar'] )? $_POST['nth_page_leftsidebar']: '',
							"nth_page_rightsidebar"		=> isset( $_POST['nth_page_rightsidebar'] )? $_POST['nth_page_rightsidebar']: '',
							"nth_slider_type"			=> isset( $_POST['nth_slider_type'] )? $_POST['nth_slider_type']: '',
							"nth_meta_slider"			=> isset( $_POST['nth_meta_slider'] )? $_POST['nth_meta_slider']: '',
							"nth_rev_slider"			=> isset( $_POST['nth_rev_slider'] )? $_POST['nth_rev_slider']: ''
						);
						if( isset( $_POST['nth_blog_columns'] ) && strlen($_POST['nth_blog_columns']) > 0 )
							$data['nth_blog_columns'] = absint($_POST['nth_blog_columns']);
						if( isset( $_POST['nth_blog_v_size'] ) && is_array( $_POST['nth_blog_v_size'] ) ) {
							if( !empty($_POST['nth_blog_v_size']['width']) && !empty($_POST['nth_blog_v_size']['height']) ) {
								$data['nth_blog_v_size'] = $_POST['nth_blog_v_size'];
							}
						}
						if( isset( $_POST['page_temp_per_page'] ) && strlen($_POST['page_temp_per_page']) > 0 )
							$data['page_temp_per_page'] = absint($_POST['page_temp_per_page']);
						if( isset( $_POST['nth_album_style'] ) && strlen($_POST['nth_album_style']) > 0 )
							$data['nth_album_style'] = esc_attr($_POST['nth_album_style']);

						update_post_meta( $post_id, 'theshopier_page_options', serialize( $data ) );
					}
					break;
				case 'post':
					if( isset( $_POST['nth_nonce_post_options'] ) && wp_verify_nonce($_POST['nth_nonce_post_options'],'_UPDATE_POST_OPTION_') ){
						
						$data = array(
							"nth_blog_layout"		=> isset( $_POST['nth_blog_layout'] )? $_POST['nth_blog_layout']: '',
							"nth_post_leftsidebar"	=> isset( $_POST['nth_post_leftsidebar'] )? $_POST['nth_post_leftsidebar']: '',
							"nth_post_rightsidebar"	=> isset( $_POST['nth_post_rightsidebar'] )? $_POST['nth_post_rightsidebar']: '',
							"nth_source_type"		=> isset( $_POST['nth_source_type'] )? $_POST['nth_source_type']: 'local',
							"nth_onl_url"			=> isset( $_POST['nth_onl_url'] )? $_POST['nth_onl_url']: '',
							"nth_mp4_url"			=> isset( $_POST['nth_mp4_url'] )? $_POST['nth_mp4_url']: '',
							"nth_ogg_url"			=> isset( $_POST['nth_ogg_url'] )? $_POST['nth_ogg_url']: '',
							"nth_webm_url"			=> isset( $_POST['nth_webm_url'] )? $_POST['nth_webm_url']: '',
							"nth_audio_embed"		=> isset( $_POST['nth_audio_embed'] )? esc_html($_POST['nth_audio_embed']) : '',
							"nth_post_shortcode"	=> isset( $_POST['nth_post_shortcode'] )? esc_html($_POST['nth_post_shortcode']) : '',

						);
						
						update_post_meta( $post_id, 'theshopier_post_options', wp_slash(serialize($data)) );
					}
				
				case 'team':
					if( isset( $_POST['nth_nonce_team_options'] ) && wp_verify_nonce($_POST['nth_nonce_team_options'],'_UPDATE_TEAM_OPTION_') ){
						
						$data = array(
							"role"		=> isset( $_POST['role'] )? $_POST['role']: '',
							"email"		=> isset( $_POST['email'] )? $_POST['email']: '',
							"phone"		=> isset( $_POST['phone'] )? $_POST['phone']: '',
							"pr_link"	=> isset( $_POST['pr_link'] )? $_POST['pr_link']: '#',
							"fb_link"	=> isset( $_POST['fb_link'] )? $_POST['fb_link']: '',
							"tw_link"	=> isset( $_POST['tw_link'] )? $_POST['tw_link']: '',
							"goo_link"	=> isset( $_POST['goo_link'] )? $_POST['goo_link']: '',
							"inst_link"	=> isset( $_POST['inst_link'] )? $_POST['inst_link']: '',
							"in_link"	=> isset( $_POST['in_link'] )? $_POST['in_link']: '',
							"drib_link"	=> isset( $_POST['drib_link'] )? $_POST['drib_link']: '',
							"pin_link"	=> isset( $_POST['pin_link'] )? $_POST['pin_link']: ''
						);
						
						update_post_meta( $post_id, 'nth_team_options', serialize( $data ) );
					}
				
				case 'nth_stblock':
					if( isset( $_POST['nth_nonce_static_block'] ) && wp_verify_nonce($_POST['nth_nonce_static_block'],'_UPDATE_STATIC_BLOCK_') ){
						$data = isset( $_POST['nth_stblock_position'] )? $_POST['nth_stblock_position']: 'all';
						update_post_meta( $post_id, 'theshopier_nth_stblock_options', $data );
					}
					
					break;
			}

		}
		
	}
}