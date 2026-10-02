<?php
/**
 * Title: Service page
 * Slug: witryna/page-service
 * Categories: witryna-pages
 * Keywords: service, repair, workshop, maintenance, stihl
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport Width: 1400
 * Description: Service page: intro with call to action, equipment serviced, scope of work, how a repair works and a service request section with phone and a pre-filled e-mail.
 *
 * @package Witryna
 */

$witryna_info = witryna_store_info();

$witryna_equipment = array(
	array( __( 'Kosiarki', 'witryna' ), __( 'Spalinowe, akumulatorowe i elektryczne', 'witryna' ) ),
	array( __( 'Traktorki ogrodowe', 'witryna' ), __( 'Przeglądy, noże, paski i układ napędowy', 'witryna' ) ),
	array( __( 'Pilarki łańcuchowe', 'witryna' ), __( 'Ostrzenie, regulacja i naprawy silnika', 'witryna' ) ),
	array( __( 'Kosy i podkaszarki', 'witryna' ), __( 'Głowice, wały, sprzęgła i gaźniki', 'witryna' ) ),
	array( __( 'Nożyce i dmuchawy', 'witryna' ), __( 'Ostrzenie listew i przeglądy silników', 'witryna' ) ),
	array( __( 'Glebogryzarki', 'witryna' ), __( 'Przygotowanie do sezonu i naprawy', 'witryna' ) ),
);

$witryna_scope = array(
	__( 'Przegląd sezonowy: olej, filtr powietrza, świeca, ostrzenie noża, regulacja', 'witryna' ),
	__( 'Ostrzenie łańcuchów i noży', 'witryna' ),
	__( 'Naprawy silników spalinowych', 'witryna' ),
	__( 'Diagnostyka sprzętu akumulatorowego', 'witryna' ),
	__( 'Wymiana części na oryginalne', 'witryna' ),
	__( 'Przygotowanie sprzętu do zimy i do sezonu', 'witryna' ),
);

$witryna_mail_subject = __( 'Zgłoszenie serwisowe', 'witryna' );
$witryna_mail_body    = __( "Imię i nazwisko:\nTelefon:\nRodzaj sprzętu:\nMarka i model:\nOpis usterki:\nCzy potrzebny odbiór sprzętu (tak/nie):\nAdres odbioru:\n", 'witryna' );
$witryna_mail_href    = 'mailto:' . $witryna_info['email'] . '?subject=' . rawurlencode( $witryna_mail_subject ) . '&body=' . rawurlencode( $witryna_mail_body );
?>
<!-- wp:group {"align":"full","className":"is-style-section-dark","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-dark" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px","justifyContent":"left"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow witryna-hero__eyebrow"} -->
<p class="is-style-eyebrow witryna-hero__eyebrow"><?php esc_html_e( 'Serwis sprzętu ogrodowego', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"display"} -->
<h1 class="wp-block-heading has-display-font-size"><?php esc_html_e( 'Serwis kosiarek, pilarek i kos w Czernicy', 'witryna' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"witryna-soft","fontSize":"large"} -->
<p class="witryna-soft has-large-font-size"><?php esc_html_e( 'Regularny przegląd to najtańszy sposób, żeby sprzęt działał długo i bez niespodzianek. Zajmujemy się wszystkim, od wymiany oleju po naprawę silnika.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#zgloszenie"><?php esc_html_e( 'Zgłoś sprzęt do serwisu', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( $witryna_info['phone_href'] ); ?>"><?php echo esc_html( sprintf( /* translators: %s: phone number. */ __( 'Zadzwoń: %s', 'witryna' ), $witryna_info['phone'] ) ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Co serwisujemy', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'STIHL i sprzęt innych producentów', 'witryna' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"16rem"}} -->
<div class="wp-block-group alignwide">
<?php foreach ( $witryna_equipment as $witryna_item ) : ?>
<!-- wp:group {"className":"is-style-card witryna-service-card","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card witryna-service-card"><!-- wp:icon {"icon":"witryna/wrench","className":"witryna-usp__icon","style":{"dimensions":{"width":"28px"}}} /-->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $witryna_item[0] ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_item[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|50","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Zakres usług', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Od przeglądu po naprawę silnika', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"is-style-checklist"} -->
<ul class="wp-block-list is-style-checklist">
<?php foreach ( $witryna_scope as $witryna_line ) : ?>
<!-- wp:list-item -->
<li><?php echo esc_html( $witryna_line ); ?></li>
<!-- /wp:list-item -->
<?php endforeach; ?>
</ul>
<!-- /wp:list -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php esc_html_e( 'Ostateczną cenę podajemy po diagnozie, zanim zaczniemy naprawę. Przeglądy najlepiej zlecać zimą lub wczesną wiosną: w sezonie czas oczekiwania jest dłuższy.', 'witryna' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:group {"className":"witryna-steps is-style-card","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"backgroundColor":"base","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group witryna-steps is-style-card has-base-background-color has-background"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Jak to działa', 'witryna' ); ?></h3>
<!-- /wp:heading -->

<?php
$witryna_steps = array(
	array( __( 'Zgłoś sprzęt', 'witryna' ), __( 'Zadzwoń albo wyślij zgłoszenie poniżej.', 'witryna' ) ),
	array( __( 'Przywieź lub umów odbiór', 'witryna' ), __( 'W okolicy Czernicy możemy odebrać sprzęt od Ciebie.', 'witryna' ) ),
	array( __( 'Wycena przed naprawą', 'witryna' ), __( 'Po diagnozie dzwonimy z ceną. Naprawiamy po Twojej zgodzie.', 'witryna' ) ),
	array( __( 'Odbierz sprawny sprzęt', 'witryna' ), __( 'Odbierasz go u nas albo go odwozimy.', 'witryna' ) ),
);
foreach ( $witryna_steps as $witryna_index => $witryna_step ) :
	?>
<!-- wp:group {"className":"witryna-step","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group witryna-step"><!-- wp:paragraph {"className":"witryna-step__number"} -->
<p class="witryna-step__number"><?php echo esc_html( $witryna_index + 1 ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"0.15rem"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":4,"fontSize":"medium"} -->
<h4 class="wp-block-heading has-medium-font-size"><?php echo esc_html( $witryna_step[0] ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted","fontSize":"small"} -->
<p class="has-muted-color has-text-color has-small-font-size"><?php echo esc_html( $witryna_step[1] ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<?php endforeach; ?>
</div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"zgloszenie","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"760px"}} -->
<div id="zgloszenie" class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow"><?php esc_html_e( 'Zgłoszenie serwisowe', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Zgłoś sprzęt do serwisu', 'witryna' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php esc_html_e( 'Podaj rodzaj sprzętu, markę i model oraz krótko opisz usterkę. Oddzwonimy, żeby ustalić termin i ewentualny odbiór.', 'witryna' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $witryna_mail_href, array( 'mailto' ) ); ?>"><?php esc_html_e( 'Wyślij zgłoszenie e-mailem', 'witryna' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="tel:<?php echo esc_attr( $witryna_info['phone_href'] ); ?>"><?php echo esc_html( sprintf( /* translators: %s: phone number. */ __( 'Zadzwoń: %s', 'witryna' ), $witryna_info['phone'] ) ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
