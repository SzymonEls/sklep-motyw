/**
 * Witryna – small front-end enhancements.
 *
 * - Sticky header that hides while scrolling down and returns when scrolling up.
 * - Exposes header measurements as CSS custom properties used by the stylesheet.
 */
( function () {
	const header = document.querySelector( '.wp-site-blocks > header.wp-block-template-part' );

	if ( ! header || ! header.querySelector( '.witryna-header' ) ) {
		return;
	}

	const root = document.documentElement;
	const topbar = header.querySelector( '.witryna-topbar' );
	let lastY = window.scrollY;
	let ticking = false;
	let topbarHeight = 0;
	let headerHeight = 0;

	const isOverlayOpen = () =>
		document.querySelector(
			'.wp-block-navigation__responsive-container.is-menu-open, .wc-block-mini-cart__drawer:not(.is-closed), .wc-block-product-filters.is-overlay-opened'
		) !== null;

	const measure = () => {
		topbarHeight = topbar ? topbar.offsetHeight : 0;
		headerHeight = header.offsetHeight;
		header.style.setProperty( '--witryna-topbar-height', topbarHeight + 'px' );
		header.style.setProperty( '--witryna-full-height', headerHeight + 'px' );
		root.style.setProperty( '--witryna-header-height', headerHeight - topbarHeight + 'px' );
	};

	const update = () => {
		const y = Math.max( window.scrollY, 0 );
		const delta = y - lastY;

		header.classList.toggle( 'is-scrolled', y > topbarHeight + 1 );

		if ( isOverlayOpen() || y < headerHeight * 2 ) {
			header.classList.remove( 'is-hidden' );
		} else if ( delta > 6 ) {
			header.classList.add( 'is-hidden' );
		} else if ( delta < -6 ) {
			header.classList.remove( 'is-hidden' );
		}

		root.classList.toggle( 'witryna-header-hidden', header.classList.contains( 'is-hidden' ) );
		lastY = y;
		ticking = false;
	};

	measure();
	update();
	header.classList.add( 'is-sticky-ready' );

	window.addEventListener(
		'scroll',
		() => {
			if ( ! ticking ) {
				ticking = true;
				window.requestAnimationFrame( update );
			}
		},
		{ passive: true }
	);

	if ( 'ResizeObserver' in window ) {
		new window.ResizeObserver( measure ).observe( header );
	} else {
		window.addEventListener( 'resize', measure );
	}

	// Keep the header visible while keyboard users move through it.
	header.addEventListener( 'focusin', () => header.classList.remove( 'is-hidden' ) );
} )();
