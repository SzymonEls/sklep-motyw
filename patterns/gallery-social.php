<?php
/**
 * Title: TikTok section
 * Slug: witryna/gallery-social
 * Categories: gallery, call-to-action
 * Keywords: tiktok, social, video, community
 * Viewport Width: 1400
 * Description: Dark section inviting visitors to the store's TikTok profile, with an embedded profile feed next to a follow button.
 *
 * @package Witryna
 */

$witryna_tiktok = witryna_store_info( 'tiktok' );
?>
<!-- wp:group {"align":"full","className":"witryna-social witryna-tiktok is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-social witryna-tiktok is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'TikTok', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Zobacz sprzęt w akcji', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft"} -->
<p class="witryna-soft"><?php esc_html_e( 'Na TikToku pokazujemy nowości STIHL, kulisy serwisu, naprawy krok po kroku i szybkie porady, jak dbać o kosiarkę, pilarkę i trawnik.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_tiktok ); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html( sprintf( /* translators: %s: TikTok account name. */ __( 'Obserwuj %s', 'witryna' ), witryna_store_info( 'tiktok_name' ) ) ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:embed {"url":"<?php echo esc_url( $witryna_tiktok ); ?>","type":"rich","providerNameSlug":"tiktok","responsive":true,"className":"witryna-tiktok__embed"} -->
<figure class="wp-block-embed is-type-rich is-provider-tiktok wp-block-embed-tiktok witryna-tiktok__embed"><div class="wp-block-embed__wrapper">
<?php echo esc_url( $witryna_tiktok ); ?>

</div></figure>
<!-- /wp:embed --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
