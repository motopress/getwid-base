<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getwid_base
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>
<div id="page" class="site">

	<?php
	if(!getwid_base_hide_header_search()):
	?>
		<div class="search-modal" id="search-modal">
			<button class="close-search-modal" id="close-search-modal">
				<span class="lnr lnr-cross"></span>
			</button>
			<div class="search-form-wrapper">
				<?php
				get_search_form();
				?>
			</div>
		</div>
	<?php
	endif;
	?>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'getwid-base' ); ?></a>

	<?php
	$header_classes = apply_filters( 'getwid_base_header_classes', array( 'site-header' ) )
	?>
	<header id="masthead" class="<?php echo esc_attr( implode( ' ', $header_classes ) ); ?>">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php
			else :
				?>
				<p class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php
			endif;
			$getwid_base_description = get_bloginfo( 'description', 'display' );
			if ( $getwid_base_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo esc_html( $getwid_base_description ); /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<div class="main-navigation-wrapper">
			<nav id="site-navigation" class="main-navigation">
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
					<span class="lnr lnr-menu"></span> <span class="lnr lnr-cross"></span>
				</button>
				<div class="primary-menu-wrapper">
					<?php
					wp_nav_menu( array(
						'theme_location'  => 'menu-1',
						'menu_id'         => 'primary-menu',
						'menu_class'      => 'menu primary-menu',
						'container_class' => 'primary-menu-container'
					) );

					if(!getwid_base_hide_header_search()):
					?>
						<div class="mobile-search-form-wrapper">
							<?php
							get_search_form();
							?>
						</div>
					<?php
					endif;
					?>
				</div>
			</nav><!-- #site-navigation -->
			<?php
			if(!getwid_base_hide_header_search()):
			?>
				<button class="search-toggle" id="search-toggle">
					<span class="lnr lnr-magnifier"></span>
				</button>
			<?php
			endif;
			?>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
