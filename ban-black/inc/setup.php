<?php
/**
 * Theme setup — supports, menus, image sizes.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', function () {

	load_theme_textdomain( 'ban-black', BB_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', [
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
	] );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-logo', [
		'height' => 40, 'width' => 120, 'flex-height' => true, 'flex-width' => true,
	] );

	// WooCommerce
	add_theme_support( 'woocommerce', [
		'product_grid' => [
			'default_rows'    => 3,
			'min_rows'        => 1,
			'default_columns' => 4,
			'min_columns'     => 2,
			'max_columns'     => 6,
		],
	] );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Image sizes used across the site
	add_image_size( 'bb-product-card', 800, 800, true );
	add_image_size( 'bb-product-hero', 1600, 1600, false );
	add_image_size( 'bb-journal-card', 1200, 750, true );
	add_image_size( 'bb-hero', 2400, 1600, true );
	add_image_size( 'bb-category', 1200, 900, true );

	// Menus
	register_nav_menus( [
		'primary' => __( 'Primary (top-left links)', 'ban-black' ),
		'footer-shop'   => __( 'Footer · Shop', 'ban-black' ),
		'footer-inside' => __( 'Footer · Inside', 'ban-black' ),
		'footer-help'   => __( 'Footer · Help', 'ban-black' ),
	] );

} );

/**
 * Register sidebar for footer newsletter (optional).
 */
add_action( 'widgets_init', function () {
	register_sidebar( [
		'name'          => __( 'Footer · Newsletter', 'ban-black' ),
		'id'            => 'footer-newsletter',
		'description'   => __( 'Appears in the far-right footer column.', 'ban-black' ),
		'before_widget' => '<div class="footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	] );
} );

/**
 * Slim the wp_head output (remove junk we don't need).
 */
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
