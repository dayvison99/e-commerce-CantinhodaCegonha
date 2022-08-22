<?php
function storebiz_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer', 'storebiz'),
		) 
	);
	
	// Footer Background // 
	$wp_customize->add_section(
        'footer_background',
        array(
            'title' 		=> __('Footer Background','storebiz'),
			'panel'  		=> 'footer_section',
			'priority'      => 3,
		)
    );
	
	// Background // 
	$wp_customize->add_setting(
		'footer_bg_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_text',
			'priority' => 1,
		)
	);

	$wp_customize->add_control(
	'footer_bg_head',
		array(
			'type' => 'hidden',
			'label' => __('Background','storebiz'),
			'section' => 'footer_background',
		)
	);
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'footer_bg_img' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/bg/footer_bg.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_url',	
			'priority' => 10,
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_bg_img' ,
		array(
			'label'          => esc_html__( 'Background Image', 'storebiz'),
			'section'        => 'footer_background',
		) 
	));
	
	// Background Attachment // 
	$wp_customize->add_setting( 
		'footer_back_attach' , 
			array(
			'default' => 'scroll',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_select',
			'priority'  => 10,
		) 
	);
	
	$wp_customize->add_control(
	'footer_back_attach' , 
		array(
			'label'          => __( 'Background Attachment', 'storebiz' ),
			'section'        => 'footer_background',
			'type'           => 'select',
			'choices'        => 
			array(
				'inherit' => __( 'Inherit', 'storebiz' ),
				'scroll' => __( 'Scroll', 'storebiz' ),
				'fixed'   => __( 'Fixed', 'storebiz' )
			) 
		) 
	);
	
	// Footer Bottom // 
	$wp_customize->add_section(
        'footer_bottom',
        array(
            'title' 		=> __('Footer Bottom','storebiz'),
			'panel'  		=> 'footer_section',
			'priority'      => 3,
		)
    );
	// Footer Copyright Head
	$wp_customize->add_setting(
		'footer_btm_copy_head'
			,array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'storebiz_sanitize_text',
			'priority'  => 3,
		)
	);

	$wp_customize->add_control(
	'footer_btm_copy_head',
		array(
			'type' => 'hidden',
			'label' => __('Copyright','storebiz'),
			'section' => 'footer_bottom',
		)
	);
	
	// Footer Copyright 
	$storebiz_foo_copy = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'storebiz' );
	$wp_customize->add_setting(
    	'footer_copyright',
    	array(
			'default' => $storebiz_foo_copy,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'wp_kses_post',
			'priority'      => 4,
		)
	);	

	$wp_customize->add_control( 
		'footer_copyright',
		array(
		    'label'   		=> __('Copytight','storebiz'),
		    'section'		=> 'footer_bottom',
			'type' 			=> 'textarea',
			'transport'         => $selective_refresh,
		)  
	);	
}
add_action( 'customize_register', 'storebiz_footer' );
// Footer selective refresh
function storebiz_footer_partials( $wp_customize ){
	// footer_copyright
	$wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
		'selector'            => '#footer-section .footer-copyright .copyright-text',
		'settings'            => 'footer_copyright',
		'render_callback'  => 'storebiz_footer_copyright_render_callback',
	) );
}
add_action( 'customize_register', 'storebiz_footer_partials' );

// copyright_content
function storebiz_footer_copyright_render_callback() {
	return get_theme_mod( 'footer_copyright' );
}