/**
 * Full-page screenshots of the local demo store (uses the installed Google Chrome).
 *
 *   node dev/tools/shots.mjs <out-dir> <width> <path> [path...]
 *
 * Environment: LOGIN=admin|klient, ADD_TO_CART=12,34, SCHEME=dark, SEGMENT=1100.
 *
 * Long pages are also cut into numbered segments that are easier to review.
 */
import { chromium } from 'playwright-core';
import { mkdirSync } from 'node:fs';
import { join } from 'node:path';

const [ out = 'shots', width = '1440', ...paths ] = process.argv.slice( 2 );
const base = process.env.BASE_URL || 'http://127.0.0.1:9400';
const height = Number( process.env.SEGMENT || 1100 );
const login = process.env.LOGIN || '';
const scheme = process.env.SCHEME || 'light';

mkdirSync( out, { recursive: true } );
const browser = await chromium.launch( { channel: 'chrome' } );
const context = await browser.newContext( {
	viewport: { width: Number( width ), height },
	deviceScaleFactor: 1,
	colorScheme: scheme,
	isMobile: Number( width ) < 768,
	hasTouch: Number( width ) < 768,
} );
const page = await context.newPage();
const errors = [];
page.on( 'pageerror', ( e ) => errors.push( `pageerror: ${ e.message }` ) );
page.on( 'console', ( m ) => m.type() === 'error' && errors.push( `console: ${ m.text() }` ) );

if ( login ) {
	await page.goto( `${ base }/?dev-login=${ login }`, { waitUntil: 'networkidle' } );
}

for ( const id of ( process.env.ADD_TO_CART || '' ).split( ',' ).filter( Boolean ) ) {
	await page.goto( `${ base }/?add-to-cart=${ id }`, { waitUntil: 'networkidle' } );
}

for ( const path of paths.length ? paths : [ '/' ] ) {
	const name = ( path.replace( /[^a-z0-9]+/gi, '-' ).replace( /^-|-$/g, '' ) || 'home' ) + `-${ width }`;
	await page.goto( base + path, { waitUntil: 'networkidle' } );
	await page.evaluate( async () => {
		// Trigger lazy images and scroll-driven reveals, then return to the top.
		for ( let y = 0; y < document.body.scrollHeight; y += 600 ) {
			window.scrollTo( 0, y );
			await new Promise( ( r ) => setTimeout( r, 140 ) );
		}
		window.scrollTo( 0, 0 );
		await new Promise( ( r ) => setTimeout( r, 900 ) );
		document.querySelectorAll( '*' ).forEach( ( el ) => {
			if ( getComputedStyle( el ).animationName === 'witryna-rise' ) {
				el.style.animation = 'none';
			}
		} );
	} );
	const full = join( out, `${ name }.png` );
	await page.screenshot( { path: full, fullPage: true } );
	const total = await page.evaluate( () => document.documentElement.scrollHeight );
	let i = 0;
	for ( let y = 0; y < total; y += height ) {
		await page.screenshot( {
			path: join( out, `${ name }-${ String( ++i ).padStart( 2, '0' ) }.png` ),
			fullPage: true,
			clip: { x: 0, y, width: Number( width ), height: Math.min( height, total - y ) },
		} );
	}
	console.log( `${ name }: ${ total }px, ${ i } segments` );
}

if ( errors.length ) {
	console.log( 'Errors:\n' + [ ...new Set( errors ) ].join( '\n' ) );
}
await browser.close();
