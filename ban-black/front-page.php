<?php
/**
 * Home / Front page.
 * Fields pull from ACF "Home Modules" group; sensible fallbacks if empty.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$hero_title = bb_field( 'bb_hero_title', null, "Black,<br>and <em>only black.</em>" );
$hero_lede  = bb_field( 'bb_hero_lede',  null, 'We import the beans. We roast them. We sell the machines that make them sing. The coffee world — espresso bar to pour-over ritual — quietly assembled under one word.' );
$hero_img   = bb_field( 'bb_hero_img' );
$reserve_id = bb_field( 'bb_reserve_product' );
?>

<style>
@media (max-width: 900px) {
	.bb-home .hero { min-height: 0 !important; }
	.bb-home .hero-inner {
		grid-template-columns: 1fr !important;
		min-height: 0 !important;
		align-items: start !important;
		padding: 50px 24px 50px !important;
	}
}
.admin-bar .bb-home .hero-inner {
	padding-top: 50px !important;
}
@media screen and (max-width: 782px) {
	.admin-bar .bb-home .hero { min-height: 0 !important; }
	.admin-bar .bb-home .hero-inner {
		min-height: 0 !important;
		padding-top: 50px !important;
	}
}
</style>
<main id="site-main" class="bb-home">

<!-- HERO -->
<section class="hero">
	<div class="hero-img">
		<?php if ( $hero_img ) {
			echo wp_get_attachment_image( $hero_img, 'bb-hero', false, [ 'class' => 'bb-img', 'style' => 'position:absolute;inset:0;width:100%;height:100%;object-fit:cover;' ] );
		} else {
			echo bb_config_img( BB_IMG_HERO_HOME, 'Ban Black — Specialty Coffee' );
		} ?>
	</div>
	<div class="hero-inner">
		<h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
		<div class="hero-side">
			<div class="eyebrow">EST. 2014 · BEIRUT · ROAST BATCH 412</div>
			<p class="hero-lede"><?php echo esc_html( $hero_lede ); ?></p>
			<div class="hero-ctas">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn solid">Shop Coffee <span class="arr">→</span></a>
				<a href="/about" class="btn">Our Story</a>
			</div>
			<div class="hero-meta">
				<div><span class="tick">Origins</span><strong>14</strong></div>
				<div><span class="tick">Cafés served</span><strong>42</strong></div>
				<div><span class="tick">Roasts this week</span><strong>06</strong></div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/marquee' ); ?>

<!-- CATEGORIES -->
<section class="bb-categories-section">
	<div class="section" style="padding:120px var(--gutter) 40px;">
		<div class="section-head">
			<span class="num">§ 01 / INDEX</span>
			<h2>Shop by<br><em>discipline.</em></h2>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="link">All items →</a>
		</div>
	</div>
	<div class="categories">
		<?php
		$terms = get_terms( [ 'taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0, 'number' => 4 ] );
		$i = 0;
		foreach ( $terms as $term ) : $i++;
			$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
			?>
			<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="cat-cell">
				<span class="num"><?php printf( '§ 01.%02d', $i ); ?></span>
				<span class="arr">↗</span>
				<h3><?php echo esc_html( $term->name ); ?></h3>
				<span class="count"><?php echo esc_html( sprintf( '%02d items', $term->count ) ); ?></span>
				<?php if ( $thumb_id ) {
					echo wp_get_attachment_image( $thumb_id, 'bb-category' );
				} else {
					echo bb_placeholder( $term->name, 'CAT/' . sprintf( '%02d', $i ) );
				} ?>
			</a>
		<?php endforeach; ?>
	</div>
</section>

<!-- FEATURED RESERVE -->
<?php if ( $reserve_id && ( $rp = wc_get_product( $reserve_id ) ) ) :
	$origin   = get_field( 'bb_origin',   $reserve_id );
	$altitude = get_field( 'bb_altitude', $reserve_id );
	$process  = get_field( 'bb_process',  $reserve_id );
	$roast    = get_field( 'bb_roast',    $reserve_id );
	?>
<section class="featured inverted">
	<div class="featured-img">
		<?php bb_thumbnail_or_placeholder( $reserve_id, 'bb-product-hero', $rp->get_name(), true ); ?>
	</div>
	<div class="featured-body">
		<span class="eyebrow">§ 02 / RESERVE · LOT 014</span>
		<h2><?php echo esc_html( $rp->get_short_description() ?: $rp->get_name() ); ?></h2>
		<p class="featured-blurb"><?php echo wp_kses_post( wp_trim_words( $rp->get_description(), 40 ) ); ?></p>
		<div class="featured-notes">
			<?php if ( $origin )   : ?><div><span class="tick">Origin</span><strong><?php echo esc_html( $origin ); ?></strong></div><?php endif; ?>
			<?php if ( $altitude ) : ?><div><span class="tick">Altitude</span><strong><?php echo esc_html( $altitude ); ?></strong></div><?php endif; ?>
			<?php if ( $process )  : ?><div><span class="tick">Process</span><strong><?php echo esc_html( $process ); ?></strong></div><?php endif; ?>
			<?php if ( $roast )    : ?><div><span class="tick">Roast</span><strong><?php echo esc_html( $roast ); ?></strong></div><?php endif; ?>
		</div>
		<div class="featured-cta">
			<a href="<?php echo esc_url( get_permalink( $reserve_id ) ); ?>" class="btn dark">
				Take the bag · <?php echo wp_kses_post( $rp->get_price_html() ); ?> <span class="arr">→</span>
			</a>
			<?php if ( $rp->managing_stock() ) : ?>
				<span class="stock-note"><?php echo esc_html( $rp->get_stock_quantity() ); ?> left</span>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- LATEST -->
<section>
	<div class="section" style="padding-bottom:0;">
		<div class="section-head">
			<span class="num">§ 03 / NEW THIS WEEK</span>
			<h2>Fresh<br><em>off the drum.</em></h2>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="link">Shop all →</a>
		</div>
	</div>
	<div class="prod-grid">
		<?php
		$q = new WP_Query( [ 'post_type' => 'product', 'posts_per_page' => 8, 'orderby' => 'date' ] );
		while ( $q->have_posts() ) { $q->the_post();
			get_template_part( 'template-parts/product-card' );
		}
		wp_reset_postdata();
		?>
	</div>
</section>

<!-- RITUAL -->
<section>
	<div class="section" style="padding-bottom:0;">
		<div class="section-head">
			<span class="num">§ 04 / BREW</span>
			<h2>Ritual,<br><em>in six moves.</em></h2>
			<a href="/journal" class="link">Brew guides →</a>
		</div>
	</div>
	<div class="ritual">
		<?php $steps = [
			[ '01', 'Weigh',  '18 grams. Not "about" 18. Eighteen. Trust the scale, not your eyeballs.' ],
			[ '02', 'Grind',  'Fresh. Always. If you ground it yesterday, make tea.' ],
			[ '03', 'Bloom',  'Twice the weight in water. Forty seconds. Smell the thing.' ],
			[ '04', 'Pour',   'Center, spiral out, spiral in. Keep the bed flat, keep the ego flatter.' ],
			[ '05', 'Wait',   'Three minutes, thirty. No phone. This is what you\'re paying for.' ],
			[ '06', 'Drink',  'Black. Of course.' ],
		];
		foreach ( $steps as $s ) : ?>
			<div class="ritual-step">
				<span class="no"><?php echo esc_html( $s[0] ); ?></span>
				<h4><?php echo esc_html( $s[1] ); ?></h4>
				<p><?php echo esc_html( $s[2] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- MANIFESTO -->
<section class="manifesto">
	<p>
		There's a reason we didn't name it
		<em>Brown Beige.</em>
		Color is a distraction.
		Black is a decision.
	</p>
	<div class="sig">— The Ban Black Team · Zouk Mosbeh</div>
</section>

<!-- JOURNAL -->
<section>
	<div class="section" style="padding-bottom:0;">
		<div class="section-head">
			<span class="num">§ 05 / JOURNAL</span>
			<h2>Words<br><em>& grind sizes.</em></h2>
			<a href="/journal" class="link">Read all →</a>
		</div>
	</div>
	<div class="jrnl-grid">
		<?php
		$jq = new WP_Query( [ 'post_type' => 'bb_journal', 'posts_per_page' => 3 ] );
		while ( $jq->have_posts() ) { $jq->the_post();
			get_template_part( 'template-parts/journal-card' );
		}
		wp_reset_postdata();
		?>
	</div>
</section>

<!-- WHOLESALE TEASER -->
<section class="ws-teaser inverted">
	<div class="ws-left">
		<span class="eyebrow">§ 06 / WHOLESALE</span>
		<h2>Opening<br>a coffee shop?<br><em>Start correctly.</em></h2>
		<p class="ws-blurb">Concept to cup. Equipment to training to the 127 small decisions that make or break a café. We've done it 42 times. We'll do it for you once.</p>
		<div class="ws-ctas">
			<a href="/wholesale" class="btn dark">Start a project <span class="arr">→</span></a>
			<a href="tel:+96171888768" class="btn btn-outline-dark">Call us</a>
		</div>
		<div class="stats">
			<div><strong>42</strong><span class="tick">cafés opened</span></div>
			<div><strong>127</strong><span class="tick">decision points</span></div>
			<div><strong>14 d</strong><span class="tick">avg. lead time</span></div>
		</div>
	</div>
	<div class="ws-right">
		<?php echo bb_placeholder( 'Coffee shop install · 2025', 'WS/01', true ); ?>
	</div>
</section>

</main>

<?php get_footer();
