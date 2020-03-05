<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package getwid_base
 */

if ( ! function_exists( 'getwid_base_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function getwid_base_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<span class="posted-on">' . $time_string . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'getwid_base_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function getwid_base_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'getwid-base' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;


if ( ! function_exists( 'getwid_base_posted_in' ) ) :
	/**
	 * Prints HTML for categories.
	 */
	function getwid_base_posted_in() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'getwid-base' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'in %1$s', 'getwid-base' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}

endif;

if ( ! function_exists( 'getwid_base_comments_link' ) ) :
	/**
	 * Prints HTML for comment link.
	 */
	function getwid_base_comments_link() {
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'getwid-base' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}
	}

endif;

if ( ! function_exists( 'getwid_base_edit_link' ) ) :
	/**
	 * Prints HTML for edit link.
	 */
	function getwid_base_edit_link() {
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'getwid-base' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}

endif;

if ( ! function_exists( 'getwid_base_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function getwid_base_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', '' );
			if ( $tags_list ) {

				echo '<span class="tags-links">' . $tags_list . '</span>'; // WPCS: XSS OK.
			}
		}

	}
endif;

if ( ! function_exists( 'getwid_base_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	/**
	 * @param string $size
	 */
	function getwid_base_post_thumbnail( $size = 'post-thumbnail' ) {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( $size ); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>
			<div class="post-thumbnail-wrapper">
				<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail( $size, array(
						'alt' => the_title_attribute( array(
							'echo' => false,
						) ),
					) );
					?>
				</a>
				<?php
				if ( is_sticky() ):
					?>
					<span class="sticky"><span class="lnr lnr-pushpin"></span></span>
				<?php
				endif;
				?>
			</div>

		<?php
		endif; // End is_singular().
	}
endif;


if ( ! function_exists( 'getwid_base_posts_pagination' ) ) {
	function getwid_base_posts_pagination() {
		the_posts_pagination( array(
			'mid_size'  => 1,
			'prev_text' => '<span class="previous-icon"></span>',
			'next_text' => '<span class="next-icon"></span>',
		) );
	}
}

if ( ! function_exists( 'getwid_base_the_post_navigation' ) ) {
	function getwid_base_the_post_navigation() {
		?>
		<div class="post-navigation-wrapper">
			<?php
			the_post_navigation( array(
				'next_text' => '<div class="next">' .
				               '<div class="title">' .
				               '<span class="meta">' . esc_html__( 'Next Post', 'getwid-base' ) . '</span>' .
				               '<span class="post-title">%title</span>' .
				               '</div>' .
				               '<span class="lnr lnr-chevron-right"></span>' .
				               '</div> ',
				'prev_text' => '<div class="previous">' .
				               '<span class="lnr lnr-chevron-left"></span>' .
				               '<div class="title">' .
				               '<span class="meta">' . esc_html__( 'Previous Post', 'getwid-base' ) . '</span>' .
				               '<span class="post-title">%title</span>' .
				               '</div>' .
				               '</div>'
			) );
			?>
		</div>
		<?php
	}
}