<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package getwid_base
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function getwid_base_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$default_color = getwid_base_get_default_colors()['text'];
	$color         = get_theme_mod( 'getwid_base_text_color', $default_color );
	if ( $color !== $default_color ) {
		$classes[] = 'has-custom-text-color';
	}

	return $classes;
}

add_filter( 'body_class', 'getwid_base_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function getwid_base_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'getwid_base_pingback_header' );


function getwid_base_read_more_link( $link ) {
	if ( ! is_singular() ) {
		return '<p class="more-tag-wrapper">' . $link . '</p>';
	}

	return $link;
}

add_filter( 'the_content_more_link', 'getwid_base_read_more_link' );

function getwid_base_comment_form_default_fields( $fields ) {

	unset( $fields['url'] );

	return $fields;

}

add_filter( 'comment_form_default_fields', 'getwid_base_comment_form_default_fields' );

function getwid_base_add_custom_icon_font( $font_manager ) {

	// Register Linearicons Font
	$font_manager->registerFont( 'linearicons-free', array(
		'icons' => get_lnr_icons(),
		'style' => 'linearicons-free',
	) );
}

add_action( 'getwid/icons-manager/init', 'getwid_base_add_custom_icon_font' );

function getwid_base_excerpt_length( $length ) {
	return 25;
}

add_filter( 'excerpt_length', 'getwid_base_excerpt_length' );

function getwid_base_getwid_custom_post_type_pagination_args( $args ) {

	$new_args = [
		'mid_size'  => 1,
		'prev_text' => '<span class="previous-icon"></span>',
		'next_text' => '<span class="next-icon"></span>',
	];

	return array_merge( $args, $new_args );
}

add_filter( 'getwid/blocks/custom_post_type/pagination_args', 'getwid_base_getwid_custom_post_type_pagination_args' );

function getwid_base_add_more_to_nav( $nav_menu, $args ) {
	if ( 'menu-1' === $args->theme_location ) :
		$nav_menu .= '<div class="primary-menu-more">';
		$nav_menu .= '<ul class="menu nav-menu">';
		$nav_menu .= '<li class="menu-item menu-item-has-children">';
		$nav_menu .= '<button class="submenu-expand primary-menu-more-toggle is-empty" tabindex="-1" aria-label="' . esc_html__( 'More', 'getwid-base' ) . '" aria-haspopup="true" aria-expanded="false">';
		$nav_menu .= '<span class="screen-reader-text">' . esc_html__( 'More', 'getwid-base' ) . '</span>';
		$nav_menu .= '<svg height="474pt" viewBox="-14 -174 474.66578 474" width="474pt" xmlns="http://www.w3.org/2000/svg">
						<path d="m382.457031-10.382812c-34.539062-.003907-62.539062 28-62.539062 62.542968 0 34.539063 28 62.539063 
						62.539062 62.539063 34.542969 0 62.542969-28 62.542969-62.539063-.039062-34.527344-28.015625-62.503906-62.542969-62.542968zm0 
						100.148437c-20.765625 0-37.605469-16.839844-37.605469-37.605469 0-20.769531 16.839844-37.605468 37.605469-37.605468 20.769531 
						0 37.605469 16.832031 37.605469 37.605468-.023438 20.757813-16.847656 37.574219-37.605469 37.605469zm0 0"/>
						<path d="m222.503906-10.382812c-34.542968 0-62.546875 28-62.546875 62.542968 0 34.539063 28.003907 62.539063 
						62.546875 62.539063 34.539063 0 62.539063-28 62.539063-62.539063 0-34.542968-28-62.542968-62.539063-62.542968zm0 
						100.148437c-20.773437 0-37.613281-16.839844-37.613281-37.605469 0-20.773437 16.839844-37.605468 37.613281-37.605468 
						20.765625 0 37.601563 16.832031 37.601563 37.605468 0 20.765625-16.835938 37.605469-37.601563 37.605469zm0 0"/>
						<path d="m62.542969-10.382812c-34.542969 0-62.542969 28-62.542969 62.542968 0 34.539063 28 62.539063 62.542969 62.539063 
						34.539062 0 62.539062-28 62.539062-62.539063-.039062-34.527344-28.015625-62.503906-62.539062-62.542968zm0 100.148437c-20.769531 
						0-37.605469-16.839844-37.605469-37.605469 0-20.773437 16.835938-37.605468 37.605469-37.605468s37.601562 16.832031 37.601562 
						37.605468c0 20.765625-16.835937 37.605469-37.601562 37.605469zm0 0"/></svg>';
		$nav_menu .= '</button>';
		$nav_menu .= '<ul class="sub-menu hidden-links">';
		$nav_menu .= '</ul>';
		$nav_menu .= '</li>';
		$nav_menu .= '</ul>';
		$nav_menu .= '</div>';
	endif;

	return $nav_menu;
}

add_filter( 'wp_nav_menu', 'getwid_base_add_more_to_nav', 10, 2 );

function getwid_base_header_classes_filter( array $classes ) {

	$default_color = getwid_base_get_default_colors()['header-bg'];
	$color         = get_theme_mod( 'getwid_base_header_bg_color', $default_color );
	if ( $color !== $default_color ) {
		$classes[] = 'has-custom-background';
	}

	$default_color = getwid_base_get_default_colors()['header-menu'];
	$color         = get_theme_mod( 'getwid_base_header_menu_color', $default_color );
	if ( $color !== $default_color ) {
		$classes[] = 'has-custom-color';
	}

	return $classes;
}

add_filter( 'getwid_base_header_classes', 'getwid_base_header_classes_filter' );

function getwid_base_filter_sidebars_wrapper_classes( $classes ) {

	$classes[] = 'has-layout-' . get_theme_mod( 'getwid_base_sidebars_layout', '40-20-20-20' );

	return $classes;
}

add_filter( 'getwid_base_sidebars_wrapper_classes', 'getwid_base_filter_sidebars_wrapper_classes' );

function getwid_base_color_palette_colors( $colors ) {

	foreach ( $colors as $index => $color ) {

		$setting_id = 'getwid_editor_color_' . str_replace( '-', '_', $color['slug'] );
		$new_color  = get_theme_mod( $setting_id, false );

		if ( $new_color ) {
			$colors[ $index ]['color'] = $new_color;
		}

	}

	return $colors;
}

add_filter( 'getwid_base_color_palette', 'getwid_base_color_palette_colors' );