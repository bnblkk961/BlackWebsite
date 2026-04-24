<?php
/**
 * Ban Black — Site Configuration
 * 
 * ONE place to update images, text, and settings.
 * All templates read from here.
 * Never edit individual template files for content changes.
 */

defined( 'ABSPATH' ) || exit;

// ============================================
// MEDIA BASE URL
// Change this when moving from staging to production
// ============================================
define( 'BB_MEDIA', 'https://banblack.staging.tempurl.host/wp-content/uploads' );

// ============================================
// LOGOS
// ============================================
define( 'BB_LOGO_WHITE',  'https://banblack.staging.tempurl.host/wp-content/uploads/2026/04/BanBlack-Logo-white.png' );
define( 'BB_LOGO_BLACK',  'https://banblack.staging.tempurl.host/wp-content/uploads/2026/04/BanBlack-Logo-black.png' );
define( 'BB_LOGO_B',      'https://banblack.staging.tempurl.host/wp-content/uploads/2026/04/B_Logo-WHITE-01-01.png' );
define( 'BB_LOGO_B_DARK', 'https://banblack.staging.tempurl.host/wp-content/uploads/2026/04/B_Logo-01.png' );

// ============================================
// HERO IMAGES (per page)
// ============================================
define( 'BB_IMG_HERO_HOME',      BB_MEDIA . '/2024/08/Roasting.jpg' );
define( 'BB_IMG_HERO_ABOUT',     BB_MEDIA . '/2024/08/Roasting.jpg' ); // replace when ready
define( 'BB_IMG_HERO_WHOLESALE', BB_MEDIA . '/2024/08/Roasting.jpg' ); // replace when ready
define( 'BB_IMG_HERO_SHOP',      BB_MEDIA . '/2024/08/Roasting.jpg' ); // replace when ready

// ============================================
// SECTION IMAGES (home page)
// ============================================
define( 'BB_IMG_FEATURED',    BB_MEDIA . '/2026/04/Melodrip_pour_over_assist.jpg' );
define( 'BB_IMG_WHOLESALE',   BB_MEDIA . '/2024/08/Roasting.jpg' ); // replace when ready

// ============================================
// BRAND INFO
// ============================================
define( 'BB_CITY',      'Zouk Mosbeh, Lebanon' );
define( 'BB_EST',       '2014' );
define( 'BB_PHONE',     '+961 71 888 768' );
define( 'BB_EMAIL',     'hello@banblack.com' );
define( 'BB_ADDRESS',   'Zouk Mosbeh, Keserwan, Lebanon' );
define( 'BB_WHATSAPP',  '96171888768' );

// ============================================
// STATS (update these manually as they grow)
// ============================================
define( 'BB_STAT_ORIGINS',  '14' );
define( 'BB_STAT_CAFES',    '42' );
define( 'BB_STAT_ROASTS',   '06' );
define( 'BB_STAT_BATCH',    '412' );

// ============================================
// HELPER: get config image with fallback
// Usage: bb_config_img( BB_IMG_HERO_HOME, 'Hero background' )
// ============================================
function bb_config_img( $url, $alt = '', $style = 'position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;display:block;' ) {
    if ( empty( $url ) ) return '';
    return '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" style="' . esc_attr( $style ) . '">';
}

// ============================================
// PRODUCTION SWITCH
// When going live, change BB_MEDIA above to:
// https://banblack.com/wp-content/uploads
// All images update automatically across the site.
// ============================================
