<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'after_setup_theme', function () {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );
} );

add_action( 'wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'mtctire-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get( 'Version' )
    );
    wp_enqueue_style(
        'mtctire-fonts',
        'https://fonts.googleapis.com/css2?family=Oswald:wght@400;600;700&family=Inter:wght@400;500;600&display=swap',
        [],
        null
    );
} );

// LocalBusiness JSON-LD schema — injected into <head> sitewide
add_action( 'wp_head', function () {
    $year = (int) date( 'Y' );

    // Victoria Day: last Monday on or before May 25
    $may25 = new DateTime( "$year-05-25" );
    $victoria_day = $may25->format( 'N' ) === '1' ? $may25 : (clone $may25)->modify( 'last monday' );
    $vd_sat = (clone $victoria_day)->modify( '-2 days' );
    $labour_day = new DateTime( "first monday of September $year" );
    $today = new DateTime();
    $today->setTime( 0, 0, 0 );
    $sat_closed = ( $today >= $vd_sat && $today <= $labour_day );

    $hours = [
        [ 'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ], 'opens' => '08:00', 'closes' => '17:30' ],
    ];
    if ( ! $sat_closed ) {
        $hours[] = [ 'dayOfWeek' => [ 'Saturday' ], 'opens' => '09:00', 'closes' => '14:00' ];
    }

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'AutoRepair',
        'name'        => 'MTC Tire Oakville Inc.',
        'image'       => get_site_url() . '/wp-content/uploads/2017/05/mtctire-logo.png',
        'url'         => 'https://mtctire.ca',
        'telephone'   => '+19058476665',
        'email'       => 'tiresales@mtctire.ca',
        'foundingDate'=> '2005',
        'description' => 'Family-owned tire and automotive repair shop in Oakville, Ontario, serving the community since 2005.',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => '1439 Speers Rd',
            'addressLocality' => 'Oakville',
            'addressRegion'   => 'ON',
            'postalCode'      => 'L6L 2X5',
            'addressCountry'  => 'CA',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 43.4217,
            'longitude' => -79.7176,
        ],
        'openingHoursSpecification' => $hours,
        'aggregateRating' => [
            '@type'       => 'AggregateRating',
            'ratingValue' => '4.6',
            'bestRating'  => '5',
            'ratingCount' => '200',
        ],
        'priceRange'  => '$$',
        'currenciesAccepted' => 'CAD',
        'paymentAccepted'    => 'Cash, Credit Card, Debit',
        'areaServed'  => [ 'Oakville', 'Burlington', 'Mississauga', 'Milton' ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}, 5 );

// Dynamic copyright year shortcode — [mtc_copyright]
add_shortcode( 'mtc_copyright', function () {
    return '<p class="has-text-color" style="color:#333333;font-size:0.65rem;margin:0">&copy; 2005&ndash;' . date( 'Y' ) . ' MTC Tire Oakville Inc. All rights reserved.</p>';
} );

// Dynamic hours shortcode — [mtc_hours]
add_shortcode( 'mtc_hours', function () {
    $year = (int) date( 'Y' );

    // Victoria Day: last Monday on or before May 25
    $may25 = new DateTime( "$year-05-25" );
    if ( $may25->format( 'N' ) === '1' ) {
        $victoria_day = $may25;
    } else {
        $victoria_day = clone $may25;
        $victoria_day->modify( 'last monday' );
    }
    $vd_sat = clone $victoria_day;
    $vd_sat->modify( '-2 days' ); // Saturday of Victoria Day weekend

    // Labour Day: first Monday of September
    $labour_day = new DateTime( "first monday of September $year" );

    $today = new DateTime();
    $today->setTime( 0, 0, 0 );

    $closed_saturdays = ( $today >= $vd_sat && $today <= $labour_day );

    $sat_line = $closed_saturdays
        ? 'Sat: Closed'
        : 'Sat: 9:00am – 2:00pm';

    return '<p style="color:#aaaaaa;font-size:0.8rem;line-height:1.9;margin:0">'
        . 'Mon–Fri: 8:00am – 5:30pm<br>'
        . esc_html( $sat_line ) . '<br>'
        . '<span style="color:#555555;font-size:0.72rem">(Closed Saturdays: Victoria Day weekend through Labour Day weekend)</span><br>'
        . 'Sun: Closed'
        . '</p>';
} );

// Register pattern category and service content patterns for the block inserter
add_action( 'init', function () {
    register_block_pattern_category( 'mtctire', [ 'label' => 'MTC Tire' ] );

    $service_patterns = [
        'service-tires-wheels'      => [ 'title' => 'Service: Tires & Wheels',      'file' => 'service-tires-wheels' ],
        'service-tire-storage'      => [ 'title' => 'Service: Tire Storage',         'file' => 'service-tire-storage' ],
        'service-automotive-repair' => [ 'title' => 'Service: Automotive Repair',    'file' => 'service-automotive-repair' ],
        'service-wheel-alignment'   => [ 'title' => 'Service: Wheel Alignment',      'file' => 'service-wheel-alignment' ],
        'service-brake-inspection'  => [ 'title' => 'Service: Brake Inspection',     'file' => 'service-brake-inspection' ],
        'service-fleet-cards'       => [ 'title' => 'Service: Fleet Cards',          'file' => 'service-fleet-cards' ],
    ];

    foreach ( $service_patterns as $slug => $pattern ) {
        $path = get_template_directory() . '/patterns/' . $pattern['file'] . '.php';
        if ( ! file_exists( $path ) ) continue;
        $raw     = file_get_contents( $path );
        $content = preg_replace( '/^<\?php.*?\?>/s', '', $raw );
        $content = str_replace( 'src="/wp-content/', 'src="' . esc_url( get_site_url() ) . '/wp-content/', $content );
        register_block_pattern( 'mtctire/' . $slug, [
            'title'      => $pattern['title'],
            'categories' => [ 'mtctire' ],
            'content'    => trim( $content ),
        ] );
    }
} );
//
// Promo URL checker — called by JS on rebates page before navigating to a brand-specific link.
// Does a server-side HEAD request (no CORS restrictions), caches result for 24 h with transients.
// Only allows requests to treadpro.ca to prevent misuse as an open proxy.
add_action( 'wp_ajax_nopriv_mtc_check_url', 'mtc_check_promo_url' );
add_action( 'wp_ajax_mtc_check_url',        'mtc_check_promo_url' );
function mtc_check_promo_url() {
    $url = isset( $_GET['url'] ) ? esc_url_raw( $_GET['url'] ) : '';

    if ( ! $url || strpos( $url, 'https://treadpro.ca/' ) !== 0 ) {
        wp_send_json( [ 'ok' => false ] );
    }

    $cache_key = 'mtc_url_' . md5( $url );
    $cached    = get_transient( $cache_key );

    if ( $cached !== false ) {
        wp_send_json( [ 'ok' => $cached === '1' ] );
    }

    $response = wp_remote_head( $url, [ 'timeout' => 5, 'redirection' => 3 ] );
    $code     = wp_remote_retrieve_response_code( $response );
    $ok       = ( $code >= 200 && $code < 400 );

    set_transient( $cache_key, $ok ? '1' : '0', DAY_IN_SECONDS );

    wp_send_json( [ 'ok' => $ok, 'code' => $code ] );
}

// Note on Google Fonts: Loading from external Google servers transmits visitor IPs to Google.
// For stricter GDPR/PIPEDA compliance, self-host fonts instead: WordPress 6.5+ includes a
// Font Library under Appearance → Editor → Styles → Typography. Alternatively, download the
// font files and serve them from /assets/fonts/ with @font-face in style.css.
