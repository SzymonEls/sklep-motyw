/**
 * Starts a local WordPress + WooCommerce site with the Witryna theme.
 *
 * The site lives in node_modules/.cache/witryna-playground so products and
 * settings survive restarts (WordPress ignores node_modules inside themes).
 * The first start installs WordPress and WooCommerce and creates the demo store.
 *
 *   npm start            start (or create) the site on http://127.0.0.1:9400
 *   npm run reset        delete the site and create a fresh one
 *
 * The demo imports up to six STIHL products per category. To import all of
 * them, create the site with WITRYNA_DEMO_ALL=1 (e.g. WITRYNA_DEMO_ALL=1 npm run reset).
 */
import { spawn } from 'node:child_process';
import { existsSync, mkdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const site = join( root, 'node_modules', '.cache', 'witryna-playground' );
const args = process.argv.slice( 2 );
const port = process.env.PORT || '9400';

if ( args.includes( '--reset' ) ) {
	rmSync( site, { recursive: true, force: true } );
}

const isNew = ! existsSync( join( site, 'wp-config.php' ) );
mkdirSync( site, { recursive: true } );

const cli = [
	'wp-playground-cli',
	'server',
	`--port=${ port }`,
	'--php=8.3',
	`--mount-before-install=${ site }:/wordpress`,
	`--mount=${ root }:/wordpress/wp-content/themes/witryna`,
	`--mount=${ join( root, 'dev/plugins/witryna-dev' ) }:/wordpress/wp-content/plugins/witryna-dev`,
	`--mount=${ join( root, 'dev/demo' ) }:/wordpress/wp-content/witryna-demo`,
];

if ( isNew ) {
	let blueprint = join( root, 'dev/blueprint.json' );
	if ( process.env.WITRYNA_DEMO_ALL ) {
		const data = JSON.parse( readFileSync( blueprint, 'utf8' ) );
		data.steps.unshift( { step: 'defineWpConfigConsts', consts: { WITRYNA_DEMO_ALL: true } } );
		blueprint = join( site, '..', 'witryna-blueprint-all.json' );
		writeFileSync( blueprint, JSON.stringify( data ) );
	}
	cli.push( `--blueprint=${ blueprint }` );
	console.log( 'Tworzę nowy sklep demo – pierwsze uruchomienie potrwa kilka minut…' );
} else {
	cli.push( '--wordpress-install-mode=do-not-attempt-installing' );
}

const child = spawn( 'npx', cli, { cwd: root, stdio: 'inherit' } );
child.on( 'exit', ( code ) => process.exit( code ?? 0 ) );
