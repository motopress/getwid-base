<?php

/**
 *
 * Demo data
 *
 **/

function getwid_base_ocdi_import_files() {
	$import_notice = '<h4>' . esc_html__( 'Important note before importing sample data.', 'getwid-base' ) . '</h4>';
	$import_notice .= __( 'Data import is generally not immediate and can take up to 10 minutes.', 'getwid-base' ) . '<br/>';
	$import_notice .= __( 'After you import this demo, you will have to configure the Contact Form and Google Maps API key separately.', 'getwid-base' );

	$import_notice = wp_kses(
		$import_notice,
		array(
			'a'  => array(
				'href' => array(),
			),
			'ol' => array(),
			'li' => array(),
			'h4' => array(),
			'br' => array(),
		)
	);

	return array(
		array(
			'import_file_name'         => 'Demo Import 1',
			'local_import_file'        => trailingslashit( get_template_directory() ) . 'assets/demo-data/getwid-base.xml',
			'local_import_widget_file' => trailingslashit( get_template_directory() ) . 'assets/demo-data/getwid-base-widgets.wie',
			'import_preview_image_url' => '',
			'import_notice'            => $import_notice,
			'preview_url'              => 'https://getwid.getmotopress.com',
		),
	);
}

add_filter( 'pt-ocdi/import_files', 'getwid_base_ocdi_import_files' );

function getwid_base_ocdi_after_import_setup() {

	// Assign menus to their locations.
	$menu1 = get_term_by( 'slug', 'menu-1', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'menu-1' => $menu1->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

	//update taxonomies
	$update_taxonomies = array(
		'post_tag',
		'category'
	);
	foreach ( $update_taxonomies as $taxonomy ) {
		getwid_base_ocdi_update_taxonomy( $taxonomy );
	}

}

add_action( 'pt-ocdi/after_import', 'getwid_base_ocdi_after_import_setup' );

// Disable generation of smaller images (thumbnails) during the content import
//add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// Disable the branding notice
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function getwid_base_ocdi_update_taxonomy( $taxonomy ) {
	$get_terms_args = array(
		'taxonomy'   => $taxonomy,
		'fields'     => 'ids',
		'hide_empty' => false,
	);

	$update_terms = get_terms( $get_terms_args );
	if ( $taxonomy && $update_terms ) {
		wp_update_term_count_now( $update_terms, $taxonomy );
	}
}
