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
 * @author      Dovy Paukstys (dovy)
 * @version     3.0.0
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_extension_custom_field' ) ) {


    /**
     * Main ReduxFramework custom_field extension class
     *
     * @since       3.1.6
     */
    class ReduxFramework_extension_custom_field extends ReduxFramework {

        // Protected vars
        protected $parent;
        public $extension_url;
        public $extension_dir;
        public static $theInstance;

        /**
        * Class Constructor. Defines the args for the extions class
        *
        * @since       1.0.0
        * @access      public
        * @param       array $sections Panel sections.
        * @param       array $args Class constructor arguments.
        * @param       array $extra_tabs Extra panel tabs.
        * @return      void
        */
        public function __construct( $parent ) {
            
            $this->parent = $parent;
            if ( empty( $this->extension_dir ) ) {
                $extension_dir = get_template_directory() . '/framework/incs/redux-framework/extensions/custom_field';
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', $extension_dir ) );
            }
            $field_args = array('multi_social');

            self::$theInstance = $this;

            $this->register_redux_filter( $field_args );

        }

		public function register_redux_filter( $field_args = array() ){
			foreach( $field_args as $field_name ) {
				$this->field_name = $field_name;
				add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/class/'.$field_name, array( &$this, 'overload_field_path' ) ); 
			}
		}
		
        public function getInstance() {
            return self::$theInstance;
        }

        // Forces the use of the embeded field path vs what the core typically would use    
        public function overload_field_path($field) {
            $extension_dir = get_template_directory() . '/framework/incs/redux-framework/extensions/custom_field';
            return $extension_dir .'/'.$this->field_name.'/field_'.$this->field_name.'.php';
        }

    } // class
} // if
