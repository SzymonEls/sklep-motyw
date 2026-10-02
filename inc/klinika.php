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
		'google'            => 'https://www.google.com/maps?cid=6246252236807402821',
		'google_name'       => 'KLINIKA TRAWNIKA - Autoryzowany dealer STIHL',
		'google_place_id'   => 'ChIJpc45KqjfD0cRRfVkuFAlr1Y',
		'google_review_url' => 'https://search.google.com/local/writereview?placeid=ChIJpc45KqjfD0cRRfVkuFAlr1Y',
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
	$google = witryna_store_info( 'google' );

	if ( $google ) {
		return $google;
	}

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

/**
 * Registers the Google reviews settings in the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function witryna_google_customize( $wp_customize ) {
	$wp_customize->add_section(
		'witryna_google',
		array(
			'title'       => __( 'Opinie Google', 'witryna' ),
			'description' => __( 'Opinie z wizytówki Google są pobierane przez Google Places API. Wklej klucz API z Google Cloud (z włączonym Places API (New)). Identyfikator miejsca zostanie znaleziony automatycznie, jeśli pole zostawisz puste.', 'witryna' ),
			'priority'    => 160,
		)
	);

	$wp_customize->add_setting(
		'witryna_google_api_key',
		array(
			'type'              => 'option',
			'capability'        => 'manage_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'witryna_google_api_key',
		array(
			'label'   => __( 'Klucz Google Places API', 'witryna' ),
			'section' => 'witryna_google',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'witryna_google_place_id',
		array(
			'type'              => 'option',
			'capability'        => 'manage_options',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'witryna_google_place_id',
		array(
			'label'   => __( 'Identyfikator miejsca (Place ID, opcjonalnie)', 'witryna' ),
			'section' => 'witryna_google',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'witryna_google_customize' );

/**
 * Clears cached Google data when the settings change.
 */
function witryna_google_flush() {
	delete_transient( 'witryna_google_place' );
	delete_option( 'witryna_google_found_place_id' );
}
add_action( 'update_option_witryna_google_api_key', 'witryna_google_flush' );
add_action( 'update_option_witryna_google_place_id', 'witryna_google_flush' );

/**
 * Sends a request to Google Places API (New).
 *
 * @param string $url    Endpoint URL.
 * @param string $fields Field mask.
 * @param array  $body   JSON body for a POST request; empty for GET.
 * @return array|null Decoded response or null on failure.
 */
function witryna_google_request( $url, $fields, $body = array() ) {
	$args = array(
		'timeout' => 8,
		'headers' => array(
			'X-Goog-Api-Key'   => get_option( 'witryna_google_api_key', '' ),
			'X-Goog-FieldMask' => $fields,
			'Content-Type'     => 'application/json',
		),
	);

	if ( $body ) {
		$args['body'] = wp_json_encode( $body );
		$response     = wp_remote_post( $url, $args );
	} else {
		$response = wp_remote_get( $url, $args );
	}

	if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
		return null;
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	return is_array( $data ) ? $data : null;
}

/**
 * Returns the Google place ID of the store, looking it up once when not set.
 *
 * @return string
 */
function witryna_google_place_id() {
	$place_id = get_option( 'witryna_google_place_id', '' );

	if ( ! $place_id ) {
		$place_id = witryna_store_info( 'google_place_id' );
	}

	if ( $place_id ) {
		return $place_id;
	}

	$place_id = get_option( 'witryna_google_found_place_id', '' );

	if ( $place_id || ! get_option( 'witryna_google_api_key' ) ) {
		return $place_id;
	}

	$data = witryna_google_request(
		'https://places.googleapis.com/v1/places:searchText',
		'places.id',
		array(
			'textQuery'    => witryna_store_info( 'google_name' ) . ', ' . witryna_store_address(),
			'languageCode' => 'pl',
		)
	);

	if ( ! empty( $data['places'][0]['id'] ) ) {
		$place_id = sanitize_text_field( $data['places'][0]['id'] );
		update_option( 'witryna_google_found_place_id', $place_id, false );
	}

	return $place_id;
}

/**
 * Returns the store's Google rating and newest reviews.
 *
 * Google returns at most five reviews. The result is cached for 12 hours.
 *
 * @return array{rating: float, count: int, url: string, review_url: string, reviews: array[]}|array Empty array when unavailable.
 */
function witryna_google_place() {
	if ( ! get_option( 'witryna_google_api_key' ) ) {
		return array();
	}

	$cached = get_transient( 'witryna_google_place' );

	if ( false !== $cached ) {
		return $cached;
	}

	$place    = array();
	$place_id = witryna_google_place_id();
	$data     = $place_id ? witryna_google_request(
		'https://places.googleapis.com/v1/places/' . rawurlencode( $place_id ) . '?languageCode=pl',
		'rating,userRatingCount,googleMapsUri,reviews'
	) : null;

	if ( $data ) {
		$reviews = array();

		foreach ( isset( $data['reviews'] ) ? $data['reviews'] : array() as $review ) {
			$text = isset( $review['text']['text'] ) ? $review['text']['text'] : ( isset( $review['originalText']['text'] ) ? $review['originalText']['text'] : '' );

			if ( '' === trim( $text ) ) {
				continue;
			}

			$reviews[] = array(
				'author'     => isset( $review['authorAttribution']['displayName'] ) ? $review['authorAttribution']['displayName'] : '',
				'author_url' => isset( $review['authorAttribution']['uri'] ) ? $review['authorAttribution']['uri'] : '',
				'text'       => wp_trim_words( $text, 40 ),
				'rating'     => isset( $review['rating'] ) ? (int) $review['rating'] : 5,
				'product'    => __( 'Opinia z Google', 'witryna' ),
				'date'       => isset( $review['relativePublishTimeDescription'] ) ? $review['relativePublishTimeDescription'] : '',
				'verified'   => false,
				'source'     => 'google',
			);
		}

		$place = array(
			'rating'     => isset( $data['rating'] ) ? (float) $data['rating'] : 0,
			'count'      => isset( $data['userRatingCount'] ) ? (int) $data['userRatingCount'] : 0,
			'url'        => isset( $data['googleMapsUri'] ) ? $data['googleMapsUri'] : witryna_store_info( 'google' ),
			'review_url' => 'https://search.google.com/local/writereview?placeid=' . rawurlencode( $place_id ),
			'reviews'    => $reviews,
		);
	}

	// Cache failures for an hour so a wrong key does not slow every page down.
	set_transient( 'witryna_google_place', $place, $place ? 12 * HOUR_IN_SECONDS : HOUR_IN_SECONDS );

	return $place;
}

/**
 * Returns the URL where visitors can leave a Google review.
 *
 * @return string
 */
function witryna_google_review_url() {
	$place = witryna_google_place();

	return $place ? $place['review_url'] : witryna_store_info( 'google_review_url' );
}

/**
 * Returns reviews to show on the site: Google reviews first, then shop reviews.
 *
 * @param int $number     Maximum number of reviews.
 * @param int $min_rating Lowest rating to include (1–5).
 * @return array[]
 */
function witryna_all_reviews( $number = 3, $min_rating = 4 ) {
	$place  = witryna_google_place();
	$google = array();

	foreach ( $place ? $place['reviews'] : array() as $review ) {
		if ( $review['rating'] >= $min_rating ) {
			$google[] = $review;
		}
	}

	return array_slice( array_merge( $google, witryna_store_reviews( $number, $min_rating ) ), 0, $number );
}
