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
if( !class_exists( 'ReduxFramework_import_font' ) ) {

    /**
     * Main ReduxFramework_custom_field class
     *
     * @since       1.0.0
     */
    class ReduxFramework_import_font extends ReduxFramework {
    
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
                $extension_dir = get_template_directory() . '/framework/incs/redux-framework/extensions/import_font/import_font';
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
        function render() {
			if ( ! empty( $this->field['data'] ) && empty( $this->field['options'] ) ) {
                if ( empty( $this->field['args'] ) ) {
                    $this->field['args'] = array();
                }

                $this->field['options'] = $this->parent->get_wordpress_data( $this->field['data'], $this->field['args'] );
                $this->field['class'] .= " hasOptions ";
            }
			
			if ( empty( $this->value ) && ! empty( $this->field['data'] ) && ! empty( $this->field['options'] ) ) {
                $this->value = $this->field['options'];
            }
            $filename = empty( $this->field['filename'] )? 'font_options': $this->field['filename'];
			$xml_exist = ( file_exists(THEME_FRAMEWORK_INCS . "redux-framework/xml/".$filename.".xml") )? 1: 0;

			?>
			<div class="nth-redux-import-export">
				<button class="nth-import-btn button button-primary" data-assign="<?php echo esc_attr($this->field['id'])?>"><i class="el el-upload"></i> <?php esc_html_e('Import', 'theshopier' );?></button>
				<input type="file" data-file_exists="<?php echo absint($xml_exist);?>" class="nth-import-input-file" data-filename="<?php echo esc_attr($filename)?>" data-action="theshopier_import_font_xml" style="display: none;" id="<?php echo esc_attr($this->field['id'])?>" name="nth_import_font" />
			</div>
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
                'theshopier-field_import_font-js',
                $this->extension_url . 'field_import_font.js', 
                array( 'jquery' ),
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
