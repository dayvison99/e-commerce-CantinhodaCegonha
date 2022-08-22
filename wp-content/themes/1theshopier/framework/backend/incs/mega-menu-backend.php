<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package     ReduxFramework\Uninstall
 * @author      Dovy Paukstys <info@simplerain.com>
 * @since       3.0.0
 */

class Theshopier_Walker_Nav_Menu_Edit extends Walker_Nav_Menu  {
	
	public $menu_opts;
	
	function __construct() {
		
	}
	
	function start_lvl( &$output, $depth = 0, $args = array() ) {}
	
	function end_lvl( &$output, $depth = 0, $args = array() ) {}
	
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	 
		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);
	 
		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		}
	 
		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);
	 
		$title = $item->title;
	 
		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( esc_html__( '%s (Invalid)', 'theshopier' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( esc_html__( '%s (Pending)', 'theshopier' ), $item->title );
		}
	 
		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;
	 
		$submenu_text = array('is-submenu');
		if ( 0 == $depth )
			$submenu_text[] = 'hidden';
		
		$input_key = "edit-menu-item-";

		$mega_field_act = strcmp( $item->mega, '1' )!==0? "hidden": '';
		
		?>
		<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo esc_attr(implode(' ', $classes )); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="<?php echo esc_attr(implode(' ', $submenu_text));?>"><?php esc_html_e( 'sub item', 'theshopier' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'theshopier' ); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'theshopier' ); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'theshopier'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', absint($item_id), remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . absint($item_id) ) ) );
						?>"><?php esc_html_e( 'Edit Menu Item', 'theshopier' ); ?></a>
					</span>
				</dt>
			</dl>
	 
			<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
				
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-thin">
						<label for="<?php echo esc_attr($input_key);?>url-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'URL', 'theshopier' ); ?><br />
							<input type="text" id="<?php echo esc_attr($input_key);?>url-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="<?php echo esc_attr($input_key);?>title-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Navigation Label', 'theshopier' ); ?><br />
						<input type="text" id="<?php echo esc_attr($input_key);?>title-<?php echo esc_attr($item_id); ?>" class="widefat <?php echo esc_attr($input_key);?>title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="<?php echo esc_attr($input_key);?>attr-title-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Title Attribute', 'theshopier' ); ?><br />
						<input type="text" id="<?php echo esc_attr($input_key);?>attr-title-<?php echo esc_attr($item_id); ?>" class="widefat <?php echo esc_attr($input_key);?>attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				
				<p class="field-link-target description description-thin">
					<label for="<?php echo esc_attr($input_key);?>target-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="<?php echo esc_attr($input_key);?>target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new window/tab', 'theshopier' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="<?php echo esc_attr($input_key);?>classes-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'CSS Classes (optional)', 'theshopier' ); ?><br />
						<input type="text" id="<?php echo esc_attr($input_key);?>classes-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="<?php echo esc_attr($input_key);?>xfn-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)', 'theshopier' ); ?><br />
						<input type="text" id="<?php echo esc_attr($input_key);?>xfn-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="<?php echo esc_attr($input_key);?>description-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Description', 'theshopier' ); ?><br />
						<textarea id="<?php echo esc_attr($input_key);?>description-<?php echo esc_attr($item_id); ?>" class="widefat <?php echo esc_attr($input_key);?>description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php esc_html_e('The description will be displayed in the menu if the current theme supports it.', 'theshopier' ); ?></span>
					</label>
				</p>
				<div class="clear"></div>
				
				<p class="description description-thin">
					<label for="<?php echo esc_attr($input_key);?>text-color-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Text Color', 'theshopier' ); ?><br />
						<input type="text" id="<?php echo esc_attr($input_key);?>text-color-<?php echo esc_attr($item_id); ?>" class="widefat <?php echo esc_attr($input_key);?>text-color nth-colorpicker" name="menu-item-text-color[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->text_color );?>" data-default-color="#000000" />
					</label>
				</p>
				
				<div class="description description-thin">
					<label for="<?php echo esc_attr($input_key);?>icon-id-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Icon image', 'theshopier' ); ?><br />
						<?php $image = THEME_BACKEND_URI . "images/placeholder.png";
							$dis_none_remove = "display: none;";
							if( absint($item->icon_id)  > 0 ){
								$image = wp_get_attachment_image_src( $item->icon_id, 'thumbnail' );
								$image = $image[0];
								$dis_none_remove = "display: inline-block;";
							}
						?>
						<div class="nth_upload_image" data-f_title="<?php esc_html_e( 'Choose an image', 'theshopier' ); ?>" data-f_btext="<?php esc_html_e( 'Use image', 'theshopier' ); ?>">
							<div class="nth_thumbnail" style="float:left;margin-right:10px;">
								<?php theshopier_getImage(array(
									'src'	=> esc_url($image),
									'alt'	=> esc_attr__('Media thumbnail', 'theshopier'),
									'width' => '28',
									'height' => '28'
								));?>
							</div>
							<div style="line-height:28px;">
								<input type="hidden" class="nth_image_id <?php echo esc_attr($input_key);?>icon-id" name="menu-item-icon-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->icon_id ); ?>" />
								<button type="submit" class="nth_upload_image_button button"><?php esc_html_e( 'Add image', 'theshopier' ); ?></button>
								<button type="submit" style="<?php echo esc_attr($dis_none_remove);?>" class="nth_remove_image_button button"><?php esc_html_e( 'Remove', 'theshopier' ); ?></button>
							</div>
						</div>
						
						<div class="clear"></div>
							
					</label>
				</div>

				<div class="description description-thin nth-meta-toggle <?php echo esc_attr($mega_field_act);?>">
					<label for="<?php echo esc_attr($input_key);?>backg-id-<?php echo esc_attr($item_id); ?>">
						<?php esc_html_e( 'Background image', 'theshopier' ); ?><br />
						<?php $image = THEME_BACKEND_URI . "images/placeholder.png";
							$dis_none_remove = "display: none;";
							if( absint($item->backg_id)  > 0 ){
								$image = wp_get_attachment_image_src( $item->backg_id, 'thumbnail' );
								$image = $image[0];
								$dis_none_remove = "display: inline-block;";
							}
						?>
						<div class="nth_upload_image" data-f_title="<?php esc_html_e( 'Choose an image', 'theshopier' ); ?>" data-f_btext="<?php esc_html_e( 'Use image', 'theshopier' ); ?>">
							<div class="nth_thumbnail" style="float:left;margin-right:10px;">
								<?php theshopier_getImage(array(
									'src'	=> esc_url($image),
									'alt'	=> esc_attr__('Media thumbnail', 'theshopier'),
									'width' => '28',
									'height' => '28'
								));?>
							</div>
							<div style="line-height:28px;">
								<input type="hidden" class="nth_image_id <?php echo esc_attr($input_key);?>backg-id" name="menu-item-backg-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->backg_id ); ?>" />
								<button type="submit" class="nth_upload_image_button button"><?php esc_html_e( 'Add image', 'theshopier' ); ?></button>
								<button type="submit" style="<?php echo esc_attr($dis_none_remove);?>" class="nth_remove_image_button button"><?php esc_html_e( 'Remove', 'theshopier' ); ?></button>
							</div>
						</div>

						<div class="clear"></div>

					</label>
				</div>
				
				<div class="clear"></div>
				
				
				<?php if( !absint( $item->menu_item_parent ) ):?>
				<div class="nth-adv-menu-opts">
					
					<p class="field-mega description description-thin">
						<label for="<?php echo esc_attr($input_key);?>mega-<?php echo esc_attr($item_id); ?>">
							<input type="checkbox" id="<?php echo esc_attr($input_key);?>mega-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>mega" <?php echo strcmp( $item->mega, '1' )==0? "checked=\"checked\"": '';?> name="menu-item-mega[<?php echo esc_attr($item_id); ?>]" value="1" /><?php esc_html_e( 'Use mega menu', 'theshopier' ); ?>
						</label>
					</p>
					
					<p class="field-label description description-thin">
						<label for="<?php echo esc_attr($input_key);?>label-<?php echo esc_attr($item_id); ?>">
							<?php esc_html_e( 'Label:', 'theshopier' ); ?><br />
							<select id="<?php echo esc_attr($input_key);?>label-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>label" name="menu-item-label[<?php echo esc_attr($item_id); ?>]">
								<option value=""></option>
								<option value="lb_new" <?php selected(esc_attr($item->f_label), 'lb_new')?>><?php esc_html_e('New', 'theshopier')?></option>
								<option value="lb_sale" <?php selected(esc_attr($item->f_label), 'lb_sale')?>><?php esc_html_e('Sale', 'theshopier')?></option>
							</select>
						</label>
					</p>
					
					<div class="clear"></div>

					<p class="field-width description description-thin nth-meta-toggle <?php echo esc_attr($mega_field_act);?>">
						<?php esc_html_e( 'Width:', 'theshopier' ); ?><br />
						<label for="<?php echo esc_attr($input_key);?>width-<?php echo esc_attr($item_id); ?>">
							<select id="<?php echo esc_attr($input_key);?>width-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>width" name="menu-item-width[<?php echo esc_attr($item_id); ?>]">
								<option value="1" <?php selected(absint($item->width), 1);?>><?php esc_html_e('Mega menu width 1', 'theshopier')?></option>
								<option value="2" <?php selected(absint($item->width), 2);?>><?php esc_html_e('Mega menu width 2', 'theshopier')?></option>
								<option value="3" <?php selected(absint($item->width), 3);?>><?php esc_html_e('Mega menu width 3', 'theshopier')?></option>
								<option value="4" <?php selected(absint($item->width), 4);?>><?php esc_html_e('Mega menu width 4', 'theshopier')?></option>
								<option value="5" <?php selected(absint($item->width), 5);?>><?php esc_html_e('Mega menu width 5', 'theshopier')?></option>
							</select>
						</label>
					</p>
					
					<p class="field-widget description description-thin nth-meta-toggle <?php echo esc_attr($mega_field_act);?>">
						<?php esc_html_e( 'Static block:', 'theshopier' ); ?><br />
						<label for="<?php echo esc_attr($input_key);?>widget-<?php echo esc_attr($item_id); ?>">
							<?php $nexthemes_stblocks = class_exists('Nexthemes_StaticBlock')? Nexthemes_StaticBlock::getStaticBlocks( array( 'menu', 'all' ) ): array();
							if( count($nexthemes_stblocks) > 0 ):?>
							
							<select id="<?php echo esc_attr($input_key);?>widget-<?php echo esc_attr($item_id); ?>" class="widefat code <?php echo esc_attr($input_key);?>widget" name="menu-item-widget[<?php echo esc_attr($item_id); ?>]">
								<?php foreach ($nexthemes_stblocks as $key): ?>
									<option value="<?php echo esc_attr($key['id']); ?>" <?php selected(absint($item->widget), absint($key['id'])); ?>><?php echo esc_html($key['title']) ?></option>
								<?php endforeach ?>
							</select>
							<?php else: esc_html_e('Please create static block for menu.', 'theshopier' );endif;?>
						</label>
					</p>
					
				</div>
				<?php endif;?>
				
				
				<!--p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php esc_html_e( 'Move', 'theshopier' ); ?></span>
						<a href="#" class="menus-move menus-move-up" data-dir="up"><?php esc_html_e( 'Up one', 'theshopier' ); ?></a>
						<a href="#" class="menus-move menus-move-down" data-dir="down"><?php esc_html_e( 'Down one', 'theshopier' ); ?></a>
						<a href="#" class="menus-move menus-move-left" data-dir="left"></a>
						<a href="#" class="menus-move menus-move-right" data-dir="right"></a>
						<a href="#" class="menus-move menus-move-top" data-dir="top"><?php esc_html_e( 'To the top', 'theshopier' ); ?></a>
					</label>
				</p-->
	 
				<div class="menu-item-actions description-full submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( esc_html__( 'Original: %s', 'theshopier' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php esc_html_e( 'Remove', 'theshopier' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => esc_attr($item_id), 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php esc_html_e( 'Cancel', 'theshopier' ); ?></a>
				</div>
	 
				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				
			</div><!-- .menu-item-settings-->
			
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
	
}

if( class_exists('Theshopier_Walker_Nav_Menu_Edit') ) {
	
	add_filter( 'wp_edit_nav_menu_walker', 'theshopier_add_items_custom_walker', 10, 2 );
	
	function theshopier_add_items_custom_walker( $class, $menu_id ){
		return 'Theshopier_Walker_Nav_Menu_Edit';
	}

}

function theshopier_get_menu_widget_sidebar( $value ){
	$menu_number = 5;
	for( $i = 1; $i <= $menu_number; $i++ ){ 
	?>
		<option <?php echo strcmp( $value, 'nth-mega-menu-widget-'.$i )==0? "selected=\"selected\"": '';?> value="nth-mega-menu-widget-<?php echo absint($i)?>">NTH Memu Widget Sidebar <?php echo absint($i);?></option>
	<?php 
	}
}