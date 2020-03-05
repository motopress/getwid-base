<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package getwid_base
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">
						<?php esc_html_e( 'Oops!', 'getwid-base' ); ?>
						<span class="subtitle"><?php esc_html_e( 'That page can&rsquo;t be found.', 'getwid-base' ); ?></span>
					</h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<?php
					get_search_form();
					?>
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'getwid-base' ); ?></p>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
