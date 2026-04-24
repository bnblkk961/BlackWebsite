<?php
/**
 * Product card — used in loops + shortcodes.
 * Expects: inside the WP Loop.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
global $product;
if ( ! $product instanceof WC_Product ) $product = wc_get_product( get_the_ID() );
if ( ! $product ) return;

$cats  = wc_get_product_category_list( $product->get_id(), ', ' );
$roast = bb_field( 'bb_roast' );
$notes = bb_field( 'bb_notes' );
$sku   = $product->get_sku() ?: 'BB-' . $product->get_id();

// Figure out a "tag" badge (featured / on-sale / new-this-week)
$tag = '';
if ( $product->is_on_sale() )                             $tag = 'sale';
elseif ( $product->is_featured() )                        $tag = 'featured';
elseif ( strtotime( $product->get_date_created() ) > strtotime( '-30 days' ) ) $tag = 'new';
?>
<a href="<?php the_permalink(); ?>" class="prod-card" data-sku="<?php echo esc_attr( $sku ); ?>">
	<div class="ph-wrap">
		<?php if ( $tag ) : ?><span class="tag"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
		<?php bb_thumbnail_or_placeholder( $product->get_id(), 'bb-product-card', $product->get_name(), false ); ?>
	</div>
	<div class="row">
		<span><?php echo wp_kses_post( $cats ); ?></span>
		<?php if ( $roast ) : ?><span><?php echo esc_html( $roast ); ?></span><?php endif; ?>
	</div>
	<h4><?php the_title(); ?></h4>
	<?php if ( $notes ) : ?><p class="notes"><?php echo esc_html( $notes ); ?></p><?php endif; ?>
	<div class="bot">
		<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
		<?php
		woocommerce_template_loop_add_to_cart( [ 'class' => 'add' ] );
		?>
	</div>
</a>
