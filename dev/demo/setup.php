<?php
/**
 * Demo store for the local Playground environment.
 *
 * Creates the Klinika Trawnika store: STIHL categories and products from
 * stihl-products.json, blog posts, pages, a navigation menu, shipping and
 * payment methods and a sample order. No reviews are created: the theme only
 * shows real ones.
 * Run once on a fresh site: it is executed by dev/blueprint.json.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

/* ---------------------------------------------------------------------------
 * Store settings (Poland, PLN).
 * ------------------------------------------------------------------------ */
$witryna_options = array(
	'blogname'                                 => 'Klinika Trawnika',
	'blogdescription'                          => 'Autoryzowany dealer STIHL – sklep i serwis',
	'woocommerce_default_country'              => 'PL:',
	'woocommerce_store_address'                => 'ul. Miła 1',
	'woocommerce_store_city'                   => 'Czernica',
	'woocommerce_store_postcode'               => '55-003',
	'woocommerce_currency'                     => 'PLN',
	'woocommerce_currency_pos'                 => 'right_space',
	'woocommerce_price_thousand_sep'           => ' ',
	'woocommerce_price_decimal_sep'            => ',',
	'woocommerce_price_num_decimals'           => 2,
	'woocommerce_weight_unit'                  => 'kg',
	'woocommerce_dimension_unit'               => 'cm',
	'woocommerce_enable_reviews'               => 'yes',
	'woocommerce_review_rating_verification_required' => 'yes',
	'woocommerce_review_rating_verification_label' => 'yes',
	'woocommerce_enable_review_rating'         => 'yes',
	'woocommerce_calc_taxes'                   => 'no',
	'woocommerce_coming_soon'                  => 'no',
	'woocommerce_store_pages_only'             => 'no',
	'woocommerce_enable_guest_checkout'        => 'yes',
	'woocommerce_enable_signup_and_login_from_checkout' => 'yes',
	'woocommerce_task_list_hidden'             => 'yes',
	'woocommerce_onboarding_profile'           => array( 'skipped' => true ),
	'woocommerce_show_marketplace_suggestions' => 'no',
	'woocommerce_allow_tracking'               => 'no',
	'woocommerce_analytics_enabled'            => 'no',
	'woocommerce_feature_product_block_editor_enabled' => 'no',
	'permalink_structure'                      => '/%postname%/',
	'date_format'                              => 'j F Y',
	'posts_per_page'                           => 9,
);
foreach ( $witryna_options as $witryna_key => $witryna_value ) {
	update_option( $witryna_key, $witryna_value );
}

/* ---------------------------------------------------------------------------
 * STIHL categories and products from stihl-products.json.
 *
 * The JSON is made by dev/tools/stihl-products.py. By default up to six
 * products per category are imported so the preview starts quickly; set
 * WITRYNA_DEMO_ALL=1 (constant or environment variable) to import all.
 * Prices are the STIHL list prices without promotions: a sale price would
 * need the lowest price from the last 30 days (Omnibus), which a fresh demo
 * does not have. Images are downloaded from stihl.pl during the import.
 * ------------------------------------------------------------------------ */
$witryna_demo_all = ( defined( 'WITRYNA_DEMO_ALL' ) && WITRYNA_DEMO_ALL ) || getenv( 'WITRYNA_DEMO_ALL' );
$witryna_per_cat  = $witryna_demo_all ? PHP_INT_MAX : 6;
$witryna_catalog  = json_decode( (string) file_get_contents( __DIR__ . '/stihl-products.json' ), true );
$witryna_catalog  = is_array( $witryna_catalog ) ? $witryna_catalog : array();

$witryna_category_info = array(
	'Kosiarki'                        => 'Kosiarki akumulatorowe, spalinowe i elektryczne STIHL, kosiarki mulczujące i traktorki ogrodowe.',
	'Roboty koszące'                  => 'Roboty koszące iMOW, które same dbają o równy trawnik. Pomagamy dobrać model i przygotować trawnik do montażu.',
	'Pilarki'                         => 'Pilarki łańcuchowe STIHL do ogrodu, drewna opałowego i prac leśnych oraz podkrzesywarki.',
	'Kosy i podkaszarki'              => 'Kosy mechaniczne i podkaszarki do trawy, chwastów i zarośli.',
	'Nożyce do żywopłotu'             => 'Akumulatorowe, spalinowe i elektryczne nożyce do żywopłotów.',
	'KombiSystem'                     => 'Jeden napęd, wiele narzędzi: kosa, nożyce, podkrzesywarka, dmuchawa i inne.',
	'Narzędzia ręczne'                => 'Siekiery, sekatory, piły ręczne i narzędzia leśne STIHL.',
	'Przecinarki i pilarki do betonu' => 'Przecinarki i pilarki do cięcia betonu, kamienia i stali.',
	'Uprawa gleby'                    => 'Wertykulatory, aeratory, glebogryzarki i świdry glebowe.',
	'Opryskiwacze'                    => 'Opryskiwacze ręczne, plecakowe i spalinowe.',
	'Myjki ciśnieniowe'               => 'Myjki wysokociśnieniowe STIHL do domu i firmy.',
	'Dmuchawy i odkurzacze'           => 'Dmuchawy do liści, odkurzacze ogrodowe i odkurzacze przemysłowe.',
	'Zamiatarki'                      => 'Zamiatarki ręczne do podjazdów, chodników i placów.',
	'Rozdrabniacze'                   => 'Rozdrabniacze do gałęzi i odpadów ogrodowych.',
	'Kompresory i pompy'              => 'Kompresory i pompy wodne STIHL.',
);

/**
 * Returns the ID of a product category, creating it when needed.
 */
function witryna_demo_category( $name, $parent = 0, $description = '' ) {
	// Short slugs ("kosiarki-akumulatorowe"); the parent's slug is added only
	// when another parent already uses the name ("Akumulatorowe").
	$slug = sanitize_title( $name );
	$term = get_term_by( 'slug', $slug, 'product_cat' );
	if ( $term && (int) $term->parent !== (int) $parent ) {
		$slug = sanitize_title( get_term( $parent, 'product_cat' )->slug . '-' . $name );
		$term = get_term_by( 'slug', $slug, 'product_cat' );
	}
	if ( $term ) {
		return (int) $term->term_id;
	}
	$term = wp_insert_term( $name, 'product_cat', array( 'slug' => $slug, 'parent' => $parent, 'description' => $description ) );
	return is_wp_error( $term ) ? 0 : (int) $term['term_id'];
}

/**
 * Downloads an image from stihl.pl into the media library.
 */
function witryna_demo_remote_image( $url, $title ) {
	static $cache = array();
	if ( isset( $cache[ $url ] ) ) {
		return $cache[ $url ];
	}
	$tmp = download_url( $url, 30 );
	if ( is_wp_error( $tmp ) ) {
		error_log( 'Witryna demo: ' . $url . ': ' . $tmp->get_error_message() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return $cache[ $url ] = 0;
	}
	$id = media_handle_sideload( array( 'name' => 'stihl-' . basename( wp_parse_url( $url, PHP_URL_PATH ) ), 'tmp_name' => $tmp ), 0, $title );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		error_log( 'Witryna demo: ' . $id->get_error_message() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return $cache[ $url ] = 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $title );
	return $cache[ $url ] = $id;
}

$witryna_cat_ids     = array();
$witryna_per_leaf    = array();
$witryna_product_ids = array();
foreach ( $witryna_catalog as $witryna_i => $witryna_item ) {
	if ( empty( $witryna_item['price_regular'] ) ) {
		continue;
	}
	$witryna_path = array_map( 'trim', explode( '>', $witryna_item['category'] ) );
	$witryna_leaf = implode( ' > ', $witryna_path );
	if ( ( $witryna_per_leaf[ $witryna_leaf ] ?? 0 ) >= $witryna_per_cat ) {
		continue;
	}

	$witryna_parent = 0;
	$witryna_terms  = array();
	foreach ( $witryna_path as $witryna_depth => $witryna_name ) {
		$witryna_key = implode( ' > ', array_slice( $witryna_path, 0, $witryna_depth + 1 ) );
		if ( ! isset( $witryna_cat_ids[ $witryna_key ] ) ) {
			$witryna_cat_ids[ $witryna_key ] = witryna_demo_category( $witryna_name, $witryna_parent, $witryna_parent ? '' : ( $witryna_category_info[ $witryna_name ] ?? '' ) );
		}
		$witryna_parent  = $witryna_cat_ids[ $witryna_key ];
		$witryna_terms[] = $witryna_parent;
	}

	$witryna_product = new WC_Product_Simple();
	$witryna_product->set_name( $witryna_item['name'] );
	$witryna_product->set_status( 'publish' );
	$witryna_product->set_regular_price( $witryna_item['price_regular'] );
	$witryna_product->set_short_description( $witryna_item['short_description'] );
	$witryna_product->set_description( $witryna_item['description_html'] . sprintf( '<p><a href="%s" target="_blank" rel="noopener">Strona produktu na stihl.pl</a></p>', esc_url( $witryna_item['url'] ) ) );
	$witryna_product->set_category_ids( $witryna_terms );
	if ( $witryna_item['sku'] && ! wc_get_product_id_by_sku( $witryna_item['sku'] ) ) {
		$witryna_product->set_sku( $witryna_item['sku'] );
	}

	$witryna_attributes = array();
	foreach ( $witryna_item['attributes'] as $witryna_name => $witryna_value ) {
		$witryna_attribute = new WC_Product_Attribute();
		$witryna_attribute->set_name( $witryna_name );
		$witryna_attribute->set_options( array( $witryna_value ) );
		$witryna_attribute->set_visible( true );
		$witryna_attribute->set_variation( false );
		$witryna_attributes[] = $witryna_attribute;
	}
	$witryna_product->set_attributes( $witryna_attributes );

	$witryna_images = array_slice( $witryna_item['images'], 0, $witryna_demo_all ? 4 : 2 );
	$witryna_image  = $witryna_images ? witryna_demo_remote_image( array_shift( $witryna_images ), $witryna_item['name'] ) : 0;
	$witryna_product->set_image_id( $witryna_image );
	$witryna_product->set_gallery_image_ids( array_filter( array_map( static fn( $url ) => witryna_demo_remote_image( $url, $witryna_item['name'] ), $witryna_images ) ) );
	$witryna_first = 0 === ( $witryna_per_leaf[ $witryna_leaf ] ?? 0 );
	$witryna_product->set_featured( $witryna_first );
	$witryna_product->set_stock_status( 'instock' );
	// The theme marks products added in the last 30 days as new, so only
	// products STIHL marks as new get a recent date.
	$witryna_new = in_array( 'NOWOŚĆ', $witryna_item['badges'], true );
	$witryna_product->set_date_created( time() - ( $witryna_new ? 1 : 90 ) * DAY_IN_SECONDS - $witryna_i * HOUR_IN_SECONDS );
	// Demo only: the first product of each category fills the "Bestsellers" section.
	$witryna_product->set_total_sales( $witryna_first ? max( 1, 500 - $witryna_i ) : 0 );
	$witryna_product->save();

	foreach ( $witryna_terms as $witryna_term_id ) {
		if ( ! get_term_meta( $witryna_term_id, 'thumbnail_id', true ) && $witryna_image ) {
			update_term_meta( $witryna_term_id, 'thumbnail_id', $witryna_image );
		}
	}

	$witryna_per_leaf[ $witryna_leaf ] = ( $witryna_per_leaf[ $witryna_leaf ] ?? 0 ) + 1;
	$witryna_product_ids[]             = $witryna_product->get_id();
}

/* ---------------------------------------------------------------------------
 * Pages.
 * ------------------------------------------------------------------------ */
function witryna_demo_page( $title, $slug, $content = '', $template = '' ) {
	$existing = get_page_by_path( $slug );
	$id       = $existing ? $existing->ID : wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
		)
	);
	if ( $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return $id;
}

$witryna_home  = witryna_demo_page( 'Strona główna', 'strona-glowna' );
$witryna_blog  = witryna_demo_page( 'Blog', 'blog' );
// These slugs have their own templates (templates/page-<slug>.html).
$witryna_service = witryna_demo_page( 'Serwis', 'serwis' );
$witryna_reviews = witryna_demo_page( 'Opinie', 'opinie' );
$witryna_social  = witryna_demo_page( 'Social media', 'social-media' );
$witryna_about   = witryna_demo_page( 'O firmie', 'o-firmie' );
$witryna_contact = witryna_demo_page( 'Kontakt', 'kontakt' );
$witryna_terms = witryna_demo_page( 'Regulamin', 'regulamin', '<!-- wp:paragraph --><p>Tu znajdzie się regulamin sklepu internetowego.</p><!-- /wp:paragraph -->' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $witryna_home );
update_option( 'page_for_posts', $witryna_blog );
update_option( 'woocommerce_terms_page_id', $witryna_terms );
$witryna_privacy = (int) get_option( 'wp_page_for_privacy_policy' );
if ( $witryna_privacy ) {
	wp_update_post( array( 'ID' => $witryna_privacy, 'post_status' => 'publish', 'post_title' => 'Polityka prywatności' ) );
}
wp_update_post( array( 'ID' => wc_get_page_id( 'shop' ), 'post_title' => 'Sklep' ) );
wp_update_post( array( 'ID' => wc_get_page_id( 'cart' ), 'post_title' => 'Koszyk' ) );
wp_update_post( array( 'ID' => wc_get_page_id( 'checkout' ), 'post_title' => 'Zamówienie' ) );
wp_update_post( array( 'ID' => wc_get_page_id( 'myaccount' ), 'post_title' => 'Moje konto' ) );

/* ---------------------------------------------------------------------------
 * Blog posts.
 * ------------------------------------------------------------------------ */
$witryna_posts = array(
	array(
		'Przegląd kosiarki przed sezonem: co sprawdzić',
		'Poradniki',
		'Kosiarki',
		'Kilka prostych czynności, dzięki którym kosiarka odpali bez problemu i równo skosi trawnik przez cały sezon.',
		'<!-- wp:paragraph --><p>Zanim pierwszy raz w sezonie wyjedziesz kosiarką na trawnik, warto poświęcić jej pół godziny. Większość usterek, z którymi kosiarki trafiają do serwisu wiosną, wynika z zaniedbań po zimie.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Kosiarka spalinowa</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Wymień olej silnikowy i sprawdź jego poziom na płaskim podłożu.</li><li>Oczyść lub wymień filtr powietrza.</li><li>Sprawdź świecę zapłonową.</li><li>Zatankuj świeże paliwo. Stara benzyna to najczęstsza przyczyna problemów z rozruchem.</li></ul><!-- /wp:list --><!-- wp:heading --><h2 class="wp-block-heading">Każda kosiarka</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Naostrz albo wymień nóż. Tępy nóż szarpie trawę i zostawia brązowe końcówki.</li><li>Oczyść obudowę od spodu z zaschniętej trawy.</li><li>Sprawdź kosz, koła i linkę hamulca noża.</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Nie masz czasu albo narzędzi? Przegląd sezonowy zrobimy w naszym serwisie w Czernicy.</p><!-- /wp:paragraph -->',
	),
	array(
		'Jak dobrać pilarkę do swoich potrzeb',
		'Poradniki',
		'Pilarki',
		'Akumulatorowa czy spalinowa, jaka prowadnica i moc? Podpowiadamy, na co zwrócić uwagę przy wyborze pilarki.',
		'<!-- wp:paragraph --><p>Dobra pilarka to taka, która pasuje do pracy, jaką chcesz wykonać. Do przycinania gałęzi w ogrodzie potrzebujesz innego sprzętu niż do cięcia drewna na opał.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Akumulatorowa</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Cicha, lekka i gotowa do pracy po naciśnięciu przycisku. Sprawdzi się przy przycinaniu drzew i krzewów, pracach przy domu i w miejscach, gdzie liczy się niski hałas.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Spalinowa</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Więcej mocy i dowolnie długa praca. To dobry wybór do cięcia drewna opałowego, ścinania drzew i prac na działce bez dostępu do prądu.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Długość prowadnicy</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Prowadnica powinna być dłuższa niż średnica drewna, które najczęściej tniesz. Do ogrodu zwykle wystarczy 30–35 cm, do drewna opałowego 35–40 cm.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Przyjedź do sklepu, a pomożemy dobrać model i pokażemy, jak bezpiecznie z niego korzystać.</p><!-- /wp:paragraph -->',
	),
	array(
		'Robot koszący iMOW: na jaki trawnik?',
		'Poradniki',
		'Roboty koszące',
		'Sprawdź, czy Twój ogród nadaje się dla robota koszącego i jak dobrać model do powierzchni trawnika.',
		'<!-- wp:paragraph --><p>Robot koszący kosi codziennie po trochu, więc trawnik jest gęsty i zawsze równo przycięty, a Ty nie musisz o tym myśleć.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Powierzchnia i nachylenie</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Każdy model iMOW ma podaną maksymalną powierzchnię trawnika i nachylenie terenu. Wybierz model z zapasem, jeśli ogród ma dużo zakamarków albo wąskich przejść.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Przygotowanie ogrodu</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Zaplanuj miejsce na stację dokującą z dostępem do prądu.</li><li>Usuń z trawnika kamienie, gałęzie i zabawki.</li><li>Zastanów się, gdzie robot ma nie wjeżdżać: rabaty, oczko wodne, warzywnik.</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Pomagamy dobrać robota do ogrodu i zajmujemy się jego montażem.</p><!-- /wp:paragraph -->',
	),
);
foreach ( $witryna_posts as $witryna_i => list( $witryna_title, $witryna_category, $witryna_product_cat, $witryna_excerpt, $witryna_content ) ) {
	$witryna_cat = term_exists( $witryna_category, 'category' );
	if ( ! $witryna_cat ) {
		$witryna_cat = wp_insert_term( $witryna_category, 'category' );
	}
	$witryna_post = wp_insert_post(
		array(
			'post_type'     => 'post',
			'post_status'   => 'publish',
			'post_title'    => $witryna_title,
			'post_excerpt'  => $witryna_excerpt,
			'post_date'     => gmdate( 'Y-m-d H:i:s', time() - ( $witryna_i + 1 ) * 5 * DAY_IN_SECONDS ),
			'post_category' => array( (int) $witryna_cat['term_id'] ),
			'post_content'  => '<!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">' . $witryna_excerpt . '</p><!-- /wp:paragraph -->' . $witryna_content,
		)
	);
	if ( isset( $witryna_cat_ids[ $witryna_product_cat ] ) ) {
		$witryna_thumbnail = (int) get_term_meta( $witryna_cat_ids[ $witryna_product_cat ], 'thumbnail_id', true );
		if ( $witryna_thumbnail ) {
			set_post_thumbnail( $witryna_post, $witryna_thumbnail );
		}
	}
}

/* ---------------------------------------------------------------------------
 * Navigation menu.
 * ------------------------------------------------------------------------ */
$witryna_shop_url = get_permalink( wc_get_page_id( 'shop' ) );
$witryna_links    = '';
foreach ( $witryna_cat_ids as $witryna_key => $witryna_id ) {
	if ( false === strpos( $witryna_key, '>' ) ) {
		$witryna_links .= sprintf( '<!-- wp:navigation-link {"label":"%s","type":"product_cat","id":%d,"url":"%s","kind":"taxonomy"} /-->', esc_attr( $witryna_key ), $witryna_id, esc_url( get_term_link( $witryna_id, 'product_cat' ) ) );
	}
}
$witryna_menu = sprintf( '<!-- wp:navigation-submenu {"label":"Sklep","url":"%1$s","kind":"custom"} -->%2$s<!-- /wp:navigation-submenu -->', esc_url( $witryna_shop_url ), $witryna_links );
foreach ( array( 'Serwis' => $witryna_service, 'Opinie' => $witryna_reviews, 'Social media' => $witryna_social, 'O firmie' => $witryna_about, 'Kontakt' => $witryna_contact ) as $witryna_label => $witryna_page ) {
	$witryna_menu .= sprintf( '<!-- wp:navigation-link {"label":"%s","type":"page","id":%d,"url":"%s","kind":"post-type"} /-->', esc_attr( $witryna_label ), $witryna_page, esc_url( get_permalink( $witryna_page ) ) );
}
wp_insert_post(
	array(
		'post_type'    => 'wp_navigation',
		'post_status'  => 'publish',
		'post_title'   => 'Menu główne',
		'post_content' => $witryna_menu,
	)
);

/* ---------------------------------------------------------------------------
 * Shipping and payments.
 * ------------------------------------------------------------------------ */
$witryna_zone = new WC_Shipping_Zone();
$witryna_zone->set_zone_name( 'Polska' );
$witryna_zone->add_location( 'PL', 'country' );
$witryna_zone->save();
$witryna_flat = $witryna_zone->add_shipping_method( 'flat_rate' );
update_option( 'woocommerce_flat_rate_' . $witryna_flat . '_settings', array( 'title' => 'Kurier', 'cost' => '14.99', 'tax_status' => 'none' ) );
$witryna_free = $witryna_zone->add_shipping_method( 'free_shipping' );
update_option( 'woocommerce_free_shipping_' . $witryna_free . '_settings', array( 'title' => 'Darmowa dostawa', 'requires' => 'min_amount', 'min_amount' => '199' ) );
$witryna_pickup = $witryna_zone->add_shipping_method( 'local_pickup' );
update_option( 'woocommerce_local_pickup_' . $witryna_pickup . '_settings', array( 'title' => 'Odbiór osobisty w Czernicy', 'cost' => '0' ) );

update_option( 'woocommerce_bacs_settings', array( 'enabled' => 'yes', 'title' => 'Przelew tradycyjny', 'description' => 'Wpłać kwotę zamówienia na nasze konto. Wyślemy paczkę po zaksięgowaniu wpłaty.' ) );
update_option( 'woocommerce_cod_settings', array( 'enabled' => 'yes', 'title' => 'Płatność przy odbiorze', 'description' => 'Zapłać kurierowi gotówką lub kartą.' ) );

/* ---------------------------------------------------------------------------
 * Demo customer with an order.
 * ------------------------------------------------------------------------ */
if ( ! username_exists( 'klient' ) ) {
	$witryna_customer_id = wc_create_new_customer( 'klient@example.com', 'klient', wp_generate_password( 24 ), array( 'first_name' => 'Jan', 'last_name' => 'Kowalski' ) );
	if ( ! is_wp_error( $witryna_customer_id ) ) {
		$witryna_address = array(
			'first_name' => 'Jan',
			'last_name'  => 'Kowalski',
			'address_1'  => 'ul. Kwiatowa 5',
			'city'       => 'Kraków',
			'postcode'   => '30-001',
			'country'    => 'PL',
			'email'      => 'klient@example.com',
			'phone'      => '500600700',
		);
		$witryna_order = wc_create_order( array( 'customer_id' => $witryna_customer_id ) );
		foreach ( array_slice( $witryna_product_ids, 0, 2 ) as $witryna_product_id ) {
			$witryna_order->add_product( wc_get_product( $witryna_product_id ), 1 );
		}
		$witryna_order->set_address( $witryna_address, 'billing' );
		$witryna_order->set_address( $witryna_address, 'shipping' );
		$witryna_order->set_payment_method( 'bacs' );
		$witryna_order->set_payment_method_title( 'Przelew tradycyjny' );
		$witryna_order->calculate_totals();
		$witryna_order->update_status( 'completed' );
		foreach ( $witryna_address as $witryna_field => $witryna_value ) {
			update_user_meta( $witryna_customer_id, 'billing_' . $witryna_field, $witryna_value );
			if ( ! in_array( $witryna_field, array( 'email', 'phone' ), true ) ) {
				update_user_meta( $witryna_customer_id, 'shipping_' . $witryna_field, $witryna_value );
			}
		}
	}
}

flush_rewrite_rules();
delete_transient( 'wc_term_counts' );
wc_delete_product_transients();

echo "Klinika Trawnika demo store is ready (" . count( $witryna_product_ids ) . " products).\n";
