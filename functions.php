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

// Returns true if today falls within the summer Saturday closure window
// (Saturday of Victoria Day weekend through Labour Day).
function mtc_is_summer_sat_closed() {
    $year      = (int) date( 'Y' );
    $may25     = new DateTime( "$year-05-25" );
    $vd        = $may25->format( 'N' ) === '1' ? $may25 : (clone $may25)->modify( 'last monday' );
    $vd_sat    = (clone $vd)->modify( '-2 days' );
    $labour    = new DateTime( "first monday of September $year" );
    $today     = new DateTime();
    $today->setTime( 0, 0, 0 );
    return ( $today >= $vd_sat && $today <= $labour );
}

// Returns true if Saturdays are closed — either by manual toggle or summer window.
function mtc_is_saturday_closed() {
    return (bool) get_option( 'mtc_saturday_force_closed' ) || mtc_is_summer_sat_closed();
}

// LocalBusiness JSON-LD schema — injected into <head> sitewide
add_action( 'wp_head', function () {
    $sat_closed = mtc_is_saturday_closed();

    $sat_open  = get_option( 'mtc_hours_sat_open',  '9:00am' );
    $sat_close = get_option( 'mtc_hours_sat_close', '2:00pm' );

    // Convert stored 12h times to HH:MM for schema.org (e.g. "9:00am" → "09:00")
    $to_schema_time = function( $t ) {
        $dt = DateTime::createFromFormat( 'g:ia', strtolower( str_replace( ' ', '', $t ) ) );
        return $dt ? $dt->format( 'H:i' ) : $t;
    };

    $hours = [
        [ 'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ],
          'opens'     => $to_schema_time( get_option( 'mtc_hours_weekday_open',  '8:00am' ) ),
          'closes'    => $to_schema_time( get_option( 'mtc_hours_weekday_close', '5:30pm' ) ) ],
    ];
    if ( ! $sat_closed ) {
        $hours[] = [ 'dayOfWeek' => [ 'Saturday' ],
                     'opens'     => $to_schema_time( $sat_open ),
                     'closes'    => $to_schema_time( $sat_close ) ];
    }

    $phone = '+1' . preg_replace( '/[^0-9]/', '', get_option( 'mtc_phone', '905.847.6665' ) );

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'AutoRepair',
        'name'        => 'MTC Tire Oakville Inc.',
        'image'       => 'https://mtctire.ca/wp-content/uploads/2017/05/mtctire-logo.png',
        'url'         => 'https://mtctire.ca',
        'telephone'   => $phone,
        'email'       => get_option( 'mtc_email', 'tiresales@mtctire.ca' ),
        'foundingDate'=> '2005',
        'description' => 'Family-owned tire and automotive repair shop in Oakville, Ontario, serving the community since 2005.',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => get_option( 'mtc_street_address', '1439 Speers Rd' ),
            'addressLocality' => get_option( 'mtc_city',           'Oakville' ),
            'addressRegion'   => get_option( 'mtc_province',       'ON' ),
            'postalCode'      => get_option( 'mtc_postal_code',    'L6L 2X5' ),
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
            'ratingValue' => get_option( 'mtc_rating_value', '4.6' ),
            'bestRating'  => '5',
            'ratingCount' => get_option( 'mtc_rating_count', '200' ),
        ],
        'priceRange'  => '$$',
        'currenciesAccepted' => 'CAD',
        'paymentAccepted'    => 'Cash, Credit Card, Debit',
        'areaServed'  => [ 'Oakville', 'Burlington', 'Mississauga', 'Milton' ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}, 5 );

// Process shortcodes inside Custom HTML (wp:html) blocks.
// Needed because WordPress doesn't run do_shortcode on core/html blocks by default.
add_filter( 'render_block_core/html', 'do_shortcode' );

// Business info shortcodes — values editable via Settings → Business Info
add_shortcode( 'mtc_phone', function () {
    return esc_html( get_option( 'mtc_phone', '905.847.6665' ) );
} );
add_shortcode( 'mtc_phone_url', function () {
    // Strips non-digits for use in tel: href attributes
    return esc_attr( preg_replace( '/[^0-9]/', '', get_option( 'mtc_phone', '9058476665' ) ) );
} );
add_shortcode( 'mtc_email', function () {
    return esc_html( get_option( 'mtc_email', 'tiresales@mtctire.ca' ) );
} );
add_shortcode( 'mtc_address', function () {
    $street = get_option( 'mtc_street_address', '1439 Speers Rd' );
    $city   = get_option( 'mtc_city',           'Oakville' );
    $prov   = get_option( 'mtc_province',        'ON' );
    $postal = get_option( 'mtc_postal_code',     'L6L 2X5' );
    return esc_html( "$street, $city $prov $postal" );
} );

// Google rating shortcode — [mtc_rating]
// Returns the rating value from Settings → Google Reviews.
add_shortcode( 'mtc_rating', function () {
    return esc_html( get_option( 'mtc_rating_value', '4.6' ) );
} );

// Dynamic copyright year shortcode — [mtc_copyright]
add_shortcode( 'mtc_copyright', function () {
    return '<p class="has-text-color" style="color:#333333;font-size:0.65rem;margin:0">&copy; 2005&ndash;' . date( 'Y' ) . ' MTC Tire Oakville Inc. All rights reserved.</p>';
} );

// Dynamic hours shortcode — [mtc_hours]
// Core open/close times are editable via Settings → Business Hours.
// The summer Saturday closure window remains calculated dynamically.
add_shortcode( 'mtc_hours', function () {
    $wkday_open  = get_option( 'mtc_hours_weekday_open',  '8:00am' );
    $wkday_close = get_option( 'mtc_hours_weekday_close', '5:30pm' );
    $sat_open    = get_option( 'mtc_hours_sat_open',      '9:00am' );
    $sat_close   = get_option( 'mtc_hours_sat_close',     '2:00pm' );

    $closed_saturdays = mtc_is_saturday_closed();

    $sat_line = $closed_saturdays
        ? 'Sat: Closed'
        : 'Sat: ' . esc_html( $sat_open ) . ' – ' . esc_html( $sat_close );

    $sat_note = get_option( 'mtc_saturday_force_closed' )
        ? '(Saturdays currently closed)'
        : '(Closed Saturdays: Victoria Day weekend through Labour Day weekend)';

    return '<p style="color:#aaaaaa;font-size:0.8rem;line-height:1.9;margin:0">'
        . 'Mon–Fri: ' . esc_html( $wkday_open ) . ' – ' . esc_html( $wkday_close ) . '<br>'
        . esc_html( $sat_line ) . '<br>'
        . '<span style="color:#555555;font-size:0.72rem">' . esc_html( $sat_note ) . '</span><br>'
        . 'Sun: Closed'
        . '</p>';
} );

// Settings pages — Business Info, Business Hours, Google Reviews
add_action( 'admin_menu', function () {
    add_options_page( 'Business Info',   'Business Info',   'manage_options', 'mtc-business-info',  'mtc_business_info_page' );
    add_options_page( 'Business Hours',  'Business Hours',  'manage_options', 'mtc-business-hours', 'mtc_business_hours_page' );
    add_options_page( 'Google Reviews',  'Google Reviews',  'manage_options', 'mtc-google-reviews',  'mtc_google_reviews_page' );
} );

add_action( 'admin_init', function () {
    foreach ( [
        'mtc_phone'          => 'Phone',
        'mtc_email'          => 'Email',
        'mtc_street_address' => 'Street Address',
        'mtc_city'           => 'City',
        'mtc_province'       => 'Province',
        'mtc_postal_code'    => 'Postal Code',
    ] as $key => $label ) {
        register_setting( 'mtc_business_info', $key, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    }
    register_setting( 'mtc_business_hours', 'mtc_saturday_force_closed', [ 'sanitize_callback' => 'absint' ] );
    foreach ( [
        'mtc_hours_weekday_open'  => 'Mon–Fri Open',
        'mtc_hours_weekday_close' => 'Mon–Fri Close',
        'mtc_hours_sat_open'      => 'Saturday Open',
        'mtc_hours_sat_close'     => 'Saturday Close',
    ] as $key => $label ) {
        register_setting( 'mtc_business_hours', $key, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    }
    foreach ( [
        'mtc_rating_value' => 'Google Rating',
        'mtc_rating_count' => 'Number of Reviews',
    ] as $key => $label ) {
        register_setting( 'mtc_google_reviews', $key, [ 'sanitize_callback' => 'sanitize_text_field' ] );
    }
} );

function mtc_business_info_page() {
    ?>
    <div class="wrap">
        <h1>Business Info</h1>
        <p style="color:#666">These values are used throughout the site — in the header, footer, contact page, service sidebar, and structured data. Update once and it changes everywhere.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'mtc_business_info' ); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mtc_phone">Phone</label></th>
                    <td>
                        <input type="text" id="mtc_phone" name="mtc_phone" value="<?php echo esc_attr( get_option( 'mtc_phone', '905.847.6665' ) ); ?>" class="regular-text" placeholder="905.847.6665" />
                        <p class="description">Display format (e.g. 905.847.6665). Digits are stripped automatically for click-to-call links.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_email">Email</label></th>
                    <td><input type="text" id="mtc_email" name="mtc_email" value="<?php echo esc_attr( get_option( 'mtc_email', 'tiresales@mtctire.ca' ) ); ?>" class="regular-text" placeholder="tiresales@mtctire.ca" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_street_address">Street Address</label></th>
                    <td><input type="text" id="mtc_street_address" name="mtc_street_address" value="<?php echo esc_attr( get_option( 'mtc_street_address', '1439 Speers Rd' ) ); ?>" class="regular-text" placeholder="1439 Speers Rd" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_city">City</label></th>
                    <td><input type="text" id="mtc_city" name="mtc_city" value="<?php echo esc_attr( get_option( 'mtc_city', 'Oakville' ) ); ?>" class="regular-text" placeholder="Oakville" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_province">Province</label></th>
                    <td><input type="text" id="mtc_province" name="mtc_province" value="<?php echo esc_attr( get_option( 'mtc_province', 'ON' ) ); ?>" class="small-text" placeholder="ON" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_postal_code">Postal Code</label></th>
                    <td><input type="text" id="mtc_postal_code" name="mtc_postal_code" value="<?php echo esc_attr( get_option( 'mtc_postal_code', 'L6L 2X5' ) ); ?>" class="small-text" placeholder="L6L 2X5" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function mtc_business_hours_page() {
    ?>
    <div class="wrap">
        <h1>Business Hours</h1>
        <p style="color:#666">These hours appear on the Contact page and service sidebar. The summer Saturday closure (Victoria Day weekend through Labour Day weekend) is applied automatically — or you can force Saturdays closed year-round with the toggle below.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'mtc_business_hours' ); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mtc_hours_weekday_open">Mon–Fri Open</label></th>
                    <td><input type="text" id="mtc_hours_weekday_open" name="mtc_hours_weekday_open" value="<?php echo esc_attr( get_option( 'mtc_hours_weekday_open', '8:00am' ) ); ?>" class="regular-text" placeholder="8:00am" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_hours_weekday_close">Mon–Fri Close</label></th>
                    <td><input type="text" id="mtc_hours_weekday_close" name="mtc_hours_weekday_close" value="<?php echo esc_attr( get_option( 'mtc_hours_weekday_close', '5:30pm' ) ); ?>" class="regular-text" placeholder="5:30pm" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_hours_sat_open">Saturday Open</label></th>
                    <td><input type="text" id="mtc_hours_sat_open" name="mtc_hours_sat_open" value="<?php echo esc_attr( get_option( 'mtc_hours_sat_open', '9:00am' ) ); ?>" class="regular-text" placeholder="9:00am" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_hours_sat_close">Saturday Close</label></th>
                    <td><input type="text" id="mtc_hours_sat_close" name="mtc_hours_sat_close" value="<?php echo esc_attr( get_option( 'mtc_hours_sat_close', '2:00pm' ) ); ?>" class="regular-text" placeholder="2:00pm" /></td>
                </tr>
                <tr>
                    <th scope="row">Saturday Closure Override</th>
                    <td>
                        <label>
                            <input type="checkbox" name="mtc_saturday_force_closed" value="1" <?php checked( 1, get_option( 'mtc_saturday_force_closed', 0 ) ); ?> />
                            Force Saturdays closed
                        </label>
                        <p class="description">Check this to show Saturday as closed regardless of the time of year. The summer closure window still applies automatically when this is off.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function mtc_google_reviews_page() {
    ?>
    <div class="wrap">
        <h1>Google Reviews</h1>
        <p style="color:#666">These values update the rating displayed in the trust bar and about strip, and in the structured data (schema.org) injected into every page.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'mtc_google_reviews' ); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mtc_rating_value">Google Rating</label></th>
                    <td><input type="text" id="mtc_rating_value" name="mtc_rating_value" value="<?php echo esc_attr( get_option( 'mtc_rating_value', '4.6' ) ); ?>" class="small-text" placeholder="4.6" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mtc_rating_count">Number of Reviews</label></th>
                    <td>
                        <input type="text" id="mtc_rating_count" name="mtc_rating_count" value="<?php echo esc_attr( get_option( 'mtc_rating_count', '200' ) ); ?>" class="small-text" placeholder="200" />
                        <p class="description">Used in structured data only — not displayed visibly on the site.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register pattern category and service content patterns for the block inserter
add_action( 'init', function () {
    register_block_pattern_category( 'mtctire', [ 'label' => 'MTC Tire' ] );

    $service_patterns = [
        'service-tires-wheels'      => [ 'title' => 'Service: Tires & Wheels',         'file' => 'service-tires-wheels' ],
        'service-tire-storage'      => [ 'title' => 'Service: Tire Storage',            'file' => 'service-tire-storage' ],
        'service-automotive-repair' => [ 'title' => 'Service: Automotive Repair',       'file' => 'service-automotive-repair' ],
        'service-wheel-alignment'   => [ 'title' => 'Service: Wheel Alignment',         'file' => 'service-wheel-alignment' ],
        'service-brake-inspection'  => [ 'title' => 'Service: Brake Inspection',        'file' => 'service-brake-inspection' ],
        'service-fleet-cards'       => [ 'title' => 'Service: Safety Inspection',       'file' => 'service-fleet-cards' ],
        'about-content'             => [ 'title' => 'Page: About Content',              'file' => 'about-content' ],
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

// =========================================================
// Synced Pattern Seeder
// Runs once on init — creates wp_block posts for all front-page
// sections by rendering the PHP pattern files via output buffering.
// IDs are stored in wp_options so the template filter can reference them.
// To re-seed (e.g. after a fresh DB): delete the 'mtc_synced_patterns_v1'
// option via WP CLI: wp option delete mtc_synced_patterns_v1
// =========================================================

function mtc_get_pattern_html( $file ) {
    ob_start();
    include get_template_directory() . '/patterns/' . $file . '.php';
    return trim( ob_get_clean() );
}

function mtc_seed_synced_patterns() {
    if ( get_option( 'mtc_synced_patterns_v2' ) ) return;

    $patterns = [
        'mtc-front-hero'          => [ 'title' => 'MTC: Hero',            'file' => 'hero' ],
        'mtc-front-trust-bar'     => [ 'title' => 'MTC: Trust Bar',       'file' => 'trust-bar' ],
        'mtc-front-services-grid' => [ 'title' => 'MTC: Services Grid',   'file' => 'services-grid' ],
        'mtc-front-about-strip'   => [ 'title' => 'MTC: About Strip',     'file' => 'about-strip' ],
        'mtc-front-brands'        => [ 'title' => 'MTC: Brands',          'file' => 'brands' ],
        'mtc-front-reviews'       => [ 'title' => 'MTC: Reviews',         'file' => 'reviews' ],
        'mtc-front-cta-banner'    => [ 'title' => 'MTC: CTA Banner',      'file' => 'cta-banner' ],
        'mtc-service-sidebar'     => [ 'title' => 'MTC: Service Sidebar', 'file' => 'service-sidebar' ],
    ];

    $ids = (array) get_option( 'mtc_synced_pattern_ids', [] );

    foreach ( $patterns as $slug => $data ) {
        // Reuse existing wp_block post if it was already created
        $existing = get_page_by_path( $slug, OBJECT, 'wp_block' );
        if ( $existing ) {
            $ids[ $slug ] = $existing->ID;
            continue;
        }

        $content = mtc_get_pattern_html( $data['file'] );
        $id = wp_insert_post( [
            'post_title'   => $data['title'],
            'post_name'    => $slug,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'wp_block',
        ] );

        if ( ! is_wp_error( $id ) ) {
            $ids[ $slug ] = $id;
        }
    }

    update_option( 'mtc_synced_pattern_ids', $ids );
    update_option( 'mtc_synced_patterns_v2', true );
}
add_action( 'init', 'mtc_seed_synced_patterns', 20 );

// Inject synced block references into theme templates at runtime.
// For the front-page, replaces the whole content with wp:block refs.
// For all other theme templates, does a targeted string replace of known
// pattern slugs (cta-banner, service-sidebar) with their synced refs.
// Once a client customises any template via the Site Editor, WordPress
// stores a DB copy (source: 'custom') and this filter no longer applies to it.
add_filter( 'get_block_templates', function ( $templates, $query, $template_type ) {
    if ( $template_type !== 'wp_template' ) return $templates;

    $ids = get_option( 'mtc_synced_pattern_ids', [] );
    if ( empty( $ids ) ) return $templates;

    // Map PHP pattern slugs → synced pattern ID keys
    $replacements = array_filter( [
        'mtctire/cta-banner'      => ! empty( $ids['mtc-front-cta-banner'] )  ? (int) $ids['mtc-front-cta-banner']  : null,
        'mtctire/service-sidebar' => ! empty( $ids['mtc-service-sidebar'] )   ? (int) $ids['mtc-service-sidebar']   : null,
    ] );

    foreach ( $templates as &$template ) {
        if ( $template->source !== 'theme' ) continue;

        // front-page now renders wp:post-content — skip it entirely
        if ( $template->slug === 'front-page' ) continue;

        // Replace remaining PHP pattern refs with synced wp:block refs
        $content = $template->content;
        foreach ( $replacements as $pattern_slug => $ref_id ) {
            $content = str_replace(
                '<!-- wp:pattern {"slug":"' . $pattern_slug . '"} /-->',
                '<!-- wp:block {"ref":' . $ref_id . '} /-->',
                $content
            );
        }
        $template->content = $content;
    }
    return $templates;
}, 10, 3 );

// Home page content seeder — runs once after the synced pattern seeder.
// Concatenates the current synced pattern HTML into the static front page's
// post_content so it's editable directly in the WordPress Page Editor.
// To re-seed: wp option delete mtc_home_page_seeded_v1
function mtc_seed_home_page() {
    if ( get_option( 'mtc_home_page_seeded_v1' ) ) return;

    $home_id = (int) get_option( 'page_on_front' );
    if ( ! $home_id ) return;

    $ids = get_option( 'mtc_synced_pattern_ids', [] );
    if ( empty( $ids ) ) return;

    $order = [
        'mtc-front-hero',
        'mtc-front-trust-bar',
        'mtc-front-services-grid',
        'mtc-front-about-strip',
        'mtc-front-brands',
        'mtc-front-reviews',
        'mtc-front-cta-banner',
    ];

    $content = '';
    foreach ( $order as $key ) {
        if ( empty( $ids[ $key ] ) ) continue;
        $pattern = get_post( (int) $ids[ $key ] );
        if ( $pattern ) {
            $content .= "\n" . $pattern->post_content;
        }
    }

    // Write directly to avoid wp_kses_post() stripping <style> tags from block content
    global $wpdb;
    $wpdb->update(
        $wpdb->posts,
        [
            'post_content'      => trim( $content ),
            'post_modified'     => current_time( 'mysql' ),
            'post_modified_gmt' => current_time( 'mysql', 1 ),
        ],
        [ 'ID' => $home_id ]
    );
    clean_post_cache( $home_id );

    update_option( 'mtc_home_page_seeded_v1', true );
}
add_action( 'init', 'mtc_seed_home_page', 25 );

// Contact page content seeder — moves the hardcoded template layout into post_content
// so the contact page is editable directly in the WordPress Page Editor.
// To re-seed: wp option delete mtc_contact_page_seeded_v1
function mtc_seed_contact_page() {
    if ( get_option( 'mtc_contact_page_seeded_v1' ) ) return;

    $contact = get_page_by_path( 'contact', OBJECT, 'page' );
    if ( ! $contact ) return;

    $content = '<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"2px"}}},"layout":{"type":"default"}} -->
<div class="wp-block-columns mtc-page-columns" style="gap:0;display:flex;flex-wrap:wrap">
  <!-- wp:column {"width":"55%","style":{"color":{"background":"#111111"},"spacing":{"padding":{"top":"48px","bottom":"48px","left":"48px","right":"40px"}}}} -->
  <div class="wp-block-column" style="background-color:#111111;padding-top:48px;padding-bottom:48px;padding-left:48px;padding-right:40px;flex:0 0 55%;max-width:55%">
    <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"1.5rem"},"spacing":{"margin":{"bottom":"6px"}}}} --><h1>Let Us Contact You</h1><!-- /wp:heading -->
    <!-- wp:paragraph {"style":{"color":{"text":"#666666"},"typography":{"fontSize":"0.75rem"},"spacing":{"margin":{"bottom":"28px"}}}} --><p style="color:#666666;font-size:0.75rem">Fill in your vehicle details and what you\'re looking for — someone from the MTC Tire team will get back to you shortly.</p><!-- /wp:paragraph -->
    <!-- wp:shortcode -->
    [wpforms id="1140"]
    <!-- /wp:shortcode -->
  </div>
  <!-- /wp:column -->
  <!-- wp:column {"width":"45%","style":{"color":{"background":"#0d0d0d"},"spacing":{"padding":{"top":"48px","bottom":"48px","left":"40px","right":"48px"}}}} -->
  <div class="wp-block-column" style="background-color:#0d0d0d;padding-top:48px;padding-bottom:48px;padding-left:40px;padding-right:48px;flex:0 0 45%;max-width:45%">
    <!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"1.3rem"},"spacing":{"margin":{"bottom":"24px"}}}} --><h2>Find Us</h2><!-- /wp:heading -->
    <!-- wp:group {"style":{"spacing":{"margin":{"bottom":"20px","top":"0"},"padding":{"bottom":"20px"}},"border":{"bottom":{"color":"#1e1e1e","style":"solid","width":"1px"}}}} -->
    <div class="wp-block-group">
      <!-- wp:paragraph {"style":{"color":{"text":"#f3832e"},"typography":{"fontSize":"0.6rem","textTransform":"uppercase","letterSpacing":"2px"}}} --><p style="color:#f3832e;font-size:0.6rem;text-transform:uppercase;letter-spacing:2px">Address</p><!-- /wp:paragraph -->
      <!-- wp:paragraph {"style":{"color":{"text":"#aaaaaa"},"typography":{"fontSize":"0.8rem"}}} --><p style="color:#aaaaaa;font-size:0.8rem"><a href="https://maps.google.com/?q=[mtc_address]" target="_blank" rel="noopener" style="color:#aaaaaa;text-decoration:none">[mtc_address]</a></p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"style":{"spacing":{"margin":{"bottom":"20px","top":"0"},"padding":{"bottom":"20px"}},"border":{"bottom":{"color":"#1e1e1e","style":"solid","width":"1px"}}}} -->
    <div class="wp-block-group">
      <!-- wp:paragraph {"style":{"color":{"text":"#f3832e"},"typography":{"fontSize":"0.6rem","textTransform":"uppercase","letterSpacing":"2px"}}} --><p style="color:#f3832e;font-size:0.6rem;text-transform:uppercase;letter-spacing:2px">Phone</p><!-- /wp:paragraph -->
      <!-- wp:paragraph {"style":{"color":{"text":"#aaaaaa"},"typography":{"fontSize":"0.8rem"}}} --><p style="color:#aaaaaa;font-size:0.8rem"><a href="tel:[mtc_phone_url]" style="color:#aaaaaa;text-decoration:none">[mtc_phone]</a></p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"style":{"spacing":{"margin":{"bottom":"20px","top":"0"},"padding":{"bottom":"20px"}},"border":{"bottom":{"color":"#1e1e1e","style":"solid","width":"1px"}}}} -->
    <div class="wp-block-group">
      <!-- wp:paragraph {"style":{"color":{"text":"#f3832e"},"typography":{"fontSize":"0.6rem","textTransform":"uppercase","letterSpacing":"2px"}}} --><p style="color:#f3832e;font-size:0.6rem;text-transform:uppercase;letter-spacing:2px">Email</p><!-- /wp:paragraph -->
      <!-- wp:paragraph {"style":{"color":{"text":"#aaaaaa"},"typography":{"fontSize":"0.8rem"}}} --><p style="color:#aaaaaa;font-size:0.8rem"><a href="mailto:[mtc_email]" style="color:#aaaaaa;text-decoration:none">[mtc_email]</a></p><!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
    <!-- wp:group {"style":{"spacing":{"margin":{"bottom":"20px","top":"0"}}}} -->
    <div class="wp-block-group">
      <!-- wp:paragraph {"style":{"color":{"text":"#f3832e"},"typography":{"fontSize":"0.6rem","textTransform":"uppercase","letterSpacing":"2px"}}} --><p style="color:#f3832e;font-size:0.6rem;text-transform:uppercase;letter-spacing:2px">Hours</p><!-- /wp:paragraph -->
      <!-- wp:shortcode -->[mtc_hours]<!-- /wp:shortcode -->
    </div>
    <!-- /wp:group -->
    <!-- wp:html -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2897.863653509784!2d-79.71764138830888!3d43.421675370993604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b5dc0f57b7fa7%3A0x5bf33780d6b05da4!2sMTC%20Tire%20Oakville%20Inc.!5e0!3m2!1sen!2sca!4v1776732824177!5m2!1sen!2sca" width="100%" height="240" style="border:0;filter:grayscale(100%) invert(90%) contrast(90%)" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    <!-- /wp:html -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->';

    global $wpdb;
    $wpdb->update(
        $wpdb->posts,
        [
            'post_content'      => $content,
            'post_modified'     => current_time( 'mysql' ),
            'post_modified_gmt' => current_time( 'mysql', 1 ),
        ],
        [ 'ID' => $contact->ID ]
    );
    clean_post_cache( $contact->ID );

    update_option( 'mtc_contact_page_seeded_v1', true );
}
add_action( 'init', 'mtc_seed_contact_page', 26 );

// Note on Google Fonts: Loading from external Google servers transmits visitor IPs to Google.
// For stricter GDPR/PIPEDA compliance, self-host fonts instead: WordPress 6.5+ includes a
// Font Library under Appearance → Editor → Styles → Typography. Alternatively, download the
// font files and serve them from /assets/fonts/ with @font-face in style.css.
