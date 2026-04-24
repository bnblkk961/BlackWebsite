<?php
/**
 * Enqueues — CSS + JS loaded per page type.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function () {

	$v = BB_VERSION;

	// ---- Fonts (fallback — prefer OMGF / self-hosted in production) ----
	wp_enqueue_style(
		'bb-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,800;0,900;1,900&family=Roboto:wght@100;300;400;500;700;900&family=Roboto+Mono:wght@300;400;500&family=Noto+Naskh+Arabic:wght@500;700&display=swap',
		[], null
	);

	// ---- Global shared styles (always) ----
	wp_enqueue_style( 'bb-shared', BB_URI . '/assets/css/shared.css', [], $v );

	// ---- Page-specific styles ----
	if ( is_front_page() ) {
		wp_enqueue_style( 'bb-home', BB_URI . '/assets/css/home.css', [ 'bb-shared' ], $v );
	}
	if ( is_shop() || is_product_category() || is_product_tag() ) {
		wp_enqueue_style( 'bb-shop', BB_URI . '/assets/css/shop.css', [ 'bb-shared' ], $v );
	}
	if ( is_product() ) {
		wp_enqueue_style( 'bb-product', BB_URI . '/assets/css/product.css', [ 'bb-shared' ], $v );
	}
	if ( is_page_template( 'page-about.php' ) || is_page( 'about' ) ) {
		wp_enqueue_style( 'bb-about', BB_URI . '/assets/css/about.css', [ 'bb-shared' ], $v );
	}
	if ( is_page_template( 'page-wholesale.php' ) || is_page( 'wholesale' ) ) {
		wp_enqueue_style( 'bb-wholesale', BB_URI . '/assets/css/wholesale.css', [ 'bb-shared' ], $v );
	}
	if ( is_singular( 'bb_journal' ) || is_post_type_archive( 'bb_journal' ) || is_tax( 'bb_journal_cat' ) || is_home() ) {
		wp_enqueue_style( 'bb-journal', BB_URI . '/assets/css/journal.css', [ 'bb-shared' ], $v );
	}

	// WP requires the child-theme-registering style.css
	wp_enqueue_style( 'bb-style', get_stylesheet_uri(), [], $v );

	// ---- JS ----
	wp_enqueue_script( 'bb-shared', BB_URI . '/assets/js/shared.js', [], $v, true );

}, 20 );

/**
 * Preconnect to Google Fonts (or swap for self-hosted origin).
 */
add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );

/**
 * Defer our JS for better Core Web Vitals.
 */
add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	if ( in_array( $handle, [ 'bb-shared' ], true ) ) {
		return str_replace( ' src', ' defer src', $tag );
	}
	return $tag;
}, 10, 2 );
