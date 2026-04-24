<?php
/**
 * Ticker bar — top of every page.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$items = get_field( 'bb_ticker', 'option' );
if ( ! $items && is_front_page() ) {
	$items = get_field( 'bb_ticker' );
}
$default = [
	'LIVE ROAST · BATCH 412 · ' . strtoupper( date( 'd M Y' ) ),
	'FREE SHIPPING OVER 75 USD · DISPATCHED FROM ZOUK MOSBEH',
	'EST. BEIRUT · SERVING 42 CAFÉS',
];
$list = $items ? array_filter( array_map( 'trim', explode( "\n", $items ) ) ) : $default;
?>
<div class="ticker">
	<?php foreach ( $list as $i => $line ) : ?>
		<span>
			<?php if ( $i === 0 ) : ?><span class="blink"></span><?php endif; ?>
			<?php echo esc_html( $line ); ?>
		</span>
	<?php endforeach; ?>
</div>
