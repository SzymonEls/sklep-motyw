/**
 * Builds dist/witryna.zip – the installable theme package.
 *
 * The theme folder inside the package is "witryna". To replace a theme that
 * is installed under another folder name (WordPress offers "Replace active
 * with uploaded" only when the names match), pass it as an argument:
 *
 *   npm run build -- sklep-motyw     →  dist/sklep-motyw.zip
 *
 * The repository root is the theme; only theme files are copied into the
 * package (development tools, demo content and node_modules are left out).
 */
import { execFileSync } from 'node:child_process';
import { cpSync, existsSync, mkdirSync, rmSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const dist = join( root, 'dist' );
const name = ( process.argv[ 2 ] || 'witryna' ).replace( /[^a-z0-9_-]/gi, '' ) || 'witryna';
const stage = join( dist, name );
const entries = [
	'style.css',
	'theme.json',
	'functions.php',
	'readme.txt',
	'screenshot.png',
	'assets',
	'blocks',
	'inc',
	'languages',
	'parts',
	'patterns',
	'styles',
	'templates',
];

rmSync( stage, { recursive: true, force: true } );
rmSync( join( dist, name + '.zip' ), { force: true } );
mkdirSync( stage, { recursive: true } );

for ( const entry of entries ) {
	if ( existsSync( join( root, entry ) ) ) {
		cpSync( join( root, entry ), join( stage, entry ), {
			recursive: true,
			filter: ( src ) => ! src.endsWith( '.DS_Store' ),
		} );
	}
}

execFileSync( 'zip', [ '-rq', name + '.zip', name ], { cwd: dist, stdio: 'inherit' } );
rmSync( stage, { recursive: true, force: true } );
console.log( 'dist/' + name + '.zip' );
