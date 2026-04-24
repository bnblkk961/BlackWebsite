<?php
/**
 * WooCommerce integration.
 *
 * Strategy: don't fight Woo. We unhook the default wrappers + components
 * and replace them with our own hooks so the shop / product pages use
 * the Ban Black typographic system.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// ------------------------------------------------------------------
// 1 · Strip default Woo wrappers, re-wrap with ours.
// ------------------------------------------------------------------
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', function () {
	echo '<main id="site-main" class="bb-woo-main">';
}, 10 );
add_action( 'woocommerce_after_main_content', function () {
	echo '</main>';
}, 10 );

// ------------------------------------------------------------------
// 2 · Shop / archive tweaks
// ------------------------------------------------------------------
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Our own shop header (editorial style) runs from archive-product.php instead.

// Set shop columns
add_filter( 'loop_shop_columns', function () { return 4; }, 10 );
add_filter( 'loop_shop_per_page', function () { return 24; }, 20 );

// ------------------------------------------------------------------
// 3 · Product loop item — hand full control to our content-product.php
// ------------------------------------------------------------------
remove_action( 'woocommerce_before_shop_loop_item',       'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title',        'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title',  'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item',        'woocommerce_template_loop_add_to_cart', 10 );

// ------------------------------------------------------------------
// 4 · Single product — kill Woo's default layout, we draw our own.
// ------------------------------------------------------------------
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

// Keep: title(5), price(10), excerpt(20), add_to_cart(30), meta(40), sharing(50)
// We re-theme these in /woocommerce/single-product/*.php overrides.

// Breadcrumb separator + styling (overridden in archive-product.php)
add_filter( 'woocommerce_breadcrumb_defaults', function ( $d ) {
	$d['delimiter']   = ' / ';
	$d['wrap_before'] = '<nav class="bb-breadcrumbs" aria-label="Breadcrumb">';
	$d['wrap_after']  = '</nav>';
	return $d;
} );

// ------------------------------------------------------------------
// 5 · Add-to-cart button copy
// ------------------------------------------------------------------
add_filter( 'woocommerce_product_single_add_to_cart_text', function () { return __( 'Take the bag', 'ban-black' ); } );
add_filter( 'woocommerce_product_add_to_cart_text',        function () { return __( '+ Bag',        'ban-black' ); } );

// ------------------------------------------------------------------
// 6 · Mini-cart count for nav pill — trigger fragments refresh
// ------------------------------------------------------------------
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	ob_start(); ?>
	<span class="cart-pip" data-cart-count><?php echo esc_html( bb_cart_count() ); ?></span>
	<?php
	$fragments['span.cart-pip'] = ob_get_clean();
	return $fragments;
} );

// ------------------------------------------------------------------
// 7 · ACF brew-spec fields appear on single product "meta" area.
// ------------------------------------------------------------------
add_action( 'woocommerce_single_product_summary', 'bb_render_product_brew_specs', 25 );
function bb_render_product_brew_specs() {
	$specs = [
		'bb_origin'   => __( 'Origin',   'ban-black' ),
		'bb_altitude' => __( 'Altitude', 'ban-black' ),
		'bb_process'  => __( 'Process',  'ban-black' ),
		'bb_roast'    => __( 'Roast',    'ban-black' ),
		'bb_notes'    => __( 'Notes',    'ban-black' ),
		'bb_weight'   => __( 'Weight',   'ban-black' ),
	];
	$out = [];
	foreach ( $specs as $k => $label ) {
		$v = bb_field( $k );
		if ( $v ) $out[ $label ] = $v;
	}
	if ( empty( $out ) ) return;
	echo '<ul class="bb-brew-specs">';
	foreach ( $out as $label => $v ) {
		printf(
			'<li><span class="tick">%s</span><strong>%s</strong></li>',
			esc_html( $label ), esc_html( $v )
		);
	}
	echo '</ul>';
}

// ------------------------------------------------------------------
// 8 · Shop sidebar filter (simple — real faceting via plugin later).
// ------------------------------------------------------------------
add_filter( 'woocommerce_get_image_size_thumbnail', function () {
	return [ 'width' => 800, 'height' => 800, 'crop' => 1 ];
} );
