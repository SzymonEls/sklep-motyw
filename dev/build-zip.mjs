/**
 * Builds dist/witryna.zip – the installable theme package.
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
const stage = join( dist, 'witryna' );
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
rmSync( join( dist, 'witryna.zip' ), { force: true } );
mkdirSync( stage, { recursive: true } );

for ( const entry of entries ) {
	if ( existsSync( join( root, entry ) ) ) {
		cpSync( join( root, entry ), join( stage, entry ), {
			recursive: true,
			filter: ( src ) => ! src.endsWith( '.DS_Store' ),
		} );
	}
}

execFileSync( 'zip', [ '-rq', 'witryna.zip', 'witryna' ], { cwd: dist, stdio: 'inherit' } );
rmSync( stage, { recursive: true, force: true } );
console.log( 'dist/witryna.zip' );
