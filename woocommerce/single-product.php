<?php
/**
 * Single Product — replaces WooCommerce's single-product.php.
 *
 * All categories (whole-bean, espresso machines, equipment) use THIS template.
 * The page adapts based on available ACF fields.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<?php while ( have_posts() ) : the_post(); wc_get_template_part( 'content', 'single-product' ); endwhile; ?>

<?php get_footer();
