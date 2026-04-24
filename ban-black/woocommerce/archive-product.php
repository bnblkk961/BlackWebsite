<?php
/**
 * Shop / Product archive — replaces WooCommerce's archive-product.php.
 *
 * We take full control here: editorial header, sidebar filters, grid.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$shop_page_id = wc_get_page_id( 'shop' );
$shop_title   = woocommerce_page_title( false );
$description  = term_description();
if ( ! $description && is_shop() ) {
	$description = get_post_field( 'post_content', $shop_page_id );
}

$count = wc_get_loop_prop( 'total' );
?>

<main id="site-main" class="bb-shop">

<section class="shop-hero">
	<?php woocommerce_breadcrumb(); ?>
	<div class="shop-hero-row">
		<div>
			<span class="eyebrow">§ <?php echo esc_html( is_shop() ? 'Catalog' : 'Category' ); ?> · <?php echo esc_html( sprintf( '%02d items', (int) $count ) ); ?></span>
			<h1 class="display"><?php echo esc_html( $shop_title ); ?></h1>
		</div>
		<?php if ( $description ) : ?>
			<div class="shop-hero-lede"><?php echo wp_kses_post( $description ); ?></div>
		<?php endif; ?>
	</div>
</section>

<section class="shop-layout">
	<aside class="shop-sidebar">

		<div class="filter-block">
			<h4>Category</h4>
			<ul>
				<li><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="<?php echo is_shop() ? 'is-active' : ''; ?>">All</a></li>
				<?php
				$cats = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0 ] );
				foreach ( $cats as $c ) :
					$active = is_product_category( $c->slug ) ? 'is-active' : '';
					?>
					<li><a href="<?php echo esc_url( get_term_link( $c ) ); ?>" class="<?php echo esc_attr( $active ); ?>">
						<?php echo esc_html( $c->name ); ?> <span>(<?php echo (int) $c->count; ?>)</span>
					</a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="filter-block">
			<h4>Sort</h4>
			<?php woocommerce_catalog_ordering(); ?>
		</div>

		<div class="filter-block">
			<h4>Ritual</h4>
			<ul class="facets">
				<li><label><input type="checkbox"> Pour-over</label></li>
				<li><label><input type="checkbox"> Espresso</label></li>
				<li><label><input type="checkbox"> Filter / v60</label></li>
				<li><label><input type="checkbox"> AeroPress</label></li>
				<li><label><input type="checkbox"> French press</label></li>
			</ul>
			<p class="facet-note">Connect a faceting plugin (FacetWP / WOOF) for real filtering.</p>
		</div>
	</aside>

	<div class="shop-main">
		<?php if ( woocommerce_product_loop() ) : ?>
			<div class="prod-grid">
				<?php
				woocommerce_product_loop_start( false );
				if ( wc_get_loop_prop( 'total' ) ) {
					while ( have_posts() ) { the_post();
						get_template_part( 'template-parts/product-card' );
					}
				}
				woocommerce_product_loop_end( false );
				?>
			</div>
			<div class="shop-pagination">
				<?php woocommerce_pagination(); ?>
			</div>
		<?php else : ?>
			<p class="no-products">
				<?php esc_html_e( 'Nothing here yet. The bean drum is still turning.', 'ban-black' ); ?>
			</p>
		<?php endif; ?>
	</div>
</section>

</main>
<?php get_footer();
