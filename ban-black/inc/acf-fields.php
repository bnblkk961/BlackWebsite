<?php
/**
 * ACF field groups — registered in PHP as a *fallback* so the theme works
 * even without ACF Local JSON sync. If ACF is installed, these also sync
 * to /acf-json/ via the local-json feature (see acf-json/ directory).
 *
 * Groups:
 *  1. Coffee Bean Specs — attached to WooCommerce products in the "whole-bean" category.
 *  2. Journal Article   — attached to the bb_journal CPT.
 *  3. Home Modules      — attached to the Home page (front-page).
 *  4. About Page        — pillars, timeline, team.
 *  5. Wholesale Page    — services, stats, café wall.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Point ACF local-json to theme folder.
add_filter( 'acf/settings/save_json', function ( $path ) {
	$p = BB_DIR . '/acf-json';
	if ( ! file_exists( $p ) ) wp_mkdir_p( $p );
	return $p;
} );
add_filter( 'acf/settings/load_json', function ( $paths ) {
	$paths[] = BB_DIR . '/acf-json';
	return $paths;
} );

/**
 * PHP-registered field groups (fallback if JSON sync hasn't run).
 */
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

	// --- 1. Coffee Bean Specs (WooCommerce products) ---
	acf_add_local_field_group( [
		'key'      => 'group_bb_coffee_specs',
		'title'    => 'Coffee Specs',
		'fields'   => [
			[ 'key' => 'field_bb_origin',   'label' => 'Origin (region, country)', 'name' => 'bb_origin',   'type' => 'text' ],
			[ 'key' => 'field_bb_altitude', 'label' => 'Altitude',                 'name' => 'bb_altitude', 'type' => 'text', 'placeholder' => '1800m' ],
			[ 'key' => 'field_bb_process',  'label' => 'Process',                  'name' => 'bb_process',  'type' => 'select', 'choices' => [ 'Washed' => 'Washed', 'Natural' => 'Natural', 'Honey' => 'Honey', 'Anaerobic' => 'Anaerobic' ] ],
			[ 'key' => 'field_bb_roast',    'label' => 'Roast level',              'name' => 'bb_roast',    'type' => 'select', 'choices' => [ 'Light' => 'Light', 'Light-Medium' => 'Light-Medium', 'Medium' => 'Medium', 'Medium-Dark' => 'Medium-Dark', 'Dark' => 'Dark', 'Espresso' => 'Espresso' ] ],
			[ 'key' => 'field_bb_notes',    'label' => 'Tasting notes',            'name' => 'bb_notes',    'type' => 'text', 'placeholder' => 'Jasmine · Bergamot · Peach' ],
			[ 'key' => 'field_bb_weight',   'label' => 'Package weight',           'name' => 'bb_weight',   'type' => 'text', 'placeholder' => '250g' ],
			[ 'key' => 'field_bb_harvest',  'label' => 'Harvest date',             'name' => 'bb_harvest',  'type' => 'date_picker' ],
			[ 'key' => 'field_bb_story',    'label' => 'Origin story',             'name' => 'bb_story',    'type' => 'wysiwyg', 'tabs' => 'visual', 'toolbar' => 'basic' ],
		],
		'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'product' ] ] ],
		'position' => 'normal',
		'style'    => 'default',
	] );

	// --- 2. Journal Article ---
	acf_add_local_field_group( [
		'key'      => 'group_bb_journal',
		'title'    => 'Journal Meta',
		'fields'   => [
			[ 'key' => 'field_bb_jrnl_kicker',  'label' => 'Kicker', 'name' => 'bb_kicker', 'type' => 'text', 'placeholder' => 'Field Notes' ],
			[ 'key' => 'field_bb_jrnl_read',    'label' => 'Read time (min)', 'name' => 'bb_read_time', 'type' => 'number', 'default_value' => 4 ],
			[ 'key' => 'field_bb_jrnl_pullq',   'label' => 'Pull quote', 'name' => 'bb_pull_quote', 'type' => 'textarea', 'rows' => 3 ],
		],
		'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'bb_journal' ] ] ],
	] );

	// --- 3. Home Modules ---
	acf_add_local_field_group( [
		'key'      => 'group_bb_home',
		'title'    => 'Home Modules',
		'fields'   => [
			[ 'key' => 'field_bb_hero_title',  'label' => 'Hero title (HTML)',   'name' => 'bb_hero_title',  'type' => 'textarea', 'rows' => 3, 'default_value' => "<span class='ar'>بان</span><br>Black,<br>and <em>only black.</em>" ],
			[ 'key' => 'field_bb_hero_lede',   'label' => 'Hero lede',           'name' => 'bb_hero_lede',   'type' => 'textarea', 'rows' => 3 ],
			[ 'key' => 'field_bb_hero_img',    'label' => 'Hero image',          'name' => 'bb_hero_img',    'type' => 'image', 'return_format' => 'id', 'preview_size' => 'medium' ],
			[ 'key' => 'field_bb_reserve',     'label' => 'Featured reserve product', 'name' => 'bb_reserve_product', 'type' => 'post_object', 'post_type' => [ 'product' ], 'return_format' => 'id' ],
			[ 'key' => 'field_bb_ticker',      'label' => 'Ticker items (one per line)', 'name' => 'bb_ticker', 'type' => 'textarea', 'rows' => 4 ],
			[ 'key' => 'field_bb_marquee',     'label' => 'Marquee phrases (one per line)', 'name' => 'bb_marquee', 'type' => 'textarea', 'rows' => 4 ],
		],
		'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
	] );

	// --- 4. About Page ---
	acf_add_local_field_group( [
		'key'      => 'group_bb_about',
		'title'    => 'About Page',
		'fields'   => [
			[ 'key' => 'field_bb_about_pillars', 'label' => 'Manifesto pillars', 'name' => 'bb_pillars', 'type' => 'repeater', 'layout' => 'block', 'sub_fields' => [
				[ 'key' => 'field_bb_pillar_num',   'label' => 'Number', 'name' => 'num',   'type' => 'text' ],
				[ 'key' => 'field_bb_pillar_title', 'label' => 'Title',  'name' => 'title', 'type' => 'text' ],
				[ 'key' => 'field_bb_pillar_body',  'label' => 'Body',   'name' => 'body',  'type' => 'textarea', 'rows' => 3 ],
			] ],
			[ 'key' => 'field_bb_about_timeline', 'label' => 'Timeline', 'name' => 'bb_timeline', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => [
				[ 'key' => 'field_bb_tl_year', 'label' => 'Year',  'name' => 'year',  'type' => 'text' ],
				[ 'key' => 'field_bb_tl_body', 'label' => 'Event', 'name' => 'body',  'type' => 'textarea', 'rows' => 2 ],
			] ],
			[ 'key' => 'field_bb_about_team', 'label' => 'Team', 'name' => 'bb_team', 'type' => 'repeater', 'layout' => 'row', 'sub_fields' => [
				[ 'key' => 'field_bb_team_name',  'label' => 'Name',  'name' => 'name',  'type' => 'text' ],
				[ 'key' => 'field_bb_team_role',  'label' => 'Role',  'name' => 'role',  'type' => 'text' ],
				[ 'key' => 'field_bb_team_photo', 'label' => 'Photo', 'name' => 'photo', 'type' => 'image', 'return_format' => 'id' ],
			] ],
		],
		'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ] ] ],
	] );

	// --- 5. Wholesale Page ---
	acf_add_local_field_group( [
		'key'      => 'group_bb_wholesale',
		'title'    => 'Wholesale Page',
		'fields'   => [
			[ 'key' => 'field_bb_ws_services', 'label' => 'Services', 'name' => 'bb_services', 'type' => 'repeater', 'layout' => 'block', 'sub_fields' => [
				[ 'key' => 'field_bb_svc_num',   'label' => 'Number', 'name' => 'num', 'type' => 'text' ],
				[ 'key' => 'field_bb_svc_title', 'label' => 'Title',  'name' => 'title', 'type' => 'text' ],
				[ 'key' => 'field_bb_svc_body',  'label' => 'Body',   'name' => 'body', 'type' => 'textarea', 'rows' => 3 ],
			] ],
			[ 'key' => 'field_bb_ws_stats', 'label' => 'Stats', 'name' => 'bb_stats', 'type' => 'repeater', 'layout' => 'table', 'sub_fields' => [
				[ 'key' => 'field_bb_stat_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text' ],
				[ 'key' => 'field_bb_stat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ],
			] ],
			[ 'key' => 'field_bb_ws_cafes', 'label' => 'Partner cafés', 'name' => 'bb_cafes', 'type' => 'repeater', 'layout' => 'row', 'sub_fields' => [
				[ 'key' => 'field_bb_cafe_name', 'label' => 'Name',    'name' => 'name',  'type' => 'text' ],
				[ 'key' => 'field_bb_cafe_city', 'label' => 'City',    'name' => 'city',  'type' => 'text' ],
				[ 'key' => 'field_bb_cafe_year', 'label' => 'Year',    'name' => 'year',  'type' => 'text' ],
				[ 'key' => 'field_bb_cafe_img',  'label' => 'Photo',   'name' => 'photo', 'type' => 'image', 'return_format' => 'id' ],
			] ],
		],
		'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-wholesale.php' ] ] ],
	] );

} );
