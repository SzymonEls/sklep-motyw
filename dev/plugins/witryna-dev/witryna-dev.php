<?php
/**
 * Plugin Name: Witryna – narzędzia deweloperskie
 * Description: Ułatwienia dla lokalnego środowiska WordPress Playground (automatyczne logowanie). Nie instaluj na serwerze produkcyjnym.
 * Version: 1.0.0
 * License: GPL-2.0-or-later
 */

defined( 'ABSPATH' ) || exit;

/*
 * Automatyczne logowanie: dodaj ?dev-login=1 (administrator) lub ?dev-login=klient
 * (konto klienta demo) do dowolnego adresu. Działa wyłącznie na localhost/127.0.0.1.
 */
add_action(
	'init',
	static function () {
		if ( empty( $_GET['dev-login'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return;
		}
		$host = wp_parse_url( home_url(), PHP_URL_HOST );
		if ( ! in_array( $host, array( '127.0.0.1', 'localhost' ), true ) ) {
			return;
		}
		$login = 'klient' === $_GET['dev-login'] ? 'klient' : 'admin'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$user  = get_user_by( 'login', $login );
		if ( ! $user ) {
			return;
		}
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID, true );
		wp_safe_redirect( remove_query_arg( 'dev-login' ) );
		exit;
	}
);
