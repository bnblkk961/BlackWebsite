<?php
/**
 * Generic page template (used when no more-specific template exists).
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>

<main id="site-main" class="bb-page">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'section' ); ?>>
			<header class="page-header">
				<h1 class="display"><?php the_title(); ?></h1>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</main>

<?php get_footer();
