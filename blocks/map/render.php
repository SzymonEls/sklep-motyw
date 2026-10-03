<?php
/**
 * Map block: Google Maps centred on the store (keyless embed).
 *
 * The map is always shown (the shop owner's choice): the browser connects to
 * Google when the page is opened, which the privacy policy should mention.
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
$witryna_route  = 'https://www.google.com/maps/dir/?' . http_build_query(
	array(
		'api'                  => 1,
		'destination'          => $witryna_query,
		'destination_place_id' => witryna_google_config()['place_id'],
	)
);
$witryna_wrapper = get_block_wrapper_attributes( array( 'class' => 'witryna-map' ) );
?>
<div <?php echo $witryna_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $witryna_editor ) : ?>
		<div class="witryna-map__placeholder">
			<p class="witryna-map__address"><strong><?php echo esc_html( witryna_store_info( 'name' ) ); ?></strong><br><?php echo esc_html( witryna_store_address() ); ?></p>
			<p><?php esc_html_e( 'Tu na stronie wyświetli się mapa Google.', 'witryna' ); ?></p>
		</div>
	<?php else : ?>
		<iframe class="witryna-map__frame" src="<?php echo esc_url( $witryna_embed ); ?>" title="<?php echo esc_attr( sprintf( /* translators: %s: store name. */ __( 'Mapa dojazdu: %s', 'witryna' ), witryna_store_info( 'name' ) ) ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
	<?php endif; ?>
	<p class="screen-reader-text"><?php echo esc_html( witryna_store_info( 'name' ) . ', ' . witryna_store_address() ); ?></p>
	<div class="wp-block-buttons witryna-map__links">
		<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( witryna_store_map_url() ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Otwórz w Mapach Google', 'witryna' ); ?></a></div>
		<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_route ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wyznacz trasę', 'witryna' ); ?></a></div>
	</div>
</div>
