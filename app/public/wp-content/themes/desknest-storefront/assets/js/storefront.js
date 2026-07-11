/**
 * DeskNest Storefront - mobile navigation toggle.
 * No dependencies, no build step.
 */
( function () {
	'use strict';

	var toggle = document.querySelector( '.storefront-menu-toggle' );
	var nav = document.getElementById( 'storefront-primary-navigation' );

	if ( ! toggle || ! nav ) {
		return;
	}

	function closeMenu() {
		toggle.setAttribute( 'aria-expanded', 'false' );
		nav.classList.remove( 'is-open' );
	}

	function toggleMenu() {
		var isOpen = toggle.getAttribute( 'aria-expanded' ) === 'true';
		toggle.setAttribute( 'aria-expanded', String( ! isOpen ) );
		nav.classList.toggle( 'is-open', ! isOpen );
	}

	toggle.addEventListener( 'click', toggleMenu );

	nav.querySelectorAll( 'a' ).forEach( function ( link ) {
		link.addEventListener( 'click', closeMenu );
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' ) {
			closeMenu();
		}
	} );
}() );

/**
 * Scope 21 Step 5A Polish - custom /shop/ sorting dropdown.
 *
 * Progressive enhancement over the real WooCommerce orderby select
 * (form.woocommerce-ordering select.orderby): the native select stays in
 * the DOM and is the real source of truth for the form submission. This
 * script builds a button + listbox next to it, keeps them in sync, and
 * only visually hides the native select via a documentElement class
 * (CSS-gated, see "Scope 21 Step 5A Polish" in style.css) - if this
 * script does not run, the class is never added and the native select
 * stays fully visible/usable. No jQuery, no build step.
 */
( function () {
	'use strict';

	var select = document.querySelector( '.storefront-shop-ordering select.orderby' );

	if ( ! select || select.dataset.storefrontEnhanced ) {
		return;
	}

	select.dataset.storefrontEnhanced = 'true';

	var wrapper = document.createElement( 'div' );
	wrapper.className = 'storefront-select';

	var toggle = document.createElement( 'button' );
	toggle.type = 'button';
	toggle.className = 'storefront-select-toggle';
	toggle.setAttribute( 'aria-haspopup', 'listbox' );
	toggle.setAttribute( 'aria-expanded', 'false' );

	var toggleLabel = document.createElement( 'span' );
	toggle.appendChild( toggleLabel );

	var menu = document.createElement( 'ul' );
	menu.className = 'storefront-select-menu';
	menu.setAttribute( 'role', 'listbox' );
	menu.hidden = true;

	var optionEls = [];

	function syncToggleLabel() {
		var selected = select.options[ select.selectedIndex ];
		toggleLabel.textContent = selected ? selected.textContent : '';
	}

	function closeMenu() {
		menu.hidden = true;
		toggle.setAttribute( 'aria-expanded', 'false' );
	}

	function openMenu() {
		menu.hidden = false;
		toggle.setAttribute( 'aria-expanded', 'true' );
		var current = optionEls[ select.selectedIndex ];
		if ( current ) {
			current.focus();
		}
	}

	function selectOption( index ) {
		select.selectedIndex = index;
		syncToggleLabel();
		optionEls.forEach( function ( el, i ) {
			var active = i === index;
			el.classList.toggle( 'is-active', active );
			el.setAttribute( 'aria-selected', active ? 'true' : 'false' );
		} );
		closeMenu();
		toggle.focus();

		var form = select.closest( 'form.woocommerce-ordering' );
		if ( form ) {
			form.submit();
		}
	}

	Array.prototype.forEach.call( select.options, function ( option, index ) {
		var item = document.createElement( 'li' );
		item.className = 'storefront-select-option';
		item.setAttribute( 'role', 'option' );
		item.textContent = option.textContent;
		item.tabIndex = -1;
		item.setAttribute( 'aria-selected', option.selected ? 'true' : 'false' );
		if ( option.selected ) {
			item.classList.add( 'is-active' );
		}

		item.addEventListener( 'click', function () {
			selectOption( index );
		} );

		item.addEventListener( 'keydown', function ( event ) {
			if ( 'Enter' === event.key || ' ' === event.key ) {
				event.preventDefault();
				selectOption( index );
			} else if ( 'Escape' === event.key ) {
				closeMenu();
				toggle.focus();
			} else if ( 'ArrowDown' === event.key ) {
				event.preventDefault();
				var next = optionEls[ index + 1 ];
				if ( next ) {
					next.focus();
				}
			} else if ( 'ArrowUp' === event.key ) {
				event.preventDefault();
				var prev = optionEls[ index - 1 ];
				if ( prev ) {
					prev.focus();
				}
			}
		} );

		menu.appendChild( item );
		optionEls.push( item );
	} );

	toggle.addEventListener( 'click', function () {
		if ( menu.hidden ) {
			openMenu();
		} else {
			closeMenu();
		}
	} );

	toggle.addEventListener( 'keydown', function ( event ) {
		if ( 'ArrowDown' === event.key || 'ArrowUp' === event.key ) {
			event.preventDefault();
			openMenu();
		} else if ( 'Escape' === event.key ) {
			closeMenu();
		}
	} );

	document.addEventListener( 'click', function ( event ) {
		if ( ! menu.hidden && ! wrapper.contains( event.target ) ) {
			closeMenu();
		}
	} );

	wrapper.addEventListener( 'focusout', function ( event ) {
		if ( ! wrapper.contains( event.relatedTarget ) ) {
			closeMenu();
		}
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && ! menu.hidden ) {
			closeMenu();
			toggle.focus();
		}
	} );

	syncToggleLabel();
	wrapper.appendChild( menu );
	select.insertAdjacentElement( 'afterend', wrapper );
	wrapper.insertBefore( toggle, menu );
	select.setAttribute( 'aria-hidden', 'true' );
	select.tabIndex = -1;

	document.documentElement.classList.add( 'storefront-shop-sort-js' );
}() );

/**
 * Scope 21 Step 5C (repaired in Step 5C Repair) - custom DeskNest dropdown
 * for WooCommerce single-product variation selects (e.g. the "Finish"
 * attribute on a variable product).
 *
 * Progressive enhancement, scoped strictly to any <select> inside
 * body.single-product form.variations_form - every select in that form is a
 * variation attribute select (the quantity control is an <input>), so this
 * targets selects directly instead of depending on the .variations table
 * wrapper markup, which is why the earlier .variations-scoped version could
 * silently match nothing and leave the native select in place. It never
 * touches the shop/category sorting dropdown (a different container) or any
 * checkout/cart/account select. The native WooCommerce <select> stays in the
 * DOM as the real source of truth: choosing a custom option sets the native
 * value and dispatches native, bubbling 'input' and 'change' events, which
 * WooCommerce's own variation script (bound via jQuery .on('change'), which
 * does fire for natively-dispatched events) picks up - so price, SKU, stock
 * and the add-to-cart state all keep updating normally. The native select is
 * only visually hidden (class added here, never in the CSS by default), so
 * with JS off it stays fully usable. Reuses the same .storefront-select*
 * styling as the sorting dropdown. No jQuery, no build step.
 */
( function () {
	'use strict';

	var variationSelectId = 0;

	function initVariationSelects() {
		var forms = document.querySelectorAll( 'body.single-product form.variations_form' );

		if ( ! forms.length ) {
			return;
		}

		Array.prototype.forEach.call( forms, function ( form ) {
			var selects = form.querySelectorAll( 'select' );
			Array.prototype.forEach.call( selects, function ( select ) {
				enhanceVariationSelect( select, form );
			} );
		} );
	}

	function enhanceVariationSelect( select, form ) {
		if ( select.dataset.storefrontEnhanced ) {
			return;
		}
		select.dataset.storefrontEnhanced = 'true';

		var row = select.closest( 'tr' );
		var label = row ? row.querySelector( 'th label, th' ) : null;
		var labelText = label ? label.textContent.trim() : select.getAttribute( 'name' ) || 'Option';
		var controlId = 'storefront-variation-select-' + ( variationSelectId++ );

		var wrapper = document.createElement( 'div' );
		wrapper.className = 'storefront-select storefront-variation-select';

		var toggle = document.createElement( 'button' );
		toggle.type = 'button';
		toggle.className = 'storefront-select-toggle';
		toggle.setAttribute( 'aria-haspopup', 'listbox' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		toggle.setAttribute( 'aria-controls', controlId );

		var toggleLabel = document.createElement( 'span' );
		toggle.appendChild( toggleLabel );

		var menu = document.createElement( 'ul' );
		menu.id = controlId;
		menu.className = 'storefront-select-menu';
		menu.setAttribute( 'role', 'listbox' );
		menu.setAttribute( 'aria-label', labelText );
		menu.hidden = true;

		var optionEls = [];

		// Tracks the last value we rendered so the poll below reacts only to
		// real value changes (from our dropdown, WooCommerce's default/restore,
		// or the Clear link) rather than re-rendering every tick.
		var lastValue = null;

		function render() {
			var selected = select.options[ select.selectedIndex ];
			toggleLabel.textContent = selected ? selected.textContent : '';
			toggle.setAttribute( 'aria-label', labelText + ': ' + ( selected ? selected.textContent : '' ) );
			if ( ! menu.hidden ) {
				buildOptions();
			}
		}

		function pollSync() {
			if ( select.value !== lastValue ) {
				lastValue = select.value;
				render();
			}
		}

		function closeMenu() {
			menu.hidden = true;
			toggle.setAttribute( 'aria-expanded', 'false' );
		}

		function focusOption( index ) {
			var item = optionEls[ index ];
			if ( item ) {
				item.focus();
			}
		}

		function enabledOptionIndex( startIndex, direction ) {
			var index = startIndex;

			while ( index >= 0 && index < optionEls.length ) {
				if ( optionEls[ index ] && optionEls[ index ].getAttribute( 'aria-disabled' ) !== 'true' ) {
					return index;
				}
				index += direction;
			}

			return -1;
		}

		function choose( value ) {
			select.value = value;
			// Dispatch both input and change (bubbling) so WooCommerce's own
			// variation script updates price, SKU, stock and the add-to-cart
			// enabled/disabled state.
			select.dispatchEvent( new Event( 'input', { bubbles: true } ) );
			select.dispatchEvent( new Event( 'change', { bubbles: true } ) );
			pollSync();
			closeMenu();
			toggle.focus();
		}

		function dispatchNativeSelectChange() {
			select.dispatchEvent( new Event( 'input', { bubbles: true } ) );
			select.dispatchEvent( new Event( 'change', { bubbles: true } ) );
			if ( window.jQuery ) {
				window.jQuery( select ).trigger( 'change' );
			}
		}

		function syncAfterReset() {
			window.setTimeout( function () {
				select.value = '';
				dispatchNativeSelectChange();
				if ( window.jQuery ) {
					window.jQuery( form ).trigger( 'reset_data' );
				}
				var variationDetails = form.querySelector( '.single_variation, .woocommerce-variation' );
				if ( variationDetails ) {
					variationDetails.innerHTML = '';
					variationDetails.style.display = 'none';
				}
				pollSync();
				closeMenu();
				toggle.focus();
			}, 0 );
		}

		// Rebuilt on every open so WooCommerce's dynamic re-population of
		// dependent attribute options (multi-attribute products) is reflected.
		function buildOptions() {
			menu.innerHTML = '';
			optionEls = [];
			Array.prototype.forEach.call( select.options, function ( option, index ) {
				var item = document.createElement( 'li' );
				item.className = 'storefront-select-option';
				item.setAttribute( 'role', 'option' );
				item.textContent = option.textContent;
				item.tabIndex = -1;
				item.dataset.value = option.value;
				item.dataset.index = String( index );

				var isSelected = option.value === select.value;
				var isDisabled = option.disabled || option.hidden;
				item.setAttribute( 'aria-selected', isSelected ? 'true' : 'false' );
				if ( isDisabled ) {
					item.setAttribute( 'aria-disabled', 'true' );
				}
				if ( isSelected ) {
					item.classList.add( 'is-active' );
				}

				item.addEventListener( 'click', function () {
					if ( item.getAttribute( 'aria-disabled' ) === 'true' ) {
						return;
					}
					choose( option.value );
				} );
				item.addEventListener( 'keydown', function ( event ) {
					if ( 'Enter' === event.key || ' ' === event.key ) {
						event.preventDefault();
						if ( item.getAttribute( 'aria-disabled' ) === 'true' ) {
							return;
						}
						choose( option.value );
					} else if ( 'Escape' === event.key ) {
						event.preventDefault();
						closeMenu();
						toggle.focus();
					} else if ( 'ArrowDown' === event.key ) {
						event.preventDefault();
						focusOption( enabledOptionIndex( Number( item.dataset.index ) + 1, 1 ) );
					} else if ( 'ArrowUp' === event.key ) {
						event.preventDefault();
						focusOption( enabledOptionIndex( Number( item.dataset.index ) - 1, -1 ) );
					} else if ( 'Home' === event.key ) {
						event.preventDefault();
						focusOption( enabledOptionIndex( 0, 1 ) );
					} else if ( 'End' === event.key ) {
						event.preventDefault();
						focusOption( enabledOptionIndex( optionEls.length - 1, -1 ) );
					}
				} );

				menu.appendChild( item );
				optionEls.push( item );
			} );
		}

		function openMenu( direction ) {
			buildOptions();
			menu.hidden = false;
			toggle.setAttribute( 'aria-expanded', 'true' );
			var selectedIndex = -1;

			optionEls.forEach( function ( item, index ) {
				if ( item.dataset.value === select.value ) {
					selectedIndex = index;
				}
			} );

			if ( selectedIndex < 0 || optionEls[ selectedIndex ].getAttribute( 'aria-disabled' ) === 'true' ) {
				selectedIndex = 'up' === direction
					? enabledOptionIndex( optionEls.length - 1, -1 )
					: enabledOptionIndex( 0, 1 );
			}

			focusOption( selectedIndex );
		}

		toggle.addEventListener( 'click', function () {
			if ( menu.hidden ) {
				openMenu();
			} else {
				closeMenu();
			}
		} );

		toggle.addEventListener( 'keydown', function ( event ) {
			if ( 'Enter' === event.key || ' ' === event.key || 'ArrowDown' === event.key || 'ArrowUp' === event.key ) {
				event.preventDefault();
				openMenu( 'ArrowUp' === event.key ? 'up' : 'down' );
			} else if ( 'Escape' === event.key ) {
				closeMenu();
			}
		} );

		// Keep the custom label/active state in step with the native select no
		// matter what changes it: our own dropdown, WooCommerce's on-load
		// default/restore of a variation, or the "Clear" link. WooCommerce
		// mutates the select via jQuery, whose triggered 'change' does not
		// reach native addEventListener handlers, so a light value poll (not an
		// event) is the reliable, framework-agnostic way to stay in sync.
		select.addEventListener( 'change', pollSync );
		window.setInterval( pollSync, 250 );

		document.addEventListener( 'click', function ( event ) {
			if ( ! menu.hidden && ! wrapper.contains( event.target ) ) {
				closeMenu();
			}
		} );
		wrapper.addEventListener( 'focusout', function ( event ) {
			if ( ! wrapper.contains( event.relatedTarget ) ) {
				closeMenu();
			}
		} );

		form.addEventListener( 'keydown', function ( event ) {
			if ( ' ' === event.key && event.target && event.target.classList && event.target.classList.contains( 'reset_variations' ) ) {
				event.preventDefault();
				event.target.click();
				syncAfterReset();
			}
		} );
		form.addEventListener( 'click', function ( event ) {
			if ( event.target && event.target.classList && event.target.classList.contains( 'reset_variations' ) ) {
				syncAfterReset();
			}
		} );

		pollSync();
		select.insertAdjacentElement( 'afterend', wrapper );
		wrapper.appendChild( toggle );
		wrapper.appendChild( menu );
		select.setAttribute( 'aria-hidden', 'true' );
		select.tabIndex = -1;
		// Only now - after the working replacement exists - hide the native
		// select. With JS off this class is never added, so it stays visible.
		select.classList.add( 'storefront-variation-native-hidden' );
	}

	// The variations form is server-rendered, but guard against running
	// before the DOM is parsed just in case the script is ever moved.
	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', initVariationSelects );
	} else {
		initVariationSelects();
	}
}() );
