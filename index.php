<?php
/**
 * Fallback template — serves any request not matched by a more specific template.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<main id="site-main" class="bb-generic">
	<div class="section">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<h1 class="display"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		<?php else : ?>
			<h1 class="display"><?php esc_html_e( 'Nothing here.', 'ban-black' ); ?></h1>
			<p><?php esc_html_e( 'Try the shop, or brew something black.', 'ban-black' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer();
