<?php
/**
 * Custom Post Type: Journal (editorial content distinct from WP "posts").
 */
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', function () {
	register_post_type( 'bb_journal', [
		'label'         => __( 'Journal', 'ban-black' ),
		'labels'        => [
			'name'          => __( 'Journal', 'ban-black' ),
			'singular_name' => __( 'Journal Article', 'ban-black' ),
			'add_new_item'  => __( 'Add new article', 'ban-black' ),
			'edit_item'     => __( 'Edit article', 'ban-black' ),
			'all_items'     => __( 'All articles', 'ban-black' ),
			'menu_name'     => __( 'Journal', 'ban-black' ),
		],
		'public'        => true,
		'has_archive'   => 'journal',
		'rewrite'       => [ 'slug' => 'journal' ],
		'menu_icon'     => 'dashicons-book',
		'menu_position' => 20,
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'revisions' ],
		'show_in_rest'  => true,
	] );

	register_taxonomy( 'bb_journal_cat', [ 'bb_journal' ], [
		'label'        => __( 'Journal categories', 'ban-black' ),
		'public'       => true,
		'hierarchical' => true,
		'rewrite'      => [ 'slug' => 'journal/category' ],
		'show_in_rest' => true,
	] );
} );
