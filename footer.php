<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getwid_base
 */

?>

</div><!-- #content -->

<?php
get_sidebar();
?>
<footer id="colophon" class="site-footer">
	<?php

	$show_site_info = (bool) get_theme_mod( 'getwid_base_show_footer_text', true );
	if ( $show_site_info ):
		?>
		<div class="site-info">
			<?php
			$dateObj           = new DateTime;
			$current_year      = $dateObj->format( "Y" );
			$site_info_default = apply_filters( 'getwid_base_site_info',
				/* translators: %1$s: current year. */
				esc_html_x( 'Copyright &copy; %1$s.  All Rights Reserved.', 'Default footer text. %1$s - current year.', 'getwid-base' )
			);
			$site_info         = get_theme_mod( 'getwid_base_footer_text', false ) ? get_theme_mod( 'getwid_base_footer_text' ) : $site_info_default;

			echo wp_kses_post(
				sprintf(
					$site_info,
					$current_year
				)
			);
			?>
		</div>
	<?php
	endif;
	?>
</footer><!-- #colophon --></div><!-- #page -->

<?php wp_footer(); ?>

</body></html>
