<?php
/**
 * Demo store for the local Playground environment.
 *
 * Creates categories, products (simple and variable), reviews, blog posts,
 * pages, a navigation menu, shipping and payment methods and a sample order.
 * Run once on a fresh site: it is executed by dev/blueprint.json.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$witryna_demo_dir = __DIR__;

/**
 * Imports an image from the demo folder into the media library.
 */
function witryna_demo_image( $file, $title ) {
	static $cache = array();
	if ( isset( $cache[ $file ] ) ) {
		return $cache[ $file ];
	}
	$src = __DIR__ . '/images/' . $file;
	if ( ! file_exists( $src ) ) {
		$src = WP_CONTENT_DIR . '/themes/witryna/assets/images/' . $file;
	}
	$tmp = wp_tempnam( $file );
	copy( $src, $tmp );
	$id = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), 0, $title );
	if ( is_wp_error( $id ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		error_log( 'Witryna demo: ' . $id->get_error_message() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', $title );
	$cache[ $file ] = $id;
	return $id;
}

/* ---------------------------------------------------------------------------
 * Store settings (Poland, PLN).
 * ------------------------------------------------------------------------ */
$witryna_options = array(
	'blogname'                                 => 'Witryna',
	'blogdescription'                          => 'Ceramika i dodatki do domu',
	'woocommerce_default_country'              => 'PL:',
	'woocommerce_store_address'                => 'ul. Przykładowa 12',
	'woocommerce_store_city'                   => 'Warszawa',
	'woocommerce_store_postcode'               => '00-001',
	'woocommerce_currency'                     => 'PLN',
	'woocommerce_currency_pos'                 => 'right_space',
	'woocommerce_price_thousand_sep'           => ' ',
	'woocommerce_price_decimal_sep'            => ',',
	'woocommerce_price_num_decimals'           => 2,
	'woocommerce_weight_unit'                  => 'kg',
	'woocommerce_dimension_unit'               => 'cm',
	'woocommerce_enable_reviews'               => 'yes',
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
 * Categories.
 * ------------------------------------------------------------------------ */
$witryna_categories = array(
	'wazony'    => array( 'Wazony', 'Ręcznie toczone wazony z kamionki i porcelany – od smukłych butelek po pękate amfory.', 'category-1.jpg' ),
	'kuchnia'   => array( 'Kuchnia i stół', 'Kubki, misy, talerze i dzbanki do codziennego użytku i na wyjątkowe okazje.', 'category-3.jpg' ),
	'oswietlenie' => array( 'Oświetlenie', 'Lampy i świece, które ocieplają wnętrze w długie wieczory.', 'category-2.jpg' ),
	'dekoracje' => array( 'Dekoracje', 'Doniczki, dyfuzory i drobiazgi, które nadają wnętrzu charakter.', 'category-4.jpg' ),
);
$witryna_cat_ids = array();
foreach ( $witryna_categories as $witryna_slug => list( $witryna_name, $witryna_desc, $witryna_img ) ) {
	$witryna_term = term_exists( $witryna_slug, 'product_cat' );
	if ( ! $witryna_term ) {
		$witryna_term = wp_insert_term( $witryna_name, 'product_cat', array( 'slug' => $witryna_slug, 'description' => $witryna_desc ) );
	}
	$witryna_cat_ids[ $witryna_slug ] = (int) $witryna_term['term_id'];
	update_term_meta( $witryna_cat_ids[ $witryna_slug ], 'thumbnail_id', witryna_demo_image( $witryna_img, $witryna_name ) );
}

/* ---------------------------------------------------------------------------
 * Colour attribute for the variable product.
 * ------------------------------------------------------------------------ */
$witryna_attr_id = wc_attribute_taxonomy_id_by_name( 'pa_kolor' );
if ( ! $witryna_attr_id ) {
	$witryna_attr_id = wc_create_attribute( array( 'name' => 'Kolor', 'slug' => 'kolor', 'type' => 'select', 'order_by' => 'menu_order', 'has_archives' => false ) );
}
register_taxonomy( 'pa_kolor', array( 'product' ), array( 'hierarchical' => false, 'show_ui' => false, 'query_var' => true, 'rewrite' => false ) );
$witryna_colors = array();
foreach ( array( 'szalwia' => 'Szałwia', 'piasek' => 'Piasek', 'ocean' => 'Ocean' ) as $witryna_slug => $witryna_name ) {
	$witryna_term = term_exists( $witryna_slug, 'pa_kolor' );
	if ( ! $witryna_term ) {
		$witryna_term = wp_insert_term( $witryna_name, 'pa_kolor', array( 'slug' => $witryna_slug ) );
	}
	$witryna_colors[ $witryna_slug ] = (int) $witryna_term['term_id'];
}

/* ---------------------------------------------------------------------------
 * Products.
 * ------------------------------------------------------------------------ */
$witryna_lorem = '<p>Każdy egzemplarz powstaje ręcznie w niewielkiej pracowni, dlatego drobne różnice w kolorze szkliwa i fakturze są naturalną cechą produktu, a nie wadą.</p><p>Wykonane z wysokiej jakości kamionki wypalanej w temperaturze 1250°C. Szkliwo jest bezpieczne w kontakcie z żywnością i odporne na zarysowania.</p><h3>Pielęgnacja</h3><ul><li>Można myć w zmywarce w programie delikatnym.</li><li>Nie należy używać ostrych gąbek.</li><li>Unikaj gwałtownych zmian temperatury.</li></ul>';

$witryna_products = array(
	array( 'Wazon Amfora', 'wazony', '189', '149', 'amfora.jpg', array( 'amfora-2.jpg' ), 'Pękaty wazon z kamionki z ręcznie nakładanym, ciepłym szkliwem. Idealny na suche bukiety i gałązki.', array( 1.4, 24, 24, 30 ), 140, true, array( 'kamionka', 'bestseller' ) ),
	array( 'Wazon Smukły', 'wazony', '129', '', 'smukly.jpg', array( 'smukly-2.jpg' ), 'Wysoki wazon o kształcie butelki. Pięknie wygląda z pojedynczą gałązką lub trawą pampasową.', array( 0.9, 11, 11, 34 ), 95, true, array( 'porcelana' ) ),
	array( 'Wazon Kula', 'wazony', '159', '', 'kula.jpg', array( 'kula-2.jpg' ), 'Krągły wazon z piaskowej kamionki z charakterystycznymi drobinkami żelaza.', array( 1.6, 26, 26, 24 ), 60, false, array( 'kamionka' ) ),
	array( 'Filiżanka Espresso', 'kuchnia', '79', '', 'espresso.jpg', array(), 'Zestaw filiżanki i spodka do espresso. Grube ścianki dłużej utrzymują temperaturę kawy.', array( 0.4, 12, 12, 6 ), 70, false, array( 'kawa' ) ),
	array( 'Misa Fala', 'kuchnia', '99', '79', 'misa.jpg', array( 'misa-2.jpg' ), 'Głęboka misa z oceanicznym szkliwem – na sałatki, owoce albo poke bowl.', array( 0.8, 24, 24, 9 ), 110, true, array( 'kamionka', 'bestseller' ) ),
	array( 'Talerze Len (komplet 3 szt.)', 'kuchnia', '149', '', 'talerz.jpg', array(), 'Komplet trzech płaskich talerzy w naturalnych odcieniach lnu.', array( 2.1, 27, 27, 3 ), 45, false, array( 'komplet' ) ),
	array( 'Dzbanek Rosa', 'kuchnia', '139', '', 'dzbanek.jpg', array( 'dzbanek-2.jpg' ), 'Dzbanek o pojemności 1 litra z wygodnym uchem. Do wody, lemoniady albo kwiatów.', array( 1.1, 18, 14, 22 ), 38, false, array( 'kamionka' ) ),
	array( 'Lampa Glob', 'oswietlenie', '349', '', 'lampa.jpg', array( 'lampa-2.jpg' ), 'Lampa stołowa z kloszem z matowego szkła i mosiężną podstawą. Daje ciepłe, rozproszone światło.', array( 2.4, 25, 25, 42 ), 52, true, array( 'mosiądz' ) ),
	array( 'Świeca sojowa Bursztyn', 'oswietlenie', '69', '', 'swieca.jpg', array( 'swieca-2.jpg' ), 'Świeca z wosku sojowego o zapachu bursztynu i drzewa sandałowego. Czas palenia około 45 godzin.', array( 0.5, 9, 9, 10 ), 160, false, array( 'zapach', 'bestseller' ) ),
	array( 'Dyfuzor Cedr', 'dekoracje', '89', '', 'dyfuzor.jpg', array(), 'Dyfuzor zapachowy z nutą cedru i wetywerii w butelce z ciemnego szkła.', array( 0.6, 8, 8, 30 ), 75, false, array( 'zapach' ) ),
	array( 'Doniczka Terra', 'dekoracje', '119', '', 'doniczka.jpg', array( 'doniczka-2.jpg' ), 'Doniczka z otworem odpływowym i podstawką. Pasuje do roślin o średnicy do 18 cm.', array( 1.9, 20, 20, 17 ), 30, false, array( 'kamionka' ) ),
);

$witryna_product_ids = array();
foreach ( $witryna_products as $witryna_i => list( $witryna_name, $witryna_cat, $witryna_regular, $witryna_sale, $witryna_img, $witryna_gallery, $witryna_short, $witryna_dims, $witryna_sales, $witryna_featured, $witryna_tags ) ) {
	$witryna_product = new WC_Product_Simple();
	$witryna_product->set_name( $witryna_name );
	$witryna_product->set_status( 'publish' );
	$witryna_product->set_regular_price( $witryna_regular );
	if ( $witryna_sale ) {
		$witryna_product->set_sale_price( $witryna_sale );
	}
	$witryna_product->set_short_description( $witryna_short );
	$witryna_product->set_description( $witryna_lorem );
	$witryna_product->set_category_ids( array( $witryna_cat_ids[ $witryna_cat ] ) );
	$witryna_product->set_image_id( witryna_demo_image( $witryna_img, $witryna_name ) );
	$witryna_product->set_gallery_image_ids( array_map( static fn( $f ) => witryna_demo_image( $f, $witryna_name ), $witryna_gallery ) );
	$witryna_product->set_weight( (string) $witryna_dims[0] );
	$witryna_product->set_length( (string) $witryna_dims[1] );
	$witryna_product->set_width( (string) $witryna_dims[2] );
	$witryna_product->set_height( (string) $witryna_dims[3] );
	$witryna_product->set_sku( 'WIT-' . str_pad( (string) ( $witryna_i + 1 ), 3, '0', STR_PAD_LEFT ) );
	$witryna_product->set_featured( $witryna_featured );
	$witryna_product->set_manage_stock( true );
	$witryna_product->set_stock_quantity( 'Dyfuzor Cedr' === $witryna_name ? 0 : 5 + $witryna_i * 3 );
	$witryna_product->set_stock_status( 'Dyfuzor Cedr' === $witryna_name ? 'outofstock' : 'instock' );
	$witryna_product->set_date_created( time() - ( count( $witryna_products ) - $witryna_i ) * DAY_IN_SECONDS );
	$witryna_product->save();
	wp_set_object_terms( $witryna_product->get_id(), $witryna_tags, 'product_tag' );
	update_post_meta( $witryna_product->get_id(), 'total_sales', $witryna_sales );
	$witryna_product_ids[ $witryna_name ] = $witryna_product->get_id();
}

// Variable product: mug in three colours.
$witryna_attribute = new WC_Product_Attribute();
$witryna_attribute->set_id( $witryna_attr_id );
$witryna_attribute->set_name( 'pa_kolor' );
$witryna_attribute->set_options( array_values( $witryna_colors ) );
$witryna_attribute->set_visible( true );
$witryna_attribute->set_variation( true );

$witryna_mug = new WC_Product_Variable();
$witryna_mug->set_name( 'Kubek Poranek' );
$witryna_mug->set_status( 'publish' );
$witryna_mug->set_short_description( 'Kubek o pojemności 350 ml z wygodnym uchem i dwukolorowym szkliwem. Wybierz swój ulubiony kolor.' );
$witryna_mug->set_description( $witryna_lorem );
$witryna_mug->set_category_ids( array( $witryna_cat_ids['kuchnia'] ) );
$witryna_mug->set_attributes( array( $witryna_attribute ) );
$witryna_mug->set_image_id( witryna_demo_image( 'kubek-szalwia.jpg', 'Kubek Poranek' ) );
$witryna_mug->set_gallery_image_ids( array( witryna_demo_image( 'kubek-zestaw.jpg', 'Kubek Poranek – zestaw' ), witryna_demo_image( 'kubek-piasek.jpg', 'Kubek Poranek' ), witryna_demo_image( 'kubek-ocean.jpg', 'Kubek Poranek' ) ) );
$witryna_mug->set_weight( '0.45' );
$witryna_mug->set_length( '12' );
$witryna_mug->set_width( '9' );
$witryna_mug->set_height( '10' );
$witryna_mug->set_sku( 'WIT-KUB' );
$witryna_mug->set_featured( true );
$witryna_mug->set_date_created( time() );
$witryna_mug->save();
wp_set_object_terms( $witryna_mug->get_id(), array( 'kamionka', 'bestseller', 'kawa' ), 'product_tag' );
update_post_meta( $witryna_mug->get_id(), 'total_sales', 210 );

foreach ( array( 'szalwia' => array( '59', '49', 'kubek-szalwia.jpg' ), 'piasek' => array( '59', '', 'kubek-piasek.jpg' ), 'ocean' => array( '59', '', 'kubek-ocean.jpg' ) ) as $witryna_slug => list( $witryna_regular, $witryna_sale, $witryna_img ) ) {
	$witryna_variation = new WC_Product_Variation();
	$witryna_variation->set_parent_id( $witryna_mug->get_id() );
	$witryna_variation->set_attributes( array( 'pa_kolor' => $witryna_slug ) );
	$witryna_variation->set_regular_price( $witryna_regular );
	if ( $witryna_sale ) {
		$witryna_variation->set_sale_price( $witryna_sale );
	}
	$witryna_variation->set_image_id( witryna_demo_image( $witryna_img, 'Kubek Poranek' ) );
	$witryna_variation->set_manage_stock( true );
	$witryna_variation->set_stock_quantity( 'ocean' === $witryna_slug ? 2 : 15 );
	$witryna_variation->set_sku( 'WIT-KUB-' . strtoupper( substr( $witryna_slug, 0, 3 ) ) );
	$witryna_variation->save();
}
WC_Product_Variable::sync( $witryna_mug->get_id() );
$witryna_product_ids['Kubek Poranek'] = $witryna_mug->get_id();

// Related products and upsells.
update_post_meta( $witryna_product_ids['Wazon Amfora'], '_upsell_ids', array( $witryna_product_ids['Wazon Kula'], $witryna_product_ids['Wazon Smukły'] ) );

/* ---------------------------------------------------------------------------
 * Reviews.
 * ------------------------------------------------------------------------ */
$witryna_reviews = array(
	array( 'Kubek Poranek', 'Anna', 5, 'Piękny kolor szkliwa i idealna pojemność na poranną kawę. Kupiłam drugi w prezencie.' ),
	array( 'Kubek Poranek', 'Tomek', 5, 'Solidny, dobrze leży w dłoni. Przesyłka dotarła następnego dnia.' ),
	array( 'Kubek Poranek', 'Marta', 4, 'Bardzo ładny, choć kolor na żywo jest odrobinę ciemniejszy niż na zdjęciu.' ),
	array( 'Wazon Amfora', 'Kasia', 5, 'Wazon robi ogromne wrażenie. Starannie zapakowany, bez najmniejszej rysy.' ),
	array( 'Wazon Amfora', 'Piotr', 5, 'Kupiony na prezent – obdarowana zachwycona. Polecam!' ),
	array( 'Lampa Glob', 'Ola', 5, 'Daje bardzo przyjemne, ciepłe światło. Mosiężna podstawa wygląda luksusowo.' ),
	array( 'Misa Fala', 'Michał', 4, 'Świetna na sałatki. Szkliwo ma piękną głębię.' ),
	array( 'Świeca sojowa Bursztyn', 'Ewa', 5, 'Zapach jest subtelny i otulający, świeca pali się równo.' ),
);
foreach ( $witryna_reviews as $witryna_i => list( $witryna_product_name, $witryna_author, $witryna_rating, $witryna_text ) ) {
	$witryna_comment = wp_insert_comment(
		array(
			'comment_post_ID'      => $witryna_product_ids[ $witryna_product_name ],
			'comment_author'       => $witryna_author,
			'comment_author_email' => sanitize_title( $witryna_author ) . '@example.com',
			'comment_content'      => $witryna_text,
			'comment_type'         => 'review',
			'comment_approved'     => 1,
			'comment_date'         => gmdate( 'Y-m-d H:i:s', time() - ( $witryna_i + 1 ) * 3 * DAY_IN_SECONDS ),
		)
	);
	update_comment_meta( $witryna_comment, 'rating', $witryna_rating );
	update_comment_meta( $witryna_comment, 'verified', 1 );
}
foreach ( array_unique( array_column( $witryna_reviews, 0 ) ) as $witryna_product_name ) {
	$witryna_product = wc_get_product( $witryna_product_ids[ $witryna_product_name ] );
	$witryna_product->set_rating_counts( WC_Comments::get_rating_counts_for_product( $witryna_product ) );
	$witryna_product->set_average_rating( WC_Comments::get_average_rating_for_product( $witryna_product ) );
	$witryna_product->set_review_count( WC_Comments::get_review_count_for_product( $witryna_product ) );
	$witryna_product->save();
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
$witryna_about = witryna_demo_page( 'O nas', 'o-nas', '<!-- wp:pattern {"slug":"witryna/page-about"} /-->', 'page-no-title' );
$witryna_contact = witryna_demo_page( 'Kontakt', 'kontakt', '<!-- wp:pattern {"slug":"witryna/page-contact"} /-->', 'page-no-title' );
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
	array( 'Jak dobrać wazon do bukietu', 'Inspiracje', 'hero.jpg', 'Proporcje, kolory i kilka prostych zasad, dzięki którym każdy bukiet będzie wyglądał jak z kwiaciarni.' ),
	array( 'Kamionka czy porcelana? Krótki przewodnik', 'Poradniki', 'story.jpg', 'Wyjaśniamy różnice między materiałami ceramicznymi i podpowiadamy, co sprawdzi się w Twojej kuchni.' ),
	array( 'Jesienne nakrycie stołu w pięciu krokach', 'Inspiracje', 'promo.jpg', 'Ciepłe barwy, naturalne tkaniny i ceramika z charakterem – tak przygotujesz stół na długie wieczory.' ),
);
foreach ( $witryna_posts as $witryna_i => list( $witryna_title, $witryna_category, $witryna_img, $witryna_excerpt ) ) {
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
			'post_content'  => '<!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">' . $witryna_excerpt . '</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Ceramika to materiał, który z czasem nabiera charakteru. Dobrze dobrana potrafi zmienić wnętrze bardziej niż nowe meble – wystarczy kilka przemyślanych przedmiotów.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Zacznij od światła</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ustaw przedmioty tam, gdzie pada dzienne światło. Szkliwo pięknie odbija promienie słońca, a matowe powierzchnie podkreślą fakturę gliny.</p><!-- /wp:paragraph --><!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>Najpiękniejsze wnętrza powstają powoli, z przedmiotów, które naprawdę lubimy.</p><!-- /wp:paragraph --><cite>Zespół Witryny</cite></blockquote><!-- /wp:quote --><!-- wp:paragraph --><p>Nie bój się łączyć różnych kolorów i wysokości. Grupy nieparzystej liczby przedmiotów wyglądają naturalnie i swobodnie.</p><!-- /wp:paragraph -->',
		)
	);
	set_post_thumbnail( $witryna_post, witryna_demo_image( $witryna_img, $witryna_title ) );
}

/* ---------------------------------------------------------------------------
 * Navigation menu.
 * ------------------------------------------------------------------------ */
$witryna_shop_url = get_permalink( wc_get_page_id( 'shop' ) );
$witryna_links    = '';
foreach ( $witryna_cat_ids as $witryna_slug => $witryna_id ) {
	$witryna_links .= sprintf( '<!-- wp:navigation-link {"label":"%s","type":"product_cat","id":%d,"url":"%s","kind":"taxonomy"} /-->', esc_attr( $witryna_categories[ $witryna_slug ][0] ), $witryna_id, esc_url( get_term_link( $witryna_id, 'product_cat' ) ) );
}
$witryna_menu = sprintf(
	'<!-- wp:navigation-submenu {"label":"Sklep","url":"%1$s","kind":"custom"} -->%2$s<!-- /wp:navigation-submenu --><!-- wp:navigation-link {"label":"Nowości","url":"%3$s","kind":"custom"} /--><!-- wp:navigation-link {"label":"Blog","type":"page","id":%4$d,"url":"%5$s","kind":"post-type"} /--><!-- wp:navigation-link {"label":"O nas","type":"page","id":%6$d,"url":"%7$s","kind":"post-type"} /--><!-- wp:navigation-link {"label":"Kontakt","type":"page","id":%8$d,"url":"%9$s","kind":"post-type"} /-->',
	esc_url( $witryna_shop_url ),
	$witryna_links,
	esc_url( add_query_arg( 'orderby', 'date', $witryna_shop_url ) ),
	$witryna_blog,
	esc_url( get_permalink( $witryna_blog ) ),
	$witryna_about,
	esc_url( get_permalink( $witryna_about ) ),
	$witryna_contact,
	esc_url( get_permalink( $witryna_contact ) )
);
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
update_option( 'woocommerce_local_pickup_' . $witryna_pickup . '_settings', array( 'title' => 'Odbiór w salonie', 'cost' => '0' ) );

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
		$witryna_order->add_product( wc_get_product( $witryna_product_ids['Wazon Amfora'] ), 1 );
		$witryna_order->add_product( wc_get_product( $witryna_product_ids['Świeca sojowa Bursztyn'] ), 2 );
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

echo "Witryna demo store is ready.\n";
