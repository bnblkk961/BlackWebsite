<?php
/**
 * The markup of a single product page.
 *
 * Category-aware: shows brew specs if it's a coffee bean;
 * shows tech specs (via product attributes) if it's a machine.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
global $product;

$cats        = wp_get_post_terms( $product->get_id(), 'product_cat', [ 'fields' => 'slugs' ] );
$is_coffee   = in_array( 'whole-bean', $cats, true ) || in_array( 'coffee', $cats, true );
$is_machine  = in_array( 'machines', $cats, true ) || in_array( 'espresso-machines', $cats, true );
$sku         = $product->get_sku() ?: 'BB-' . $product->get_id();
?>

<main id="site-main" class="bb-product" <?php wc_product_class( '', $product ); ?>>

	<?php woocommerce_breadcrumb(); ?>

	<section class="prod-top">

		<!-- GALLERY -->
		<div class="prod-gallery">
			<?php
			do_action( 'woocommerce_before_single_product_summary' );
			// ^ runs: product images gallery (big + thumbnails via wc-product-gallery)
			?>
		</div>

		<!-- SUMMARY -->
		<div class="prod-summary">
			<span class="eyebrow">§ <?php echo esc_html( wc_get_product_category_list( $product->get_id(), ' · ' ) ); ?> · SKU <?php echo esc_html( $sku ); ?></span>

			<h1 class="prod-title"><?php the_title(); ?></h1>

			<?php if ( $product->get_short_description() ) : ?>
				<div class="prod-short"><?php echo wp_kses_post( $product->get_short_description() ); ?></div>
			<?php endif; ?>

			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *  - price  (10)
			 *  - excerpt (20)
			 *  - bb_brew_specs (25)   ← added by our integration
			 *  - add_to_cart (30)
			 *  - meta (40)
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>

			<div class="prod-reassure">
				<div><span class="tick">Freshness</span><strong>Roasted to order</strong></div>
				<div><span class="tick">Shipping</span><strong>Next-day dispatch</strong></div>
				<div><span class="tick">Returns</span><strong>14 days, no questions</strong></div>
			</div>
		</div>
	</section>

	<!-- ORIGIN STORY (coffee only) -->
	<?php $story = bb_field( 'bb_story' ); if ( $is_coffee && $story ) : ?>
	<section class="prod-story inverted">
		<div class="section-head">
			<span class="num">§ Origin</span>
			<h2>The<br><em>story in the bag.</em></h2>
		</div>
		<div class="prod-story-body"><?php echo wp_kses_post( $story ); ?></div>
	</section>
	<?php endif; ?>

	<!-- FULL DESCRIPTION / TABS -->
	<section class="prod-details">
		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *  - description (10)
		 *  - additional_information_tab (20)
		 *  - reviews (30)
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</section>

	<!-- RELATED -->
	<section class="prod-related">
		<div class="section-head">
			<span class="num">§ Keep going</span>
			<h2>Also<br><em>black.</em></h2>
		</div>
		<?php
		$related_ids = wc_get_related_products( $product->get_id(), 4 );
		if ( $related_ids ) :
			$rq = new WP_Query( [ 'post_type' => 'product', 'post__in' => $related_ids, 'posts_per_page' => 4, 'orderby' => 'post__in' ] );
			?>
			<div class="prod-grid">
				<?php while ( $rq->have_posts() ) { $rq->the_post();
					get_template_part( 'template-parts/product-card' );
				} ?>
			</div>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</section>

	<?php do_action( 'woocommerce_after_single_product' ); ?>

</main>
