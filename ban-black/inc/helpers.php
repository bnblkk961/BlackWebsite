<?php
/**
 * Small helpers used across templates.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Placeholder block — used anywhere we don't yet have imagery.
 * Swap once real images are uploaded.
 */
function bb_placeholder( $label = 'Photo', $idx = '', $light = false ) {
	$cls = 'ph' . ( $light ? ' light' : '' );
	$idx = $idx ?: 'PH';
	return sprintf(
		'<div class="%1$s" data-label="%2$s"><span class="ph-idx">%3$s</span></div>',
		esc_attr( $cls ),
		esc_attr( $label ),
		esc_attr( strtoupper( $idx ) )
	);
}

/**
 * Render featured image or a placeholder if missing.
 */
function bb_thumbnail_or_placeholder( $post_id = null, $size = 'bb-product-card', $label = 'Photo', $light = false ) {
	$post_id = $post_id ?: get_the_ID();
	if ( has_post_thumbnail( $post_id ) ) {
		echo get_the_post_thumbnail( $post_id, $size, [ 'class' => 'bb-img' ] );
		return;
	}
	echo bb_placeholder( $label, 'BB-' . $post_id, $light );
}

/**
 * Arabic + Latin wordmark — reusable.
 */
function bb_logo() {
	?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" aria-label="Ban Black">
		<img src="<?php echo esc_url( BB_LOGO_WHITE ); ?>" alt="Ban Black" height="36" style="height:36px;width:auto;display:block;">
	</a>
	<?php
}

/**
 * Current cart count for pill in nav.
 */
function bb_cart_count() {
	if ( function_exists( 'WC' ) && WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/**
 * Pull an ACF field with a fallback.
 */
function bb_field( $key, $post_id = null, $fallback = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$v = get_field( $key, $post_id );
		if ( ! empty( $v ) ) return $v;
	}
	return $fallback;
}

/**
 * Short SVG arrow used in buttons.
 */
function bb_arrow() {
	echo '<span class="arr" aria-hidden="true">→</span>';
}
