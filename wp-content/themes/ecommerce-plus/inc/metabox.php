<?php
/**
 * Metabox file.
 *
 * This is the template that shows the metaboxes.
 *
 * @package ceylonthemes
 * @subpackage eCommerce Plus
 * @since 1.0.0
 */

/**
 * Class to Renders and save metabox options
 *
 * @since 1.0.0
 */
class ecommerce_plus_MetaBox {
    private $meta_box;

    private $fields;

    /**
    * Constructor
    *
    * @since 1.0.0
    *
    * @access public
    *
    */
    public function __construct( $meta_box_id, $meta_box_title, $post_type ) {
        
        $this->meta_box = array (
                            'id'        => $meta_box_id,
                            'title'     => $meta_box_title,
                            'post_type' => $post_type,
                            );

        $this->fields = array(
                            'ecommerce-plus-header-layout',
                            'ecommerce-plus-header-style',
                            );


        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'add' ) );
        
        add_action( 'save_post', array( $this, 'save' ) );  
    }

    /**
    * Add Meta Box for multiple post types.
    *
    * @since 1.0.0
    *
    * @access public
    */
    public function add($postType) {
        if( in_array( $postType, $this->meta_box['post_type'] ) ) {
            add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'show' ), $postType, 'side' );
        }
    }

    /**
    * Renders metabox
    *
    * @since 1.0.0
    *
    * @access public
    */
    public function show() {
        global $post;

        $layout_options      = ecommerce_plus_header_layout();
        $style_options       = ecommerce_plus_header_type();
        
        
        // Use nonce for verification  
        wp_nonce_field( basename( __FILE__ ), 'ecommerce_plus_custom_meta_box_nonce' );

        // Begin the field table and loop  ?>  
        <div id="ecommerce-plus-ui-tabs" class="ui-tabs">
            <ul class="ecommerce-plus-ui-tabs-nav" id="ecommerce-plus-ui-tabs-nav">
                <li><a href="#frag1"><?php esc_html_e( 'Header Layout', 'ecommerce-plus' ); ?></a></li>
                <li><a href="#frag2"><?php esc_html_e( 'Header Style', 'ecommerce-plus' ); ?></a></li>
            </ul> 

            <div id="frag1" class="tabhead">
                <table id="layout-options" class="form-table" width="100%">
                    <tbody>
                        <tr>
                            <?php  
                                $metalayout = get_post_meta( $post->ID, 'ecommerce-plus-header-layout', true );
                                if( empty( $metalayout ) ){
                                    $metalayout = 'storefront';
                                }

                                foreach ( $layout_options as $value => $url ) :
                                    echo '<label>';
                                    echo '<input type="radio" name="ecommerce-plus-header-layout" value="' . esc_attr( $value ) . '" ' . checked( $metalayout, $value, false ) . ' />';
                                    echo '<img src="' . esc_url( $url ) . '"/>';
                                    echo '</label>';
                                endforeach;
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="frag2" class="tabhead">
                <table id="sidebar-metabox" class="form-table" width="100%">
                    <tbody> 
                        <tr>
                            <?php
                            $style = get_post_meta( $post->ID, 'ecommerce-plus-header-style', true );
                            if ( empty( $style ) ){
                                $style = 'shadow';
                            } 
                            foreach ( $style_options as $field => $value ) {  
                            ?>
                                <td style="vertical-align:top;">
                                    <label class="description">
                                        <input type="radio" name="ecommerce-plus-header-style" value="<?php echo esc_attr( $field ); ?>" <?php checked( $style, $field ); ?>/>&nbsp;&nbsp;<?php echo esc_html( $value ); ?>
                                    </label>
                                </td>
                                
                            <?php
                            } // end foreach 
                            ?>
                        </tr>
                    </tbody>
                </table>        
            </div>

        </div>
    <?php 
    }

    /**
     * Save custom metabox data
     * 
     * @action save_post
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function save( $post_id ) { 
    
        // Checks save status
        $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'ecommerce_plus_nonce' ] ) && wp_verify_nonce( sanitize_key( $_POST[ 'ecommerce_plus_nonce' ] ), basename( __FILE__ ) ) ) ? 'true' : 'false';

        // Exits script depending on save status
        if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
            return;
        }
      
        foreach ( $this->fields as $field ) {      
            // Checks for input and sanitizes/saves if needed
            if( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
            }
        } // end foreach         
    }
}
$ecommerce_plus_post_types = array( 'page', 'post' );

$ecommerce_plus_metabox = new ecommerce_plus_MetaBox( 
                                    'ecommerce-plus-options',     //metabox id
                                    esc_html__( 'Page Options', 'ecommerce-plus' ), //metabox title
                                    $ecommerce_plus_post_types            //metabox post types
                                    );

/**
 * Enqueue scripts and styles for Metaboxes
 * @uses wp_enqueue_script, and  wp_enqueue_style
 *
 * @since 1.0.0
 */
function ecommerce_plus_enqueue_metabox_scripts( $hook ) {

    if( $hook == 'post.php' || $hook == 'post-new.php'  ){
        //Scripts
        wp_enqueue_script( 'ecommerce-plus-metabox', get_template_directory_uri() . '/js/metabox.js', array( 'jquery', 'jquery-ui-tabs' ), '20201201' );
        //CSS Styles
        wp_enqueue_style( 'ecommerce-plus-metabox-tabs', get_template_directory_uri() . '/css/metabox-tabs.css' );
    }
    return;
}
add_action( 'admin_enqueue_scripts', 'ecommerce_plus_enqueue_metabox_scripts', 11 );
