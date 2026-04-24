/* ==========================================================================
   Ban Black — shared JS
   Reveal-on-scroll + Woo add-to-cart feedback + nav cart pip update.
   ========================================================================== */

( () => {
	'use strict';

	// Reveal on scroll (simple IntersectionObserver)
	const io = new IntersectionObserver( entries => {
		for ( const e of entries ) {
			if ( e.isIntersecting ) {
				e.target.classList.add( 'is-in' );
				io.unobserve( e.target );
			}
		}
	}, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' } );

	document.querySelectorAll( '.prod-card, .jrnl-card, .cat-cell, .pillar, .svc, .cafe, .ritual-step, .timeline li' ).forEach( el => io.observe( el ) );

	// Cart pip update (WooCommerce fragments)
	document.body.addEventListener( 'updated_wc_div', () => {
		/* Woo handles this via AJAX fragments — nothing extra here */
	} );

	// Ticker: pause on hover (for accessibility)
	const ticker = document.querySelector( '.ticker' );
	if ( ticker ) {
		ticker.addEventListener( 'mouseenter', () => ticker.style.animationPlayState = 'paused' );
		ticker.addEventListener( 'mouseleave', () => ticker.style.animationPlayState = 'running' );
	}

} )();
