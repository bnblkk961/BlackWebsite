<?php
/**
 * 404
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header(); ?>
<main id="site-main" class="bb-404">
	<div class="section" style="padding:200px var(--gutter); text-align:center;">
		<div class="eyebrow">§ 404</div>
		<h1 class="display" style="font-size:clamp(80px, 14vw, 200px); margin:24px 0;">Not here.</h1>
		<p style="max-width:440px; margin:0 auto 40px; color:var(--bb-fog);">
			<?php esc_html_e( 'The page you wanted was either roasted too dark or never existed. Head back.', 'ban-black' ); ?>
		</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn solid">Home <span class="arr">→</span></a>
	</div>
</main>
<?php get_footer();
