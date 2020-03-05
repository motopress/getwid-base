<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package getwid_base
 */

if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' ) ) {
	return;
}
?>
<div class="footer-sidebars-wrapper">
	<?php
	$widgets_wrapper_classes = apply_filters( 'getwid_base_sidebars_wrapper_classes', [ 'footer-sidebars' ] );
	?>
	<div class="<?php echo esc_attr( implode( ' ', $widgets_wrapper_classes ) ); ?>">
		<?php
		if ( is_active_sidebar( 'sidebar-1' ) ):
			?>
			<aside class="widget-area">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside>
		<?php
		endif;

		if ( is_active_sidebar( 'sidebar-2' ) ):
			?>
			<aside class="widget-area">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</aside>
		<?php
		endif;

		if ( is_active_sidebar( 'sidebar-3' ) ):
			?>
			<aside class="widget-area">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</aside>
		<?php
		endif;

		if ( is_active_sidebar( 'sidebar-4' ) ):
			?>
			<aside class="widget-area">
				<?php dynamic_sidebar( 'sidebar-4' ); ?>
			</aside>
		<?php
		endif;
		?>
	</div>
</div>