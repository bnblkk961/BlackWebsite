<?php
/**
 * Journal archive — list of bb_journal posts.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<main id="site-main" class="bb-journal-archive">

<section class="jrnl-hero">
	<div class="eyebrow">§ Journal</div>
	<h1 class="display">Words<br><em>& grind sizes.</em></h1>
	<p class="jrnl-lede">Field notes, brew guides, roast sheets, and the occasional rant. One email per month if you want it in your inbox.</p>
</section>

<?php if ( have_posts() ) : ?>

	<?php
	// Featured: most recent, full-bleed
	the_post();
	?>
	<section class="jrnl-featured">
		<a href="<?php the_permalink(); ?>" class="jrnl-featured-link">
			<?php bb_thumbnail_or_placeholder( get_the_ID(), 'bb-hero', get_the_title() ); ?>
			<div class="jrnl-featured-body">
				<span class="eyebrow"><?php echo esc_html( bb_field( 'bb_kicker', null, 'Featured' ) ); ?></span>
				<h2><?php the_title(); ?></h2>
				<p><?php echo esc_html( get_the_excerpt() ); ?></p>
				<span class="arr">Read the piece →</span>
			</div>
		</a>
	</section>

	<section class="jrnl-list">
		<div class="jrnl-grid">
			<?php while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/journal-card' );
			endwhile; ?>
		</div>

		<div class="jrnl-pagination">
			<?php the_posts_pagination( [ 'mid_size' => 2, 'prev_text' => '← Previous', 'next_text' => 'Next →' ] ); ?>
		</div>
	</section>

<?php else : ?>
	<section class="section">
		<p><?php esc_html_e( 'No journal entries yet. Check back soon.', 'ban-black' ); ?></p>
	</section>
<?php endif; ?>

</main>
<?php get_footer();
