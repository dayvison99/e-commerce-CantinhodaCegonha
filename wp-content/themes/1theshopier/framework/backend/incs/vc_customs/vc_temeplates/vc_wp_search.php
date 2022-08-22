<?php
$output = $title = $el_class = '';
extract( shortcode_atts( array(
	'title' 		=> '',
	'el_class'	 	=> '',
	'bg_color'		=> '',
	'hidden_label'	=> ''
), $atts ) );

$el_class = $this->getExtraClass( $el_class );

$theshopier_class  = strlen( $hidden_label ) > 0? ' '.$hidden_label: '';
$theshopier_class .= strlen( $bg_color ) > 0? ' use_background': '';
$bg_color = strlen( $bg_color ) > 0? $bg_color: 'transparent';

$type = 'WP_Widget_Search';
$args = array();
?>
<div style="background-color: <?php echo esc_attr($bg_color);?>" class="vc_wp_search wpb_content_element <?php echo esc_attr($el_class . $theshopier_class);?>">

	<?php the_widget( $type, $atts, $args );?>

</div><!-- END .vc_wp_search -->
