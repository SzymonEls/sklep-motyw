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
 * Returns approved product reviews left in the shop, newest first.
 *
 * Only genuine WooCommerce reviews are shown and they are not filtered by
 * rating by default, so negative reviews are shown as well (Omnibus).
 *
 * @param int $number     Maximum number of reviews.
 * @param int $min_rating Lowest rating to include (1–5).
 * @return array[] Reviews with author, text, rating, product, date, link and verified.
 */
function witryna_store_reviews( $number = 3, $min_rating = 1 ) {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return array();
	}

	$args = array(
		'post_type' => 'product',
		'type'      => 'review',
		'status'    => 'approve',
		'parent'    => 0,
		'number'    => $number,
		'orderby'   => 'comment_date_gmt',
		'order'     => 'DESC',
	);

	if ( $min_rating > 1 ) {
		$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			array(
				'key'     => 'rating',
				'value'   => $min_rating,
				'compare' => '>=',
				'type'    => 'NUMERIC',
			),
		);
	}

	$reviews = array();

	foreach ( get_comments( $args ) as $comment ) {
		$reviews[] = array(
			'author'   => $comment->comment_author,
			'text'     => $comment->comment_content,
			'rating'   => (int) get_comment_meta( $comment->comment_ID, 'rating', true ),
			'product'  => get_the_title( $comment->comment_post_ID ),
			'date'     => get_comment_date( '', $comment ),
			'link'     => get_comment_link( $comment ),
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
 * Returns the Google reviews settings.
 *
 * The reviews are shown by Google's own Place Details element (Places UI Kit)
 * in the visitor's browser: the shop never downloads or stores them, as the
 * Google Maps Platform terms require.
 *
 * @return array{key: string, place_id: string, autoload: bool, is_admin: bool}
 */
function witryna_google_config() {
	$place_id = trim( (string) get_option( 'witryna_google_place_id', '' ) );

	return array(
		'key'      => preg_replace( '/[^A-Za-z0-9_-]/', '', (string) get_option( 'witryna_google_browser_key', '' ) ),
		'place_id' => preg_replace( '/[^A-Za-z0-9_-]/', '', $place_id ? $place_id : witryna_store_info( 'google_place_id' ) ),
		'autoload' => (bool) get_option( 'witryna_google_autoload', false ),
		'is_admin' => current_user_can( 'manage_options' ),
	);
}

/**
 * Returns the URL where visitors can leave a Google review.
 *
 * @return string
 */
function witryna_google_review_url() {
	$place_id = witryna_google_config()['place_id'];

	return $place_id ? 'https://search.google.com/local/writereview?placeid=' . rawurlencode( $place_id ) : witryna_store_info( 'google' );
}

/**
 * Sanitizes the Google browser API key.
 *
 * @param string $value Key.
 * @return string
 */
function witryna_google_sanitize_key( $value ) {
	return preg_replace( '/[^A-Za-z0-9_-]/', '', (string) $value );
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
			'title'    => __( 'Opinie Google', 'witryna' ),
			'priority' => 160,
		)
	);

	$fields = array(
		'witryna_google_browser_key' => array(
			'label'       => __( 'Klucz API Google (przeglądarkowy)', 'witryna' ),
			'description' => __( 'Ten klucz będzie widoczny w kodzie strony. W Google Cloud ogranicz go do domeny sklepu (Witryny) i do Maps JavaScript API oraz Places UI Kit.', 'witryna' ),
			'type'        => 'text',
			'sanitize'    => 'witryna_google_sanitize_key',
		),
		'witryna_google_place_id'    => array(
			'label'       => __( 'Identyfikator miejsca (Place ID)', 'witryna' ),
			'description' => '',
			'type'        => 'text',
			'sanitize'    => 'witryna_google_sanitize_key',
		),
		'witryna_google_autoload'    => array(
			'label'       => __( 'Wczytuj opinie Google automatycznie', 'witryna' ),
			'description' => __( 'Zaznacz, gdy polityka prywatności (i baner cookies, jeśli jest) obejmuje Mapy Google. Bez tego opinie wczytają się po kliknięciu przycisku.', 'witryna' ),
			'type'        => 'checkbox',
			'sanitize'    => 'rest_sanitize_boolean',
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'type'              => 'option',
				'capability'        => 'manage_options',
				'default'           => 'witryna_google_place_id' === $id ? witryna_store_info( 'google_place_id' ) : '',
				'sanitize_callback' => $field['sanitize'],
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'       => $field['label'],
				'description' => $field['description'],
				'section'     => 'witryna_google',
				'type'        => $field['type'],
			)
		);
	}
}
add_action( 'customize_register', 'witryna_google_customize' );

/**
 * Registers the reviews block (Google reviews and shop reviews).
 */
function witryna_register_reviews_block() {
	wp_register_script(
		'witryna-google-reviews',
		get_theme_file_uri( 'assets/js/google-reviews.js' ),
		array(),
		WITRYNA_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	register_block_type( get_theme_file_path( 'blocks/reviews' ) );
}
add_action( 'init', 'witryna_register_reviews_block' );
