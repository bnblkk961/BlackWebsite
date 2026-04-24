<?php
/**
 * Single journal article.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
the_post();

$kicker = bb_field( 'bb_kicker', null, 'Field Notes' );
$read   = bb_field( 'bb_read_time', null, 4 );
$pull   = bb_field( 'bb_pull_quote' );
?>

<main id="site-main" class="bb-journal-single">

<article class="jrnl-article">

	<header class="jrnl-hdr">
		<span class="eyebrow"><?php echo esc_html( $kicker ); ?> · <?php echo esc_html( sprintf( '%02d min read', (int) $read ) ); ?></span>
		<h1 class="display"><?php the_title(); ?></h1>
		<div class="jrnl-meta">
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<span>by <?php the_author(); ?></span>
		</div>
	</header>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="jrnl-lead-img">
			<?php the_post_thumbnail( 'bb-hero' ); ?>
		</div>
	<?php endif; ?>

	<div class="jrnl-body">
		<?php the_content(); ?>
	</div>

	<?php if ( $pull ) : ?>
		<aside class="pull-quote">“<?php echo esc_html( $pull ); ?>”</aside>
	<?php endif; ?>

	<footer class="jrnl-foot">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'bb_journal' ) ); ?>" class="btn">← All articles</a>
	</footer>
</article>

<!-- RELATED -->
<section class="jrnl-related">
	<div class="section-head">
		<span class="num">§ More</span>
		<h2>Keep<br><em>reading.</em></h2>
	</div>
	<div class="jrnl-grid">
		<?php
		$rq = new WP_Query( [
			'post_type' => 'bb_journal',
			'posts_per_page' => 3,
			'post__not_in' => [ get_the_ID() ],
		] );
		while ( $rq->have_posts() ) { $rq->the_post();
			get_template_part( 'template-parts/journal-card' );
		}
		wp_reset_postdata();
		?>
	</div>
</section>

</main>
<?php get_footer();
