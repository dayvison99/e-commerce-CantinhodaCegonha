<?php 
if( !class_exists( 'Theshopier_MetaBox_Template' ) ) {
	class Theshopier_MetaBox_Template {
		
		protected $tmp_options = array();
		
		public function __construct(){
			
		}
		
		protected function set_TmpOptions( $args ){
			$this->tmp_options = $args;
		}
		
		protected function createTmp(){
			$options = $this->tmp_options;
			?>
			<div class="nth_config_wrapper">
				<div class="nth_config_inner">
					<?php
					if( is_array($options) ){
						foreach($options as $item) {
							if( is_array( $item ) && isset( $item['type'] ) ) {
								$this->createElements($item);
							}
						}
					}
					?>
				</div>
			</div>
			<?php
		}

		protected function get_current_val($tab, $item){
			$return = '';

			if(is_array($tab) && !empty($tab)){
				foreach($tab['pagram'] as $ops) {
					if(strcmp($ops['name'], trim($item)) == 0) {
						$return = $ops['ntd'];
					}
				}
			}
			return $return;
		}
		
		public function createElements( $options, $tab = array() ){
			if( is_array( $options ) && isset( $options['type'] ) ) {
				switch( $options['type'] ) {
					case 'tabs': 
						$this->render_tab($options);
						break;
					case 'subtabs':
						$this->render_subtab($options);
						break;
					case "text": case "number": case "phone": case "email": case "url":
						$this->render_text( $options );
						break;
					case "size":
						$this->render_size($options);
						break;
					case "textarea":
						$this->render_textarea($options);
						break;
					case "media":
						$this->render_media($options);
						break;
					case "select":
						$this->render_select($options, $tab);
						break;
					case "checkbox":
						$this->render_checkbox($options);
						break;
					case 'radio':
						$this->render_radio($options);
						break;
					case 'editor': 
						$this->render_editor($options);
						break;
					case 'wp_nonce_field':
						if( isset($options['key']) && isset($options['value']) ){
							wp_nonce_field( $options['value'], $options['key'] );
						}
						break;
				}
			}
		}

		private function render_tab($options = array()){
			if( count($options) == 0 ) return;
			?>
			<div class="nth_be_tabs">
				<?php if( isset($options['pagram']) && is_array($options['pagram'])): ?>
				<ul class="nth_be_tabs_head">
					<?php foreach( $options['pagram'] as $k => $tab ) {
						$class = array('nth_item_head');
						if( absint($k) == 0 ) $class[] = 'current';
						if(isset($tab['class'])) $class[] = trim( $tab['class'] );
						$tab_link = '#'.$tab['id'];
						printf('<li class="%s"><a href="%s">%s</a></li>', esc_attr(implode(' ', $class)), esc_url($tab_link), esc_html($tab['title']));
					}?>
				</ul>
				<div class="nth_be_tabs_content">
					<?php foreach( $options['pagram'] as $k => $tab ):
						$class = array('nth_item_cont');
						if( absint($k) == 0 ) $class[] = 'active';
						?>
						<div id="<?php echo esc_attr($tab['id']);?>" class="<?php echo esc_attr(implode(' ', $class))?>">
							<?php if( isset($tab['pagram']) && is_array($tab['pagram'])): ?>
							<ul class="list-options">
								<?php foreach( $tab['pagram'] as $element ) : ?>
								<li><?php $this->createElements($element, $tab);?></li>
								<?php endforeach;?>
							</ul>
							<?php endif;?>
						</div>
					<?php endforeach;?>
				</div>
				<?php endif;?>
			</div>
			<?php
		}

		private function render_subtab($options = array()){
			if( count($options) == 0 ) return;
			$class = array('nth_be_subtabs');
			if(isset( $options['class'] )) $class[] = esc_attr($options['class']);
			?>
			<div class="<?php echo esc_attr(implode(' ', $class));?>">
				<?php if( isset($options['pagram']) && is_array($options['pagram'])) : ?>
					<ul class="nth_be_subtabs_head">
						<?php foreach( $options['pagram'] as $k => $tab ) {
							$class = array('nth_item_head');
							if( absint($k) == 0 ) $class[] = 'current';
							if(isset($tab['class'])) $class[] = esc_attr($tab['class']);
							$tab_link = '#'.$tab['id'];
							printf('<li class="%s"><a href="%s">%s</a></li>', esc_attr(implode(' ', $class)), esc_url($tab_link), esc_html($tab['title']));
						} ?>
					</ul>
					<div class="nth_be_subtabs_content">
						<?php foreach( $options['pagram'] as $k => $tab ) :
							$class = array('nth_item_cont');
							if( absint($k) == 0 ) $class[] = 'active';
							?>
							<div id="<?php echo esc_attr($tab['id']);?>" class="<?php echo esc_attr(implode(' ', $class));?>" data-id="<?php esc_attr($k)?>">
								<?php if( isset($tab['pagram']) && is_array($tab['pagram'])) : ?>
									<ul class="list-options">
										<?php foreach( $tab['pagram'] as $element ) : ?>
											<li><?php $this->createElements($element, $tab);?></li>
										<?php endforeach;?>
									</ul>
								<?php endif;?>
							</div>
						<?php endforeach;?>
					</div>
				<?php endif;?>
			</div>
			<?php
		}

		private function render_text( $options = array() ){
			if( count($options) == 0 ) return;
			if( isset($options['name']) ) {
				$class = array('nth-form-row');
				if(isset( $options['class'] )) $class[] = esc_attr($options['class']);
				$options['ntd'] = isset( $options['ntd'] )? $options['ntd']: '';
				$placeholder = isset( $options['holder'] )? $options['holder']: '';
				?>
				<div class="<?php echo esc_attr(implode(' ', $class))?>">
					<?php if( isset($options['label']) ) printf('<label>%s</label>', esc_html($options['label']));?>
					<div class="nth-form-field">
						<input type="<?php echo esc_attr($options['type'])?>" placeholder="<?php echo esc_attr($placeholder);?>" name="<?php echo esc_attr($options['name']);?>" id="<?php echo esc_attr($options['name']);?>" value="<?php echo esc_attr($options['ntd']);?>" />
						<?php if( isset($options['desc']) && strlen($options['desc']) > 0 ) printf('<span class="desc">%s</span>', esc_html($options['desc']));?>
					</div>
				</div>
				<?php
			}
		}

		private function render_size($options = array()){
			if( count($options) == 0 ) return;
			if( isset($options['name']) ) {
				$class = array('nth-form-row');
				if(isset( $options['class'] )) $class[] = esc_attr($options['class']);
				$options['ntd'] = isset( $options['ntd'] ) && isset($options['ntd']['width']) && isset($options['ntd']['height'])?
					$options['ntd']: array("width"=>'', "height" => '');
				?>
				<div class="<?php echo esc_attr(implode(' ', $class));?>">
					<?php if( isset($options['label']) ) printf('<label>%s</label>', esc_html($options['label']));?>
					<div class="nth-form-field">
						<input type="number" name="<?php echo esc_attr($options['name']);?>[width]" id="<?php echo esc_attr($options['name']);?>_width" value="<?php echo esc_attr($options['ntd']['width']);?>" style='max-width: 65px;'/>&nbsp;&times;&nbsp;
						<input type="number" name="<?php echo esc_attr($options['name']);?>[height]" id="<?php echo esc_attr($options['name']);?>_height" value="<?php echo esc_attr($options['ntd']['height']);?>" style='max-width: 65px;'/>
						<?php if( isset($options['desc']) && strlen($options['desc']) > 0 ) printf('<span class="desc">%s</span>', esc_html($options['desc']));?>
					</div>
				</div>
				<?php
			}
		}

		private function render_textarea($options = array()){
			if( count($options) == 0 ) return;
			if( isset($options['name']) ) {
				$class = array('nth-form-row');
				if(isset( $options['class'] )) $class[] = esc_html($options['class']);
				$options['ntd'] = isset( $options['ntd'] )? $options['ntd']: '';
				$placeholder = isset( $options['holder'] )? esc_attr($options['holder']): '';
				?>
				<div class="<?php echo esc_attr(implode(' ', $class));?>">
					<?php if( isset($options['label']) ) printf('<label>%s</label>', esc_html($options['label']));?>
					<div class="nth-form-field">
						<textarea type="text" placeholder="<?php echo esc_attr($placeholder);?>" name="<?php echo esc_attr($options['name']);?>" id="<?php echo esc_attr($options['name']);?>"><?php echo esc_html($options['ntd']);?></textarea>
						<?php if( isset($options['desc']) && strlen($options['desc']) > 0 ) printf('<span class="desc">%s</span>', wp_kses($options['desc'], array('a' => array('title'=>array(), 'href'=>array(), 'target'=>array()))));?>
					</div>
				</div>
				<?php
			}
		}

		private function render_media($options = array()){
			if( count($options) == 0 ) return;
			if( isset($options['name']) ):
				$options['ntd'] = isset( $options['ntd'] ) && strlen($options['ntd']) > 0? $options['ntd']: '';
				$dis_none_remove = isset( $options['ntd'] ) && strlen($options['ntd']) > 0? "display: initial;": "display: none;";

				$class = isset( $options['class'] )? " ".$options['class']: '';
				?>
				<div class="nth-form-row<?php echo esc_attr( $class );?>">
					<?php if( isset($options['label']) ):?>
						<label><?php echo esc_html($options['label']);?></label>
					<?php endif;?>
					<div class="nth-form-field nth_upload_media" data-f_title="<?php esc_html_e( 'Choose an media', 'theshopier' ); ?>" data-f_btext="<?php esc_html_e( 'Use Media', 'theshopier' ); ?>">
						<input type="url" class="nth_media_output" name="<?php echo esc_attr( $options['name'] );?>" id="<?php echo esc_attr($options['name'] );?>" value="<?php echo esc_url($options['ntd']);?>" />
						<div class="controls">
							<button type="submit" class="upload_media_button button button-primary"><i class="dashicons-before dashicons-admin-media"></i></button>
							<button type="submit" class="remove_media_button button<?php if( !isset( $options['ntd'] ) || strlen($options['ntd']) <= 0 ) echo " hidden";?>"><i class="dashicons-before dashicons-trash"></i></button>
						</div>
					</div>
				</div>

				<?php
			endif;
		}

		private function render_select($options = array(), $tab = array()){
			if( empty($options) || empty($tab) ) return;
			if( isset($options['value']) && isset($options['name']) ) {
				$class = array('nth-form-row');
				if(isset( $options['class'] )) $class[] = esc_attr($options['class']);
				$request_data = '';
				if(!empty($options['request'])) {
					$class[] = 'nth-field-request';
					$options['request'] = wp_parse_args($options['request'], array(
						'element'	=> '',
						'values'	=> array(),
						'compare'	=> '=',
					));
					$request_data = wp_json_encode($options['request']);
					$current_pa_val = $this->get_current_val($tab, $options['request']['element']);
					if(empty($current_pa_val) || !is_array($options['request']['values']) || !in_array($current_pa_val, $options['request']['values'])) {
						$class[] = 'hidden';
					}
				}
				?>
				<div class="<?php echo esc_attr(implode(' ', $class));?>" data-request="<?php echo esc_attr($request_data);?>">
					<?php if( isset($options['label']) ) printf('<label>%s</label>', esc_html($options['label']));?>
					<div class="nth-form-field">
						<?php if( is_array($options['value']) && count($options['value']) > 0 ) : ?>
							<select name="<?php echo esc_attr($options['name']);?>" id="<?php echo esc_attr($options['name']);?>">
								<?php foreach( $options['value'] as $k => $v ) :
									$options['ntd'] = isset($options['ntd'])? esc_attr($options['ntd']): ''; ?>
									<option value="<?php echo esc_attr($k);?>" <?php selected($options['ntd'], $k);?>><?php echo esc_html($v);?></option>
								<?php endforeach;?>
							</select>
						<?php elseif(!empty($options['empty_mess'])): ?>
							<i><?php echo esc_html($options['empty_mess'])?></i>
						<?php endif;?>
						<?php if( !empty($options['desc']) ) printf('<span class="desc">%s</span>', esc_html($options['desc']));?>
					</div>
				</div>
				<?php
			}
		}

		private function render_checkbox($options = array()){
			if( count($options) == 0 ) return;
			if(isset($options['name'])):
				$class = array('nth-form-row');
				if(isset( $options['class'] )) $class[] = esc_attr($options['class']);
				$options['ntd'] = !empty($options['ntd'])? absint($options['ntd']): 0;
				?>
				<div class="<?php echo esc_attr(implode(' ', $class));?>">
					<?php if( isset($options['label']) ) printf('<label>%s</label>', esc_html($options['label']));?>
					<div class="nth-form-field">
						<input type="checkbox" name="<?php echo esc_attr( $options['name'] );?>" id="<?php echo esc_attr( $options['name'] );?>" <?php checked($options['ntd'], 1)?> value="1" />
					</div><!-- .form-field -->
				</div>
				<?php
			endif;
		}

		private function render_radio($options = array()) {
			if( count($options) == 0 ) return;
			if( isset($options['value']) ) {
				$options['ntd'] = isset($options['ntd'])? esc_attr($options['ntd']): '';
				?>
				<div class="nth-form-row">
					<?php if( !empty($options['label']) ) printf('<label>%s</label>', esc_html($options['label']));?>
					<?php if( is_array($options['value']) && count($options['value']) > 0 ) : ?>
						<?php foreach( $options['value'] as $k => $v ) :
							$radio_id = $options['name'] . '-' . $k;
							?>
							<input type="radio" name="<?php echo esc_attr($options['name'])?>" id="<?php echo esc_attr($radio_id)?>" value="<?php echo esc_attr($k);?>" <?php checked($options['ntd'], $k);?>>
							<label class="option-label" for="<?php echo esc_attr($radio_id);?>"><span class="nth-label <?php echo esc_attr($k)?>"><?php echo esc_html($v)?></span></label><br />
						<?php endforeach;?>
					<?php endif;?>
				</div>
				<?php
			}
		}

		private function render_editor($options = array()){
			if( count($options) == 0 ) return;
			if( isset($options['name']) ) {
				$class = array('nth-form-row');
				if(isset( $options['class'] )) $class[] = esc_attr($options['class']);
				$options['ntd'] = isset( $options['ntd'] )? $options['ntd']: '';
				?>
				<div class="<?php echo esc_attr(implode(' ', $class));?>">
					<?php if( isset($options['label']) ) printf('<label>%s</label>', esc_html($options['label'])); ?>
					<div class="nth-form-field">
						<?php wp_editor( stripslashes(htmlspecialchars_decode($options['ntd'])), esc_attr($options['name']), array("editor_height" => 225) );?>
						<?php if( isset($options['desc']) && strlen($options['desc']) > 0 ): ?>
							<span class="desc"><?php echo esc_html($options['desc']);?></span>
						<?php endif;?>
					</div>
				</div>
				<?php
			}
		}
	}
}