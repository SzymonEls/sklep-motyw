<?php
/**
 * Map block: Google Maps centred on the store (keyless embed).
 *
 * The map is loaded by assets/js/google-reviews.js after a click, or right
 * away when automatic loading of Google content is allowed in the Customizer
 * (Opinie Google), because the browser then connects to Google.
 *
 * @package Witryna
 *
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$witryna_zoom   = max( 3, min( 20, (int) ( $attributes['zoom'] ?? 16 ) ) );
$witryna_editor = defined( 'REST_REQUEST' ) && REST_REQUEST;
$witryna_query  = witryna_store_info( 'google_name' ) . ', ' . witryna_store_address();
$witryna_embed  = 'https://maps.google.com/maps?' . http_build_query(
	array(
		'q'      => $witryna_query,
		'z'      => $witryna_zoom,
		'hl'     => 'pl',
		'output' => 'embed',
	)
);
$witryna_auto   = witryna_google_config()['autoload'];
$witryna_route  = 'https://www.google.com/maps/dir/?' . http_build_query(
	array(
		'api'                  => 1,
		'destination'          => $witryna_query,
		'destination_place_id' => witryna_google_config()['place_id'],
	)
);
$witryna_privacy = get_privacy_policy_url();

if ( ! $witryna_editor ) {
	wp_enqueue_script( 'witryna-google-reviews' );
}

$witryna_wrapper = get_block_wrapper_attributes( array( 'class' => 'witryna-map' ) );
?>
<div <?php echo $witryna_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="witryna-greviews witryna-map__box"
		<?php if ( ! $witryna_editor ) : ?>
		data-embed="<?php echo esc_url( $witryna_embed ); ?>"
		data-map-title="<?php echo esc_attr( sprintf( /* translators: %s: store name. */ __( 'Mapa dojazdu: %s', 'witryna' ), witryna_store_info( 'name' ) ) ); ?>"
		data-autoload="<?php echo $witryna_auto ? '1' : '0'; ?>"
		<?php endif; ?>
	>
		<div class="witryna-greviews__slot"></div>
		<p class="screen-reader-text witryna-greviews__status" role="status" aria-live="polite"
			data-loading="<?php esc_attr_e( 'Wczytywanie mapy…', 'witryna' ); ?>"
			data-failed="<?php esc_attr_e( 'Nie udało się wczytać mapy.', 'witryna' ); ?>"></p>

		<div class="witryna-map__placeholder witryna-greviews__fallback">
			<p class="witryna-map__address"><strong><?php echo esc_html( witryna_store_info( 'name' ) ); ?></strong><br><?php echo esc_html( witryna_store_address() ); ?></p>
			<?php if ( ! $witryna_auto && ! $witryna_editor ) : ?>
				<div class="witryna-greviews__consent">
					<button type="button" class="wp-element-button witryna-greviews__load"><?php esc_html_e( 'Pokaż mapę', 'witryna' ); ?></button>
					<p class="witryna-greviews__note">
						<?php esc_html_e( 'Po kliknięciu Twoja przeglądarka połączy się z serwerami Google (Mapy Google), które otrzymają m.in. Twój adres IP. Szczegóły w polityce prywatności.', 'witryna' ); ?>
						<?php if ( $witryna_privacy ) : ?>
							<a href="<?php echo esc_url( $witryna_privacy ); ?>"><?php esc_html_e( 'Polityka prywatności', 'witryna' ); ?></a>
						<?php endif; ?>
					</p>
				</div>
			<?php endif; ?>
		</div>
		<div class="wp-block-buttons witryna-map__links">
			<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( witryna_store_map_url() ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Otwórz w Mapach Google', 'witryna' ); ?></a></div>
			<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_route ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wyznacz trasę', 'witryna' ); ?></a></div>
		</div>
	</div>
</div>
