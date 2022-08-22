<?php
$ecommerce_plus_options = ecommerce_plus_get_theme_options();

// Add service section
$wp_customize->add_section( 'ecommerce_plus_contact_section', array(
	'title'             => esc_html__( 'Contacts','ecommerce-plus' ),
	'description'       => esc_html__( 'If this section not appears, First create a page from home-page-template and set as home page. Then open customizer.', 'ecommerce-plus' ),
	'panel'             => 'ecommerce_plus_home_panel',
));

$wp_customize->selective_refresh->add_partial( 'ecommerce_plus_options[contact_section_title]', array(
	'selector' => '#home-contact-section .section-title',
) );

// blog title settings and control
$wp_customize->add_setting( 'ecommerce_plus_options[contact_section_title]', array(
	'default'			=> $ecommerce_plus_options['contact_section_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'      		=> 'option',
) );

$wp_customize->add_control( 'ecommerce_plus_options[contact_section_title]', array(
	'label'           	=> esc_html__( 'Section Title', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_contact_section',
	'type'				=> 'text',
) );


// About btn title setting and control
$wp_customize->add_setting( 'ecommerce_plus_options[contact_form_shortcode]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $ecommerce_plus_options['contact_form_shortcode'],
	'type'      		=> 'option',
	'transport'			=> 'postMessage',
));

$wp_customize->add_control( 'ecommerce_plus_options[contact_form_shortcode]', array(
	'label'           	=> esc_html__( 'Contact Form Shortcode', 'ecommerce-plus' ),
	'description'       => esc_html__( '(Install contact form 7 and put shortcode here.)', 'ecommerce-plus' ),
	'section'        	=> 'ecommerce_plus_contact_section',
	'type'				=> 'text',
));
