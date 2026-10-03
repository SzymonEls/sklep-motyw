<?php
/**
 * Reviews block: Google reviews and shop reviews.
 *
 * Google reviews are shown by Google's Place Details element in the browser
 * (assets/js/google-reviews.js). The shop never downloads or stores them and
 * does not filter them. Shop reviews are rendered here, newest first, with
 * any rating.
 *
 * @package Witryna
 *
 * @var array $attributes Block attributes.
 */

defined( 'ABSPATH' ) || exit;

$witryna_variant  = isset( $attributes['variant'] ) && 'home' === $attributes['variant'] ? 'home' : 'page';
$witryna_count    = max( 1, min( 50, (int) ( $attributes['shopCount'] ?? 20 ) ) );
$witryna_reviews  = witryna_store_reviews( $witryna_count );
$witryna_google   = witryna_google_config();
$witryna_has_key  = $witryna_google['key'] && $witryna_google['place_id'];
// Without an API key Google allows no review texts, only its map card with
// the rating and the number of reviews (the keyless Maps embed).
$witryna_embed    = $witryna_has_key ? '' : add_query_arg( array( 'hl' => 'pl', 'output' => 'embed' ), witryna_store_info( 'google' ) );
$witryna_active   = ( $witryna_has_key || $witryna_embed ) && ! ( defined( 'REST_REQUEST' ) && REST_REQUEST );
$witryna_editor   = defined( 'REST_REQUEST' ) && REST_REQUEST;
$witryna_maps_url = witryna_store_info( 'google' );
$witryna_write    = witryna_google_review_url();
$witryna_verified = 'yes' === get_option( 'woocommerce_review_rating_verification_required' );
$witryna_privacy  = get_privacy_policy_url();

if ( $witryna_active ) {
	wp_enqueue_script( 'witryna-google-reviews' );
}

$witryna_wrapper = get_block_wrapper_attributes( array( 'class' => 'witryna-reviews witryna-reviews--' . $witryna_variant ) );
?>
<div <?php echo $witryna_wrapper; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( 'page' === $witryna_variant ) : ?>
		<p class="witryna-reviews__intro"><?php esc_html_e( 'Najpierw pokazujemy opinie z Google (wybór i kolejność ustala Google), a pod nimi opinie z naszego sklepu internetowego, od najnowszych. Nie filtrujemy opinii według oceny.', 'witryna' ); ?></p>
	<?php endif; ?>

	<section class="witryna-reviews__google" aria-labelledby="witryna-reviews-google-<?php echo esc_attr( $witryna_variant ); ?>">
		<h3 class="witryna-reviews__heading" id="witryna-reviews-google-<?php echo esc_attr( $witryna_variant ); ?>" tabindex="-1"><?php esc_html_e( 'Opinie z Google', 'witryna' ); ?></h3>

		<?php if ( $witryna_editor && $witryna_has_key ) : ?>
			<p class="witryna-reviews__placeholder"><?php esc_html_e( 'Tu na stronie pojawią się opinie z Google, wczytane bezpośrednio przez Google.', 'witryna' ); ?></p>
		<?php endif; ?>

		<div class="witryna-greviews"
			<?php if ( $witryna_active && $witryna_embed ) : ?>
			data-embed="<?php echo esc_url( $witryna_embed ); ?>"
			data-map-title="<?php esc_attr_e( "Klinika Trawnika w Mapach Google: ocena i opinie", "witryna" ); ?>"
			data-autoload="<?php echo $witryna_google['autoload'] ? '1' : '0'; ?>"
			<?php endif; ?>
			<?php if ( $witryna_has_key && ! $witryna_editor ) : ?>
			data-key="<?php echo esc_attr( $witryna_google['key'] ); ?>"
			data-place="<?php echo esc_attr( $witryna_google['place_id'] ); ?>"
			data-autoload="<?php echo $witryna_google['autoload'] ? '1' : '0'; ?>"
			data-admin="<?php echo $witryna_google['is_admin'] ? '1' : '0'; ?>"
			<?php endif; ?>
		>
			<div class="witryna-greviews__slot"></div>
			<p class="screen-reader-text witryna-greviews__status" role="status" aria-live="polite"
				data-loading="<?php esc_attr_e( 'Wczytywanie opinii z Google…', 'witryna' ); ?>"
				data-failed="<?php esc_attr_e( 'Nie udało się wczytać opinii z Google. Skorzystaj z linków do Map Google.', 'witryna' ); ?>"></p>
			<p class="witryna-greviews__loading" aria-hidden="true"><?php esc_html_e( 'Wczytywanie opinii z Google…', 'witryna' ); ?></p>

			<div class="witryna-greviews__fallback">
				<p class="witryna-greviews__fallback-text"><?php esc_html_e( 'Opinie o nas przeczytasz w Mapach Google.', 'witryna' ); ?></p>
				<div class="wp-block-buttons">
					<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_maps_url ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Przeczytaj opinie w Google', 'witryna' ); ?></a></div>
					<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_write ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wystaw opinię w Google', 'witryna' ); ?></a></div>
				</div>
			</div>

			<?php if ( $witryna_active && ! $witryna_google['autoload'] ) : ?>
				<div class="witryna-greviews__consent">
					<button type="button" class="wp-element-button witryna-greviews__load"><?php echo esc_html( $witryna_embed ? __( 'Pokaż ocenę w Mapach Google', 'witryna' ) : __( 'Pokaż opinie z Google', 'witryna' ) ); ?></button>
					<p class="witryna-greviews__note">
						<?php esc_html_e( 'Po kliknięciu Twoja przeglądarka połączy się z serwerami Google (Mapy Google), które otrzymają m.in. Twój adres IP. Szczegóły w polityce prywatności.', 'witryna' ); ?>
						<?php if ( $witryna_privacy ) : ?>
							<a href="<?php echo esc_url( $witryna_privacy ); ?>"><?php esc_html_e( 'Polityka prywatności', 'witryna' ); ?></a>
						<?php endif; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ( $witryna_embed && $witryna_google['is_admin'] && ! $witryna_editor ) : ?>
				<p class="witryna-greviews__admin"><?php esc_html_e( 'Widać tylko ocenę z Map Google. Aby pokazać tu treść opinii, wklej klucz API Google w Wygląd → Dostosuj → Opinie Google. Ten komunikat widzą tylko administratorzy.', 'witryna' ); ?></p>
			<?php endif; ?>

			<?php if ( $witryna_has_key && $witryna_google['is_admin'] && ! $witryna_editor ) : ?>
				<p class="witryna-greviews__admin" hidden><?php esc_html_e( 'Nie udało się wczytać opinii z Google. Sprawdź klucz API, Place ID i limity w Google Cloud. Ten komunikat widzą tylko administratorzy.', 'witryna' ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( 'page' === $witryna_variant ) : ?>
			<div class="witryna-reviews__info" id="jak-weryfikujemy">
				<p><?php esc_html_e( 'Opinie z Google pochodzą z naszej wizytówki w Mapach Google. Nie sprawdzamy, czy ich autorzy kupili u nas sprzęt lub korzystali z serwisu. To Google wybiera, które opinie tu widać, i ustala ich kolejność. My ich nie filtrujemy, nie zmieniamy i nie ukrywamy negatywnych.', 'witryna' ); ?></p>
				<p>
					<a href="<?php echo esc_url( $witryna_maps_url ); ?>" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Wszystkie opinie w Mapach Google', 'witryna' ); ?></a>
					·
					<a href="https://support.google.com/contributionpolicy/answer/7422880?hl=pl" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Jak Google sprawdza opinie', 'witryna' ); ?></a>
				</p>
			</div>
		<?php endif; ?>
	</section>

	<section class="witryna-reviews__shop" aria-labelledby="witryna-reviews-shop-<?php echo esc_attr( $witryna_variant ); ?>">
		<h3 class="witryna-reviews__heading" id="witryna-reviews-shop-<?php echo esc_attr( $witryna_variant ); ?>"><?php esc_html_e( 'Opinie z naszego sklepu internetowego', 'witryna' ); ?></h3>

		<?php if ( $witryna_reviews ) : ?>
			<ul class="witryna-reviews__list">
				<?php foreach ( $witryna_reviews as $witryna_review ) : ?>
					<?php
					$witryna_words = preg_split( '/[\n\r\t ]+/', wp_strip_all_tags( $witryna_review['text'] ), -1, PREG_SPLIT_NO_EMPTY );
					$witryna_long  = count( $witryna_words ) > 40;
					?>
					<li class="witryna-review">
						<?php if ( $witryna_review['rating'] > 0 ) : ?>
							<p class="witryna-stars" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: rating. */ __( 'Ocena %d na 5', 'witryna' ), $witryna_review['rating'] ) ); ?>"><?php echo esc_html( witryna_stars( $witryna_review['rating'] ) ); ?></p>
						<?php endif; ?>
						<p class="witryna-review__text">
							<?php echo esc_html( $witryna_long ? wp_trim_words( $witryna_review['text'], 40 ) : $witryna_review['text'] ); ?>
							<?php if ( $witryna_long ) : ?>
								<a href="<?php echo esc_url( $witryna_review['link'] ); ?>"><?php esc_html_e( 'Czytaj całość', 'witryna' ); ?></a>
							<?php endif; ?>
						</p>
						<p class="witryna-review__meta">
							<strong><?php echo esc_html( $witryna_review['author'] ); ?></strong>
							<?php if ( $witryna_review['verified'] ) : ?>
								<span class="witryna-review__badge"><?php esc_html_e( 'Zweryfikowany zakup', 'witryna' ); ?></span>
							<?php endif; ?>
							<span><?php echo esc_html( $witryna_review['product'] . ' · ' . $witryna_review['date'] ); ?></span>
						</p>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="witryna-reviews__empty"><?php esc_html_e( 'W sklepie internetowym nie ma jeszcze opinii. Po zakupie możesz ocenić produkt na jego stronie.', 'witryna' ); ?></p>
		<?php endif; ?>

		<?php if ( 'page' === $witryna_variant ) : ?>
			<p class="witryna-reviews__info">
				<?php
				if ( $witryna_verified ) {
					esc_html_e( 'Opinie ze sklepu internetowego weryfikujemy: produkt może ocenić tylko klient, który kupił go w naszym sklepie. Sprawdzamy to automatycznie na podstawie zamówień. Publikujemy opinie pozytywne i negatywne, a odrzucamy tylko spam i treści niezgodne z prawem.', 'witryna' );
				} else {
					esc_html_e( 'Opinii ze sklepu internetowego nie weryfikujemy pod kątem zakupu. Oznaczenie „Zweryfikowany zakup” widnieje tylko przy opiniach klientów, u których znaleźliśmy zamówienie danego produktu. Publikujemy opinie pozytywne i negatywne, a odrzucamy tylko spam i treści niezgodne z prawem.', 'witryna' );
				}
				?>
			</p>
		<?php endif; ?>
	</section>

	<?php if ( 'home' === $witryna_variant ) : ?>
		<p class="witryna-reviews__info witryna-reviews__info--home">
			<?php esc_html_e( 'Opinie z Google wybiera i porządkuje Google. Nie sprawdzamy, czy ich autorzy są naszymi klientami. Opinie ze sklepu pokazujemy bez filtrowania ocen.', 'witryna' ); ?>
			<a href="<?php echo esc_url( witryna_page_url( 'opinie' ) . '#jak-weryfikujemy' ); ?>"><?php esc_html_e( 'Jak weryfikujemy opinie', 'witryna' ); ?></a>
		</p>
	<?php endif; ?>
</div>
