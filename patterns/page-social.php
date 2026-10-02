<?php
/**
 * Title: Social media page
 * Slug: witryna/page-social
 * Categories: witryna-pages
 * Keywords: social media, tiktok, video, follow
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: Social media page centred on the store's TikTok profile, with an embedded feed, follow button and a Google review invitation.
 *
 * @package Witryna
 */

$witryna_info = witryna_store_info();
?>
<!-- wp:group {"align":"full","className":"is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'Social media', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Zobacz nas na TikToku', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"large"} -->
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Pokazujemy sprzęt w akcji: nowości STIHL, kulisy serwisu, naprawy krok po kroku i szybkie porady, jak dbać o kosiarkę, pilarkę i trawnik. Zajrzyj, zanim przyjedziesz do sklepu.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_info['tiktok'] ); ?>" target="_blank" rel="noreferrer noopener"><?php echo esc_html( sprintf( /* translators: %s: TikTok account name. */ __( 'Obserwuj %s', 'witryna' ), $witryna_info['tiktok_name'] ) ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:embed {"url":"<?php echo esc_url( $witryna_info['tiktok'] ); ?>","type":"rich","providerNameSlug":"tiktok","responsive":true,"className":"witryna-tiktok__embed"} -->
<figure class="wp-block-embed is-type-rich is-provider-tiktok wp-block-embed-tiktok witryna-tiktok__embed"><div class="wp-block-embed__wrapper">
<?php echo esc_url( $witryna_info['tiktok'] ); ?>

</div></figure>
<!-- /wp:embed -->

<!-- wp:group {"className":"is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card"><!-- wp:heading {"level":2,"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Zostaw opinię', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Twoja opinia pomaga innym znaleźć dobry sklep i serwis w okolicy, a nam pokazuje, co robimy dobrze.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-arrow"} -->
<div class="wp-block-button is-style-arrow"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_info['google'] ? $witryna_info['google'] : witryna_page_url( 'opinie' ) ); ?>"><?php esc_html_e( 'Przejdź do opinii', 'witryna' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
