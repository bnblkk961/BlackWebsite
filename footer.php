<?php
/**
 * Footer — newsletter + links + copyright.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<footer class="footer" role="contentinfo">
	<div class="footer-grid">

		<div>
			<div class="footer-mark"><span class="ar">بان</span><span>BLACK</span></div>
			<p class="footer-blurb">
				<?php esc_html_e( 'The coffee world in one store. Meticulously imported, roasted in Zouk Mosbeh, shipped black.', 'ban-black' ); ?>
			</p>
			<p class="footer-geo">
				33.98°N / 35.61°E<br>
				<?php esc_html_e( 'Keserwan · Lebanon', 'ban-black' ); ?>
			</p>
		</div>

		<div>
			<h4><?php esc_html_e( 'Shop', 'ban-black' ); ?></h4>
			<?php wp_nav_menu( [
				'theme_location' => 'footer-shop',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			] ); ?>
		</div>

		<div>
			<h4><?php esc_html_e( 'Inside', 'ban-black' ); ?></h4>
			<?php wp_nav_menu( [
				'theme_location' => 'footer-inside',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			] ); ?>
		</div>

		<div>
			<h4><?php esc_html_e( 'Help', 'ban-black' ); ?></h4>
			<?php wp_nav_menu( [
				'theme_location' => 'footer-help',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'fallback_cb'    => false,
				'depth'          => 1,
			] ); ?>
		</div>

		<div>
			<h4><?php esc_html_e( 'Ritual, delivered', 'ban-black' ); ?></h4>
			<?php if ( is_active_sidebar( 'footer-newsletter' ) ) {
				dynamic_sidebar( 'footer-newsletter' );
			} else { ?>
				<p class="footer-newsletter-blurb"><?php esc_html_e( 'One email per month. Roast notes, new drops, zero fluff.', 'ban-black' ); ?></p>
				<form class="footer-newsletter" onsubmit="event.preventDefault();" aria-label="Newsletter signup">
					<input type="email" placeholder="your@email.com" required>
					<button type="submit"><?php esc_html_e( 'Sign up →', 'ban-black' ); ?></button>
				</form>
			<?php } ?>
		</div>
	</div>

	<div class="footer-bottom">
		<span>© <?php echo esc_html( date( 'Y' ) ); ?> <?php esc_html_e( 'Ban Black SARL', 'ban-black' ); ?></span>
		<span><?php esc_html_e( 'Crafted black · All rights reserved', 'ban-black' ); ?></span>
		<span>
			<a href="/privacy">Privacy</a> ·
			<a href="/terms">Terms</a> ·
			<a href="/returns">Returns</a>
		</span>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
