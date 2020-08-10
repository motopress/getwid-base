(function ($) {

	"use strict";

	var search_modal = $('#search-modal'),
		search_field = search_modal.find('.search-field');

	$('#search-toggle, #close-search-modal').on('click', function (e) {

		e.preventDefault();

		search_modal.toggleClass('opened');

		if (search_modal.hasClass('opened')) {
			search_field.focus();
		} else {
			search_field.blur();
		}

	});

	var masthead, menuToggle, siteNavigation, siteHeaderMenu;

	function initMainNavigation(container) {
		// Add dropdown toggle that displays child menu items.
		var dropdownToggle = $('<button />', {
			'class': 'dropdown-toggle',
			'aria-expanded': false,
			'html': '<span class="lnr lnr-chevron-down"></span><span class="screen-reader-text">Expand dropdown</span>'
		});

		container.find('.menu-item-has-children > a').after(dropdownToggle);

		// Toggle buttons and submenu items with active children menu items.
		container.find('.current-menu-ancestor > button').addClass('toggled-on');
		container.find('.current-menu-ancestor > .children, .current-menu-ancestor > .sub-menu').addClass('toggled-on');

		// Add menu items with submenus to aria-haspopup="true".
		container.find('.menu-item-has-children').attr('aria-haspopup', 'true');

		container.on('click', '.dropdown-toggle', function (e) {
			var _this = $(this);

			e.preventDefault();
			_this.toggleClass('toggled-on');
			_this.next('.children, .sub-menu').toggleClass('toggled-on');

			_this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');
		});
	}

	initMainNavigation($('.main-navigation'));

	masthead = $('#masthead');
	menuToggle = masthead.find('#menu-toggle');

	// Enable menuToggle.
	(function () {
		// Return early if menuToggle is missing.
		if (!menuToggle.length) {
			return;
		}

		// Add an initial values for the attribute.
		menuToggle.add(siteNavigation).attr('aria-expanded', 'false');

		menuToggle.on('click', function () {
			$(this).add(siteHeaderMenu).toggleClass('toggled-on');
			$(this).add(siteNavigation).attr('aria-expanded', $(this).add(siteNavigation).attr('aria-expanded') === 'false' ? 'true' : 'false');
		});
	})();

	function subMenuPosition() {
		$('.sub-menu').each(function () {
			$(this).removeClass('toleft');
			if (($(this).parent().offset().left + $(this).parent().width() - $(window).width() + 230) > 0) {
				$(this).addClass('toleft');
			}
		});
	}

	function prependElement(container, element) {
		if (container.firstChild) {
			return container.insertBefore(element, container.firstChild);
		} else {
			return container.appendChild(element);
		}
	}

	function showButton(element) {
		// classList.remove is not supported in IE11
		element.className = element.className.replace('is-empty', '');
	}

	function hideButton(element) {
		// classList.add is not supported in IE11
		if (!element.classList.contains('is-empty')) {
			element.className += ' is-empty';
		}
	}

	function getAvailableSpace(button, container) {
		return container.offsetWidth - button.offsetWidth - 85;
	}

	function isOverflowingNavivation(list, button, container) {
		return list.offsetWidth > getAvailableSpace(button, container);
	}

	function addItemToVisibleList(toggleButton, container, visibleList, hiddenList) {
		if (getAvailableSpace(toggleButton, container) > breaks[breaks.length - 1]) {
			// Move the item to the visible list
			visibleList.appendChild(hiddenList.firstChild);
			breaks.pop();
			addItemToVisibleList(toggleButton, container, visibleList, hiddenList);
		}
	}


	var navContainer = document.querySelector('.main-navigation-wrapper');
	var breaks = [];

	if (navContainer) {
		function updateNavigationMenu(container) {

			if (!container.parentNode.querySelector('.primary-menu[id]')) {
				return;
			}

			// Adds the necessary UI to operate the menu.
			var visibleList = container.parentNode.querySelector('.primary-menu[id]');
			var hiddenList = visibleList.parentNode.nextElementSibling.querySelector('.hidden-links');
			var toggleButton = visibleList.parentNode.nextElementSibling.querySelector('.primary-menu-more-toggle');

			if ((window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth) <= 991) {
				while (breaks.length > 0) {
					visibleList.appendChild(hiddenList.firstChild);
					breaks.pop();
					addItemToVisibleList(toggleButton, container, visibleList, hiddenList);
				}
				return;
			}

			if (isOverflowingNavivation(visibleList, toggleButton, container)) {
				// Record the width of the list
				breaks.push(visibleList.offsetWidth);
				// Move last item to the hidden list
				prependElement(hiddenList, !visibleList.lastChild || null === visibleList.lastChild ? visibleList.previousElementSibling : visibleList.lastChild);
				// Show the toggle button
				showButton(toggleButton);

			} else {

				// There is space for another item in the nav
				addItemToVisibleList(toggleButton, container, visibleList, hiddenList);

				// Hide the dropdown btn if hidden list is empty
				if (breaks.length < 2) {
					hideButton(toggleButton);
				}

			}

			// Recur if the visible list is still overflowing the nav
			if (isOverflowingNavivation(visibleList, toggleButton, container)) {
				updateNavigationMenu(container);
			}

		}

		document.addEventListener('DOMContentLoaded', function () {

			updateNavigationMenu(navContainer);

			// Also, run our priority+ function on selective refresh in the customizer
			var hasSelectiveRefresh = (
				'undefined' !== typeof wp &&
				wp.customize &&
				wp.customize.selectiveRefresh &&
				wp.customize.navMenusPreview.NavMenuInstancePartial
			);

			if (hasSelectiveRefresh) {
				// Re-run our priority+ function on Nav Menu partial refreshes
				wp.customize.selectiveRefresh.bind('partial-content-rendered', function (placement) {

					var isNewNavMenu = (
						placement &&
						placement.partial.id.includes('nav_menu_instance') &&
						'null' !== placement.container[0].parentNode &&
						placement.container[0].parentNode.classList.contains('main-navigation')
					);

					if (isNewNavMenu) {
						updateNavigationMenu(placement.container[0].parentNode);
					}
				});
			}
		});

		window.addEventListener('load', function () {
			updateNavigationMenu(navContainer);
			subMenuPosition();
		});

		var timeout;

		window.addEventListener('resize', function () {
			function checkMenu() {
				if (timeout) {
					clearTimeout(timeout);
					timeout = undefined;
				}

				timeout = setTimeout(
					function () {
						updateNavigationMenu(navContainer);
						subMenuPosition();
					},
					100
				);
			}

			checkMenu();
			subMenuPosition();
		});

		updateNavigationMenu(navContainer);
		subMenuPosition();
	}

})(jQuery);