<?php
/**
 * Template for displaying search forms in Getwid Base Theme
 *
 * @package getwid_base
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label> <span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'getwid-base' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'getwid-base' ); ?>" value="<?php echo get_search_query(); ?>" name="s"/>
	</label>
	<button type="submit" class="search-submit">
		<span class="lnr lnr-magnifier"></span><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'getwid-base' ); ?></span>
	</button>
</form>