<?php
/**
* Customizer validation functions
*
* @package ceylonthemes
* @subpackage eCommerce Plus
* @since 1.0.0
*/

if ( ! function_exists( 'ecommerce_plus_validate_long_excerpt' ) ) :
  function ecommerce_plus_validate_long_excerpt( $validity, $value ){
         $value = intval( $value );
     if ( empty( $value ) || ! is_numeric( $value ) ) {
         $validity->add( 'required', esc_html__( 'You must supply a valid number.', 'ecommerce-plus' ) );
     } elseif ( $value < 5 ) {
         $validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 5', 'ecommerce-plus' ) );
     } elseif ( $value > 100 ) {
         $validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'ecommerce-plus' ) );
     }
     return $validity;
  }
endif;
