<?php
/**
 * Header — ticker + nav. Included on every page.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class( 'bb-site' ); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#site-main"><?php esc_html_e( 'Skip to content', 'ban-black' ); ?></a>

<?php get_template_part( 'template-parts/ticker' ); ?>

<nav class="nav" aria-label="Primary">
	<div class="nav-left">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav-menu',
				'depth'          => 1,
			] );
		} else {
			echo '<ul class="nav-menu">';
			echo '<li><a href="' . esc_url( home_url('/') ) . '">Home</a></li>';
			echo '<li><a href="' . esc_url( wc_get_page_permalink('shop') ) . '">Shop</a></li>';
			echo '<li><a href="/about">Story</a></li>';
			echo '<li><a href="/wholesale">Wholesale</a></li>';
			echo '</ul>';
		}
		?>
	</div>

	<?php bb_logo(); ?>

	<div class="nav-right">
		<a href="#search" aria-label="Search">Search</a>
		<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : '#' ); ?>">Account</a>
		<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '#' ); ?>" class="nav-cart">
			Bag<span class="cart-pip" data-cart-count><?php echo esc_html( bb_cart_count() ); ?></span>
		</a>
	</div>
</nav>