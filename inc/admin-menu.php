<?php
/**
 * Simpler admin menu for the shop owner.
 *
 * Shop first, then the rest of WordPress:
 *
 *   Kokpit, Zamówienia, Produkty, Przesyłki (InPost), Klienci, Kupony,
 *   Statystyki, Inne treści (Strony, Wpisy, Media, Komentarze),
 *   Ustawienia (shop settings first, then the WordPress ones)
 *   ──────────
 *   WooCommerce, Marketing, Wygląd, Wtyczki, Użytkownicy, Narzędzia and
 *   whatever other plugins add.
 *
 * The menu is rearranged only right before it is printed (admin_head).
 * WordPress decides who may open a plugin screen by looking the screen up in
 * the menu, so moving items earlier (in admin_menu) would lock those screens.
 * Moved items link to the same URLs as before, so every screen still works,
 * and the filters below keep the right item highlighted.
 *
 * @package Witryna
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the URL WordPress gives a menu item, relative to wp-admin.
 *
 * Mirrors _wp_menu_output(): plugin screens become admin.php?page=… (or
 * parent.php?page=… under a core screen), everything else is the slug itself.
 *
 * @param string $slug   Item slug ($menu[][2] or $submenu[][][2]).
 * @param string $parent Parent slug, 'admin.php' for top-level items.
 * @return string
 */
function witryna_menu_url( $slug, $parent = 'admin.php' ) {
	if ( false !== strpos( $slug, '://' ) ) {
		return $slug;
	}

	$file = strtok( $slug, '?' );
	if ( get_plugin_page_hook( $slug, $parent ) || ( 'index.php' !== $slug && file_exists( WP_PLUGIN_DIR . "/$file" ) && ! file_exists( ABSPATH . "wp-admin/$file" ) ) ) {
		$parent_file = strtok( $parent, '?' );
		if ( 'admin.php' !== $parent_file && file_exists( ABSPATH . "wp-admin/$parent_file" ) ) {
			return add_query_arg( 'page', $slug, $parent );
		}
		return 'admin.php?page=' . $slug;
	}

	return $slug;
}

/**
 * Splits an admin URL into its file and query arguments.
 *
 * @param string $url URL relative to wp-admin.
 * @return array{0: string, 1: array<string, string>}
 */
function witryna_menu_parse( $url ) {
	$parts = explode( '?', $url, 2 );
	$args  = array();
	if ( isset( $parts[1] ) ) {
		parse_str( html_entity_decode( $parts[1] ), $args );
	}
	unset( $args['from'], $args['return'] );

	return array( $parts[0], $args );
}

/**
 * Normalised key of an admin URL, used to find menu items by their URL.
 *
 * @param string $url URL relative to wp-admin.
 * @return string
 */
function witryna_menu_key( $url ) {
	list( $file, $args ) = witryna_menu_parse( $url );
	ksort( $args );

	return $args ? $file . '?' . http_build_query( $args ) : $file;
}

/**
 * Rearranges the admin menu (see the file comment).
 */
function witryna_admin_menu_rearrange() {
	global $menu, $submenu;

	if ( empty( $menu ) || ! is_array( $menu ) ) {
		return;
	}

	$state = array(
		'map'     => array(), // Old parent slug => array( new parent, new item URL ).
		'entries' => array(), // New item URL => new parent slug.
		'paths'   => array(), // WooCommerce app path => id of the top-level item.
	);

	// Index the current menu by URL.
	$tops = array();
	foreach ( $menu as $position => $item ) {
		if ( empty( $item[2] ) || ( isset( $item[4] ) && false !== strpos( $item[4], 'wp-menu-separator' ) ) ) {
			continue;
		}
		$first           = empty( $submenu[ $item[2] ] ) ? null : reset( $submenu[ $item[2] ] );
		$url             = $first ? witryna_menu_url( $first[2], $item[2] ) : witryna_menu_url( $item[2] );
		$tops[ $position ] = witryna_menu_key( $url );
	}

	// Takes a submenu item out of the menu: array( item, URL, old parent ) or null.
	$take_sub = static function ( $url ) use ( &$submenu ) {
		$key = witryna_menu_key( $url );
		foreach ( (array) $submenu as $parent => $items ) {
			foreach ( (array) $items as $i => $item ) {
				$item_url = witryna_menu_url( $item[2], $parent );
				if ( witryna_menu_key( $item_url ) === $key ) {
					unset( $submenu[ $parent ][ $i ] );
					return array( $item, $item_url, $parent, $item[2] );
				}
			}
		}
		return null;
	};

	// Finds a top-level item by the URL it links to: position or null.
	$find_top = static function ( $url ) use ( &$tops ) {
		$position = array_search( witryna_menu_key( $url ), $tops, true );
		return false === $position ? null : $position;
	};

	// Finds the top-level item that has a submenu item with this URL.
	$find_parent_of = static function ( $url ) use ( &$menu, &$submenu ) {
		$key = witryna_menu_key( $url );
		foreach ( $menu as $position => $item ) {
			foreach ( isset( $submenu[ $item[2] ] ) ? (array) $submenu[ $item[2] ] : array() as $sub ) {
				if ( witryna_menu_key( witryna_menu_url( $sub[2], $item[2] ) ) === $key ) {
					return $position;
				}
			}
		}
		return null;
	};

	$remove_top = static function ( $position ) use ( &$menu, &$submenu, &$tops ) {
		if ( null === $position || ! isset( $menu[ $position ] ) ) {
			return;
		}
		unset( $submenu[ $menu[ $position ][2] ], $menu[ $position ], $tops[ $position ] );
	};

	$woo = class_exists( 'WooCommerce' );

	// Top-level items of the shop part, in order.
	$shop = array();

	$dashboard = $find_top( 'index.php' );
	if ( null !== $dashboard ) {
		$shop[] = $menu[ $dashboard ];
		unset( $menu[ $dashboard ], $tops[ $dashboard ] );
	}

	// Zamówienia, out of WooCommerce.
	$orders = $take_sub( 'admin.php?page=wc-orders' );
	if ( ! $orders ) {
		$orders = $take_sub( 'edit.php?post_type=shop_order' );
	}
	if ( $orders ) {
		$shop[] = array( $orders[0][0], $orders[0][1], $orders[1], __( 'Zamówienia', 'witryna' ), 'menu-top', 'witryna-orders', 'dashicons-cart' );
		$state['entries'][ $orders[1] ] = $orders[1];
		$state['map'][ $orders[2] . '|' . $orders[3] ] = array( $orders[1], $orders[1] );
	}

	$products = $find_top( 'edit.php?post_type=product' );
	if ( null !== $products ) {
		$shop[] = $menu[ $products ];
		unset( $menu[ $products ], $tops[ $products ] );
	}

	// Przesyłki InPost: the shipment list on its own, settings go to Ustawienia.
	$inpost_top = $find_parent_of( 'admin.php?page=easypack_shipment' );
	$shipments  = $take_sub( 'admin.php?page=easypack_shipment' );
	if ( $shipments ) {
		$icon   = null !== $inpost_top && ! empty( $menu[ $inpost_top ][6] ) ? $menu[ $inpost_top ][6] : 'dashicons-archive';
		$shop[] = array( __( 'Przesyłki', 'witryna' ), $shipments[0][1], $shipments[1], $shipments[0][3] ?? __( 'Przesyłki', 'witryna' ), 'menu-top', 'witryna-shipments', $icon );
		$state['entries'][ $shipments[1] ] = $shipments[1];
	}

	// Klienci, out of WooCommerce.
	$customers = $take_sub( 'admin.php?page=wc-admin&path=/customers' );
	if ( $customers ) {
		$shop[] = array( $customers[0][0], $customers[0][1], $customers[1], $customers[0][3] ?? $customers[0][0], 'menu-top', 'witryna-customers', 'dashicons-groups' );
		$state['entries'][ $customers[1] ] = $customers[1];
		$state['paths']['/customers']      = 'witryna-customers';
	}

	// Kupony: one item instead of two (WooCommerce and Marketing).
	$coupons = $take_sub( 'edit.php?post_type=shop_coupon' );
	$take_sub( 'admin.php?page=coupons-moved' );
	if ( $coupons ) {
		$shop[] = array( __( 'Kupony', 'witryna' ), $coupons[0][1], $coupons[1], __( 'Kupony', 'witryna' ), 'menu-top', 'witryna-coupons', 'dashicons-tickets-alt' );
		$state['entries'][ $coupons[1] ] = $coupons[1];
	}

	// Statystyki: WooCommerce Analytics, only the reports a shop owner reads.
	$analytics = $find_top( 'admin.php?page=wc-admin&path=/analytics/overview' );
	if ( null !== $analytics ) {
		$item    = $menu[ $analytics ];
		$item[0] = __( 'Statystyki', 'witryna' );
		$keep    = array( '/analytics/overview', '/analytics/revenue', '/analytics/products', '/analytics/stock' );
		foreach ( isset( $submenu[ $item[2] ] ) ? $submenu[ $item[2] ] : array() as $i => $sub ) {
			list( , $args ) = witryna_menu_parse( witryna_menu_url( $sub[2], $item[2] ) );
			if ( ! isset( $args['path'] ) || ! in_array( $args['path'], $keep, true ) ) {
				unset( $submenu[ $item[2] ][ $i ] );
			}
		}
		$shop[] = $item;
		unset( $menu[ $analytics ], $tops[ $analytics ] );
	}

	// Inne treści: Strony, Wpisy, Media, Komentarze.
	$content = array();
	foreach ( array( 'edit.php?post_type=page', 'edit.php', 'upload.php', 'edit-comments.php' ) as $url ) {
		$position = $find_top( $url );
		if ( null === $position ) {
			continue;
		}
		$item      = $menu[ $position ];
		$content[] = array( $item[0], $item[1], $url, $item[3] );
		$state['map'][ $item[2] . '|' ] = array( 'witryna-content', $url );
		$state['entries'][ $url ]       = 'witryna-content';
		$remove_top( $position );
	}
	if ( $content ) {
		$submenu['witryna-content'] = $content; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$shop[] = array( __( 'Inne treści', 'witryna' ), 'edit_posts', 'witryna-content', __( 'Inne treści', 'witryna' ), 'menu-top', 'witryna-content', 'dashicons-admin-page' );
	}

	// Ustawienia: the shop first, then WordPress.
	$settings = array();
	$setup    = null;
	foreach ( isset( $submenu['options-general.php'] ) ? $submenu['options-general.php'] : array() as $i => $sub ) {
		if ( 'witryna-store-setup' === $sub[2] ) {
			$setup = $sub;
			unset( $submenu['options-general.php'][ $i ] );
		}
	}
	if ( $setup ) {
		$settings[] = $setup;
	}
	if ( $woo ) {
		$payments = $find_top( 'admin.php?page=wc-settings&tab=checkout' );
		$remove_top( $payments );

		$shop_settings = array(
			array( __( 'Płatności', 'witryna' ), 'admin.php?page=wc-settings&tab=checkout', null ),
			array( __( 'PayU', 'witryna' ), 'admin.php?page=payu-settings', 'admin.php?page=payu-settings' ),
			array( __( 'Wysyłka', 'witryna' ), 'admin.php?page=wc-settings&tab=shipping', null ),
			array( __( 'InPost', 'witryna' ), 'admin.php?page=wc-settings&tab=easypack_general', 'admin.php?page=wc-settings&tab=easypack_general' ),
			array( __( 'InPost – produkty', 'witryna' ), 'admin.php?page=easypack_product_settings', 'admin.php?page=easypack_product_settings' ),
			array( __( 'WooCommerce', 'witryna' ), 'admin.php?page=wc-settings', 'admin.php?page=wc-settings' ),
		);
		foreach ( $shop_settings as $row ) {
			list( $title, $url, $existing ) = $row;
			$capability                     = 'manage_woocommerce';
			if ( $existing ) {
				$found = $take_sub( $existing );
				if ( ! $found ) {
					continue; // The plugin is not active.
				}
				$capability = $found[0][1];
			}
			$settings[]                 = array( $title, $capability, $url, $title );
			$state['entries'][ $url ] = 'options-general.php';
		}
	}
	if ( isset( $submenu['options-general.php'] ) ) {
		$settings = array_merge( $settings, array_values( $submenu['options-general.php'] ) );
	}
	$general = $find_top( 'options-general.php' );
	if ( $settings ) {
		$submenu['options-general.php'] = $settings; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		if ( null !== $general ) {
			$shop[] = $menu[ $general ];
			unset( $menu[ $general ], $tops[ $general ] );
		} else {
			$shop[] = array( __( 'Ustawienia', 'witryna' ), 'manage_options', 'options-general.php', __( 'Ustawienia', 'witryna' ), 'menu-top menu-icon-settings', 'menu-settings', 'dashicons-admin-settings' );
		}
	}

	// InPost is empty now, Marketing may be.
	if ( null !== $inpost_top && empty( $submenu[ $menu[ $inpost_top ][2] ] ) ) {
		$remove_top( $inpost_top );
	}
	foreach ( $menu as $position => $item ) {
		if ( isset( $submenu[ $item[2] ] ) && empty( $submenu[ $item[2] ] ) ) {
			$remove_top( $position );
		}
	}

	// The rest (WooCommerce, Wygląd, Wtyczki…) below a separator, in its old order.
	ksort( $menu );
	$rest = array();
	foreach ( $menu as $item ) {
		if ( isset( $item[4] ) && false !== strpos( $item[4], 'wp-menu-separator' ) ) {
			continue;
		}
		$rest[] = $item;
	}

	$new = array();
	foreach ( $shop as $item ) {
		$new[] = $item;
	}
	if ( $rest ) {
		$new[] = array( '', 'read', 'separator-witryna', '', 'wp-menu-separator' );
		foreach ( $rest as $item ) {
			$new[] = $item;
		}
	}
	$new[] = array( '', 'read', 'separator-last', '', 'wp-menu-separator' );

	$menu = array(); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	foreach ( $new as $i => $item ) {
		if ( isset( $item[4] ) ) {
			$item[4] = trim( str_replace( array( 'menu-top-first', 'menu-top-last' ), '', $item[4] ) );
		}
		$menu[ ( $i + 1 ) * 5 ] = $item;
	}
	if ( function_exists( 'add_menu_classes' ) ) {
		$menu = add_menu_classes( $menu ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	}

	$GLOBALS['witryna_admin_menu'] = $state;
}
add_action( 'admin_head', 'witryna_admin_menu_rearrange', 9999 );

/**
 * Finds the moved menu item of the current screen.
 *
 * @param string|null $parent_file  Parent WordPress picked for the screen.
 * @param string|null $submenu_file Submenu item WordPress picked.
 * @return array{0: string, 1: string}|null New parent slug and item URL.
 */
function witryna_admin_menu_current( $parent_file = null, $submenu_file = null ) {
	static $current = false;

	if ( false !== $current ) {
		return $current;
	}
	if ( empty( $GLOBALS['witryna_admin_menu'] ) ) {
		return null;
	}

	$state = $GLOBALS['witryna_admin_menu'];
	$file  = isset( $GLOBALS['pagenow'] ) ? $GLOBALS['pagenow'] : '';
	$query = wp_unslash( $_GET ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$best  = null;
	$score = -1;

	// The item whose URL matches this screen most closely.
	foreach ( $state['entries'] as $url => $parent ) {
		list( $entry_file, $args ) = witryna_menu_parse( $url );
		if ( $entry_file !== $file ) {
			continue;
		}
		if ( in_array( $file, array( 'edit.php', 'post-new.php' ), true ) ) {
			$wanted = isset( $args['post_type'] ) ? $args['post_type'] : 'post';
			$have   = isset( $query['post_type'] ) ? $query['post_type'] : 'post';
			if ( $wanted !== $have ) {
				continue;
			}
		}
		foreach ( $args as $name => $value ) {
			if ( ! isset( $query[ $name ] ) || (string) $query[ $name ] !== (string) $value ) {
				continue 2;
			}
		}
		if ( count( $args ) > $score ) {
			$best  = array( $parent, $url );
			$score = count( $args );
		}
	}

	// Screens without their own item (editing a post, a category…).
	if ( ! $best && $parent_file ) {
		$parent_key = (string) $parent_file . '|';
		$sub_key    = (string) $parent_file . '|' . (string) $submenu_file;
		if ( isset( $state['map'][ $sub_key ] ) ) {
			$best = $state['map'][ $sub_key ];
		} elseif ( $submenu_file && isset( $state['entries'][ $submenu_file ] ) ) {
			$best = array( $state['entries'][ $submenu_file ], $submenu_file );
		} elseif ( isset( $state['map'][ $parent_key ] ) ) {
			$best = $state['map'][ $parent_key ];
		}
	}

	$current = $best;
	return $current;
}

/**
 * Opens the new parent of a moved screen.
 *
 * @param string $parent_file Parent slug.
 * @return string
 */
function witryna_admin_menu_parent_file( $parent_file ) {
	global $submenu_file;

	$current = witryna_admin_menu_current( $parent_file, $submenu_file );
	return $current ? $current[0] : $parent_file;
}
add_filter( 'parent_file', 'witryna_admin_menu_parent_file', 9999 );

/**
 * Highlights the moved item of the current screen.
 *
 * @param string|null $submenu_file Submenu slug.
 * @return string|null
 */
function witryna_admin_menu_submenu_file( $submenu_file ) {
	$current = witryna_admin_menu_current();
	return $current ? $current[1] : $submenu_file;
}
add_filter( 'submenu_file', 'witryna_admin_menu_submenu_file', 9999 );

/**
 * Styles of the rearranged menu.
 */
function witryna_admin_menu_styles() {
	?>
	<style id="witryna-admin-menu">
		#adminmenu #menu-settings .wp-submenu li:has(> a[href="options-general.php"]) {
			margin-top: 6px;
			padding-top: 6px;
			border-top: 1px solid rgba(240, 246, 252, 0.15);
		}
	</style>
	<?php
}
add_action( 'admin_head', 'witryna_admin_menu_styles' );

/**
 * Keeps moved WooCommerce app screens (Klienci) highlighted.
 *
 * WooCommerce re-highlights the menu in the browser on its app screens
 * (window.wpNavMenuClassChange) and opens the WooCommerce menu for Klienci.
 * This wraps that function as soon as WooCommerce defines it, so it opens
 * the moved item instead.
 */
function witryna_admin_menu_wc_script() {
	if ( empty( $GLOBALS['witryna_admin_menu']['paths'] ) || ! isset( $_GET['page'] ) || 'wc-admin' !== $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return;
	}
	?>
	<script id="witryna-admin-menu-js">
		( function () {
			var paths = <?php echo wp_json_encode( $GLOBALS['witryna_admin_menu']['paths'] ); ?>;
			var wrapped;
			Object.defineProperty( window, 'wpNavMenuClassChange', {
				configurable: true,
				get: function () {
					return wrapped;
				},
				set: function ( original ) {
					wrapped = typeof original !== 'function' ? original : function ( page, url ) {
						if ( page && paths[ url ] ) {
							page = Object.assign( {}, page, { wpOpenMenu: paths[ url ] } );
						}
						return original.call( this, page, url );
					};
				},
			} );
		} )();
	</script>
	<?php
}
add_action( 'admin_head', 'witryna_admin_menu_wc_script', 10000 );
