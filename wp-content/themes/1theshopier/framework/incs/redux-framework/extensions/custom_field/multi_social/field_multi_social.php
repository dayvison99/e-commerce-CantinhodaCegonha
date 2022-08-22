<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @author      Dovy Paukstys
 * @version     3.1.5
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_multi_social' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_multi_social extends ReduxFramework {
    
        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {
        
            
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
				$extension_dir = get_template_directory() . '/framework/incs/redux-framework/extensions/custom_field/multi_social';
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', $extension_dir ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }    

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true
            );
            $this->field = wp_parse_args( $this->field, $defaults );            
			
        }
		

        /**
         * Field Render Function.
         *
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
		public function get_icons(){
			$icons = array(
				'fa fa-adn'					=> 'fa-adn',
				'fa fa-amazon'				=> 'fa-amazon',
				'fa fa-android'				=> 'fa-android',
				'fa fa-angellist' 			=> 'fa-angellist',
				'fa fa-apple'				=> 'fa-apple',
				'fa fa-behance'				=> 'fa-behance',
				'fa fa-behance-square'		=> 'fa-behance-square',
				'fa fa-bitbucket'			=> 'fa-bitbucket',
				'fa fa-bitbucket-square'	=> 'fa-bitbucket-square',
				'fa fa-btc'					=> 'fa-btc',
				'fa fa-black-tie'			=> 'fa-black-tie',
				'fa fa-buysellads'			=> 'fa-buysellads',
				'fa fa-cc-amex'				=> 'fa-cc-amex',
				'fa fa-cc-diners-club'		=> 'fa-cc-diners-club',
				'fa fa-cc-discover'			=> 'fa-cc-discover',
				'fa fa-cc-jcb'				=> 'fa-cc-jcb',
				'fa fa-cc-mastercard'		=> 'fa-cc-mastercard',
				'fa fa-cc-paypal'			=> 'fa-cc-paypal',
				'fa fa-cc-stripe'			=> 'fa-cc-stripe',
				'fa fa-cc-visa'				=> 'fa-cc-visa',
				'fa fa-chrome'				=> 'fa-chrome',
				'fa fa-codepen'				=> 'fa-codepen',
				'fa fa-connectdevelop'		=> 'fa-connectdevelop',
				'fa fa-contao'				=> 'fa-contao',
				'fa fa-css3'				=> 'fa-css3',
				'fa fa-dashcube'			=> 'fa-dashcube',
				'fa fa-delicious'			=> 'fa-delicious',
				'fa fa-deviantart'			=> 'fa-deviantart',
				'fa fa-digg'				=> 'fa-digg',
				'fa fa-dribbble'			=> 'fa-dribbble',
				'fa fa-dropbox'				=> 'fa-dropbox',
				'fa fa-drupal'				=> 'fa-drupal',
				'fa fa-empire'				=> 'fa-empire',
				'fa fa-expeditedssl'		=> 'fa-expeditedssl',
				'fa fa-facebook'			=> 'fa-facebook',
				'fa fa-facebook-official'	=> 'fa-facebook-official',
				'fa fa-facebook-square'		=> 'fa-facebook-square',
				'fa fa-firefox'				=> 'fa-firefox',
				'fa fa-flickr'				=> 'fa-flickr',
				'fa fa-fonticons'			=> 'fa-fonticons',
				'fa fa-forumbee'			=> 'fa-forumbee',
				'fa fa-foursquare'			=> 'fa-foursquare',
				'fa fa-empire'				=> 'fa-empire',
				'fa fa-get-pocket'			=> 'fa-get-pocket',
				'fa fa-gg'					=> 'fa-gg',
				'fa fa-gg-circle'			=> 'fa-gg-circle',
				'fa fa-git'					=> 'fa-git',
				'fa fa-git-square'			=> 'fa-git-square',
				'fa fa-github'				=> 'fa-github',
				'fa fa-github-alt'			=> 'fa-github-alt',
				'fa fa-github-square'		=> 'fa-github-square',
				'fa fa-gratipay'			=> 'fa-gratipay',
				'fa fa-google'				=> 'fa-google',
				'fa fa-google-plus'			=> 'fa-google-plus',
				'fa fa-google-plus-square'	=> 'fa-google-plus-square',
				'fa fa-google-wallet'		=> 'fa-google-wallet',
				'fa fa-gratipay'			=> 'fa-gratipay',
				'fa fa-hacker-news'			=> 'fa-hacker-news',
				'fa fa-houzz'				=> 'fa-houzz',
				'fa fa-html5'				=> 'fa-html5',
				'fa fa-instagram'			=> 'fa-instagram',
				'fa fa-internet-explorer'	=> 'fa-internet-explorer',
				'fa fa-ioxhost'				=> 'fa-ioxhost',
				'fa fa-joomla'				=> 'fa-joomla',
				'fa fa-jsfiddle'			=> 'fa-jsfiddle',
				'fa fa-lastfm'				=> 'fa-lastfm',
				'fa fa-lastfm-square'		=> 'fa-lastfm-square',
				'fa fa-leanpub'				=> 'fa-leanpub',
				'fa fa-linkedin'			=> 'fa-linkedin',
				'fa fa-linkedin-square'		=> 'fa-linkedin-square',
				'fa fa-linux'				=> 'fa-linux',
				'fa fa-maxcdn'				=> 'fa-maxcdn',
				'fa fa-meanpath'			=> 'fa-meanpath',
				'fa fa-medium'				=> 'fa-medium',
				'fa fa-odnoklassniki'		=> 'fa-odnoklassniki',
				'fa fa-odnoklassniki-square' => 'fa-odnoklassniki-square',
				'fa fa-opencart'			=> 'fa-opencart',
				'fa fa-openid'				=> 'fa-openid',
				'fa fa-opera'				=> 'fa-opera',
				'fa fa-optin-monster'		=> 'fa-optin-monster',
				'fa fa-pagelines'			=> 'fa-pagelines',
				'fa fa-paypal'				=> 'fa-paypal',
				'fa fa-pied-piper'			=> 'fa-pied-piper',
				'fa fa-pied-piper-alt'		=> 'fa-pied-piper-alt',
				'fa fa-pinterest'			=> 'fa-pinterest',
				'fa fa-pinterest-p'			=> 'fa-pinterest-p',
				'fa fa-pinterest-square'	=> 'fa-pinterest-square',
				'fa fa-qq'					=> 'fa-qq',
				'fa fa-rebel'				=> 'fa-rebel',
				'fa fa-reddit'				=> 'fa-reddit',
				'fa fa-reddit-square'		=> 'fa-reddit-square',
				'fa fa-renren'				=> 'fa-renren',
				'fa fa-safari'				=> 'fa-safari',
				'fa fa-sellsy'				=> 'fa-sellsy',
				'fa fa-share-alt"'			=> 'fa-share-alt"',
				'fa fa-share-alt-square'	=> 'fa-share-alt-square',
				'fa fa-shirtsinbulk'		=> 'fa-shirtsinbulk',
				'fa fa-simplybuilt'			=> 'fa-simplybuilt',
				'fa fa-skyatlas'			=> 'fa-skyatlas',
				'fa fa-skype'				=> 'fa-skype',
				'fa fa-slack'				=> 'fa-slack',
				'fa fa-slideshare'			=> 'fa-slideshare',
				'fa fa-soundcloud'			=> 'fa-soundcloud',
				'fa fa-spotify'				=> 'fa-spotify',
				'fa fa-stack-exchange'		=> 'fa-stack-exchange',
				'fa fa-stack-overflow'		=> 'fa-stack-overflow',
				'fa fa-steam'				=> 'fa-steam',
				'fa fa-steam-square'		=> 'fa-steam-square',
				'fa fa-stumbleupon'			=> 'fa-stumbleupon',
				'fa fa-stumbleupon-circle'	=> 'fa-stumbleupon-circle',
				'fa fa-tencent-weibo'		=> 'fa-tencent-weibo',
				'fa fa-trello'				=> 'fa-trello',
				'fa fa-tripadvisor'			=> 'fa-tripadvisor',
				'fa fa-tumblr'				=> 'fa-tumblr',
				'fa fa-tumblr-square'		=> 'fa-tumblr-square',
				'fa fa-twitch'				=> 'fa-twitch',
				'fa fa-twitter'				=> 'fa-twitter',
				'fa fa-twitter-square'		=> 'fa-twitter-square',
				'fa fa-viacoin'				=> 'fa-viacoin',
				'fa fa-vimeo'				=> 'fa-vimeo',
				'fa fa-vimeo-square'		=> 'fa-vimeo-square',
				'fa fa-vine'				=> 'fa-vine',
				'fa fa-vk'					=> 'fa-vk',
				'fa fa-weixin'				=> 'fa-weixin',
				'fa fa-weibo'				=> 'fa-weibo',
				'fa fa-whatsapp'			=> 'fa-whatsapp',
				'fa fa-wikipedia-w'			=> 'fa-wikipedia-w',
				'fa fa-windows'				=> 'fa-windows',
				'fa fa-wordpress'			=> 'fa-wordpress',
				'fa fa-xing'				=> 'fa-xing',
				'fa fa-xing-square'			=> 'fa-xing-square',
				'fa fa-y-combinator'		=> 'fa-y-combinator',
				'fa fa-yahoo'				=> 'fa-yahoo',
				'fa fa-yelp'				=> 'fa-yelp',
				'fa fa-youtube'				=> 'fa-youtube',
				'fa fa-youtube-play'		=> 'fa-youtube-play',
				'fa fa-youtube-square'		=> 'fa-youtube-square',
				'fa fa-rss'					=> 'fa-rss',
				'fa fa-rss-square'			=> 'fa-rss-square',
			);

			return $icons;
		}
		
		private function make_option($id, $value, $k = -1) {
			
            $selected = $k !== -1? selected( $this->value[$k]['icon'], $id, false ): '';

            echo '<option value="' . $id . '"' . $selected . '>' . $value . '</option>';                
        }
		
        function render() {
			
			$this->add_text   = ( isset( $this->field['add_text'] ) ) ? esc_html($this->field['add_text']) : esc_html__( 'Add More', 'theshopier' );
            $this->show_empty = ( isset( $this->field['show_empty'] ) ) ? absint($this->field['show_empty']) : true;
			
			if ( empty( $this->field['args'] ) ) $this->field['args'] = array();
			
			$sortable = ( isset( $this->field['sortable'] ) && $this->field['sortable'] ) ? ' select2-sortable"' : "";
			
			$nth_class = 'nth-multi-socials';
			
			$this->field['class'] = " font-icons";
			
			$this->field['options'] = $this->get_icons();
			
			if ( ! empty( $this->field['options'] ) ) {
				//$multi = ( isset( $this->field['multi'] ) && $this->field['multi'] ) ? ' multiple="multiple"' : "";
				$width = '40%';
				
				$placeholder = ( isset( $this->field['placeholder'] ) ) ? esc_attr( $this->field['placeholder'] ) : esc_html__( 'Select an item', 'theshopier' );
				
				if ( isset( $this->field['select2'] ) ) {
					$select2_params = json_encode( $this->field['select2'] );
                    $select2_params = htmlspecialchars( $select2_params, ENT_QUOTES );
					echo '<input type="hidden" class="select2_params" value="' . $select2_params . '">';
				}
				
				$sortable = ( isset( $this->field['sortable'] ) && $this->field['sortable'] ) ? ' select2-sortable"' : "";
				
			} 
			
			?>
			<ul id="<?php echo esc_attr($this->field['id']);?>-ul" class="nth-multi-socials">
			<?php 

            if ( isset( $this->value ) && is_array( $this->value ) ) {
				
				$x = 0;
				foreach ( $this->value as $k => $value ) {
                    if ( $value != '' ) {
						$value['color'] = isset($value['color'])? $value['color']: '';
					?>
					<li>
					<?php if ( ! empty( $this->field['options'] ) ) :?>
						<p>
							<label for="<?php echo esc_attr($this->field['id']);?>-select-<?php echo esc_attr($k);?>"><?php esc_html_e("Icons", 'theshopier' );?></label>
							<select id="<?php echo esc_attr($this->field['id']);?>-select-<?php echo esc_attr($k);?>" data-placeholder="<?php echo esc_attr($placeholder);?>" name="<?php echo esc_attr( $this->field['name'] . $this->field['name_suffix'] );?>[<?php echo esc_attr($x);?>][icon]" class="redux-select-item <?php echo esc_attr($this->field['class'] . $sortable)?>" style="width: <?php echo esc_attr($width);?>; display: inline-block!important" rows="6">
								<option></option>
								<?php foreach ( $this->field['options'] as $s_k => $s_v ) { ?>
									<?php $this->make_option($s_k, $s_v, $k);?>
								<?php }?>
							</select>
						</p>
					<?php else:?>
							<p><strong><?php  esc_html_e( 'No items of this type were found.', 'theshopier' )?></strong></p>
					<?php endif;?>
						<p>
							<label for="<?php echo esc_attr( $this->field['id'] . '-' . $k );?>"><?php esc_html_e("Link", 'theshopier' );?></label>
							<input type="text" id="<?php echo esc_attr( $this->field['id'] . '-' . $k );?>" name="<?php echo esc_attr( $this->field['name'] . $this->field['name_suffix'] );?>[<?php echo esc_attr($x);?>][link]" value="<?php echo esc_attr( $value['link'] );?>" class="regular-text <?php echo esc_attr( $this->field['class'] );?>" />
						
							<a href="javascript:void(0);" class="deletion <?php echo esc_attr($nth_class);?>-remove"><i class="fa fa-times"></i></a>
						</p>

						<p>
							<label for="<?php echo esc_attr( $this->field['id'] . '-color-' . $k );?>"><?php esc_html_e("Color", 'theshopier' );?></label>
							<input type="text" id="<?php echo esc_attr( $this->field['id'] . '-color-' . $k );?>" name="<?php echo esc_attr( $this->field['name'] . $this->field['name_suffix'] );?>[<?php echo esc_attr($x);?>][color]" value="<?php echo esc_attr( $value['color'] );?>" class="nth_colorpicker <?php echo esc_attr( $this->field['class'] );?>" data-default-color="#6475c2" />

						</p>
					</li>
					<?php
                    }
					$x++;
                }
            } elseif ( $this->show_empty == true ) {
			?>
				<li>
				<?php $k = 0; $x = 0;?>
				<?php if ( ! empty( $this->field['options'] ) ) :?>
					<p>
						<label for="<?php echo esc_attr($this->field['id']);?>-select-<?php echo esc_attr($k);?>"><?php esc_html_e("Icons", 'theshopier' );?></label>
						<select id="<?php echo esc_attr($this->field['id']);?>-select-<?php echo esc_attr($k);?>" data-placeholder="<?php echo esc_attr($placeholder);?>" name="<?php echo esc_attr( $this->field['name'] . $this->field['name_suffix'] );?>[<?php echo esc_attr($x);?>][icon]" class="redux-select-item <?php echo esc_attr($this->field['class'] . $sortable)?>" style="width: <?php echo esc_attr($width);?>; display: inline-block!important" rows="6">
							<option></option>
							<?php foreach ( $this->field['options'] as $s_k => $s_v ) { ?>
								<?php $this->make_option($s_k, $s_v);?>
							<?php }?>
						</select>
					</p>
				<?php else:?>
						<p><strong><?php  esc_html_e( 'No items of this type were found.', 'theshopier' )?></strong></p>
				<?php endif;?>
					<p>
						<label for="<?php echo esc_attr( $this->field['id'] . '-' . $k );?>"><?php esc_html_e("Link", 'theshopier' );?></label>
						<input type="text" id="<?php echo esc_attr( $this->field['id'] . '-' . $k );?>" name="<?php echo esc_attr( $this->field['name'] . $this->field['name_suffix'] );?>[<?php echo esc_attr($x);?>][link]" value="" class="regular-text <?php echo esc_attr( $this->field['class'] );?>" /> 
					
						<a href="javascript:void(0);" class="deletion <?php echo esc_attr($nth_class);?>-remove"><i class="fa fa-times"></i></a>
					</p>
				</li>
			<?php 
            }

            ?>
				<li style="display:none;" class="item-template">
					
					<?php if ( ! empty( $this->field['options'] ) ) :?>
						<p>
							<label for="<?php echo esc_attr($this->field['id']);?>-select"><?php esc_html_e("Icons", 'theshopier' );?></label>
							<select id="<?php echo esc_attr($this->field['id']);?>-select" data-placeholder="<?php echo esc_attr($placeholder);?>" name="" class="new-redux-select-item" style="width: <?php echo esc_attr($width);?>; display: inline-block!important" rows="6">
								<option></option>
								<?php foreach ( $this->field['options'] as $s_k => $s_v ) { ?>
									<?php $this->make_option($s_k, $s_v);?>
								<?php }?>
							</select>
						</p>
					<?php else:?>
							<p><strong><?php esc_html_e( 'No items of this type were found.', 'theshopier' )?></strong></p>
					<?php endif;?>
						<p>
							<label for="<?php echo esc_attr( $this->field['id'] );?>"><?php esc_html_e("Link", 'theshopier' );?></label>
							<input type="text" id="<?php echo esc_attr( $this->field['id']);?>" name="" value="" class="regular-text" /> 
						
							<a href="javascript:void(0);" class="deletion <?php echo esc_attr($nth_class);?>-remove"><i class="fa fa-times"></i></a>
						</p>
				</li>
			
			</ul><?php 
            $this->field['add_number'] = ( isset( $this->field['add_number'] ) && is_numeric( $this->field['add_number'] ) ) ? $this->field['add_number'] : 1;
			?>
			<a href="javascript:void(0);" class="button button-primary <?php echo esc_attr($nth_class);?>-add" data-add_number="<?php echo esc_attr($this->field['add_number']);?>" data-name_number="<?php echo absint( count($this->value) );?>" data-id="<?php echo esc_attr($this->field['id']);?>-ul" data-name="<?php echo esc_attr($this->field['name'] . $this->field['name_suffix']);?>"><i class="fa fa-plus"></i> <?php echo esc_html($this->add_text);?></a><br/>
			<?php 
		}
    
        /**
         * Enqueue Function.
         *
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function enqueue() {

            //$extension = ReduxFramework_extension_custom_field::getInstance();
        
            wp_enqueue_script(
                'theshopier-field_multi_social-js',
                $this->extension_url . 'field_multi_social.js', 
                array( 'jquery' ),
                time(),
                true
            );

            wp_enqueue_style(
                'theshopier-font-awesome',
                $this->extension_url . 'font-awesome.min.css',
                time(),
                true
            );
			wp_enqueue_style(
                'theshopier-field_multi_social',
                $this->extension_url . 'field_multi_social.css',
                time(),
                true
            );
        
        }
        
        /**
         * Output Function.
         *
         * Used to enqueue to the front-end
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */        
        function output() {

            if ( $this->field['enqueue_frontend'] ) {
				
            }
            
        }        
        
    }
}
