<?php
/**
 * Ban Black — theme bootstrap
 *
 * All real logic lives in /inc/*.php. This file only loads them.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'BB_VERSION', '1.0.4' );

// Use __DIR__ for absolute path (more reliable than get_template_directory)
define( 'BB_DIR', __DIR__ );
define( 'BB_URI', get_template_directory_uri() );

// Load config first — all images, URLs and settings live here
require_once BB_DIR . '/inc/config.php';

// Safely require files with existence checks
$files = array(
	'/inc/setup.php',
	'/inc/enqueue.php',
	'/inc/helpers.php',
	'/inc/woocommerce.php',
	'/inc/acf-fields.php',
	'/inc/cpt-journal.php',
	'/inc/shortcodes.php'
);

foreach ( $files as $file ) {
	$file_path = BB_DIR . $file;
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	} else {
		// Log error but don't crash
		error_log( 'Ban Black: Missing file ' . $file_path );
	}
}
