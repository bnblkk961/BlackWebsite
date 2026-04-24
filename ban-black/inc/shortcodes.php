<?php
/**
 * Shortcodes — for the ticker, marquee, etc. so editors can drop them in anywhere.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// [bb_ticker]
add_shortcode( 'bb_ticker', function () {
	ob_start();
	get_template_part( 'template-parts/ticker' );
	return ob_get_clean();
} );

// [bb_marquee]
add_shortcode( 'bb_marquee', function () {
	ob_start();
	get_template_part( 'template-parts/marquee' );
	return ob_get_clean();
} );

// [bb_product_grid category="whole-bean" limit="8"]
add_shortcode( 'bb_product_grid', function ( $atts ) {
	$a = shortcode_atts( [ 'category' => '', 'limit' => 8, 'orderby' => 'date' ], $atts );
	$args = [
		'post_type'      => 'product',
		'posts_per_page' => (int) $a['limit'],
		'orderby'        => $a['orderby'],
	];
	if ( $a['category'] ) {
		$args['tax_query'] = [ [
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => array_map( 'trim', explode( ',', $a['category'] ) ),
		] ];
	}
	$q = new WP_Query( $args );
	ob_start();
	echo '<div class="prod-grid">';
	while ( $q->have_posts() ) { $q->the_post();
		get_template_part( 'template-parts/product-card' );
	}
	echo '</div>';
	wp_reset_postdata();
	return ob_get_clean();
} );
