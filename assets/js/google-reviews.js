/**
 * Google reviews: Google's Place Details element (Places UI Kit).
 *
 * Google renders the rating, the reviews and the attribution itself; the
 * page never copies or stores them. The Maps JavaScript API is loaded only
 * once, only from maps.googleapis.com, and only after the visitor clicks the
 * button (or when the box comes into view, if automatic loading is on).
 * A consent plugin can call window.witrynaLoadGoogleReviews().
 */
( function () {
	'use strict';

	const boxes = Array.from( document.querySelectorAll( '.witryna-greviews[data-key][data-place], .witryna-greviews[data-embed]' ) );
	if ( ! boxes.length ) {
		return;
	}

	let mapsReady = null;

	function loadMaps( key ) {
		if ( mapsReady ) {
			return mapsReady;
		}
		mapsReady = new Promise( ( resolve, reject ) => {
			if ( window.google && window.google.maps && window.google.maps.importLibrary ) {
				resolve();
				return;
			}
			window.witrynaMapsReady = resolve;
			const script = document.createElement( 'script' );
			script.src =
				'https://maps.googleapis.com/maps/api/js?key=' +
				encodeURIComponent( key ) +
				'&v=weekly&loading=async&language=pl&region=PL&callback=witrynaMapsReady';
			script.async = true;
			script.onerror = reject;
			document.head.appendChild( script );
		} ).then( () => window.google.maps.importLibrary( 'places' ) );
		return mapsReady;
	}

	function status( box, key ) {
		const region = box.querySelector( '.witryna-greviews__status' );
		if ( region ) {
			region.textContent = key ? region.dataset[ key ] || '' : '';
		}
	}

	function fail( box ) {
		if ( box.classList.contains( 'is-failed' ) ) {
			return;
		}
		box.querySelector( '.witryna-greviews__slot' ).textContent = '';
		box.classList.remove( 'is-loading', 'is-loaded' );
		box.classList.add( 'is-failed' );
		box.removeAttribute( 'aria-busy' );
		status( box, 'failed' );
		const admin = box.querySelector( '.witryna-greviews__admin' );
		if ( admin ) {
			admin.hidden = false;
		}
	}

	// The colour scheme of the page (the theme has light and dark styles), not of the system.
	function isDark( element ) {
		let node = element;
		while ( node && node !== document.documentElement ) {
			const color = window.getComputedStyle( node ).backgroundColor;
			const rgb = color.match( /\d+(\.\d+)?/g );
			if ( rgb && ( rgb.length < 4 || Number( rgb[ 3 ] ) > 0 ) ) {
				const [ r, g, b ] = rgb.map( Number );
				return 0.2126 * r + 0.7152 * g + 0.0722 * b < 128;
			}
			node = node.parentElement;
		}
		return false;
	}

	function show( box, fromClick ) {
		if ( box.dataset.started ) {
			return;
		}
		box.dataset.started = '1';
		box.classList.add( 'is-loading' );
		box.setAttribute( 'aria-busy', 'true' );
		status( box, 'loading' );

		const consent = box.querySelector( '.witryna-greviews__consent' );
		if ( consent ) {
			consent.hidden = true;
			if ( fromClick ) {
				// Keep the keyboard focus in the section after the button disappears.
				const heading = box.closest( '.witryna-reviews__google' );
				const target = heading && heading.querySelector( '.witryna-reviews__heading' );
				if ( target ) {
					target.focus();
				}
			}
		}

		const slot = box.querySelector( '.witryna-greviews__slot' );

		if ( box.dataset.embed ) {
			// No API key: Google's keyless map card with the rating and a link to the reviews.
			const frame = document.createElement( 'iframe' );
			frame.className = 'witryna-greviews__map';
			frame.src = box.dataset.embed;
			frame.title = box.dataset.mapTitle || 'Mapy Google';
			frame.loading = 'lazy';
			frame.referrerPolicy = 'no-referrer-when-downgrade';
			frame.addEventListener( 'load', () => {
				box.classList.remove( 'is-loading' );
				box.classList.add( 'is-loaded' );
				box.removeAttribute( 'aria-busy' );
				status( box, '' );
			} );
			slot.appendChild( frame );
			return;
		}

		// Loading the Maps script gets its own, longer limit.
		const scriptTimer = window.setTimeout( () => fail( box ), 20000 );

		loadMaps( box.dataset.key )
			.then( () => {
				window.clearTimeout( scriptTimer );
				if ( box.classList.contains( 'is-failed' ) ) {
					return;
				}
				const details = document.createElement( 'gmp-place-details' );
				const request = document.createElement( 'gmp-place-details-place-request' );
				request.setAttribute( 'place', box.dataset.place );
				const config = document.createElement( 'gmp-place-content-config' );
				config.appendChild( document.createElement( 'gmp-place-rating' ) );
				config.appendChild( document.createElement( 'gmp-place-reviews' ) );
				const attribution = document.createElement( 'gmp-place-attribution' );
				attribution.setAttribute( 'light-scheme-color', 'gray' );
				attribution.setAttribute( 'dark-scheme-color', 'white' );
				config.appendChild( attribution );
				details.appendChild( request );
				details.appendChild( config );
				details.style.colorScheme = isDark( box ) ? 'dark' : 'light';

				// The element itself has 10 seconds after it is added to the page.
				const timer = window.setTimeout( () => fail( box ), 10000 );
				details.addEventListener( 'gmp-load', () => {
					window.clearTimeout( timer );
					if ( box.classList.contains( 'is-failed' ) || ! details.isConnected ) {
						return;
					}
					box.classList.remove( 'is-loading' );
					box.classList.add( 'is-loaded' );
					box.removeAttribute( 'aria-busy' );
					status( box, '' );
				} );
				details.addEventListener( 'gmp-error', () => {
					window.clearTimeout( timer );
					fail( box );
				} );
				slot.appendChild( details );
			} )
			.catch( () => {
				window.clearTimeout( scriptTimer );
				fail( box );
			} );
	}

	window.witrynaLoadGoogleReviews = function () {
		boxes.forEach( ( box ) => show( box ) );
	};

	boxes.forEach( ( box ) => {
		const button = box.querySelector( '.witryna-greviews__load' );
		if ( button ) {
			button.addEventListener( 'click', () => show( box, true ) );
		}
		if ( '1' !== box.dataset.autoload ) {
			return;
		}
		if ( ! ( 'IntersectionObserver' in window ) ) {
			show( box );
			return;
		}
		const observer = new IntersectionObserver(
			( entries ) => {
				if ( entries.some( ( entry ) => entry.isIntersecting ) ) {
					observer.disconnect();
					show( box );
				}
			},
			{ rootMargin: '300px 0px' }
		);
		observer.observe( box );
	} );
} )();
