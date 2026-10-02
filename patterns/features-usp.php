<?php
/**
 * Title: Store benefits
 * Slug: witryna/features-usp
 * Categories: witryna-shop, featured
 * Keywords: benefits, dealer, service, pickup, advice, trust
 * Viewport Width: 1400
 * Description: Four short benefits with icons: authorised STIHL dealer, own service, in-store pickup and expert advice.
 *
 * @package Witryna
 */

$witryna_benefits = array(
	array(
		'icon'  => 'witryna/shield',
		'title' => __( 'Autoryzowany dealer STIHL', 'witryna' ),
		'text'  => __( 'Oryginalny sprzęt, części i gwarancja producenta', 'witryna' ),
	),
	array(
		'icon'  => 'witryna/wrench',
		'title' => __( 'Własny serwis', 'witryna' ),
		'text'  => __( 'Przeglądy i naprawy na miejscu w Czernicy', 'witryna' ),
	),
	array(
		'icon'  => 'witryna/store',
		'title' => __( 'Odbiór osobisty', 'witryna' ),
		'text'  => __( 'Zamów online i odbierz sprzęt gotowy do pracy', 'witryna' ),
	),
	array(
		'icon'  => 'witryna/chat',
		'title' => __( 'Fachowe doradztwo', 'witryna' ),
		'text'  => __( 'Dobierzemy sprzęt do Twojego ogrodu i budżetu', 'witryna' ),
	),
);?>
<!-- wp:group {"align":"full","className":"witryna-usp","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|line","width":"1px"},"bottom":{"color":"var:preset|color|line","width":"1px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull witryna-usp" style="border-top-color:var(--wp--preset--color--line);border-top-width:1px;border-bottom-color:var(--wp--preset--color--line);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":4,"minimumColumnWidth":"14rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_benefits as $witryna_benefit ) : ?>
<!-- wp:group {"style":{"spacing":{"blockGap":"0.9rem"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group"><!-- wp:icon {"icon":"<?php echo esc_attr( $witryna_benefit['icon'] ); ?>","className":"witryna-usp__icon","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.15rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3,"fontSize":"medium"} -->
<h3 class="wp-block-heading has-medium-font-size"><?php echo esc_html( $witryna_benefit['title'] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_benefit['text'] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
