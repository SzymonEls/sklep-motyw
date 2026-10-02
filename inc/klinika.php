<?php
/**
 * Klinika Trawnika store details used across patterns.
 *
 * Every pattern reads contact details from here, so a changed phone number
 * or address only needs to be updated in one place.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the store details, or a single value when a key is given.
 *
 * @param string $key Optional key, e.g. 'phone' or 'address'.
 * @return array|string
 */
function witryna_store_info( $key = '' ) {
	$info = array(
		'name'       => 'Klinika Trawnika',
		'company'    => 'Klinika Trawnika Łukasz Spychała',
		'phone'      => '603 047 842',
		'phone_href' => '+48603047842',
		'email'      => 'klinikatrawnika.czernica@gmail.com',
		'street'     => 'ul. Miła 1',
		'city'       => '55-003 Czernica',
		'nip'        => '866-158-80-81',
		'hours'      => array(
			array( 'Poniedziałek–piątek', '9:00–17:00' ),
			array( 'Sobota', '9:00–13:00' ),
			array( 'Niedziela', 'nieczynne' ),
		),
		'hours_short' => 'Pn–Pt 9–17, Sob 9–13',
		'tiktok'      => 'https://www.tiktok.com/@klinikatrawnka.czernica',
		'tiktok_name' => '@klinikatrawnka.czernica',
		'google'      => '',
	);

	/**
	 * Filters the store details.
	 *
	 * @param array $info Store details.
	 */
	$info = apply_filters( 'witryna_store_info', $info );

	if ( '' === $key ) {
		return $info;
	}

	return isset( $info[ $key ] ) ? $info[ $key ] : '';
}

/**
 * Returns the full one-line address.
 *
 * @return string
 */
function witryna_store_address() {
	return witryna_store_info( 'street' ) . ', ' . witryna_store_info( 'city' );
}

/**
 * Returns a Google Maps search URL for the store address.
 *
 * @return string
 */
function witryna_store_map_url() {
	return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( witryna_store_info( 'name' ) . ' ' . witryna_store_address() );
}

/**
 * Returns the URL of a page by its slug, or the fallback when it does not exist.
 *
 * @param string $slug     Page slug, e.g. 'serwis'.
 * @param string $fallback Fallback URL.
 * @return string
 */
function witryna_page_url( $slug, $fallback = '' ) {
	$page = get_page_by_path( $slug );

	if ( $page ) {
		return esc_url( get_permalink( $page ) );
	}

	return esc_url( $fallback ? $fallback : home_url( '/' . $slug . '/' ) );
}

/**
 * Returns real, approved product reviews left in the shop.
 *
 * Only genuine WooCommerce reviews are shown, so the theme never displays
 * invented opinions.
 *
 * @param int $number     Maximum number of reviews.
 * @param int $min_rating Lowest rating to include (1–5).
 * @return array[] List of reviews with author, text, rating, product and date.
 */
function witryna_store_reviews( $number = 3, $min_rating = 4 ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return array();
	}

	$comments = get_comments(
		array(
			'post_type'  => 'product',
			'type'       => 'review',
			'status'     => 'approve',
			'number'     => $number,
			'meta_query' => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => 'rating',
					'value'   => $min_rating,
					'compare' => '>=',
					'type'    => 'NUMERIC',
				),
			),
		)
	);

	$reviews = array();

	foreach ( $comments as $comment ) {
		$reviews[] = array(
			'author'   => $comment->comment_author,
			'text'     => wp_trim_words( $comment->comment_content, 40 ),
			'rating'   => (int) get_comment_meta( $comment->comment_ID, 'rating', true ),
			'product'  => get_the_title( $comment->comment_post_ID ),
			'date'     => get_comment_date( '', $comment ),
			'verified' => (bool) get_comment_meta( $comment->comment_ID, 'verified', true ),
		);
	}

	return $reviews;
}

/**
 * Returns a star string for a rating, e.g. "★★★★☆".
 *
 * @param int $rating Rating from 1 to 5.
 * @return string
 */
function witryna_stars( $rating ) {
	$rating = max( 0, min( 5, (int) $rating ) );

	return str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating );
}
