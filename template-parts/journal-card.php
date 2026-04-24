<?php
/**
 * Journal article card — used in archive + home preview.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
$kicker = bb_field( 'bb_kicker', get_the_ID(), get_post_type() === 'bb_journal' ? 'Field Notes' : 'Post' );
$read   = bb_field( 'bb_read_time', null, 4 );
?>
<a href="<?php the_permalink(); ?>" class="jrnl-card">
	<?php bb_thumbnail_or_placeholder( get_the_ID(), 'bb-journal-card', get_the_title() ); ?>
	<div class="meta">
		<span><?php echo esc_html( $kicker ); ?></span>
		<span><?php echo esc_html( sprintf( '%02d min', (int) $read ) ); ?></span>
	</div>
	<h4><?php the_title(); ?></h4>
	<span class="arr">Read →</span>
</a>
