/**
 * Builds dist/witryna.zip – the installable theme package.
 */
import { execFileSync } from 'node:child_process';
import { mkdirSync, rmSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join( dirname( fileURLToPath( import.meta.url ) ), '..' );
const dist = join( root, 'dist' );
mkdirSync( dist, { recursive: true } );
rmSync( join( dist, 'witryna.zip' ), { force: true } );
execFileSync( 'zip', [ '-rq', join( dist, 'witryna.zip' ), 'witryna', '-x', '*.DS_Store' ], { cwd: root, stdio: 'inherit' } );
console.log( 'dist/witryna.zip' );
