<?php
/**
 * "Ustaw sklep": makes a live shop look like the local preview.
 *
 * Pages, the main menu, the reading settings, titles and a few store options
 * are defined here once. They are used by the admin screen
 * (Wygląd → Ustaw sklep) and by dev/demo/setup.php, so the preview and the
 * live shop cannot drift apart. Products, categories, payments and shipping
 * are never touched, and every step can safely run more than once.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/* ---------------------------------------------------------------------------
 * Definitions shared with dev/demo/setup.php.
 * ------------------------------------------------------------------------ */

/**
 * Returns the pages of the store, in the order they are created.
 *
 * The titles and contents are site content, so they stay in Polish whatever
 * the language of the dashboard is.
 *
 * @return array<string, array{title: string, content: string}> Slug => page.
 */
function witryna_setup_pages() {
	return array(
		'strona-glowna' => array(
			'title'   => 'Strona główna',
			'content' => '',
		),
		'blog'          => array(
			'title'   => 'Blog',
			'content' => '',
		),
		// These slugs have their own templates (templates/page-<slug>.html).
		'serwis'        => array(
			'title'   => 'Serwis',
			'content' => '',
		),
		'opinie'        => array(
			'title'   => 'Opinie',
			'content' => '',
		),
		'social-media'  => array(
			'title'   => 'Social media',
			'content' => '',
		),
		'o-firmie'      => array(
			'title'   => 'O firmie',
			'content' => '',
		),
		'kontakt'       => array(
			'title'   => 'Kontakt',
			'content' => '',
		),
		'regulamin'     => array(
			'title'   => 'Regulamin',
			'content' => '<!-- wp:paragraph --><p>Tu znajdzie się regulamin sklepu internetowego.</p><!-- /wp:paragraph -->',
		),
	);
}

/**
 * Returns the slugs of pages that get a ready-made layout from the theme.
 *
 * @return string[]
 */
function witryna_setup_template_pages() {
	return array( 'serwis', 'kontakt', 'opinie', 'social-media', 'o-firmie' );
}

/**
 * Returns the site and store options of the preview, grouped by step.
 *
 * @return array<string, array<string, string>> Step => option name => value.
 */
function witryna_setup_site_options() {
	return array(
		'identity' => array(
			'blogname'        => 'Klinika Trawnika',
			'blogdescription' => 'Autoryzowany dealer STIHL – sklep i serwis',
		),
		'address'  => array(
			'woocommerce_store_address'   => 'ul. Miła 1',
			'woocommerce_store_city'      => 'Czernica',
			'woocommerce_store_postcode'  => '55-003',
			'woocommerce_default_country' => 'PL:',
		),
		'reviews'  => array(
			'woocommerce_enable_reviews'                      => 'yes',
			'woocommerce_review_rating_verification_required' => 'yes',
			'woocommerce_review_rating_verification_label'    => 'yes',
			'woocommerce_enable_review_rating'                => 'yes',
		),
	);
}

/**
 * Returns the titles of the WooCommerce pages.
 *
 * @return array<string, string> WooCommerce page key => title.
 */
function witryna_setup_wc_page_titles() {
	return array(
		'shop'      => 'Sklep',
		'cart'      => 'Koszyk',
		'checkout'  => 'Zamówienie',
		'myaccount' => 'Moje konto',
	);
}

/**
 * Returns the title of the main menu.
 *
 * @return string
 */
function witryna_setup_menu_title() {
	return 'Menu główne';
}

/**
 * Returns the guides published on the blog of the preview.
 *
 * @return array<int, array{title: string, category: string, product_cat: string, excerpt: string, content: string}>
 */
function witryna_setup_blog_posts() {
	return array(
		array(
			'title'       => 'Przegląd kosiarki przed sezonem: co sprawdzić',
			'category'    => 'Poradniki',
			'product_cat' => 'Kosiarki',
			'excerpt'     => 'Kilka prostych czynności, dzięki którym kosiarka odpali bez problemu i równo skosi trawnik przez cały sezon.',
			'content'     => '<!-- wp:paragraph --><p>Zanim pierwszy raz w sezonie wyjedziesz kosiarką na trawnik, warto poświęcić jej pół godziny. Większość usterek, z którymi kosiarki trafiają do serwisu wiosną, wynika z zaniedbań po zimie.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Kosiarka spalinowa</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Wymień olej silnikowy i sprawdź jego poziom na płaskim podłożu.</li><li>Oczyść lub wymień filtr powietrza.</li><li>Sprawdź świecę zapłonową.</li><li>Zatankuj świeże paliwo. Stara benzyna to najczęstsza przyczyna problemów z rozruchem.</li></ul><!-- /wp:list --><!-- wp:heading --><h2 class="wp-block-heading">Każda kosiarka</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Naostrz albo wymień nóż. Tępy nóż szarpie trawę i zostawia brązowe końcówki.</li><li>Oczyść obudowę od spodu z zaschniętej trawy.</li><li>Sprawdź kosz, koła i linkę hamulca noża.</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Nie masz czasu albo narzędzi? Przegląd sezonowy zrobimy w naszym serwisie w Czernicy.</p><!-- /wp:paragraph -->',
		),
		array(
			'title'       => 'Jak dobrać pilarkę do swoich potrzeb',
			'category'    => 'Poradniki',
			'product_cat' => 'Pilarki',
			'excerpt'     => 'Akumulatorowa czy spalinowa, jaka prowadnica i moc? Podpowiadamy, na co zwrócić uwagę przy wyborze pilarki.',
			'content'     => '<!-- wp:paragraph --><p>Dobra pilarka to taka, która pasuje do pracy, jaką chcesz wykonać. Do przycinania gałęzi w ogrodzie potrzebujesz innego sprzętu niż do cięcia drewna na opał.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Akumulatorowa</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Cicha, lekka i gotowa do pracy po naciśnięciu przycisku. Sprawdzi się przy przycinaniu drzew i krzewów, pracach przy domu i w miejscach, gdzie liczy się niski hałas.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Spalinowa</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Więcej mocy i dowolnie długa praca. To dobry wybór do cięcia drewna opałowego, ścinania drzew i prac na działce bez dostępu do prądu.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Długość prowadnicy</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Prowadnica powinna być dłuższa niż średnica drewna, które najczęściej tniesz. Do ogrodu zwykle wystarczy 30–35 cm, do drewna opałowego 35–40 cm.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Przyjedź do sklepu, a pomożemy dobrać model i pokażemy, jak bezpiecznie z niego korzystać.</p><!-- /wp:paragraph -->',
		),
		array(
			'title'       => 'Robot koszący iMOW: na jaki trawnik?',
			'category'    => 'Poradniki',
			'product_cat' => 'Roboty koszące',
			'excerpt'     => 'Sprawdź, czy Twój ogród nadaje się dla robota koszącego i jak dobrać model do powierzchni trawnika.',
			'content'     => '<!-- wp:paragraph --><p>Robot koszący kosi codziennie po trochu, więc trawnik jest gęsty i zawsze równo przycięty, a Ty nie musisz o tym myśleć.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Powierzchnia i nachylenie</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Każdy model iMOW ma podaną maksymalną powierzchnię trawnika i nachylenie terenu. Wybierz model z zapasem, jeśli ogród ma dużo zakamarków albo wąskich przejść.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Przygotowanie ogrodu</h2><!-- /wp:heading --><!-- wp:list --><ul class="wp-block-list"><li>Zaplanuj miejsce na stację dokującą z dostępem do prądu.</li><li>Usuń z trawnika kamienie, gałęzie i zabawki.</li><li>Zastanów się, gdzie robot ma nie wjeżdżać: rabaty, oczko wodne, warzywnik.</li></ul><!-- /wp:list --><!-- wp:paragraph --><p>Pomagamy dobrać robota do ogrodu i zajmujemy się jego montażem.</p><!-- /wp:paragraph -->',
		),
	);
}

/**
 * Returns the default WordPress posts and pages that can be moved to the trash.
 *
 * @return array<string, string[]> Post type => titles (Polish and English installs).
 */
function witryna_setup_sample_titles() {
	return array(
		'post' => array( 'Witaj, świecie!', 'Hello world!' ),
		'page' => array( 'Przykładowa strona', 'Sample Page' ),
	);
}

/* ---------------------------------------------------------------------------
 * Current state.
 * ------------------------------------------------------------------------ */

/**
 * Returns the statuses of pages that exist and are not in the trash.
 *
 * @return string[]
 */
function witryna_setup_live_statuses() {
	return array( 'publish', 'future', 'draft', 'pending', 'private' );
}

/**
 * Finds a page by its slug, at any level of the page tree.
 *
 * Published pages win over drafts with the same slug.
 *
 * @param string   $slug     Page slug.
 * @param string[] $statuses Statuses to look in.
 * @return WP_Post|null
 */
function witryna_setup_find_page( $slug, $statuses = null ) {
	$statuses = null === $statuses ? witryna_setup_live_statuses() : $statuses;

	foreach ( array( array( 'publish' ), array_diff( $statuses, array( 'publish' ) ) ) as $group ) {
		$group = array_values( array_intersect( $statuses, $group ) );
		if ( ! $group ) {
			continue;
		}
		$pages = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => $group,
				'name'           => $slug,
				'posts_per_page' => 1,
				'orderby'        => 'ID',
				'order'          => 'ASC',
				'no_found_rows'  => true,
			)
		);
		if ( $pages ) {
			return $pages[0];
		}
	}

	return null;
}

/**
 * Finds a page with the given slug in the trash.
 *
 * WordPress adds "__trashed" to the slug of a trashed page.
 *
 * @param string $slug Page slug.
 * @return WP_Post|null
 */
function witryna_setup_find_trashed_page( $slug ) {
	$pages = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'trash',
			'post_name__in'  => array( $slug . '__trashed', $slug ),
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		)
	);

	return $pages ? $pages[0] : null;
}

/**
 * Returns what exists at the address of a store page.
 *
 * @param string $slug Page slug.
 * @return array{state: string, page: WP_Post|null} State is "exists",
 *               "unpublished", "trash", "taken" or "missing".
 */
function witryna_setup_page_state( $slug ) {
	$page = witryna_setup_find_page( $slug );
	if ( $page ) {
		return array(
			'state' => 'publish' === $page->post_status ? 'exists' : 'unpublished',
			'page'  => $page,
		);
	}

	// A draft gets its slug only when it is published, so a draft with the
	// title of the page will get this address.
	$pages = witryna_setup_pages();
	if ( isset( $pages[ $slug ] ) ) {
		foreach ( witryna_setup_find_by_title( $pages[ $slug ]['title'], 'page', array( 'draft', 'pending' ) ) as $draft ) {
			if ( '' === $draft->post_name ) {
				return array(
					'state' => 'unpublished',
					'page'  => $draft,
				);
			}
		}
	}

	$page = witryna_setup_find_trashed_page( $slug );
	if ( $page ) {
		return array(
			'state' => 'trash',
			'page'  => $page,
		);
	}

	// Another item (e.g. a media file) would push the new page to "slug-2".
	if ( wp_unique_post_slug( $slug, 0, 'publish', 'page', 0 ) !== $slug ) {
		return array(
			'state' => 'taken',
			'page'  => null,
		);
	}

	return array(
		'state' => 'missing',
		'page'  => null,
	);
}

/**
 * Returns the IDs of the published store pages.
 *
 * @return array<string, int> Slug => page ID.
 */
function witryna_setup_page_ids() {
	$ids = array();

	foreach ( array_keys( witryna_setup_pages() ) as $slug ) {
		$page = witryna_setup_find_page( $slug, array( 'publish' ) );
		if ( $page ) {
			$ids[ $slug ] = (int) $page->ID;
		}
	}

	return $ids;
}

/**
 * Returns a page or post with the given title.
 *
 * @param string   $title     Exact title.
 * @param string   $post_type Post type.
 * @param string[] $statuses  Statuses to look in.
 * @return WP_Post[]
 */
function witryna_setup_find_by_title( $title, $post_type, $statuses ) {
	return get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => $statuses,
			'title'          => $title,
			'posts_per_page' => 5,
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
}

/**
 * Tells whether the permalinks are set to "Plain" (?page_id=12).
 *
 * @return bool
 */
function witryna_setup_plain_permalinks() {
	return '' === (string) get_option( 'permalink_structure' );
}

/**
 * Returns the address of a page relative to the site, e.g. "/serwis/".
 *
 * With plain permalinks a page has no such address, so the address that
 * finds the page by its slug is returned instead.
 *
 * @param string $slug Page slug.
 * @return string
 */
function witryna_setup_page_path( $slug ) {
	if ( witryna_setup_plain_permalinks() ) {
		return '/?pagename=' . $slug;
	}

	return user_trailingslashit( '/' . $slug, 'page' );
}

/**
 * Returns the address of a post relative to the site.
 *
 * @param WP_Post $post Post.
 * @return string
 */
function witryna_setup_post_path( $post ) {
	$link = (string) get_permalink( $post );
	$home = untrailingslashit( home_url() );

	return 0 === strpos( $link, $home ) ? substr( $link, strlen( $home ) ) : $link;
}

/**
 * Returns the published navigation menus, newest first.
 *
 * The header shows the newest one, because its Navigation block has no menu
 * selected.
 *
 * @return WP_Post[]
 */
function witryna_setup_navigations() {
	return get_posts(
		array(
			'post_type'      => 'wp_navigation',
			'post_status'    => 'publish',
			'posts_per_page' => 50,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'no_found_rows'  => true,
		)
	);
}

/**
 * Tells whether a menu is the automatic list of all pages.
 *
 * WordPress creates such a menu ("Nawigacja") by itself the first time the
 * header is shown without any menu, so it does not count as the owner's menu.
 *
 * @param WP_Post $menu Navigation menu.
 * @return bool
 */
function witryna_setup_is_auto_menu( $menu ) {
	$blocks = array_values(
		array_filter(
			parse_blocks( $menu->post_content ),
			static function ( $block ) {
				return ! empty( $block['blockName'] );
			}
		)
	);

	return ! $blocks || ( 1 === count( $blocks ) && 'core/page-list' === $blocks[0]['blockName'] && empty( $blocks[0]['innerBlocks'] ) );
}

/**
 * Returns the menus made by people (not the automatic list of pages).
 *
 * @return WP_Post[]
 */
function witryna_setup_own_menus() {
	return array_values(
		array_filter(
			witryna_setup_navigations(),
			static function ( $menu ) {
				return ! witryna_setup_is_auto_menu( $menu );
			}
		)
	);
}

/**
 * Returns the menu chosen in the header or mobile menu in the Site Editor.
 *
 * The theme's header shows the newest menu. When someone picked a menu in
 * the Site Editor, that menu is shown instead, also after a new one is added.
 *
 * @return int Navigation post ID, 0 when the header shows the newest menu.
 */
function witryna_setup_header_menu_ref() {
	foreach ( array( 'header', 'mobile-menu' ) as $part ) {
		$template = get_block_template( get_stylesheet() . '//' . $part, 'wp_template_part' );
		if ( ! $template || 'custom' !== $template->source ) {
			continue;
		}
		$ref = witryna_setup_find_navigation_ref( parse_blocks( $template->content ) );
		if ( $ref ) {
			return $ref;
		}
	}

	return 0;
}

/**
 * Returns the first menu selected in a Navigation block.
 *
 * @param array[] $blocks Parsed blocks.
 * @return int
 */
function witryna_setup_find_navigation_ref( $blocks ) {
	foreach ( $blocks as $block ) {
		if ( 'core/navigation' === $block['blockName'] && ! empty( $block['attrs']['ref'] ) ) {
			return (int) $block['attrs']['ref'];
		}
		if ( ! empty( $block['innerBlocks'] ) ) {
			$ref = witryna_setup_find_navigation_ref( $block['innerBlocks'] );
			if ( $ref ) {
				return $ref;
			}
		}
	}

	return 0;
}

/**
 * Returns the top-level product categories that have products, by name.
 *
 * The default category ("Bez kategorii") is left out. The order is
 * alphabetical: sorting by the drag-and-drop order of WooCommerce needs an
 * "order" value that categories created by an import may not have.
 * dev/demo/setup.php passes the order of its catalog instead.
 *
 * @param int[] $order Optional category IDs in the wanted order. Categories
 *                     not listed follow, by name.
 * @return WP_Term[]
 */
function witryna_setup_menu_categories( $order = array() ) {
	if ( ! taxonomy_exists( 'product_cat' ) ) {
		return array();
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'parent'     => 0,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'exclude'    => array( (int) get_option( 'default_product_cat', 0 ) ),
		)
	);

	if ( is_wp_error( $terms ) ) {
		return array();
	}

	$by_id = array();
	foreach ( $terms as $term ) {
		if ( ! in_array( $term->slug, array( 'uncategorized', 'bez-kategorii' ), true ) && witryna_setup_category_has_products( $term ) ) {
			$by_id[ (int) $term->term_id ] = $term;
		}
	}

	$sorted = array();
	foreach ( array_map( 'intval', (array) $order ) as $id ) {
		if ( isset( $by_id[ $id ] ) ) {
			$sorted[] = $by_id[ $id ];
			unset( $by_id[ $id ] );
		}
	}

	return array_merge( $sorted, array_values( $by_id ) );
}

/**
 * Tells whether a product category or one of its subcategories has a published product.
 *
 * Term counts are not trusted: imports may switch recounting off.
 *
 * @param WP_Term $term Product category.
 * @return bool
 */
function witryna_setup_category_has_products( $term ) {
	$products = get_posts(
		array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'fields'         => 'ids',
			'posts_per_page' => 1,
			'no_found_rows'  => true,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy'         => 'product_cat',
					'field'            => 'term_id',
					'terms'            => (int) $term->term_id,
					'include_children' => true,
				),
			),
		)
	);

	return ! empty( $products );
}

/**
 * Returns the ID of the published WooCommerce shop page.
 *
 * @return int 0 when WooCommerce is off or the shop page is not published.
 */
function witryna_setup_shop_page_id() {
	$shop_id = function_exists( 'wc_get_page_id' ) ? (int) wc_get_page_id( 'shop' ) : 0;

	return $shop_id > 0 && 'publish' === get_post_status( $shop_id ) ? $shop_id : 0;
}

/**
 * Returns the block markup of the main menu, the same as in the preview.
 *
 * "Sklep" opens a submenu with the top-level product categories, followed by
 * the pages with their own layout. Pages that do not exist are left out.
 * Block attributes are encoded by get_comment_delimited_block_content()
 * (wp_json_encode), so quotes or ampersands in names cannot break the markup.
 *
 * @param array<string, int> $page_ids       Slug => page ID, see witryna_setup_page_ids().
 * @param int[]              $category_order Optional order of the categories, see witryna_setup_menu_categories().
 * @return string
 */
function witryna_setup_menu_markup( $page_ids, $category_order = array() ) {
	$markup  = '';
	$shop_id = witryna_setup_shop_page_id();

	if ( $shop_id ) {
		$links = '';
		foreach ( witryna_setup_menu_categories( $category_order ) as $term ) {
			$url = get_term_link( $term );
			if ( is_wp_error( $url ) ) {
				continue;
			}
			$links .= get_comment_delimited_block_content(
				'core/navigation-link',
				array(
					'label' => esc_html( $term->name ),
					'type'  => 'product_cat',
					'id'    => (int) $term->term_id,
					'url'   => esc_url_raw( $url ),
					'kind'  => 'taxonomy',
				),
				''
			);
		}
		$markup .= get_comment_delimited_block_content(
			'core/navigation-submenu',
			array(
				'label' => 'Sklep',
				'url'   => esc_url_raw( get_permalink( $shop_id ) ),
				'kind'  => 'custom',
			),
			$links
		);
	}

	$pages = witryna_setup_pages();
	foreach ( array( 'serwis', 'opinie', 'social-media', 'o-firmie', 'kontakt' ) as $slug ) {
		if ( empty( $page_ids[ $slug ] ) ) {
			continue;
		}
		$markup .= get_comment_delimited_block_content(
			'core/navigation-link',
			array(
				'label' => esc_html( $pages[ $slug ]['title'] ),
				'type'  => 'page',
				'id'    => (int) $page_ids[ $slug ],
				'url'   => esc_url_raw( get_permalink( $page_ids[ $slug ] ) ),
				'kind'  => 'post-type',
			),
			''
		);
	}

	return $markup;
}

/**
 * Returns the published menu called "Menu główne", if there is one.
 *
 * The menu is found by its name, not by its content: the owner may have
 * edited it since, and it must never be created twice.
 *
 * @return WP_Post|null
 */
function witryna_setup_find_menu() {
	foreach ( witryna_setup_navigations() as $menu ) {
		if ( witryna_setup_menu_title() === $menu->post_title ) {
			return $menu;
		}
	}

	return null;
}

/**
 * Tells whether an option already has the value of the preview.
 *
 * For the country only the country is compared, so "PL" or a chosen region
 * is kept.
 *
 * @param string $name  Option name.
 * @param string $value Value of the preview.
 * @return bool
 */
function witryna_setup_option_matches( $name, $value ) {
	$current = (string) get_option( $name, '' );

	if ( 'woocommerce_default_country' === $name ) {
		return explode( ':', $current )[0] === explode( ':', $value )[0];
	}

	return $current === (string) $value;
}

/**
 * Returns the IDs of pages that must never be moved to the trash.
 *
 * @return int[]
 */
function witryna_setup_protected_ids() {
	$ids = array(
		(int) get_option( 'page_on_front' ),
		(int) get_option( 'page_for_posts' ),
		(int) get_option( 'wp_page_for_privacy_policy' ),
	);

	if ( function_exists( 'wc_get_page_id' ) ) {
		foreach ( array( 'shop', 'cart', 'checkout', 'myaccount', 'terms' ) as $key ) {
			$ids[] = (int) wc_get_page_id( $key );
		}
	}

	return array_filter( $ids );
}

/**
 * Returns the default WordPress post and page that still exist.
 *
 * @return WP_Post[]
 */
function witryna_setup_sample_content() {
	$found     = array();
	$protected = witryna_setup_protected_ids();

	foreach ( witryna_setup_sample_titles() as $post_type => $titles ) {
		foreach ( $titles as $title ) {
			foreach ( witryna_setup_find_by_title( $title, $post_type, witryna_setup_live_statuses() ) as $post ) {
				if ( ! in_array( (int) $post->ID, $protected, true ) ) {
					$found[ $post->ID ] = $post;
				}
			}
		}
	}

	return array_values( $found );
}

/**
 * Returns the guides that are already on the blog (also drafts and trash).
 *
 * @return array<string, WP_Post> Title => post.
 */
function witryna_setup_existing_blog_posts() {
	$existing = array();
	$statuses = array_merge( witryna_setup_live_statuses(), array( 'trash' ) );

	foreach ( witryna_setup_blog_posts() as $post ) {
		$found = witryna_setup_find_by_title( $post['title'], 'post', $statuses );
		if ( $found ) {
			$existing[ $post['title'] ] = $found[0];
		}
	}

	return $existing;
}

/* ---------------------------------------------------------------------------
 * Steps. Each one checks the current state first, so running it again
 * changes nothing.
 * ------------------------------------------------------------------------ */

/**
 * Returns the result of a step.
 *
 * @param string $step    Step ID, e.g. "page-serwis" or "menu", so callers
 *                        (WP-CLI, tests) can tell the results apart.
 * @param string $status  "created", "updated", "skipped" or "error".
 * @param string $message Plain text message.
 * @param array  $links   Links, each array{url: string, label: string}.
 * @return array
 */
function witryna_setup_result( $step, $status, $message, $links = array() ) {
	return array(
		'step'    => $step,
		'status'  => $status,
		'message' => $message,
		'links'   => array_values(
			array_filter(
				$links,
				static function ( $link ) {
					return ! empty( $link['url'] );
				}
			)
		),
	);
}

/**
 * Returns the name of a step as shown on the admin screen.
 *
 * @param string $step Step ID, see witryna_setup_step_order().
 * @return string
 */
function witryna_setup_step_label( $step ) {
	$labels = array(
		'front_page'     => __( 'Strona główna i blog', 'witryna' ),
		'wc_titles'      => __( 'Tytuły stron sklepu', 'witryna' ),
		'identity'       => __( 'Nazwa i opis witryny', 'witryna' ),
		'address'        => __( 'Adres sklepu', 'witryna' ),
		'reviews'        => __( 'Opinie tylko od zweryfikowanych klientów', 'witryna' ),
		'menu'           => __( 'Menu główne', 'witryna' ),
		'guides'         => __( 'Poradniki z podglądu na blogu', 'witryna' ),
		'sample_content' => __( 'Przykładowe treści WordPressa', 'witryna' ),
	);

	return isset( $labels[ $step ] ) ? $labels[ $step ] : $step;
}

/**
 * Returns the result of a WooCommerce step skipped because WooCommerce is off.
 *
 * @param string $step Step ID.
 * @return array
 */
function witryna_setup_no_wc_result( $step ) {
	/* translators: %s: name of the step, e.g. Adres sklepu. */
	return witryna_setup_result( $step, 'skipped', sprintf( __( '%s – pominięto, bo wtyczka WooCommerce nie jest włączona.', 'witryna' ), witryna_setup_step_label( $step ) ) );
}

/**
 * Returns the "view" and "edit" links of a post.
 *
 * @param int|WP_Post $post Post.
 * @return array
 */
function witryna_setup_post_links( $post ) {
	$post  = get_post( $post );
	$links = array();

	if ( ! $post ) {
		return $links;
	}

	if ( 'publish' === $post->post_status ) {
		$links[] = array(
			'url'   => get_permalink( $post ),
			'label' => __( 'Zobacz', 'witryna' ),
		);
	}
	$links[] = array(
		'url'   => get_edit_post_link( $post, 'raw' ),
		'label' => __( 'Edytuj', 'witryna' ),
	);

	return $links;
}

/**
 * Creates a store page unless a page with its slug already exists.
 *
 * A page in the trash is not created again (it would get the address
 * "slug-2"); it should be restored instead.
 *
 * @param string $slug   Page slug.
 * @param string $status "publish", or "draft" for a page the owner has to
 *                       fill in before customers see it.
 * @return array Result.
 */
function witryna_setup_apply_page( $slug, $status = 'publish' ) {
	$pages = witryna_setup_pages();
	$step  = 'page-' . $slug;

	if ( ! isset( $pages[ $slug ] ) ) {
		return witryna_setup_result( $step, 'error', __( 'Nieznana strona.', 'witryna' ) );
	}

	$title = $pages[ $slug ]['title'];
	$state = witryna_setup_page_state( $slug );

	switch ( $state['state'] ) {
		case 'exists':
			/* translators: %s: page title. */
			return witryna_setup_result( $step, 'skipped', sprintf( __( 'Strona „%s” już istnieje.', 'witryna' ), $title ), witryna_setup_post_links( $state['page'] ) );

		case 'unpublished':
			/* translators: %s: page title. */
			return witryna_setup_result( $step, 'skipped', sprintf( __( 'Strona „%s” już istnieje, ale nie jest opublikowana. Opublikuj ją w edytorze.', 'witryna' ), $title ), witryna_setup_post_links( $state['page'] ) );

		case 'trash':
			return witryna_setup_result(
				$step,
				'skipped',
				/* translators: %s: page title. */
				sprintf( __( 'Strona „%s” jest w koszu. Przywróć ją z kosza, zamiast tworzyć nową.', 'witryna' ), $title ),
				array(
					array(
						'url'   => admin_url( 'edit.php?post_status=trash&post_type=page' ),
						'label' => __( 'Kosz stron', 'witryna' ),
					),
				)
			);

		case 'taken':
			/* translators: 1: page title, 2: address, e.g. /serwis/. */
			return witryna_setup_result( $step, 'skipped', sprintf( __( 'Nie utworzono strony „%1$s”: adres %2$s jest zajęty, np. przez plik o tej nazwie w bibliotece mediów.', 'witryna' ), $title, witryna_setup_page_path( $slug ) ) );
	}

	$status = 'draft' === $status ? 'draft' : 'publish';
	$id     = wp_insert_post(
		wp_slash(
			array(
				'post_type'    => 'page',
				'post_status'  => $status,
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_content' => $pages[ $slug ]['content'],
			)
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		/* translators: 1: page title, 2: error message. */
		return witryna_setup_result( $step, 'error', sprintf( __( 'Nie udało się utworzyć strony „%1$s”: %2$s', 'witryna' ), $title, $id->get_error_message() ) );
	}

	if ( 'draft' === $status ) {
		$message = 'regulamin' === $slug
			? __( 'Utworzono szkic strony „Regulamin”. Wklej do niego treść regulaminu, opublikuj stronę i wybierz ją w WooCommerce → Ustawienia → Zaawansowane.', 'witryna' )
			/* translators: %s: page title. */
			: sprintf( __( 'Utworzono szkic strony „%s”. Uzupełnij go i opublikuj stronę.', 'witryna' ), $title );

		return witryna_setup_result( $step, 'created', $message, witryna_setup_post_links( $id ) );
	}

	/* translators: 1: page title, 2: address, e.g. /serwis/. */
	return witryna_setup_result( $step, 'created', sprintf( __( 'Utworzono stronę „%1$s” (%2$s).', 'witryna' ), $title, witryna_setup_post_path( get_post( $id ) ) ), witryna_setup_post_links( $id ) );
}

/**
 * Creates the missing store pages.
 *
 * @param string[]|null $slugs       Slugs to create, null for all.
 * @param string[]      $draft_slugs Slugs of pages created as drafts.
 * @return array[] Results.
 */
function witryna_setup_apply_pages( $slugs = null, $draft_slugs = array() ) {
	$results = array();

	foreach ( array_keys( witryna_setup_pages() ) as $slug ) {
		if ( null === $slugs || in_array( $slug, $slugs, true ) ) {
			$results[] = witryna_setup_apply_page( $slug, in_array( $slug, $draft_slugs, true ) ? 'draft' : 'publish' );
		}
	}

	return $results;
}

/**
 * Returns the reading settings compared with the preview.
 *
 * @return array{state: string, home: int, blog: int, front: int, posts: int}
 *               State is "done", "posts" (latest posts on the front page) or
 *               "other" (another static front page).
 */
function witryna_setup_front_page_state() {
	$ids   = witryna_setup_page_ids();
	$home  = isset( $ids['strona-glowna'] ) ? $ids['strona-glowna'] : 0;
	$blog  = isset( $ids['blog'] ) ? $ids['blog'] : 0;
	$front = (int) get_option( 'page_on_front' );
	$posts = (int) get_option( 'page_for_posts' );
	$state = 'other';

	if ( 'page' !== get_option( 'show_on_front' ) || ! $front ) {
		$state = 'posts';
	} elseif ( $home && $blog && $front === $home && $posts === $blog ) {
		$state = 'done';
	}

	return array(
		'state' => $state,
		'home'  => $home,
		'blog'  => $blog,
		'front' => $front,
		'posts' => $posts,
	);
}

/**
 * Shows the page "Strona główna" on the front page and posts on "Blog".
 *
 * @return array Result.
 */
function witryna_setup_apply_front_page() {
	$state = witryna_setup_front_page_state();

	if ( 'done' === $state['state'] ) {
		return witryna_setup_result( 'front_page', 'skipped', __( 'Strona główna i blog są już ustawione.', 'witryna' ) );
	}

	if ( ! $state['home'] || ! $state['blog'] ) {
		return witryna_setup_result( 'front_page', 'skipped', __( 'Nie zmieniono strony głównej: potrzebne są opublikowane strony „Strona główna” i „Blog”.', 'witryna' ) );
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $state['home'] );
	update_option( 'page_for_posts', $state['blog'] );

	return witryna_setup_result(
		'front_page',
		'updated',
		__( 'Stroną główną jest teraz „Strona główna”, a wpisy są na stronie „Blog”.', 'witryna' ),
		array(
			array(
				'url'   => home_url( '/' ),
				'label' => __( 'Zobacz stronę główną', 'witryna' ),
			),
			array(
				'url'   => get_permalink( $state['blog'] ),
				'label' => __( 'Zobacz blog', 'witryna' ),
			),
		)
	);
}

/**
 * Returns the WooCommerce pages with their current and new titles.
 *
 * @return array<string, array{id: int, current: string, title: string}> Only existing pages.
 */
function witryna_setup_wc_titles_state() {
	$pages = array();

	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return $pages;
	}

	foreach ( witryna_setup_wc_page_titles() as $key => $title ) {
		$id   = (int) wc_get_page_id( $key );
		$post = $id > 0 ? get_post( $id ) : null;
		if ( $post && 'trash' !== $post->post_status ) {
			$pages[ $key ] = array(
				'id'      => $id,
				'current' => $post->post_title,
				'title'   => $title,
			);
		}
	}

	return $pages;
}

/**
 * Renames the WooCommerce pages (Sklep, Koszyk, Zamówienie, Moje konto).
 *
 * @return array Result.
 */
function witryna_setup_apply_wc_titles() {
	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return witryna_setup_no_wc_result( 'wc_titles' );
	}

	$pages = witryna_setup_wc_titles_state();
	if ( ! $pages ) {
		return witryna_setup_result( 'wc_titles', 'skipped', __( 'Nie zmieniono tytułów: brak stron WooCommerce. Utwórz je w WooCommerce → Status → Narzędzia.', 'witryna' ) );
	}

	$changed = array();
	$errors  = array();

	foreach ( $pages as $page ) {
		if ( $page['current'] === $page['title'] ) {
			continue;
		}
		$updated = wp_update_post(
			wp_slash(
				array(
					'ID'         => $page['id'],
					'post_title' => $page['title'],
				)
			),
			true
		);
		if ( is_wp_error( $updated ) ) {
			$errors[] = $page['title'] . ': ' . $updated->get_error_message();
		} else {
			$changed[] = $page['title'];
		}
	}

	if ( $errors ) {
		/* translators: %s: list of errors. */
		return witryna_setup_result( 'wc_titles', 'error', sprintf( __( 'Nie udało się zmienić tytułów: %s', 'witryna' ), implode( '; ', $errors ) ) );
	}

	if ( ! $changed ) {
		return witryna_setup_result( 'wc_titles', 'skipped', __( 'Tytuły stron sklepu są już takie jak w podglądzie.', 'witryna' ) );
	}

	/* translators: %s: list of page titles. */
	return witryna_setup_result( 'wc_titles', 'updated', sprintf( __( 'Zmieniono tytuły stron sklepu: %s.', 'witryna' ), implode( ', ', $changed ) ) );
}

/**
 * Sets a group of options to the values of the preview.
 *
 * @param string $group "identity", "address" or "reviews".
 * @return array Result.
 */
function witryna_setup_apply_options( $group ) {
	$groups = witryna_setup_site_options();

	if ( ! isset( $groups[ $group ] ) ) {
		return witryna_setup_result( $group, 'error', __( 'Nieznany krok.', 'witryna' ) );
	}

	if ( 'identity' !== $group && ! function_exists( 'WC' ) ) {
		return witryna_setup_no_wc_result( $group );
	}

	$changed = 0;
	foreach ( $groups[ $group ] as $name => $value ) {
		if ( ! witryna_setup_option_matches( $name, $value ) ) {
			update_option( $name, $value );
			++$changed;
		}
	}

	$messages = array(
		'identity' => array(
			/* translators: 1: site title, 2: tagline. */
			sprintf( __( 'Nazwa witryny to teraz „%1$s”, a opis „%2$s”.', 'witryna' ), $groups['identity']['blogname'], $groups['identity']['blogdescription'] ),
			__( 'Nazwa i opis witryny są już takie jak w podglądzie.', 'witryna' ),
		),
		'address'  => array(
			/* translators: %s: store address. */
			sprintf( __( 'Adres sklepu w WooCommerce: %s.', 'witryna' ), witryna_setup_format_address( $groups['address'] ) ),
			__( 'Adres sklepu jest już wpisany.', 'witryna' ),
		),
		'reviews'  => array(
			__( 'Opinie mogą teraz wystawiać tylko klienci, którzy kupili produkt. Ich opinie mają oznaczenie „zweryfikowany właściciel” i ocenę w gwiazdkach.', 'witryna' ),
			__( 'Opinie są już ustawione jak w podglądzie.', 'witryna' ),
		),
	);

	return witryna_setup_result( $group, $changed ? 'updated' : 'skipped', $messages[ $group ][ $changed ? 0 : 1 ] );
}

/**
 * Formats address options as one line.
 *
 * @param array<string, string> $values Option name => value.
 * @return string
 */
function witryna_setup_format_address( $values ) {
	$country = isset( $values['woocommerce_default_country'] ) ? explode( ':', (string) $values['woocommerce_default_country'] )[0] : '';

	if ( $country && function_exists( 'WC' ) && WC()->countries ) {
		$countries = WC()->countries->get_countries();
		$country   = isset( $countries[ $country ] ) ? $countries[ $country ] : $country;
	}

	$city = trim( ( isset( $values['woocommerce_store_postcode'] ) ? $values['woocommerce_store_postcode'] : '' ) . ' ' . ( isset( $values['woocommerce_store_city'] ) ? $values['woocommerce_store_city'] : '' ) );
	$line = array_filter( array( isset( $values['woocommerce_store_address'] ) ? $values['woocommerce_store_address'] : '', $city, $country ) );

	return implode( ', ', $line );
}

/**
 * Returns the name of a navigation menu.
 *
 * @param int $id Navigation post ID.
 * @return string
 */
function witryna_setup_navigation_title( $id ) {
	$title = (string) get_post_field( 'post_title', $id );

	return '' !== $title ? $title : '#' . (int) $id;
}

/**
 * Returns how to show a menu in a header that has another menu chosen.
 *
 * @param int    $ref  ID of the menu chosen in the header.
 * @param string $menu Name of the menu to show.
 * @return string
 */
function witryna_setup_header_ref_hint( $ref, $menu ) {
	/* translators: 1: name of the menu chosen in the header, 2: name of the main menu. */
	return sprintf( __( 'Nagłówek ma w Edytorze wybrane menu „%1$s”. Aby pokazać „%2$s”, otwórz Wygląd → Edytor, zaznacz w nagłówku blok Nawigacja i w jego ustawieniach wybierz menu „%2$s”.', 'witryna' ), witryna_setup_navigation_title( $ref ), $menu );
}

/**
 * Creates the main menu of the preview, unless the same menu already exists.
 *
 * The new menu is the newest one, so the header shows it straight away
 * (unless a menu was chosen in the header in the Site Editor).
 *
 * @param int[] $category_order Optional order of the categories, see witryna_setup_menu_categories().
 * @return array Result.
 */
function witryna_setup_apply_menu( $category_order = array() ) {
	$ref      = witryna_setup_header_menu_ref();
	$existing = witryna_setup_find_menu();
	if ( $existing ) {
		/* translators: %s: menu name. */
		$message = sprintf( __( 'Menu „%s” już istnieje.', 'witryna' ), $existing->post_title );
		if ( $ref && (int) $existing->ID !== $ref ) {
			$message .= ' ' . witryna_setup_header_ref_hint( $ref, $existing->post_title );
		}
		return witryna_setup_result( 'menu', 'skipped', $message, witryna_setup_menu_links( $existing->ID ) );
	}

	$page_ids = witryna_setup_page_ids();
	$markup   = witryna_setup_menu_markup( $page_ids, $category_order );

	if ( '' === $markup ) {
		return witryna_setup_result( 'menu', 'skipped', __( 'Nie utworzono menu: nie ma sklepu ani stron, do których mogłoby prowadzić.', 'witryna' ) );
	}

	$id = wp_insert_post(
		wp_slash(
			array(
				'post_type'    => 'wp_navigation',
				'post_status'  => 'publish',
				'post_title'   => witryna_setup_menu_title(),
				'post_content' => $markup,
			)
		),
		true
	);

	if ( is_wp_error( $id ) ) {
		/* translators: %s: error message. */
		return witryna_setup_result( 'menu', 'error', sprintf( __( 'Nie udało się utworzyć menu: %s', 'witryna' ), $id->get_error_message() ) );
	}

	$pages   = witryna_setup_pages();
	$missing = array();
	if ( function_exists( 'wc_get_page_id' ) && ! witryna_setup_shop_page_id() ) {
		$missing[] = __( 'Sklep', 'witryna' );
	}
	foreach ( array( 'serwis', 'opinie', 'social-media', 'o-firmie', 'kontakt' ) as $slug ) {
		if ( empty( $page_ids[ $slug ] ) ) {
			$missing[] = $pages[ $slug ]['title'];
		}
	}

	$message = $ref
		/* translators: %s: menu name. */
		? sprintf( __( 'Utworzono menu „%s”.', 'witryna' ), witryna_setup_menu_title() ) . ' ' . witryna_setup_header_ref_hint( $ref, witryna_setup_menu_title() )
		/* translators: %s: menu name. */
		: sprintf( __( 'Utworzono menu „%s”. Jest już widoczne w nagłówku.', 'witryna' ), witryna_setup_menu_title() );
	if ( $missing ) {
		/* translators: %s: list of page titles. */
		$message .= ' ' . sprintf( __( 'W menu pominięto strony, których nie ma lub które nie są opublikowane: %s.', 'witryna' ), implode( ', ', $missing ) );
	}
	if ( witryna_setup_plain_permalinks() ) {
		$message .= ' ' . __( 'Bezpośrednie odnośniki są ustawione na „Prosty”, więc linki w menu zapisały się w postaci ?page_id=… Jeśli potem wybierzesz „Nazwa wpisu”, popraw w Edytorze linki w menu, zwłaszcza „Sklep”.', 'witryna' );
	}

	return witryna_setup_result( 'menu', 'created', $message, witryna_setup_menu_links( $id ) );
}

/**
 * Returns links to a menu in the Site Editor.
 *
 * @param int $id Navigation post ID.
 * @return array
 */
function witryna_setup_menu_links( $id ) {
	return array(
		array(
			'url'   => add_query_arg( 'p', '/wp_navigation/' . (int) $id, admin_url( 'site-editor.php' ) ),
			'label' => __( 'Edytuj menu', 'witryna' ),
		),
		array(
			'url'   => add_query_arg( 'p', '/navigation', admin_url( 'site-editor.php' ) ),
			'label' => __( 'Wygląd → Edytor → Nawigacja', 'witryna' ),
		),
	);
}

/**
 * Adds the guides of the preview to the blog, skipping ones that exist.
 *
 * The featured image is the photo of the matching product category.
 *
 * @return array[] Results.
 */
function witryna_setup_apply_blog_posts() {
	$results  = array();
	$existing = witryna_setup_existing_blog_posts();

	foreach ( witryna_setup_blog_posts() as $i => $post ) {
		if ( isset( $existing[ $post['title'] ] ) ) {
			$found = $existing[ $post['title'] ];
			if ( 'trash' === $found->post_status ) {
				/* translators: %s: post title. */
				$results[] = witryna_setup_result( 'guides', 'skipped', sprintf( __( 'Wpis „%s” jest w koszu – możesz go przywrócić.', 'witryna' ), $post['title'] ), array( array( 'url' => admin_url( 'edit.php?post_status=trash&post_type=post' ), 'label' => __( 'Kosz wpisów', 'witryna' ) ) ) );
			} else {
				/* translators: %s: post title. */
				$results[] = witryna_setup_result( 'guides', 'skipped', sprintf( __( 'Wpis „%s” już istnieje.', 'witryna' ), $post['title'] ), witryna_setup_post_links( $found ) );
			}
			continue;
		}

		$category = term_exists( $post['category'], 'category' );
		if ( ! $category ) {
			$category = wp_insert_term( $post['category'], 'category' );
		}

		$id = wp_insert_post(
			wp_slash(
				array(
					'post_type'     => 'post',
					'post_status'   => 'publish',
					'post_title'    => $post['title'],
					'post_excerpt'  => $post['excerpt'],
					'post_date'     => gmdate( 'Y-m-d H:i:s', time() - ( $i + 1 ) * 5 * DAY_IN_SECONDS ),
					'post_category' => is_array( $category ) ? array( (int) $category['term_id'] ) : array(),
					'post_content'  => '<!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size">' . $post['excerpt'] . '</p><!-- /wp:paragraph -->' . $post['content'],
				)
			),
			true
		);

		if ( is_wp_error( $id ) ) {
			/* translators: 1: post title, 2: error message. */
			$results[] = witryna_setup_result( 'guides', 'error', sprintf( __( 'Nie udało się dodać wpisu „%1$s”: %2$s', 'witryna' ), $post['title'], $id->get_error_message() ) );
			continue;
		}

		if ( taxonomy_exists( 'product_cat' ) && function_exists( 'witryna_category_image_id' ) ) {
			$terms = get_terms(
				array(
					'taxonomy'   => 'product_cat',
					'name'       => $post['product_cat'],
					'parent'     => 0,
					'hide_empty' => false,
					'number'     => 1,
				)
			);
			$image = $terms && ! is_wp_error( $terms ) ? witryna_category_image_id( $terms[0] ) : 0;
			if ( $image ) {
				set_post_thumbnail( $id, $image );
			}
		}

		/* translators: %s: post title. */
		$results[] = witryna_setup_result( 'guides', 'created', sprintf( __( 'Dodano wpis „%s”.', 'witryna' ), $post['title'] ), witryna_setup_post_links( $id ) );
	}

	return $results;
}

/**
 * Moves the default WordPress post and page to the trash.
 *
 * @return array Result.
 */
function witryna_setup_apply_sample_content() {
	$trashed = array();

	foreach ( witryna_setup_sample_content() as $post ) {
		if ( wp_trash_post( $post->ID ) ) {
			$trashed[] = '„' . $post->post_title . '”';
		}
	}

	if ( ! $trashed ) {
		return witryna_setup_result( 'sample_content', 'skipped', __( 'Nie ma już przykładowych treści WordPressa.', 'witryna' ) );
	}

	return witryna_setup_result(
		'sample_content',
		'updated',
		/* translators: %s: list of titles. */
		sprintf( __( 'Przeniesiono do kosza: %s. W razie potrzeby możesz je stamtąd przywrócić.', 'witryna' ), implode( ', ', $trashed ) ),
		array(
			array(
				'url'   => admin_url( 'edit.php?post_status=trash&post_type=post' ),
				'label' => __( 'Kosz wpisów', 'witryna' ),
			),
			array(
				'url'   => admin_url( 'edit.php?post_status=trash&post_type=page' ),
				'label' => __( 'Kosz stron', 'witryna' ),
			),
		)
	);
}

/**
 * Returns the IDs of the steps other than pages, in the order they run.
 *
 * Pages come first, then the reading settings and titles, then the menu,
 * which links to the pages by their real IDs.
 *
 * @return string[]
 */
function witryna_setup_step_order() {
	return array( 'front_page', 'wc_titles', 'identity', 'address', 'reviews', 'menu', 'guides', 'sample_content' );
}

/**
 * Runs the chosen steps in a safe order.
 *
 * "Regulamin" is created as a draft: placeholder legal text must not go
 * public on a live shop. dev/demo/setup.php publishes it.
 *
 * @param string[] $pages Slugs of pages to create.
 * @param string[] $steps IDs of other steps, see witryna_setup_step_order().
 * @return array[] Results.
 */
function witryna_setup_apply( $pages, $steps ) {
	$pages   = array_values( array_intersect( array_keys( witryna_setup_pages() ), (array) $pages ) );
	$steps   = (array) $steps;
	$results = $pages ? witryna_setup_apply_pages( $pages, array( 'regulamin' ) ) : array();

	foreach ( witryna_setup_step_order() as $step ) {
		if ( ! in_array( $step, $steps, true ) ) {
			continue;
		}
		switch ( $step ) {
			case 'front_page':
				$results[] = witryna_setup_apply_front_page();
				break;
			case 'wc_titles':
				$results[] = witryna_setup_apply_wc_titles();
				break;
			case 'menu':
				$results[] = witryna_setup_apply_menu();
				break;
			case 'guides':
				$results = array_merge( $results, witryna_setup_apply_blog_posts() );
				break;
			case 'sample_content':
				$results[] = witryna_setup_apply_sample_content();
				break;
			default:
				$results[] = witryna_setup_apply_options( $step );
		}
	}

	return $results;
}

/* ---------------------------------------------------------------------------
 * Admin screen: Wygląd → Ustaw sklep.
 * ------------------------------------------------------------------------ */

/**
 * Returns a step row for the admin screen.
 *
 * @param array $args Row data.
 * @return array{section: string, field: string, id: string, label: string, action: string, current: string, notes: string[], links: array, state: string, checked: bool}
 *               State is "todo" (can be applied), "done" or "blocked" (needs the owner).
 */
function witryna_setup_row( $args ) {
	return wp_parse_args(
		$args,
		array(
			'section' => 'pages',
			'field'   => 'witryna_steps',
			'id'      => '',
			'label'   => '',
			'action'  => '',
			'current' => '',
			'notes'   => array(),
			'links'   => array(),
			'state'   => 'todo',
			'checked' => false,
		)
	);
}

/**
 * Returns a link to the WooCommerce setting of the terms page.
 *
 * @return array{url: string, label: string}
 */
function witryna_setup_terms_setting_link() {
	return array(
		'url'   => admin_url( 'admin.php?page=wc-settings&tab=advanced' ),
		'label' => __( 'WooCommerce → Ustawienia → Zaawansowane', 'witryna' ),
	);
}

/**
 * Returns the row of a store page.
 *
 * @param string $slug  Page slug.
 * @param array  $page  Page definition.
 * @param array  $front Reading settings, see witryna_setup_front_page_state().
 * @return array
 */
function witryna_setup_page_row( $slug, $page, $front ) {
	$notes = array(
		'strona-glowna' => __( 'Stronę główną układa motyw (sekcje, kategorie, bestsellery), więc ta strona może zostać pusta.', 'witryna' ),
		'blog'          => __( 'Tu pojawią się wpisy z bloga.', 'witryna' ),
		'regulamin'     => __( 'Po opublikowaniu wybierz tę stronę w WooCommerce → Ustawienia → Zaawansowane, aby link „Regulamin” w stopce i przy zamówieniu prowadził do niej.', 'witryna' ),
	);
	$note  = isset( $notes[ $slug ] ) ? $notes[ $slug ] : __( 'Gotowy układ z motywu pojawi się sam. Tekst wpisany w edytorze pokaże się pod nim.', 'witryna' );
	$state = witryna_setup_page_state( $slug );
	$row   = array(
		'field'  => 'witryna_pages',
		'id'     => $slug,
		'label'  => $page['title'],
		'action' => 'regulamin' === $slug
			? __( 'Utworzy szkic strony „Regulamin” z tymczasowym tekstem. Klienci go nie zobaczą, dopóki nie wkleisz regulaminu i nie opublikujesz strony.', 'witryna' )
			/* translators: 1: page title, 2: address, e.g. /serwis/. */
			: sprintf( __( 'Utworzy stronę „%1$s” pod adresem %2$s.', 'witryna' ), $page['title'], witryna_setup_page_path( $slug ) ),
		'notes'  => array( $note ),
	);

	switch ( $state['state'] ) {
		case 'exists':
			$row['state']   = 'done';
			/* translators: %s: address, e.g. /serwis/. */
			$row['current'] = sprintf( __( 'Jest (%s).', 'witryna' ), witryna_setup_post_path( $state['page'] ) );
			$row['links']   = witryna_setup_post_links( $state['page'] );
			$row['notes']   = array();
			return witryna_setup_row( $row );

		case 'unpublished':
			$status         = get_post_status_object( $state['page']->post_status );
			$row['state']   = 'blocked';
			/* translators: %s: post status, e.g. Szkic. */
			$row['current'] = sprintf( __( 'Jest, ale nie jest opublikowana (%s). Opublikuj ją w edytorze.', 'witryna' ), $status ? $status->label : $state['page']->post_status );
			$row['links']   = witryna_setup_post_links( $state['page'] );
			if ( 'regulamin' === $slug && function_exists( 'wc_get_page_id' ) ) {
				$row['current'] .= ' ' . __( 'Wklej do niej swój regulamin, a po opublikowaniu wybierz ją w WooCommerce → Ustawienia → Zaawansowane.', 'witryna' );
				$row['links'][]  = witryna_setup_terms_setting_link();
			}
			return witryna_setup_row( $row );

		case 'trash':
			$row['state']   = 'blocked';
			$row['current'] = __( 'Jest w koszu. Przywróć ją (Strony → Kosz), zamiast tworzyć nową.', 'witryna' );
			$row['links']   = array(
				array(
					'url'   => admin_url( 'edit.php?post_status=trash&post_type=page' ),
					'label' => __( 'Kosz stron', 'witryna' ),
				),
			);
			return witryna_setup_row( $row );

		case 'taken':
			$row['state']   = 'blocked';
			/* translators: %s: address, e.g. /serwis/. */
			$row['current'] = sprintf( __( 'Adres %s jest zajęty przez coś innego, np. plik o tej nazwie w bibliotece mediów. Zmień tamten adres i wróć tutaj.', 'witryna' ), witryna_setup_page_path( $slug ) );
			return witryna_setup_row( $row );
	}

	$row['current'] = __( 'Brak.', 'witryna' );
	$row['checked'] = true;

	// A page with the same title elsewhere: let the owner decide.
	foreach ( witryna_setup_find_by_title( $page['title'], 'page', witryna_setup_live_statuses() ) as $twin ) {
		$row['checked'] = false;
		/* translators: 1: page title, 2: its address, 3: address the layout needs. */
		$row['current'] = sprintf( __( 'Masz już stronę „%1$s” pod adresem %2$s. Gotowy układ działa tylko pod adresem %3$s – zmień adres tamtej strony na %3$s albo zaznacz ten krok, aby utworzyć nową.', 'witryna' ), $twin->post_title, witryna_setup_post_path( $twin ), witryna_setup_page_path( $slug ) );
		$row['links']   = witryna_setup_post_links( $twin );
		break;
	}

	if ( 'regulamin' === $slug && function_exists( 'wc_get_page_id' ) ) {
		$terms_id = (int) wc_get_page_id( 'terms' );
		$terms    = $terms_id > 0 ? get_post( $terms_id ) : null;
		$similar  = $row['checked'] ? get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => witryna_setup_live_statuses(),
				's'              => 'regulamin',
				'search_columns' => array( 'post_title' ),
				'posts_per_page' => 1,
				'no_found_rows'  => true,
			)
		) : array();

		if ( $terms && 'trash' !== $terms->post_status ) {
			$row['checked'] = false;
			/* translators: %s: page title. */
			$row['current'] = sprintf( __( 'Regulamin sklepu jest już wybrany w WooCommerce: „%s”.', 'witryna' ), $terms->post_title );
			$row['links']   = witryna_setup_post_links( $terms );
		} elseif ( $similar ) {
			$row['checked'] = false;
			/* translators: 1: page title, 2: its address. */
			$row['current'] = sprintf( __( 'Masz już stronę „%1$s” (%2$s). Jeśli to Twój regulamin, wybierz ją w WooCommerce → Ustawienia → Zaawansowane.', 'witryna' ), $similar[0]->post_title, witryna_setup_post_path( $similar[0] ) );
			$row['links']   = array_merge( witryna_setup_post_links( $similar[0] ), array( witryna_setup_terms_setting_link() ) );
		}
	}

	if ( in_array( $slug, array( 'strona-glowna', 'blog' ), true ) && 'other' === $front['state'] ) {
		$row['checked'] = false;
		$row['notes'][] = __( 'Masz już własną stronę główną (Ustawienia → Czytanie), więc ta strona nie jest zaznaczona.', 'witryna' );
	}

	return witryna_setup_row( $row );
}

/**
 * Returns the row of the reading settings.
 *
 * @param array $front Reading settings, see witryna_setup_front_page_state().
 * @return array
 */
function witryna_setup_front_page_row( $front ) {
	$row = array(
		'section' => 'home',
		'id'      => 'front_page',
		'label'   => witryna_setup_step_label( 'front_page' ),
		'action'  => __( 'Stroną główną będzie „Strona główna” z układem motywu, a wpisy pojawią się na stronie „Blog”.', 'witryna' ),
		'links'   => array(
			array(
				'url'   => admin_url( 'options-reading.php' ),
				'label' => __( 'Ustawienia → Czytanie', 'witryna' ),
			),
		),
	);

	if ( 'done' === $front['state'] ) {
		$row['state']   = 'done';
		$row['current'] = __( 'Ustawione.', 'witryna' );
		return witryna_setup_row( $row );
	}

	if ( 'posts' === $front['state'] ) {
		$row['checked'] = true;
		$row['current'] = __( 'Strona główna pokazuje najnowsze wpisy.', 'witryna' );
	} else {
		$row['current'] = sprintf(
			/* translators: 1: front page title, 2: posts page title or "brak". */
			__( 'Stroną główną jest „%1$s”, strona z wpisami: %2$s.', 'witryna' ),
			get_the_title( $front['front'] ),
			$front['posts'] ? '„' . get_the_title( $front['posts'] ) . '”' : __( 'brak', 'witryna' )
		);
		$row['notes'][] = __( 'Masz już własną stronę główną, więc ten krok nie jest zaznaczony.', 'witryna' );
	}

	if ( ! $front['home'] || ! $front['blog'] ) {
		$row['notes'][] = __( 'Wymaga stron „Strona główna” i „Blog” (w tabeli wyżej).', 'witryna' );
	}

	return witryna_setup_row( $row );
}

/**
 * Returns the row of the main menu.
 *
 * @return array
 */
function witryna_setup_menu_row() {
	$navigations = witryna_setup_navigations();
	$own         = witryna_setup_own_menus();
	$ref         = witryna_setup_header_menu_ref();
	$header      = $ref ? get_post( $ref ) : ( $navigations ? $navigations[0] : null );
	$existing    = witryna_setup_find_menu();
	$categories  = $existing ? array() : wp_list_pluck( witryna_setup_menu_categories(), 'name' );

	$row = array(
		'section' => 'home',
		'id'      => 'menu',
		'label'   => witryna_setup_step_label( 'menu' ),
		'action'  => sprintf(
			/* translators: %s: list of product categories. */
			__( 'Utworzy menu „Menu główne” jak w podglądzie: Sklep (z kategoriami: %s), Serwis, Opinie, Social media, O firmie, Kontakt.', 'witryna' ),
			$categories ? html_entity_decode( implode( ', ', $categories ), ENT_QUOTES, 'UTF-8' ) : __( 'na razie żadna kategoria nie ma produktów', 'witryna' )
		),
		'notes'   => array( __( 'Menu powstaje jednorazowo. Kategorie, w których produkty pojawią się później, dodasz w Edytorze.', 'witryna' ) ),
		'links'   => array(
			array(
				'url'   => add_query_arg( 'p', '/navigation', admin_url( 'site-editor.php' ) ),
				'label' => __( 'Wygląd → Edytor → Nawigacja', 'witryna' ),
			),
		),
	);

	if ( $existing ) {
		$row['state']   = 'done';
		/* translators: %s: menu name. */
		$row['current'] = sprintf( __( 'Jest menu „%s”.', 'witryna' ), $existing->post_title );
		$row['notes']   = array();
		$row['links']   = witryna_setup_menu_links( $existing->ID );
		if ( $ref && (int) $existing->ID !== $ref ) {
			$row['current'] .= ' ' . witryna_setup_header_ref_hint( $ref, $existing->post_title );
		}
		return witryna_setup_row( $row );
	}

	if ( ! $header ) {
		$row['current'] = __( 'Nie ma menu, więc nagłówek pokazuje listę wszystkich stron.', 'witryna' );
	} elseif ( witryna_setup_is_auto_menu( $header ) ) {
		/* translators: %s: menu name. */
		$row['current'] = sprintf( __( 'W nagłówku jest automatyczne menu „%s” z listą wszystkich stron.', 'witryna' ), witryna_setup_navigation_title( $header->ID ) );
	} else {
		/* translators: %s: menu name. */
		$row['current'] = sprintf( __( 'W nagłówku jest Twoje menu „%s”.', 'witryna' ), witryna_setup_navigation_title( $header->ID ) );
	}

	if ( ! $own ) {
		$row['checked'] = true;
	} else {
		if ( $header && witryna_setup_is_auto_menu( $header ) ) {
			/* translators: %s: list of menu names. */
			$row['current'] .= ' ' . sprintf( __( 'Masz też menu: %s.', 'witryna' ), '„' . implode( '”, „', wp_list_pluck( $own, 'post_title' ) ) . '”' );
		}
		$row['notes'][] = $ref
			? __( 'Jeśli zaznaczysz ten krok, powstanie nowe menu „Menu główne”. Obecne menu zostanie bez zmian.', 'witryna' )
			: __( 'Jeśli zaznaczysz ten krok, powstanie nowe menu „Menu główne” i to ono pojawi się w nagłówku. Obecne menu zostanie – możesz do niego wrócić w Edytorze.', 'witryna' );
	}

	if ( $ref ) {
		$row['notes'][] = witryna_setup_header_ref_hint( $ref, witryna_setup_menu_title() );
	}

	if ( witryna_setup_plain_permalinks() ) {
		$row['checked'] = false;
		$row['notes'][] = __( 'Bezpośrednie odnośniki są ustawione na „Prosty”, więc ten krok nie jest zaznaczony. Najpierw wybierz „Nazwa wpisu” (Ustawienia → Bezpośrednie odnośniki), a potem utwórz menu – linki zapisane teraz miałyby postać ?page_id=… i po zmianie link „Sklep” prowadziłby w złe miejsce.', 'witryna' );
		$row['links'][] = array(
			'url'   => admin_url( 'options-permalink.php' ),
			'label' => __( 'Ustawienia → Bezpośrednie odnośniki', 'witryna' ),
		);
	}

	return witryna_setup_row( $row );
}

/**
 * Tells whether a site title or tagline is a WordPress default or empty.
 *
 * @param string $value Value.
 * @return bool
 */
function witryna_setup_is_default_identity( $value ) {
	$value    = strtolower( trim( wp_strip_all_tags( (string) $value ) ) );
	$defaults = array(
		'',
		'wordpress',
		'my wordpress website',
		'my wordpress site',
		'my blog',
		'moja witryna wordpress',
		'moja witryna',
		'mój blog',
		'just another wordpress site',
		'kolejna witryna oparta na wordpressie',
		strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) ),
	);

	return in_array( $value, $defaults, true );
}

/**
 * Returns the row of the site title and tagline.
 *
 * @return array
 */
function witryna_setup_identity_row() {
	$options = witryna_setup_site_options()['identity'];
	$name    = (string) get_option( 'blogname' );
	$desc    = (string) get_option( 'blogdescription' );
	$empty   = __( '(puste)', 'witryna' );
	$row     = array(
		'section' => 'store',
		'id'      => 'identity',
		'label'   => witryna_setup_step_label( 'identity' ),
		/* translators: 1: site title, 2: tagline. */
		'action'  => sprintf( __( 'Zmieni nazwę witryny na „%1$s” i opis na „%2$s”.', 'witryna' ), $options['blogname'], $options['blogdescription'] ),
		'current' => sprintf(
			/* translators: 1: site title, 2: tagline. */
			__( 'Nazwa: %1$s, opis: %2$s.', 'witryna' ),
			'' !== $name ? '„' . html_entity_decode( $name, ENT_QUOTES, 'UTF-8' ) . '”' : $empty,
			'' !== $desc ? '„' . html_entity_decode( $desc, ENT_QUOTES, 'UTF-8' ) . '”' : $empty
		),
		'links'   => array(
			array(
				'url'   => admin_url( 'options-general.php' ),
				'label' => __( 'Ustawienia → Ogólne', 'witryna' ),
			),
		),
	);

	$name_ok = witryna_setup_option_matches( 'blogname', $options['blogname'] );
	$desc_ok = witryna_setup_option_matches( 'blogdescription', $options['blogdescription'] );

	if ( $name_ok && $desc_ok ) {
		$row['state'] = 'done';
		return witryna_setup_row( $row );
	}

	$row['checked'] = ( $name_ok || witryna_setup_is_default_identity( $name ) ) && ( $desc_ok || witryna_setup_is_default_identity( $desc ) );
	if ( ! $row['checked'] ) {
		$row['notes'][] = __( 'Masz już własną nazwę lub opis, więc ten krok nie jest zaznaczony.', 'witryna' );
	}

	return witryna_setup_row( $row );
}

/**
 * Returns the row of the store address.
 *
 * @return array
 */
function witryna_setup_address_row() {
	$options = witryna_setup_site_options()['address'];
	$current = array();
	foreach ( array_keys( $options ) as $name ) {
		$current[ $name ] = (string) get_option( $name, '' );
	}

	$row = array(
		'section' => 'store',
		'id'      => 'address',
		'label'   => witryna_setup_step_label( 'address' ),
		/* translators: %s: store address. */
		'action'  => sprintf( __( 'Wpisze adres %s w ustawieniach WooCommerce (e-maile, wysyłka, podatki).', 'witryna' ), witryna_setup_format_address( $options ) ),
		'current' => witryna_setup_format_address( $current ),
		'links'   => array(
			array(
				'url'   => admin_url( 'admin.php?page=wc-settings&tab=general' ),
				'label' => __( 'WooCommerce → Ustawienia → Ogólne', 'witryna' ),
			),
		),
	);

	$matches = array_filter(
		array_keys( $options ),
		static function ( $name ) use ( $options ) {
			return witryna_setup_option_matches( $name, $options[ $name ] );
		}
	);

	if ( count( $matches ) === count( $options ) ) {
		$row['state'] = 'done';
		return witryna_setup_row( $row );
	}

	$row['checked'] = '' === trim( $current['woocommerce_store_address'] . $current['woocommerce_store_city'] . $current['woocommerce_store_postcode'] );
	if ( $row['checked'] ) {
		$row['current'] = __( 'Brak adresu.', 'witryna' );
	} else {
		/* translators: %s: store address. */
		$row['action']  = sprintf( __( 'Zastąpi obecny adres adresem %s (e-maile, wysyłka, podatki).', 'witryna' ), witryna_setup_format_address( $options ) );
		$row['notes'][] = __( 'Adres jest już wpisany, więc ten krok nie jest zaznaczony.', 'witryna' );
	}

	return witryna_setup_row( $row );
}

/**
 * Returns the row of the review settings.
 *
 * The step is checked only while reviews, star ratings and the "verified
 * owner" label are still on, as WooCommerce sets them: switching one of
 * them off is the owner's choice and is not undone by default.
 *
 * @return array
 */
function witryna_setup_reviews_row() {
	$options = witryna_setup_site_options()['reviews'];
	$labels  = array(
		'woocommerce_enable_reviews'                      => __( 'opinie', 'witryna' ),
		'woocommerce_review_rating_verification_required' => __( 'tylko od kupujących', 'witryna' ),
		'woocommerce_review_rating_verification_label'    => __( 'oznaczenie „zweryfikowany właściciel”', 'witryna' ),
		'woocommerce_enable_review_rating'                => __( 'oceny w gwiazdkach', 'witryna' ),
	);
	$current = array();
	$done    = true;
	$off     = false;
	foreach ( $options as $name => $value ) {
		$on        = 'yes' === get_option( $name );
		$done      = $done && witryna_setup_option_matches( $name, $value );
		$off       = $off || ( 'woocommerce_review_rating_verification_required' !== $name && 'no' === get_option( $name ) );
		$current[] = $labels[ $name ] . ': ' . ( $on ? __( 'tak', 'witryna' ) : __( 'nie', 'witryna' ) );
	}

	$row = array(
		'section' => 'store',
		'id'      => 'reviews',
		'label'   => witryna_setup_step_label( 'reviews' ),
		'action'  => __( 'Włączy opinie i oceny w gwiazdkach. Opinie wystawią tylko klienci, którzy kupili produkt, z oznaczeniem „zweryfikowany właściciel”. Strona /opinie poinformuje, że opinie są weryfikowane.', 'witryna' ),
		'current' => ucfirst( implode( ', ', $current ) ) . '.',
		'state'   => $done ? 'done' : 'todo',
		'checked' => ! $done && ! $off,
		'links'   => array(
			array(
				'url'   => admin_url( 'admin.php?page=wc-settings&tab=products' ),
				'label' => __( 'WooCommerce → Ustawienia → Produkty', 'witryna' ),
			),
		),
	);

	if ( ! $done && $off ) {
		$row['notes'][] = __( 'Opinie, oceny w gwiazdkach lub oznaczenie są u Ciebie wyłączone, więc ten krok nie jest zaznaczony.', 'witryna' );
	}

	return witryna_setup_row( $row );
}

/**
 * Tells whether a page title is one WooCommerce gives its pages.
 *
 * @param string $title Page title.
 * @return bool
 */
function witryna_setup_is_default_wc_title( $title ) {
	return in_array( $title, array( 'Shop', 'Cart', 'Checkout', 'My account', 'My Account', 'Sklep', 'Koszyk', 'Zamówienie', 'Kasa', 'Płatność', 'Moje konto' ), true );
}

/**
 * Returns the row of the WooCommerce page titles.
 *
 * The step is checked only when every title to change is still the one
 * WooCommerce gave the page, so titles the owner chose are kept by default.
 *
 * @return array
 */
function witryna_setup_wc_titles_row() {
	$pages   = witryna_setup_wc_titles_state();
	$titles  = witryna_setup_wc_page_titles();
	$current = array();
	$done    = true;
	$own     = false;

	foreach ( $pages as $page ) {
		if ( $page['current'] === $page['title'] ) {
			$current[] = '„' . $page['current'] . '”';
		} else {
			$done      = false;
			$own       = $own || ! witryna_setup_is_default_wc_title( $page['current'] );
			$current[] = '„' . $page['current'] . '” → „' . $page['title'] . '”';
		}
	}

	$row = array(
		'section' => 'store',
		'id'      => 'wc_titles',
		'label'   => witryna_setup_step_label( 'wc_titles' ),
		/* translators: %s: list of page titles. */
		'action'  => sprintf( __( 'Zmieni tytuły stron WooCommerce na: %s.', 'witryna' ), implode( ', ', $titles ) ),
		'current' => $current ? implode( ', ', $current ) . '.' : '',
		'state'   => $done ? 'done' : 'todo',
		'checked' => ! $done && ! $own,
	);

	if ( ! $done && $own ) {
		$row['notes'][] = __( 'Niektóre tytuły zmieniono już ręcznie, więc ten krok nie jest zaznaczony.', 'witryna' );
	}

	$missing = array_diff_key( $titles, $pages );
	if ( $missing ) {
		if ( $done ) {
			$row['state'] = 'blocked';
		}
		/* translators: %s: list of page titles. */
		$row['current'] = trim( $row['current'] . ' ' . sprintf( __( 'Brakuje stron WooCommerce: %s. Utwórz je w WooCommerce → Status → Narzędzia → Utwórz domyślne strony WooCommerce.', 'witryna' ), '„' . implode( '”, „', $missing ) . '”' ) );
		$row['links'][] = array(
			'url'   => admin_url( 'admin.php?page=wc-status&tab=tools' ),
			'label' => __( 'WooCommerce → Status → Narzędzia', 'witryna' ),
		);
	}

	return witryna_setup_row( $row );
}

/**
 * Returns the row of the guides from the preview.
 *
 * @return array
 */
function witryna_setup_guides_row() {
	$existing = witryna_setup_existing_blog_posts();
	$titles   = wp_list_pluck( witryna_setup_blog_posts(), 'title' );
	$row      = array(
		'section' => 'optional',
		'id'      => 'guides',
		'label'   => witryna_setup_step_label( 'guides' ),
		/* translators: %s: list of post titles. */
		'action'  => sprintf( __( 'Doda wpisy w kategorii Poradniki: %s.', 'witryna' ), '„' . implode( '”, „', $titles ) . '”' ),
		'notes'   => array( __( 'Wpisy wspominają o usługach sklepu: przeglądzie sezonowym w serwisie w Czernicy, pomocy w doborze pilarki i montażu robotów koszących. Sprawdź, czy to zgadza się z ofertą, zanim je zostawisz.', 'witryna' ) ),
		'current' => __( 'Nie ma ich jeszcze.', 'witryna' ),
	);

	if ( $existing ) {
		/* translators: %s: list of post titles. */
		$row['current'] = sprintf( __( 'Są już: %s.', 'witryna' ), '„' . implode( '”, „', array_keys( $existing ) ) . '”' );
	}

	if ( count( $existing ) === count( $titles ) ) {
		$row['state'] = 'done';
		$row['notes'] = array();
	}

	return witryna_setup_row( $row );
}

/**
 * Returns the row of the default WordPress content.
 *
 * @return array
 */
function witryna_setup_sample_row() {
	$found = witryna_setup_sample_content();
	$row   = array(
		'section' => 'optional',
		'id'      => 'sample_content',
		'label'   => witryna_setup_step_label( 'sample_content' ),
		'action'  => __( 'Przeniesie do kosza wpis „Witaj, świecie!” i stronę „Przykładowa strona”. Można je przywrócić z kosza.', 'witryna' ),
		'current' => __( 'Nie ma ich już.', 'witryna' ),
		'state'   => $found ? 'todo' : 'done',
	);

	if ( $found ) {
		$names = array();
		foreach ( $found as $post ) {
			$names[]        = '„' . $post->post_title . '” (' . witryna_setup_post_path( $post ) . ')';
			$row['links'][] = array(
				'url'   => get_edit_post_link( $post, 'raw' ),
				/* translators: %s: post title. */
				'label' => sprintf( __( 'Edytuj „%s”', 'witryna' ), $post->post_title ),
			);
		}
		/* translators: %s: list of titles. */
		$row['current'] = sprintf( __( 'Są: %s.', 'witryna' ), implode( ', ', $names ) );
	}

	return witryna_setup_row( $row );
}

/**
 * Returns all rows of the admin screen.
 *
 * @return array[]
 */
function witryna_setup_rows() {
	$front = witryna_setup_front_page_state();
	$rows  = array();

	foreach ( witryna_setup_pages() as $slug => $page ) {
		$rows[] = witryna_setup_page_row( $slug, $page, $front );
	}

	$rows[] = witryna_setup_front_page_row( $front );
	$rows[] = witryna_setup_menu_row();
	$rows[] = witryna_setup_identity_row();

	if ( function_exists( 'wc_get_page_id' ) ) {
		$rows[] = witryna_setup_address_row();
		$rows[] = witryna_setup_reviews_row();
		$rows[] = witryna_setup_wc_titles_row();
	}

	$rows[] = witryna_setup_guides_row();
	$rows[] = witryna_setup_sample_row();

	return $rows;
}

/**
 * Returns things the tool does not change, with their state.
 *
 * @return array[] Each array{text: string, warning: bool, links: array}.
 */
function witryna_setup_info() {
	$info = array(
		array(
			'text'    => __( 'Produkty, kategorie, płatności (PayU), wysyłka i tryb „Wkrótce dostępny” nie są zmieniane.', 'witryna' ),
			'warning' => false,
			'links'   => array(),
		),
	);

	if ( function_exists( 'wc_get_page_id' ) ) {
		$coming_soon = 'yes' === get_option( 'woocommerce_coming_soon' );
		$store_only  = 'yes' === get_option( 'woocommerce_store_pages_only' );
		$info[]      = array(
			'text'    => $coming_soon
				? ( $store_only ? __( 'Sklep jest w trybie „Wkrótce dostępny”: klienci nie widzą stron sklepu. Wyłącz go, gdy wszystko będzie gotowe.', 'witryna' ) : __( 'Sklep jest w trybie „Wkrótce dostępny”: klienci widzą tylko stronę zapowiedzi. Wyłącz go, gdy wszystko będzie gotowe.', 'witryna' ) )
				: __( 'Sklep jest widoczny dla wszystkich (tryb „Wkrótce dostępny” jest wyłączony).', 'witryna' ),
			'warning' => $coming_soon,
			'links'   => array(
				array(
					'url'   => admin_url( 'admin.php?page=wc-settings&tab=site-visibility' ),
					'label' => __( 'WooCommerce → Ustawienia → Widoczność witryny', 'witryna' ),
				),
			),
		);
	}

	$structure = (string) get_option( 'permalink_structure' );
	$info[]    = array(
		'text'    => '' === $structure
			? __( 'Bezpośrednie odnośniki są ustawione na „Prosty” (adresy typu ?page_id=12). Wybierz „Nazwa wpisu”, aby adresy wyglądały jak /serwis/.', 'witryna' )
			/* translators: %s: permalink structure, e.g. /%postname%/. */
			: sprintf( __( 'Bezpośrednie odnośniki: %s.', 'witryna' ), $structure ),
		'warning' => '' === $structure,
		'links'   => array(
			array(
				'url'   => admin_url( 'options-permalink.php' ),
				'label' => __( 'Ustawienia → Bezpośrednie odnośniki', 'witryna' ),
			),
		),
	);

	$privacy_id = (int) get_option( 'wp_page_for_privacy_policy' );
	$privacy    = $privacy_id > 0 ? get_post( $privacy_id ) : null;
	if ( ! $privacy || 'trash' === $privacy->post_status ) {
		$info[] = array(
			'text'    => __( 'Nie wybrano strony z polityką prywatności.', 'witryna' ),
			'warning' => true,
			'links'   => array(
				array(
					'url'   => admin_url( 'options-privacy.php' ),
					'label' => __( 'Ustawienia → Prywatność', 'witryna' ),
				),
			),
		);
	} elseif ( 'publish' !== $privacy->post_status ) {
		$info[] = array(
			/* translators: %s: page title. */
			'text'    => sprintf( __( 'Polityka prywatności („%s”) jest szkicem. Uzupełnij ją i opublikuj.', 'witryna' ), $privacy->post_title ),
			'warning' => true,
			'links'   => witryna_setup_post_links( $privacy ),
		);
	} else {
		$info[] = array(
			/* translators: %s: page title. */
			'text'    => sprintf( __( 'Polityka prywatności („%s”) jest opublikowana.', 'witryna' ), $privacy->post_title ),
			'warning' => false,
			'links'   => witryna_setup_post_links( $privacy ),
		);
	}

	if ( function_exists( 'wc_get_page_id' ) ) {
		$terms_id = (int) wc_get_page_id( 'terms' );
		if ( $terms_id <= 0 || 'publish' !== get_post_status( $terms_id ) ) {
			$info[] = array(
				'text'    => __( 'W WooCommerce nie wybrano opublikowanej strony z regulaminem, więc link „Regulamin” w stopce nigdzie nie prowadzi. Wybierz ją, gdy regulamin będzie gotowy.', 'witryna' ),
				'warning' => true,
				'links'   => array( witryna_setup_terms_setting_link() ),
			);
		}
	}

	// The footer links to these pages; the preview does not have them either.
	$footer_pages = array(
		'dostawa-i-platnosc'  => __( 'Dostawa i płatność', 'witryna' ),
		'zwroty-i-reklamacje' => __( 'Zwroty i reklamacje', 'witryna' ),
	);
	foreach ( $footer_pages as $slug => $title ) {
		$page = get_page_by_path( $slug );
		if ( ! $page || 'publish' !== $page->post_status ) {
			$info[] = array(
				/* translators: 1: page title, 2: address, e.g. /dostawa-i-platnosc/. */
				'text'    => sprintf( __( 'Stopka ma link do strony „%1$s” (%2$s), której nie ma lub która nie jest opublikowana. Utwórz i opublikuj stronę pod tym adresem albo zmień stopkę w Edytorze.', 'witryna' ), $title, witryna_setup_page_path( $slug ) ),
				'warning' => true,
				'links'   => array(
					array(
						'url'   => admin_url( 'post-new.php?post_type=page' ),
						'label' => __( 'Dodaj stronę', 'witryna' ),
					),
				),
			);
		}
	}

	return $info;
}

/**
 * Adds the screen to the Appearance menu.
 */
function witryna_store_setup_menu() {
	add_theme_page(
		__( 'Ustaw sklep jak w podglądzie', 'witryna' ),
		__( 'Ustaw sklep', 'witryna' ),
		'manage_options',
		'witryna-store-setup',
		'witryna_store_setup_render'
	);
}
add_action( 'admin_menu', 'witryna_store_setup_menu' );

/**
 * Returns the name of the transient with the last results of a user.
 *
 * @return string
 */
function witryna_store_setup_transient() {
	return 'witryna_store_setup_' . get_current_user_id();
}

/**
 * Prints links on a new line, separated by dots.
 *
 * @param array $links Links, each array{url: string, label: string}.
 */
function witryna_store_setup_print_links( $links ) {
	$first = true;
	foreach ( $links as $link ) {
		if ( empty( $link['url'] ) ) {
			continue;
		}
		echo $first ? '<br>' : ' · ';
		printf( '<a href="%1$s">%2$s</a>', esc_url( $link['url'] ), esc_html( $link['label'] ) );
		$first = false;
	}
}

/**
 * Prints the results of the last run.
 *
 * @param array[] $results Results.
 */
function witryna_store_setup_print_results( $results ) {
	$labels = array(
		'created' => array( __( 'Utworzono', 'witryna' ), 'dashicons-yes', '#008a20' ),
		'updated' => array( __( 'Zmieniono', 'witryna' ), 'dashicons-yes', '#008a20' ),
		'skipped' => array( __( 'Bez zmian', 'witryna' ), 'dashicons-minus', '#646970' ),
		'error'   => array( __( 'Błąd', 'witryna' ), 'dashicons-warning', '#d63638' ),
	);
	$errors = in_array( 'error', wp_list_pluck( $results, 'status' ), true );

	echo '<div class="notice ' . ( $errors ? 'notice-warning' : 'notice-success' ) . '">';
	echo '<p><strong>' . ( $errors ? esc_html__( 'Zakończono, ale nie wszystko się udało:', 'witryna' ) : esc_html__( 'Gotowe. Oto wynik:', 'witryna' ) ) . '</strong></p>';

	if ( ! $results ) {
		echo '<p>' . esc_html__( 'Nic nie było zaznaczone, więc nic się nie zmieniło.', 'witryna' ) . '</p></div>';
		return;
	}

	echo '<ul class="witryna-setup-results">';
	foreach ( $results as $result ) {
		$label = isset( $labels[ $result['status'] ] ) ? $labels[ $result['status'] ] : $labels['skipped'];
		printf(
			'<li><span class="dashicons %1$s" style="color:%2$s" aria-hidden="true"></span><span class="screen-reader-text">%3$s:</span> %4$s',
			esc_attr( $label[1] ),
			esc_attr( $label[2] ),
			esc_html( $label[0] ),
			esc_html( $result['message'] )
		);
		witryna_store_setup_print_links( $result['links'] );
		echo '</li>';
	}
	echo '</ul></div>';
}

/**
 * Prints the admin screen.
 */
function witryna_store_setup_render() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$results = get_transient( witryna_store_setup_transient() );
	if ( false !== $results ) {
		delete_transient( witryna_store_setup_transient() );
	}

	$rows     = witryna_setup_rows();
	$sections = array(
		'pages'    => __( 'Strony', 'witryna' ),
		'home'     => __( 'Strona główna i menu', 'witryna' ),
		'store'    => __( 'Dane sklepu', 'witryna' ),
		'optional' => __( 'Opcjonalnie', 'witryna' ),
	);
	$todo     = array_filter(
		$rows,
		static function ( $row ) {
			return 'todo' === $row['state'];
		}
	);
	$blocked  = array_filter(
		$rows,
		static function ( $row ) {
			return 'blocked' === $row['state'];
		}
	);

	echo '<div class="wrap">';
	echo '<h1>' . esc_html__( 'Ustaw sklep jak w podglądzie', 'witryna' ) . '</h1>';

	if ( is_array( $results ) ) {
		witryna_store_setup_print_results( $results );
	}

	echo '<p>' . esc_html__( 'To narzędzie uzupełnia sklep o to, co jest w podglądzie motywu: strony, menu, stronę główną i podstawowe dane sklepu. Niczego nie usuwa – przykładowe treści WordPressa przenosi do kosza tylko wtedy, gdy zaznaczysz ten krok. Zaznaczone są kroki, które dodają brakujące rzeczy albo zmieniają ustawienia różniące się od podglądu, więc przed kliknięciem porównaj kolumny „Co się stanie” i „Stan obecny”. Narzędzie możesz uruchomić ponownie: to, co jest gotowe, zostaje bez zmian.', 'witryna' ) . '</p>';

	// The submit button is disabled after the first click, so a double click
	// does not send the form twice (the handler also takes a lock).
	echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" onsubmit="var b=this.querySelector(\'[type=submit]\');if(b){b.disabled=true;}">';
	echo '<input type="hidden" name="action" value="witryna_store_setup">';
	wp_nonce_field( 'witryna_store_setup' );

	foreach ( $sections as $section => $title ) {
		$section_rows = array_filter(
			$rows,
			static function ( $row ) use ( $section ) {
				return $section === $row['section'];
			}
		);
		if ( ! $section_rows ) {
			continue;
		}

		echo '<h2>' . esc_html( $title ) . '</h2>';
		echo '<table class="widefat striped witryna-setup"><thead><tr>';
		echo '<td class="check-column"><span class="screen-reader-text">' . esc_html__( 'Wykonać?', 'witryna' ) . '</span></td>';
		echo '<th scope="col" style="width:20%">' . esc_html__( 'Krok', 'witryna' ) . '</th>';
		echo '<th scope="col" style="width:42%">' . esc_html__( 'Co się stanie', 'witryna' ) . '</th>';
		echo '<th scope="col">' . esc_html__( 'Stan obecny', 'witryna' ) . '</th>';
		echo '</tr></thead><tbody>';

		foreach ( $section_rows as $row ) {
			$input_id = 'witryna-setup-' . $row['field'] . '-' . $row['id'];

			echo '<tr><th scope="row" class="check-column">';
			if ( 'todo' === $row['state'] ) {
				printf(
					'<input type="checkbox" id="%1$s" name="%2$s[]" value="%3$s"%4$s>',
					esc_attr( $input_id ),
					esc_attr( $row['field'] ),
					esc_attr( $row['id'] ),
					checked( $row['checked'], true, false )
				);
			} elseif ( 'done' === $row['state'] ) {
				echo '<span class="dashicons dashicons-yes" style="color:#008a20" aria-hidden="true"></span>';
			} else {
				echo '<span class="dashicons dashicons-warning" style="color:#996800" aria-hidden="true"></span>';
			}
			echo '</th><td>';
			if ( 'todo' === $row['state'] ) {
				echo '<label for="' . esc_attr( $input_id ) . '"><strong>' . esc_html( $row['label'] ) . '</strong></label>';
			} else {
				echo '<strong>' . esc_html( $row['label'] ) . '</strong><br>';
				echo '<span class="description">' . ( 'done' === $row['state'] ? esc_html__( 'Gotowe', 'witryna' ) : esc_html__( 'Do zrobienia ręcznie', 'witryna' ) ) . '</span>';
			}
			echo '</td><td>';
			if ( 'todo' === $row['state'] ) {
				echo esc_html( $row['action'] );
				foreach ( $row['notes'] as $note ) {
					echo '<br><span class="description">' . esc_html( $note ) . '</span>';
				}
			} elseif ( 'blocked' === $row['state'] ) {
				echo '<span class="description">' . esc_html__( 'Narzędzie tego nie zmieni – zobacz obok, co możesz zrobić.', 'witryna' ) . '</span>';
			} else {
				echo '<span class="description">' . esc_html__( 'Nic do zrobienia.', 'witryna' ) . '</span>';
			}
			echo '</td><td>' . esc_html( $row['current'] );
			witryna_store_setup_print_links( $row['links'] );
			echo '</td></tr>';
		}

		echo '</tbody></table>';
	}

	echo '<h2>' . esc_html__( 'Bez zmian – do sprawdzenia', 'witryna' ) . '</h2><ul>';
	foreach ( witryna_setup_info() as $item ) {
		echo '<li><span class="dashicons ' . ( $item['warning'] ? 'dashicons-warning' : 'dashicons-info-outline' ) . '" aria-hidden="true"></span> ' . esc_html( $item['text'] );
		witryna_store_setup_print_links( $item['links'] );
		echo '</li>';
	}
	echo '</ul>';

	if ( $todo ) {
		submit_button( __( 'Zastosuj zaznaczone', 'witryna' ) );
	} elseif ( $blocked ) {
		echo '<p><strong>' . esc_html__( 'Narzędzie zrobiło już wszystko, co mogło. Kroki oznaczone „Do zrobienia ręcznie” wykonaj samodzielnie – podpowiedzi są w kolumnie „Stan obecny”.', 'witryna' ) . '</strong></p>';
	} else {
		echo '<p><strong>' . esc_html__( 'Wszystko jest już ustawione jak w podglądzie.', 'witryna' ) . '</strong></p>';
	}

	echo '</form></div>';
}

/**
 * Returns the sanitized list of values from a posted array of checkboxes.
 *
 * @param string $key Field name.
 * @return string[]
 */
function witryna_store_setup_posted( $key ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified in witryna_store_setup_handle().
	$values = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized below.

	if ( ! is_array( $values ) ) {
		return array();
	}

	return array_values( array_map( 'sanitize_key', array_filter( $values, 'is_string' ) ) );
}

/**
 * Applies the checked steps and goes back to the screen with the results.
 */
function witryna_store_setup_handle() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Nie masz uprawnień do zmiany ustawień sklepu.', 'witryna' ), '', array( 'response' => 403 ) );
	}

	check_admin_referer( 'witryna_store_setup' );

	// Two overlapping requests (a double click, a resent form) would both see
	// the pages and the menu as missing. The lock is a single INSERT IGNORE,
	// so only one request gets it.
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	if ( ! WP_Upgrader::create_lock( 'witryna_store_setup', 2 * MINUTE_IN_SECONDS ) ) {
		$results = array( witryna_setup_result( 'lock', 'error', __( 'Ustawianie sklepu już trwa (np. po podwójnym kliknięciu). Odczekaj chwilę i odśwież tę stronę.', 'witryna' ) ) );
	} else {
		try {
			$results = witryna_setup_apply( witryna_store_setup_posted( 'witryna_pages' ), witryna_store_setup_posted( 'witryna_steps' ) );
		} finally {
			WP_Upgrader::release_lock( 'witryna_store_setup' );
		}
	}
	set_transient( witryna_store_setup_transient(), $results, 10 * MINUTE_IN_SECONDS );

	wp_safe_redirect( admin_url( 'themes.php?page=witryna-store-setup' ) );
	exit;
}
add_action( 'admin_post_witryna_store_setup', 'witryna_store_setup_handle' );

/* ---------------------------------------------------------------------------
 * Admin notice on the Dashboard and Themes screens.
 * ------------------------------------------------------------------------ */

/**
 * Returns what is missing compared with the preview: pages with their own
 * layout and the main menu.
 *
 * A draft counts as present (the owner is working on it). A page in the
 * trash is named as such, because it has to be restored, not added.
 *
 * @return string[] Names of the missing parts.
 */
function witryna_setup_missing_parts() {
	$pages   = witryna_setup_pages();
	$missing = array();

	foreach ( witryna_setup_template_pages() as $slug ) {
		$state = witryna_setup_page_state( $slug )['state'];
		if ( 'trash' === $state ) {
			/* translators: %s: page title. */
			$missing[] = sprintf( __( '%s (w koszu)', 'witryna' ), $pages[ $slug ]['title'] );
		} elseif ( in_array( $state, array( 'missing', 'taken' ), true ) ) {
			$missing[] = $pages[ $slug ]['title'];
		}
	}

	if ( ! witryna_setup_own_menus() ) {
		$missing[] = __( 'menu główne', 'witryna' );
	}

	return $missing;
}

/**
 * Shows a notice when the shop lacks the pages or the menu of the preview.
 */
function witryna_store_setup_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) ) {
		return;
	}

	if ( get_user_meta( get_current_user_id(), 'witryna_store_setup_dismissed', true ) ) {
		return;
	}

	$missing = witryna_setup_missing_parts();
	if ( ! $missing ) {
		return;
	}

	printf(
		'<div class="notice notice-info"><p>%1$s</p><p><a class="button button-primary" href="%2$s">%3$s</a> <a class="button-link" href="%4$s">%5$s</a></p></div>',
		/* translators: %s: list of missing pages and the menu. */
		esc_html( sprintf( __( 'Motyw: w sklepie brakuje stron lub menu z podglądu (%s). Sprawdź i dodaj je na ekranie Wygląd → Ustaw sklep.', 'witryna' ), implode( ', ', $missing ) ) ),
		esc_url( admin_url( 'themes.php?page=witryna-store-setup' ) ),
		esc_html__( 'Ustaw sklep', 'witryna' ),
		esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=witryna_store_setup_dismiss' ), 'witryna_store_setup_dismiss' ) ),
		esc_html__( 'Nie pokazuj więcej', 'witryna' )
	);
}
add_action( 'admin_notices', 'witryna_store_setup_notice' );

/**
 * Hides the notice for the current user.
 */
function witryna_store_setup_dismiss() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Nie masz uprawnień do zmiany ustawień sklepu.', 'witryna' ), '', array( 'response' => 403 ) );
	}

	check_admin_referer( 'witryna_store_setup_dismiss' );
	update_user_meta( get_current_user_id(), 'witryna_store_setup_dismissed', 1 );

	$referer = wp_get_referer();
	wp_safe_redirect( $referer ? $referer : admin_url() );
	exit;
}
add_action( 'admin_post_witryna_store_setup_dismiss', 'witryna_store_setup_dismiss' );
