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

	const boxes = Array.from( document.querySelectorAll( '.witryna-greviews[data-key][data-place]' ) );
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

	function fail( box ) {
		const slot = box.querySelector( '.witryna-greviews__slot' );
		slot.textContent = '';
		box.classList.remove( 'is-loading', 'is-loaded' );
		box.classList.add( 'is-failed' );
		const admin = box.querySelector( '.witryna-greviews__admin' );
		if ( admin ) {
			admin.hidden = false;
		}
	}

	function show( box ) {
		if ( box.dataset.started ) {
			return;
		}
		box.dataset.started = '1';
		box.classList.add( 'is-loading' );

		const consent = box.querySelector( '.witryna-greviews__consent' );
		if ( consent ) {
			consent.hidden = true;
		}

		const dark = window.matchMedia && window.matchMedia( '(prefers-color-scheme: dark)' ).matches;
		const slot = box.querySelector( '.witryna-greviews__slot' );
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
		details.style.colorScheme = dark ? 'dark' : 'light';

		let loaded = false;
		const timer = window.setTimeout( () => {
			if ( ! loaded ) {
				fail( box );
			}
		}, 10000 );

		details.addEventListener( 'gmp-load', () => {
			loaded = true;
			window.clearTimeout( timer );
			box.classList.remove( 'is-loading' );
			box.classList.add( 'is-loaded' );
		} );
		details.addEventListener( 'gmp-error', () => {
			window.clearTimeout( timer );
			fail( box );
		} );

		loadMaps( box.dataset.key )
			.then( () => slot.appendChild( details ) )
			.catch( () => {
				window.clearTimeout( timer );
				fail( box );
			} );
	}

	window.witrynaLoadGoogleReviews = function () {
		boxes.forEach( show );
	};

	boxes.forEach( ( box ) => {
		const button = box.querySelector( '.witryna-greviews__load' );
		if ( button ) {
			button.addEventListener( 'click', () => show( box ) );
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
