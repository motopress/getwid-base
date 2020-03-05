<?php
/**
 * getwid_base functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package getwid_base
 */

if ( ! function_exists( 'getwid_base_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function getwid_base_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on getwid_base, use a find and replace
		 * to change 'getwid-base' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'getwid-base', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 938 );

		add_image_size( 'getwid_base-cropped', 938, 552, true );
		add_image_size( 'getwid_base-large', 1130 );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'getwid-base' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'getwid_base_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 63,
			'width'       => 63,
			'flex-width'  => true,
			'flex-height' => false,
		) );


		add_theme_support( 'editor-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_editor_style( array( 'css/editor-style.css', getwid_base_fonts_url() ) );

		$default_colors = getwid_base_get_default_color_palette_colors();
		$color_palette  = apply_filters( 'getwid_base_color_palette', $default_colors );
		add_theme_support( 'editor-color-palette', $color_palette );

	}
endif;
add_action( 'after_setup_theme', 'getwid_base_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function getwid_base_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'getwid_base_content_width', 1130 );
}

add_action( 'after_setup_theme', 'getwid_base_content_width', 0 );

function getwid_base_adjust_content_width() {
	global $content_width;

	if ( is_single() ) {
		$content_width = 748;
	}

}

add_action( 'template_redirect', 'getwid_base_adjust_content_width' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function getwid_base_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'getwid-base' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'getwid-base' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'getwid-base' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'getwid-base' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );


	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'getwid-base' ),
		'id'            => 'sidebar-3',
		'description'   => esc_html__( 'Add widgets here.', 'getwid-base' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'getwid-base' ),
		'id'            => 'sidebar-4',
		'description'   => esc_html__( 'Add widgets here.', 'getwid-base' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'getwid_base_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function getwid_base_scripts() {

	wp_enqueue_style( 'linearicons-free', get_template_directory_uri() . '/assets/linearicons/style.css', array(), '1.0.0' );

	wp_enqueue_style( 'getwid-base-fonts', getwid_base_fonts_url(), array(), null );

	wp_enqueue_style( 'getwid-base-style', get_stylesheet_uri(), array(), getwid_base_get_theme_version() );

	wp_enqueue_script( 'getwid-base-functions', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), getwid_base_get_theme_version(), true );

	wp_enqueue_script( 'getwid-base-navigation', get_template_directory_uri() . '/js/navigation.js', array(), getwid_base_get_theme_version(), true );

	wp_enqueue_script( 'getwid-base-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), getwid_base_get_theme_version(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'getwid_base_scripts' );

function getwid_base_add_block_editor_assets() {
	wp_enqueue_style( 'linearicons-free', get_template_directory_uri() . '/assets/linearicons/style.css', array(), '1.0.0' );
}

add_action( 'enqueue_block_editor_assets', 'getwid_base_add_block_editor_assets' );

/**
 * Include Demo Import file.
 */
require get_template_directory() . '/inc/demo-import.php';

/**
 * Include TGM Plugin Activation file.
 */
require get_template_directory() . '/inc/tgmpa-init.php';

/**
 * Include LinearIcons file.
 */
require get_template_directory() . '/inc/lnr-icons.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

function getwid_base_get_theme_version() {
	$theme_info = wp_get_theme( get_template() );

	return $theme_info->get( 'Version' );
}

if ( ! function_exists( 'getwid_base_fonts_url' ) ) :
	/**
	 * Register Google fonts for Getwid Base theme.
	 *
	 * Create your own getwid_base_fonts_url() function to override in a child theme.
	 *
	 * @return string Google fonts URL for the theme.
	 * @since getwid_base 0.0.1
	 *
	 */
	function getwid_base_fonts_url() {
		$fonts_url     = '';
		$font_families = array();

		/**
		 * Translators: If there are characters in your language that are not
		 * supported by Work Sans, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$font1 = esc_html_x( 'on', 'Work Sans font: on or off', 'getwid-base' );
		if ( 'off' !== $font1 ) {
			$font_families[] = 'Work Sans:400,500,700';
		}
		/**
		 * Translators: If there are characters in your language that are not
		 * supported by PT Serif, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		$font2 = esc_html_x( 'on', 'PT Serif font: on or off', 'getwid-base' );
		if ( 'off' !== $font2 ) {
			$font_families[] = 'PT Serif: 400,400i,700,700i';
		}

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext,cyrillic' ),
		);
		if ( $font_families ) {
			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

function getwid_base_get_default_color_palette_colors() {

	$default_colors = array(
		array(
			'name'  => __( 'Primary', 'getwid-base' ),
			'slug'  => 'primary',
			'color' => '#8f4ec7',
		),
		array(
			'name'  => __( 'Color 1', 'getwid-base' ),
			'slug'  => 'light-violet',
			'color' => '#f6eefc',
		),
		array(
			'name'  => __( 'Color 2', 'getwid-base' ),
			'slug'  => 'light-blue',
			'color' => '#f3f8fb',
		),
		array(
			'name'  => __( 'Color 3', 'getwid-base' ),
			'slug'  => 'blue',
			'color' => '#68c5f9',
		),
		array(
			'name'  => __( 'Color 4', 'getwid-base' ),
			'slug'  => 'gray',
			'color' => '#9ea6ac',
		),
		array(
			'name'  => __( 'Color 5', 'getwid-base' ),
			'slug'  => 'light-gray',
			'color' => '#f3f9fd',
		),
		array(
			'name'  => __( 'Color 6', 'getwid-base' ),
			'slug'  => 'dark-blue',
			'color' => '#2c3847',
		),
	);

	return $default_colors;

}
