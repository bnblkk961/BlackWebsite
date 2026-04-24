<?php
/**
 * Template Name: Wholesale
 * Services + stats + café wall + inquiry form.
 *
 * Uses a [bb_wholesale_form] shortcode OR a Gravity/Fluent Forms shortcode
 * set in the ACF "form_shortcode" field.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
the_post();

$services = function_exists( 'get_field' ) ? get_field( 'bb_services' ) : [];
$stats    = function_exists( 'get_field' ) ? get_field( 'bb_stats' ) : [];
$cafes    = function_exists( 'get_field' ) ? get_field( 'bb_cafes' ) : [];
$form     = function_exists( 'get_field' ) ? get_field( 'form_shortcode' ) : '';
?>

<main id="site-main" class="bb-wholesale">

<section class="ws-hero inverted">
	<div class="eyebrow">§ Wholesale · B2B</div>
	<h1 class="display"><?php the_title(); ?></h1>
	<div class="ws-lede"><?php the_content(); ?></div>
	<?php if ( $stats ) : ?>
	<div class="stats">
		<?php foreach ( $stats as $s ) : ?>
			<div><strong><?php echo esc_html( $s['value'] ); ?></strong><span class="tick"><?php echo esc_html( $s['label'] ); ?></span></div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</section>

<?php if ( $services ) : ?>
<section class="ws-services">
	<div class="section-head">
		<span class="num">§ 01 / SERVICES</span>
		<h2>What we<br><em>deliver.</em></h2>
	</div>
	<div class="svc-grid">
		<?php foreach ( $services as $s ) : ?>
			<div class="svc">
				<span class="num"><?php echo esc_html( $s['num'] ); ?></span>
				<h3><?php echo esc_html( $s['title'] ); ?></h3>
				<p><?php echo esc_html( $s['body'] ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<?php if ( $cafes ) : ?>
<section class="ws-wall inverted">
	<div class="section-head">
		<span class="num">§ 02 / PARTNERS</span>
		<h2>Cafés we've<br><em>opened.</em></h2>
	</div>
	<div class="cafe-grid">
		<?php foreach ( $cafes as $c ) : ?>
			<div class="cafe">
				<?php if ( ! empty( $c['photo'] ) ) {
					echo wp_get_attachment_image( $c['photo'], 'bb-category' );
				} else {
					echo bb_placeholder( $c['name'], 'CAFE' );
				} ?>
				<h4><?php echo esc_html( $c['name'] ); ?></h4>
				<span class="tick"><?php echo esc_html( $c['city'] . ' · ' . $c['year'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>
<?php endif; ?>

<section class="ws-form">
	<div class="section-head">
		<span class="num">§ 03 / INQUIRY</span>
		<h2>Start a<br><em>project.</em></h2>
	</div>
	<?php if ( $form ) {
		echo do_shortcode( $form );
	} else { ?>
		<form class="ws-inquiry" onsubmit="event.preventDefault(); this.classList.add('sent');" aria-label="Wholesale inquiry">
			<div class="row"><label>Business name<input name="biz" required></label></div>
			<div class="row2">
				<label>Contact name<input name="name" required></label>
				<label>Email<input type="email" name="email" required></label>
			</div>
			<div class="row2">
				<label>Phone<input type="tel" name="phone"></label>
				<label>City<input name="city"></label>
			</div>
			<div class="row">
				<label>What do you need?
					<select name="need">
						<option>Coffee wholesale</option>
						<option>Full café fit-out</option>
						<option>Equipment only</option>
						<option>Training / consulting</option>
					</select>
				</label>
			</div>
			<div class="row">
				<label>Tell us about the project<textarea name="msg" rows="5"></textarea></label>
			</div>
			<button type="submit" class="btn dark">Send inquiry <span class="arr">→</span></button>
			<p class="sent-msg">Got it. We'll be in touch within 2 business days.</p>
		</form>
	<?php } ?>
</section>

</main>
<?php get_footer();
