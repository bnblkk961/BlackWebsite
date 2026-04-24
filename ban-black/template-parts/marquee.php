<?php
/**
 * Marquee — scrolling typographic strip.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$items = get_field( 'bb_marquee' );
$default = [ 'SPECIALTY COFFEE', '<em>since 2014</em>', 'ROASTED IN ZOUK MOSBEH', 'SHIPPED BLACK' ];
$list = $items ? array_filter( array_map( 'trim', explode( "\n", $items ) ) ) : $default;
?>
<div class="marquee">
	<div class="marquee-track">
		<?php for ( $i = 0; $i < 2; $i++ ) : foreach ( $list as $phrase ) : ?>
			<span><?php echo wp_kses_post( $phrase ); ?></span>
			<span class="dot">◉</span>
		<?php endforeach; endfor; ?>
	</div>
</div>
