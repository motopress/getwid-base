/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {

	"use strict";

	const editorColors = getwidBaseCustomizer.defaultEditorColors;

	function addCustomStyleToHead(id, css) {
		let oldstyle = $('head').find('#' + id),
			style = '<style id="' + id + '">' + css + '</style>';


		if (oldstyle.length) {
			oldstyle.remove();
			$('head').append(style);
		} else {
			$('head').append(style);
		}
	}

	function removeCustomStyleFromHead(id) {
		let oldstyle = $('head').find('#' + id);
		if (oldstyle.length) {
			oldstyle.remove();
		}
	}

	// Site title and description.
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Header text color.
	wp.customize('header_textcolor', function (value) {
		value.bind(function (to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				});
			} else {
				$('.site-title, .site-description').css({
					'clip': 'auto',
					'position': 'relative'
				});
				$('.site-title a, .site-description').css({
					'color': to
				});
			}
		});
	});

	wp.customize('getwid_base_footer_text', function (value) {

		value.bind(function (to) {
			$('#colophon .site-info').html(to);
		})

	});

	wp.customize('getwid_base_primary_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-primary-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
		})
	});

	wp.customize('getwid_base_secondary_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-secondary-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
		})
	});

	wp.customize('getwid_base_secondary_2_color', function (value) {
		value.bind(function (to) {
			let oldstyle = $('head').find('#getwid-base-secondary-2-color-css'),
				style = '<style id="getwid-base-secondary-2-color-css">' +
					'.site-content {' +
					'background: linear-gradient(to bottom, ' + to + ' 0%, rgba(255, 255, 255, 0) 304px);' +
					'}' +
					'.search-modal:before {' +
					'background: ' + to + ';' +
					'opacity: .98;' +
					'}' +
					'</style>';


			if (oldstyle.length) {
				oldstyle.remove();
				$('head').append(style);
			} else {
				$('head').append(style);
			}
		})
	});

	wp.customize('getwid_base_header_bg_color', function (value) {
		value.bind(function (to) {
			$('.site-header').css({
				'background': to
			});
		});
	});

	wp.customize('getwid_base_header_menu_color', function (value) {
		value.bind(function (to) {
			$('.main-navigation, .search-toggle, .menu-toggle, .dropdown-toggle').css({
				'color': 'inherit'
			});
			$('.main-navigation-wrapper').css({
				'color': to
			});
			$('.primary-menu-more .primary-menu-more-toggle svg').css({
				'fill': to
			});
		});
	});

	wp.customize('getwid_base_text_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-text-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
			$('.site-info').css({
				'color': to
			});
		})
	});

	wp.customize('getwid_base_heading_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-heading-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
		})
	});

	wp.customize('getwid_base_border_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-borders-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
		})
	});

	wp.customize('getwid_base_border_focus_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-borders-focus-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
		})
	});

	wp.customize('getwid_base_background_blocks_color', function (value) {
		let color = value.get();
		value.bind(function (to) {
			let style = $('#getwid-base-background-blocks-color-css'),
				css = style.html();
			style.html(css.split(color).join(to));
			color = to;
		})
	});

	wp.customize('getwid_base_sidebars_layout', function (value) {
		let available_classes = [
				'has-layout-40-20-20-20',
				'has-layout-25-25-25-25',
				'has-layout-33-33-33-100',
				'has-layout-100-33-33-33',
				'has-layout-100-50-50-100',
				'has-layout-50-50-50-50'
			],
			sidebars_wrapper = $('.footer-sidebars');
		value.bind(function (new_layout) {
			sidebars_wrapper.removeClass(available_classes.join(' '));
			sidebars_wrapper.addClass('has-layout-' + new_layout);
		})
	});


	editorColors.forEach(function (item, index) {
		let id = 'getwid_editor_color_' + item.slug.replace('-', '_');
		wp.customize(id, function (value) {
			value.bind(function (to) {
				let css = '' +
					'.entry-content .has-' + item.slug + '-color{ color: ' + to + ';}' +
					'.entry-content .has-' + item.slug + '-background-color{ background-color: ' + to + '};';
				addCustomStyleToHead(id, css);
			})
		});
	})

})(jQuery);
