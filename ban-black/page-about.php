<?php
/**
 * Template Name: About
 * Pillars + timeline + team — all ACF-driven.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
the_post();

$pillars  = function_exists( 'get_field' ) ? get_field( 'bb_pillars' ) : [];
$timeline = function_exists( 'get_field' ) ? get_field( 'bb_timeline' ) : [];
$team     = function_exists( 'get_field' ) ? get_field( 'bb_team' ) : [];
?>

<main id="site-main" class="bb-about">

<!-- HERO -->
<section class="about-hero">
	<div class="eyebrow">§ Our story · Est. 2014</div>
	<h1 class="display"><?php the_title(); ?></h1>
	<div class="about-lede"><?php the_content(); ?></div>
</section>

<!-- PILLARS -->
<?php if ( $pillars ) : ?>
<section class="about-pillars">
	<div class="section-head">
		<span class="num">§ 01 / MANIFESTO</span>
		<h2>What we<br><em>believe.</em></h2>
	</div>
	<div class="pillar-grid">
		<?php foreach ( $pillars as $p ) : ?>
			<div class="pillar">
				<span class="num"><?php echo esc_html( $p['num'] ); ?></span>
				<h3><?php echo esc_html( $p['title'] ); ?></h3>
				<p><?php echo esc_html( $p['body'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<!-- TIMELINE -->
<?php if ( $timeline ) : ?>
<section class="about-timeline inverted">
	<div class="section-head">
		<span class="num">§ 02 / TIMELINE</span>
		<h2>Twelve years<br><em>of black.</em></h2>
	</div>
	<ol class="timeline">
		<?php foreach ( $timeline as $t ) : ?>
			<li>
				<span class="year"><?php echo esc_html( $t['year'] ); ?></span>
				<p><?php echo esc_html( $t['body'] ); ?></p>
			</li>
		<?php endforeach; ?>
	</ol>
</section>
<?php endif; ?>

<!-- TEAM -->
<?php if ( $team ) : ?>
<section class="about-team">
	<div class="section-head">
		<span class="num">§ 03 / TEAM</span>
		<h2>The<br><em>crew.</em></h2>
	</div>
	<div class="team-grid">
		<?php foreach ( $team as $m ) : ?>
			<div class="team-member">
				<?php if ( ! empty( $m['photo'] ) ) {
					echo wp_get_attachment_image( $m['photo'], 'bb-product-card' );
				} else {
					echo bb_placeholder( $m['name'], 'TEAM' );
				} ?>
				<h4><?php echo esc_html( $m['name'] ); ?></h4>
				<span class="tick"><?php echo esc_html( $m['role'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

</main>
<?php get_footer();
