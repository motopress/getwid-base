<?php
/**
 * getwid_base Theme Customizer
 *
 * @package getwid_base
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function getwid_base_customize_register( $wp_customize ) {

	$default_colors = getwid_base_get_default_colors();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'getwid_base_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'getwid_base_customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_panel( 'getwid_base_options', array(
		'title' => esc_html__( 'Theme Options', 'getwid-base' )
	) );

	$wp_customize->add_section( 'getwid_base_header', array(
		'title' => esc_html__( 'Header Options', 'getwid-base' ),
		'panel' => 'getwid_base_options'
	) );

	$wp_customize->add_setting( 'getwid_base_hide_header_search', array(
		'default'           => false,
		'type'              => 'theme_mod',
		'transport'         => 'refresh',
		'sanitize_callback' => 'getwid_base_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'getwid_base_hide_header_search', array(
		'label'    => esc_html__( 'Hide Header Search?', 'getwid-base' ),
		'section'  => 'getwid_base_header',
		'type'     => 'checkbox',
		'settings' => 'getwid_base_hide_header_search'
	) );

	$wp_customize->add_section( 'getwid_base_footer', array(
		'title' => esc_html__( 'Footer Options', 'getwid-base' ),
		'panel' => 'getwid_base_options'
	) );

	$footer_default_text = _x(
        '%2$s &copy; %1$s. All Rights Reserved.<br> <span style="font-size: .875em">Powered by <a href="https://motopress.com/products/getwid-base/" rel="nofollow">Getwid Base</a> WordPress theme.</span>',
        'Default footer text. %1$s - current year, %2$s - site title.',
        'getwid-base'
    );
	$wp_customize->add_setting( 'getwid_base_footer_text', array(
		'default'           => $footer_default_text,
		'transport'         => 'postMessage',
		'type'              => 'theme_mod',
		'sanitize_callback' => 'wp_kses_post'
	) );
	$wp_customize->add_control( 'getwid_base_footer_text', array(
		'label'       => esc_html__( 'Footer Text', 'getwid-base' ),
		/* translators: %1$s: current year. */
		'description' => esc_html__( 'Use %1$s to insert the current year. Does not work in the Live Preview.', 'getwid-base' ),
		'section'     => 'getwid_base_footer',
		'type'        => 'textarea',
		'settings'    => 'getwid_base_footer_text'
	) );

	$wp_customize->add_setting( 'getwid_base_sidebars_layout', array(
		'default'           => '40-20-20-20',
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'getwid_base_sanitize_radio'
	) );
	$wp_customize->add_control( 'getwid_base_sidebars_layout', array(
		'label'       => esc_html__( 'Footer Widgets Layout', 'getwid-base' ),
		'description' => esc_html__( 'Layout will be adjusted automatically if some of sidebars have no widgets. Columns width in percentage. Slash means new row.', 'getwid-base' ),
		'type'        => 'radio',
		'section'     => 'getwid_base_footer',
		'settings'    => 'getwid_base_sidebars_layout',
		'choices'     => array(
			'40-20-20-20'   => '40-20-20-20',
			'25-25-25-25'   => '25-25-25-25',
			'33-33-33-100'  => '33-33-33 / 100',
			'100-33-33-33'  => '100 / 33-33-33',
			'100-50-50-100' => '100 / 50-50 / 100',
			'50-50-50-50'   => '50-50 / 50-50'
		),
	) );

	$wp_customize->add_setting( 'getwid_base_header_menu_color', array(
		'default'           => $default_colors['header-menu'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_header_menu_color', array(
		'label'       => esc_html__( 'Primary Menu Color', 'getwid-base' ),
		'description' => esc_html__( 'Color of the primary menu in header.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_header_menu_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_header_bg_color', array(
		'default'           => $default_colors['header-bg'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_header_bg_color', array(
		'label'       => esc_html__( 'Header Background Color', 'getwid-base' ),
		'description' => esc_html__( 'Background color for the header.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_header_bg_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_primary_color', array(
		'default'           => $default_colors['primary'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_primary_color', array(
		'label'       => esc_html__( 'Primary Color', 'getwid-base' ),
		'description' => esc_html__( 'Primary color of buttons, links etc.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_primary_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_secondary_color', array(
		'default'           => $default_colors['secondary'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_secondary_color', array(
		'label'       => esc_html__( 'Secondary Color', 'getwid-base' ),
		'description' => esc_html__( 'Secondary color like buttons hover etc.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_secondary_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_secondary_2_color', array(
		'default'           => $default_colors['secondary-2'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_secondary_2_color', array(
		'label'       => esc_html__( 'Additional Color', 'getwid-base' ),
		'description' => esc_html__( 'Background color of search modal window, gradient on pages and posts.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_secondary_2_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_text_color', array(
		'default'           => $default_colors['text'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_text_color', array(
		'label'       => esc_html__( 'Text Color', 'getwid-base' ),
		'description' => esc_html__( 'Main text color.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_text_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_heading_color', array(
		'default'           => $default_colors['heading'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_heading_color', array(
		'label'       => esc_html__( 'Headings Color', 'getwid-base' ),
		'description' => esc_html__( 'Headings text color.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_heading_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_background_blocks_color', array(
		'default'           => $default_colors['background-blocks'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_background_blocks_color', array(
		'label'       => esc_html__( 'Form Fields & Blocks Background', 'getwid-base' ),
		'description' => esc_html__( 'Form fields and some blocks background color, e.g. recent posts, custom post type, posts carousel, testimonials.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_background_blocks_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_border_color', array(
		'default'           => $default_colors['border'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_border_color', array(
		'label'       => esc_html__( 'Form Fields, Blocks Border and Lines Color', 'getwid-base' ),
		'description' => esc_html__( 'Form fields and some blocks border & lines color.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_border_color'
	) ) );

	$wp_customize->add_setting( 'getwid_base_border_focus_color', array(
		'default'           => $default_colors['border-focus'],
		'type'              => 'theme_mod',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'getwid_base_border_focus_color', array(
		'label'       => esc_html__( 'Form Fields Border Focus Color', 'getwid-base' ),
		'description' => esc_html__( 'Form fields border color on focus.', 'getwid-base' ),
		'section'     => 'colors',
		'setting'     => 'getwid_base_border_focus_color'
	) ) );

	$color_palette_colors = getwid_base_get_default_color_palette_colors();
	foreach ( $color_palette_colors as $color_palette_color ) {
		$setting_id = 'getwid_editor_color_' . str_replace( '-', '_', $color_palette_color['slug'] );
		$wp_customize->add_setting( $setting_id, array(
			'default'           => $color_palette_color['color'],
			'type'              => 'theme_mod',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $setting_id, array(
			/* translators: %1$s: color label in block editor. */
			'label'   => sprintf( esc_html__( 'Block Editor - %1$s', 'getwid-base' ), $color_palette_color['name'] ),
			'section' => 'colors',
			'setting' => $setting_id
		) ) );
	}
}

add_action( 'customize_register', 'getwid_base_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function getwid_base_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function getwid_base_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function getwid_base_customize_preview_js() {
	wp_enqueue_script( 'getwid-base-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), getwid_base_get_theme_version(), true );
	wp_localize_script( 'getwid-base-customizer', 'getwidBaseCustomizer', array(
		'defaultEditorColors' => getwid_base_get_default_color_palette_colors()
	) );
}

add_action( 'customize_preview_init', 'getwid_base_customize_preview_js' );

function getwid_base_sanitize_radio( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function getwid_base_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

function getwid_base_get_default_colors() {
	return [
		'site-background'   => 'ffffff',
		'primary'           => '#8f4ec7',
		'secondary'         => '#68c5f9',
		'secondary-2'       => '#f7fbfe',
		'header-bg'         => '',
		'header-menu'       => '#2c3847',
		'text'              => '#7b838b',
		'heading'           => '#2c3847',
		'background-blocks' => '#ffffff',
		'border'            => '#ebeef1',
		'border-focus'      => '#ebeef1',
	];
}

function getwid_base_enqueue_colors_style() {

	if ( is_customize_preview() ) {
		return;
	}

	$css = getwid_base_generate_customizer_styles();

	if ( $css ) {
		wp_add_inline_style( 'getwid-base-style', $css );
	}
}

add_action( 'wp_enqueue_scripts', 'getwid_base_enqueue_colors_style' );

function getwid_base_generate_primary_color_css( $color, $is_editor = false, $prefix = '' ) {

	$general = <<<CSS
	button,
	input[type="button"],
	input[type="reset"],
	input[type="submit"],	
	.more-link,
	.wp-block-getwid-social-links.has-icons-stacked .wp-block-getwid-social-links__link:hover .wp-block-getwid-social-links__wrapper.has-background.has-blue-background-color
	{
	  background: {$color};
	}
		
	.main-navigation li:hover > a,
	.main-navigation li.focus > a,	
	.main-navigation .current_page_item > a,
	.main-navigation .current-menu-item > a,
	.main-navigation .current_page_ancestor > a,
	.main-navigation .current-menu-ancestor > a,
	.primary-menu-wrapper .dropdown-toggle:hover,
	.post-navigation-wrapper a:hover .lnr,
	.post-navigation-wrapper a:hover .post-title,
	.search-form .search-submit:hover,
	.widget_nav_menu .menu a:hover,
	body.blog .site-main > .hentry .entry-header .entry-title a:hover, 
	body.search .site-main > .hentry .entry-header .entry-title a:hover, 
	body.archive .site-main > .hentry .entry-header .entry-title a:hover,
	.comments-area .reply .comment-reply-link:hover,
	.search-toggle:hover,
	.close-search-modal:hover,	
	.wp-block-button.is-style-outline .wp-block-button__link:not(.has-background).has-text-color.has-blue-color:hover,
	.wp-block-getwid-social-links .wp-block-getwid-social-links__link:hover .wp-block-getwid-social-links__wrapper.has-text-color.has-blue-color	
	{
	  color: {$color};
	}
CSS;

	$editor = <<<CSS
	{$prefix} .wp-block-button__link:not(.has-background), 
	{$prefix} .wp-block-file__button:not(.has-background),
	{$prefix} .button
	{
		background: {$color};
	}
	
	{$prefix} a, 
	{$prefix} .wp-block-button.is-style-outline,
	{$prefix} .wp-block-getwid-images-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-media-text-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-post-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-post-carousel .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-images-slider.has-dots-inside .slick-dotted.slick-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-media-text-slider.has-dots-inside .slick-dotted.slick-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-post-slider.has-dots-inside .slick-dotted.slick-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-post-carousel.has-dots-inside .slick-dotted.slick-slider .slick-dots li.slick-active button:before,
	{$prefix} .wp-block-getwid-accordion .wp-block-getwid-accordion__header-wrapper.ui-state-active .wp-block-getwid-accordion__icon,
	{$prefix} .wp-block-getwid-accordion .wp-block-getwid-accordion__header-wrapper.ui-state-active a, 
	{$prefix} .wp-block-getwid-accordion .wp-block-getwid-accordion__header-wrapper:hover .wp-block-getwid-accordion__icon,
	{$prefix} .wp-block-getwid-accordion .wp-block-getwid-accordion__header-wrapper:hover a,
	{$prefix} .wp-block-getwid-recent-posts .wp-block-getwid-recent-posts__post .wp-block-getwid-recent-posts__post-title a:hover,
	{$prefix} .wp-block-getwid-recent-posts .wp-block-getwid-recent-posts__post .wp-block-getwid-recent-posts__entry-footer .wp-block-getwid-recent-posts__post-tags a,
	{$prefix} .wp-block-getwid-toggle .wp-block-getwid-toggle__row .wp-block-getwid-toggle__header:hover a,
	{$prefix} .wp-block-getwid-toggle .wp-block-getwid-toggle__row .wp-block-getwid-toggle__header:hover .wp-block-getwid-toggle__icon,
	{$prefix} .wp-block-getwid-toggle .wp-block-getwid-toggle__row.is-active .wp-block-getwid-toggle__header a,
	{$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link.ui-tabs-active a,
	{$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link:hover a,
	{$prefix} .wp-block-getwid-progress-bar .wp-block-getwid-progress-bar__progress:not(.has-text-color),
	{$prefix} .wp-block-getwid-price-box .wp-block-getwid-price-box__pricing,
	{$prefix} .wp-block-getwid-post-slider .wp-block-getwid-post-slider__post .wp-block-getwid-post-slider__post-title a:hover,
	{$prefix} .wp-block-getwid-post-carousel .wp-block-getwid-post-carousel__post .wp-block-getwid-post-carousel__post-title a:hover,
	{$prefix} .wp-block-getwid-custom-post-type .wp-block-getwid-custom-post-type__post .wp-block-getwid-custom-post-type__post-title a:hover,
	{$prefix} .wp-block-getwid-template-post-title:not(.has-text-color) a:hover,
	{$prefix} .navigation.pagination .nav-links .page-numbers:hover, 
	{$prefix} .navigation.pagination .nav-links .page-numbers.current
	{
	  color: {$color};
	}
	{$prefix} .navigation.pagination .nav-links .page-numbers:hover, 
	{$prefix} .navigation.pagination .nav-links .page-numbers.current 
	{
	  border-color: {$color};
	}
CSS;

	if ( $is_editor ) {
		return $editor;
	}

	return $general . $editor;
}

function getwid_base_generate_secondary_color_css( $color, $is_editor = false, $prefix = '' ) {

	$general = <<<CSS
	button:hover,
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,	
	.more-link:hover,
	.post-thumbnail-wrapper .sticky
	{ 
	  background: {$color};
	}
	
	.comments-area .reply .comment-reply-link
    {
	  color: {$color};
	}
CSS;

	$editor = <<<CSS
    {$prefix} .button:hover,
    {$prefix} .wp-block-button .wp-block-button__link:hover,
	{$prefix} .wp-block-button.is-style-outline .wp-block-button__link:hover,
	{$prefix} .wp-block-file .wp-block-file__button:hover,	
	{$prefix} .wp-block-getwid-social-links.has-icons-stacked .wp-block-getwid-social-links__link:hover .wp-block-getwid-social-links__wrapper,
	{$prefix} .wp-block-button .wp-block-button__link.has-background.has-blue-background-color:hover
    { 
	  background: {$color};
	}
    
    {$prefix} .wp-block-button.is-style-outline .wp-block-button__link:hover:not(.has-background),    
	{$prefix} .wp-block-getwid-social-links .wp-block-getwid-social-links__link:hover .wp-block-getwid-social-links__wrapper,
	{$prefix} .wp-block-getwid-social-links.has-icons-framed .wp-block-getwid-social-links__link:hover .wp-block-getwid-social-links__wrapper
    { 
	  color: {$color};
	}
CSS;

	if ( $is_editor ) {
		return $editor;
	}

	return $general . $editor;
}

function getwid_base_generate_secondary_2_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    .site-content {
        background: linear-gradient(to bottom, {$color} 0%, rgba(255, 255, 255, 0) 304px);
    }

    .search-modal:before {
        background: {$color};
        opacity: .98;
    }
CSS;

	if ( $is_editor ) {
		return '';
	}

	return $css;
}

function getwid_base_generate_header_bg_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    .site-header{
        background: {$color};
    }
    
    .primary-menu-wrapper:after{
        background: {$color};
        opacity: .98;
    }
CSS;

	if ( $is_editor ) {
		return '';
	}

	return $css;
}

function getwid_base_generate_header_menu_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    .main-navigation-wrapper{
        color: {$color};
    }
    .primary-menu-more .primary-menu-more-toggle svg{
        fill: {$color};
    }
CSS;

	if ( $is_editor ) {
		return '';
	}

	return $css;
}

function getwid_base_generate_main_text_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    body,    
    input,
    select,
    optgroup,
    textarea,
    .entry-meta,
    .post-navigation-wrapper .previous .meta, 
    .post-navigation-wrapper .next .meta,
    .comments-area .comment-metadata,    
    .wp-block-pullquote cite, 
    .wp-block-quote cite, 
    .wp-block-quote.is-style-large cite,
    .wp-block-image figcaption
    {
        color: {$color};
    }
CSS;

	$editor = <<<CSS
    {$prefix} .navigation.pagination .nav-links .page-numbers,
    {$prefix} .wp-block-quote .wp-block-quote__citation, 
    {$prefix} .wp-block-quote.is-style-large .wp-block-quote__citation,    
    {$prefix} .wp-block-pullquote .wp-block-pullquote__citation
    {
        color: {$color};        
    }
    
    .editor-styles-wrapper
    {
        color: {$color} !important;
    }    
CSS;

	if ( $is_editor ) {
		return $editor;
	}

	return $css . $editor;
}

function getwid_base_generate_heading_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    fieldset legend,
    .post-navigation-wrapper .previous .post-title,
    .post-navigation-wrapper .next .post-title,
    .tags-links a,
    .comments-area .comment-author .fn
    {
        color: {$color};
    }
CSS;

	$editor = <<<CSS
    {$prefix} h1, 
    {$prefix} h2, 
    {$prefix} h3, 
    {$prefix} h4, 
    {$prefix} h5, 
    {$prefix} h6,
    {$prefix} .wp-block-table thead th,
    {$prefix} .wp-block-quote,
    {$prefix} .wp-block-quote.is-style-large,
    {$prefix} .wp-block-pullquote,
    {$prefix} .wp-block-getwid-testimonial .wp-block-getwid-testimonial__title,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link a,
    {$prefix} .wp-block-getwid-person .wp-block-getwid-person__content-wrapper .wp-block-getwid-person__title,
    {$prefix} .wp-block-getwid-progress-bar .wp-block-getwid-progress-bar__percent,
    {$prefix} .wp-block-getwid-price-box .wp-block-getwid-price-box__title,
    {$prefix} .wp-block-getwid-counter .wp-block-getwid-counter__wrapper .wp-block-getwid-counter__number:not(.has-text-color)
    {
        color: {$color};
    }
    
    .editor-styles-wrapper .wp-block.editor-post-title__block
    {
        color: {$color} !important;
    }   
CSS;

	if ( $is_editor ) {
		return $editor;
	}

	return $css . $editor;
}

function getwid_base_generate_borders_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    th,
    td,
    input[type="text"],
    input[type="email"],
    input[type="url"],
    input[type="password"],
    input[type="search"],
    input[type="number"],
    input[type="tel"],
    input[type="range"],
    input[type="date"],
    input[type="month"],
    input[type="week"],
    input[type="time"],
    input[type="datetime"],
    input[type="datetime-local"],
    input[type="color"],
    select,
    textarea,
    fieldset,
    .primary-menu-wrapper .mobile-search-form-wrapper .search-form,
    .search-form,
    .comments-area .comment .comment-body,
    .comments-area .pingback .comment-body,
    body.blog .site-main > .hentry:after, 
    body.search .site-main > .hentry:after, 
    body.archive .site-main > .hentry:after,
    .post-navigation-wrapper,
    .comments-area
    {
        border-color: {$color};
    }
CSS;

	$editor = <<<CSS
    {$prefix} .navigation.pagination .nav-links .page-numbers,
    {$prefix} .wp-block-getwid-accordion .wp-block-getwid-accordion__header-wrapper,
    {$prefix} .wp-block-getwid-accordion .wp-block-getwid-accordion__header-wrapper:first-child,
    {$prefix} .wp-block-getwid-toggle .wp-block-getwid-toggle__row:first-child .wp-block-getwid-toggle__header-wrapper,
    {$prefix} .wp-block-getwid-toggle .wp-block-getwid-toggle__row .wp-block-getwid-toggle__header-wrapper,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link.ui-tabs-active,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__tab-content,
    {$prefix} .wp-block-getwid-tabs.has-layout-vertical-left .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link, 
    {$prefix} .wp-block-getwid-tabs.has-layout-vertical-right .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link, 
    {$prefix} .wp-block-getwid-tabs.is-style-vertical .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link,
    {$prefix} .wp-block-getwid-testimonial .wp-block-getwid-testimonial__wrapper,    
    {$prefix} .wp-block-separator.is-style-dots:not(.has-background),
    {$prefix} .wp-block-getwid-price-list.has-dots:not(.has-text-color) .wp-block-getwid-price-list__price-line,
    {$prefix} .wp-block-getwid-recent-posts .wp-block-getwid-recent-posts__post .wp-block-getwid-recent-posts__post-wrapper,
    {$prefix} .wp-block-getwid-custom-post-type .wp-block-getwid-custom-post-type__post .wp-block-getwid-custom-post-type__post-wrapper,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link:hover,    
    {$prefix} .wp-block-getwid-post-carousel .wp-block-getwid-post-carousel__post,    
    {$prefix} .wp-block-getwid-price-box,
    {$prefix} .wp-block-getwid-content-timeline-item .wp-block-getwid-content-timeline-item__point-content    
    {
        border-color: {$color};
    }    
    
    {$prefix} .wp-block-getwid-content-timeline .wp-block-getwid-content-timeline__line{
        background-color: {$color};
    }
CSS;

	if ( $is_editor ) {
		return $editor;
	}

	return $css . $editor;
}

function getwid_base_generate_background_blocks_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    input[type="text"],
    input[type="email"],
    input[type="url"],
    input[type="password"],
    input[type="search"],
    input[type="number"],
    input[type="tel"],
    input[type="range"],
    input[type="date"],
    input[type="month"],
    input[type="week"],
    input[type="time"],
    input[type="datetime"],
    input[type="datetime-local"],
    input[type="color"],
    select,
    textarea,
    .primary-menu-wrapper .mobile-search-form-wrapper .search-form,
    .search-form .search-submit
    {
        background-color: {$color};
    }
CSS;

	$editor = <<<CSS
    {$prefix} .wp-block-getwid-accordion,
    {$prefix} .wp-block-getwid-recent-posts .wp-block-getwid-recent-posts__post .wp-block-getwid-recent-posts__post-wrapper,
    {$prefix} .wp-block-getwid-toggle,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__nav-links .wp-block-getwid-tabs__nav-link.ui-tabs-active,
    {$prefix} .wp-block-getwid-tabs .wp-block-getwid-tabs__tab-content,
    {$prefix} .wp-block-getwid-testimonial .wp-block-getwid-testimonial__wrapper,    
    {$prefix} .wp-block-getwid-post-carousel .wp-block-getwid-post-carousel__post,
    {$prefix} .wp-block-getwid-custom-post-type .wp-block-getwid-custom-post-type__post .wp-block-getwid-custom-post-type__post-wrapper,
    {$prefix} .wp-block-getwid-content-timeline-item .wp-block-getwid-content-timeline-item__card,
    {$prefix} .wp-block-getwid-content-timeline-item .wp-block-getwid-content-timeline-item__point-content
    {
        background-color: {$color};
    }

    {$prefix} .wp-block-getwid-testimonial .wp-block-getwid-testimonial__image img
    {
        border-color: {$color};
    }
CSS;

	if ( $is_editor ) {
		return $editor;
	}

	return $css . $editor;
}

function getwid_base_generate_borders_focus_color_css( $color, $is_editor = false, $prefix = '' ) {

	$css = <<<CSS
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="url"]:focus,
    input[type="password"]:focus,
    input[type="search"]:focus,
    input[type="number"]:focus,
    input[type="tel"]:focus,
    input[type="range"]:focus,
    input[type="date"]:focus,
    input[type="month"]:focus,
    input[type="week"]:focus,
    input[type="time"]:focus,
    input[type="datetime"]:focus,
    input[type="datetime-local"]:focus,
    input[type="color"]:focus,
    select:focus,
    textarea:focus,
    .primary-menu-wrapper .mobile-search-form-wrapper .search-form:focus-within,
    .search-form:focus-within    
    {
        border-color: {$color};
    }
CSS;

	if ( $is_editor ) {
		return '';
	}

	return $css;
}

function getwid_base_editor_background_color_css( $color, $is_editor = false, $prefix = '' ) {

	if ( $is_editor ) {
		return <<<CSS
        .editor-styles-wrapper{
            background-color: #{$color} !important;
        }
CSS;
	}

	return '';
}

function getwid_base_generate_editor_colors_css( $is_editor = false ) {

	$css            = '';
	$default_colors = getwid_base_get_default_color_palette_colors();
	$prefix         = $is_editor ? '' : '.entry-content';

	foreach ( $default_colors as $color ) {
		$setting_id = 'getwid_editor_color_' . str_replace( '-', '_', $color['slug'] );
		$new_color  = get_theme_mod( $setting_id, false );
		if ( $new_color ) {
			$css .= <<<CSS
            {$prefix} .has-{$color['slug']}-color{
                color: {$new_color};
            }
            {$prefix} .has-{$color['slug']}-background-color{
                background-color: {$new_color};
            }
CSS;
		}
	}

	//@todo remove next 3 lines after Getwid updates
	if ( $is_editor ) {
		return '';
	}

	return $css;
}

function getwid_base_generate_customizer_styles( $is_editor = false ) {
	$prefix = '';
	if ( $is_editor ) {
		$prefix = '.editor-block-list__layout .editor-block-list__block-edit';
	}

	$css            = '';
	$default_colors = getwid_base_get_default_colors();

	$default_color = $default_colors['primary'];
	$color         = get_theme_mod( 'getwid_base_primary_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_primary_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['secondary'];
	$color         = get_theme_mod( 'getwid_base_secondary_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_secondary_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['secondary-2'];
	$color         = get_theme_mod( 'getwid_base_secondary_2_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_secondary_2_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['header-bg'];
	$color         = get_theme_mod( 'getwid_base_header_bg_color', $default_color );
	if ( $color !== $default_color ) {
		$css .= getwid_base_generate_header_bg_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['header-menu'];
	$color         = get_theme_mod( 'getwid_base_header_menu_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_header_menu_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['text'];
	$color         = get_theme_mod( 'getwid_base_text_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_main_text_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['heading'];
	$color         = get_theme_mod( 'getwid_base_heading_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_heading_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['background-blocks'];
	$color         = get_theme_mod( 'getwid_base_background_blocks_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_background_blocks_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['border'];
	$color         = get_theme_mod( 'getwid_base_border_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_borders_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['border-focus'];
	$color         = get_theme_mod( 'getwid_base_border_focus_color', $default_color );
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_generate_borders_focus_color_css( $color, $is_editor, $prefix );
	}

	$default_color = $default_colors['site-background'];
	$color         = get_background_color();
	if ( $default_color && $color !== $default_color ) {
		$css .= getwid_base_editor_background_color_css( $color, $is_editor, $prefix );
	}

	$css .= getwid_base_generate_editor_colors_css( $is_editor );

	return $css;
}

function getwid_base_customize_preview_css() {

	if ( ! is_customize_preview() ) {
		return;
	}

	$default_colors = getwid_base_get_default_colors();
	$primary_color  = get_theme_mod( 'getwid_base_primary_color', $default_colors['primary'] );
	?>
	<style id="getwid-base-primary-color-css">
		<?php
		echo getwid_base_generate_primary_color_css( $primary_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php

	$secondary_color = get_theme_mod( 'getwid_base_secondary_color', $default_colors['secondary'] );
	?>
	<style id="getwid-base-secondary-color-css">
		<?php
		echo getwid_base_generate_secondary_color_css( $secondary_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php

	$secondary_2_color = get_theme_mod( 'getwid_base_secondary_2_color', $default_colors['secondary-2'] );
	if ( $secondary_2_color !== $default_colors['secondary-2'] ):
		?>
		<style id="getwid-base-secondary-2-color-css">
			<?php
			echo getwid_base_generate_secondary_2_color_css( $secondary_2_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</style>
	<?php
	endif;

	$header_bg_color = get_theme_mod( 'getwid_base_header_bg_color', $default_colors['header-bg'] );
	if ( $header_bg_color !== $default_colors['header-bg'] ):
		?>
		<style id="getwid-base-header-bg-color-css">
			<?php
			echo getwid_base_generate_header_bg_color_css( $header_bg_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</style>
	<?php
	endif;

	$header_menu_color = get_theme_mod( 'getwid_base_header_menu_color', $default_colors['header-menu'] );
	if ( $header_menu_color !== $default_colors['header-menu'] ):
		?>
		<style id="getwid-base-header-menu-color-css">
			<?php
			echo getwid_base_generate_header_menu_color_css( $header_menu_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</style>
	<?php
	endif;

	$text_color = get_theme_mod( 'getwid_base_text_color', $default_colors['text'] );
	?>
	<style id="getwid-base-text-color-css">
		<?php
		echo getwid_base_generate_main_text_color_css( $text_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php

	$heading_color = get_theme_mod( 'getwid_base_heading_color', $default_colors['heading'] );
	?>
	<style id="getwid-base-heading-color-css">
		<?php
		echo getwid_base_generate_heading_color_css( $heading_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php

	$border_color = get_theme_mod( 'getwid_base_border_color', $default_colors['border'] );
	?>
	<style id="getwid-base-borders-color-css">
		<?php
		echo getwid_base_generate_borders_color_css( $border_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php

	$border_focus_color = get_theme_mod( 'getwid_base_border_focus_color', $default_colors['border-focus'] );
	?>
	<style id="getwid-base-borders-focus-color-css">
		<?php
		echo getwid_base_generate_borders_focus_color_css( $border_focus_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php

	$blocks_bg_color = get_theme_mod( 'getwid_base_background_blocks_color', $default_colors['background-blocks'] );
	?>
	<style id="getwid-base-background-blocks-color-css">
		<?php
		echo getwid_base_generate_background_blocks_color_css( $blocks_bg_color ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>

	<style id="getwid-base-custom-editor-colors">
		<?php
		echo getwid_base_generate_editor_colors_css(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</style>
	<?php
}

add_action( 'wp_head', 'getwid_base_customize_preview_css' );

function getwid_base_enqueue_editor_customizer_styles() {

	$css = getwid_base_generate_customizer_styles( true );

	if ( $css ) {
		//register fake stylesheet which allow add inline style
		wp_register_style( 'getwid-base-editor-customizer', false );
		wp_enqueue_style( 'getwid-base-editor-customizer' );
		wp_add_inline_style( 'getwid-base-editor-customizer', $css );
	}
}

add_action( 'enqueue_block_editor_assets', 'getwid_base_enqueue_editor_customizer_styles' );
